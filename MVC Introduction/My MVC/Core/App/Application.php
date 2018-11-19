<?php

namespace Core\App;

use Core\View\ViewInterface;
use Model\UserRegisterFormModel;
use \Core\Request\Request;

class Application
{
	private $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

	public function run(ViewInterface $view)
	{
		$controller_name = $this->request->getFullControllerName();

		$controller = new $controller_name($view);

		if(!is_callable([$controller, $this->request->getActionName()])) {
			throw new \Exception("Action does not exist.");			
		 }

		 $action_data = new \ReflectionMethod($controller_name,$this->request->getActionName());
		 $aparams = $action_data->getParameters();
		 $params = [];

		 foreach ($aparams as $param) {
			 $class = $param->getClass();

			 if ($class) {
			 	$class_name = $class->getName();
			 	$param_obj = new $class_name();
			 	$properties = new \ReflectionClass($param_obj);  
			 	foreach ($properties->getProperties() as $property) {
			 		$property_name = $property->getName();
			 		
			 		if (array_key_exists($property_name, $_POST)) {
			 			$setter = 'set' . implode(array_map(function ($element){
			 						return ucfirst($element);
			 						}, 
			 					explode('_', $property_name)));

			 			$param_obj->$setter($_POST[$property_name]);
			 		}
			 	}
			 }

			 $params[] = $param_obj;
		 }

		call_user_func_array([$controller, $this->request->getActionName], $params);
	}
}
 ?>