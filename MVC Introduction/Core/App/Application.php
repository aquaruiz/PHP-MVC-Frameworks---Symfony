<?php

namespace Core\App;

use Core\View\ViewInterface;
use Model\UserRegisterFormModel;

class Application
{
	private $controller_name;
	private $action_name;
	private $params;

	public function __construct(string $controller_name, string $action_name, array $params){
		$this->controller_name = $controller_name;
		$this->action_name = $action_name;
		$this->params = $params;
	}

	public function run(ViewInterface $view)
	{
		$controller_name = '\\Controller\\'.$this->controller_name.'Controller';

		$controller = new $controller_name($view);

		if(!is_callable([$controller, $this->action_name])) {
			throw new \Exception("Action does not exist.");			
		 }

		 $action_data = new \ReflectionMethod($controller_name,$this->action_name);
		 $aparams = $action_data->getParameters();
		 $params = [];

		 foreach ($aparams as $param) {
			 $class = $param->getClass();

			 if ($class) {
			 	$class_name = $class->getName();
			 	$param_obj = new $class_name($_POST);
			 	$properties = new \ReflectionClass($param_obj);  
			 	foreach ($properties->getProperties() as $property) {
			 		$property_name = $property->getName();
			 		
			 		if (array_key_exists($property_name, $_POST)) {
			 			$setter = 'set' . implode(array_map(function ($element){
			 						return ucfirst($element);
			 						}, 
			 					explode('_', $property_name)));

			 			$param_obj->$setter($_POST[$property_name]);
			 			$params[] = $param_obj;
			 		}
			 	}
			 }

		 }

		call_user_func_array([$controller, $this->action_name], $params);
	}
}
 ?>