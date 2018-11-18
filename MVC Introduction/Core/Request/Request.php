<?php 

namespace Core\Request;

class Request
{
	private $controller_name;
	private $action_name;
	private $params;

	public function __construct(string $controller_name, string $action_name, array $params)
	{
		$this->controller_name = $controller_name;
		$this->action_name = $action_name;
		$this->params = $params;
	}

	public function getControllerName() : string 
	{
		return $this->controller_name;
	}

	public function getFullControllerName() : string 
	{
		return '\\Controller\\'.$this->controller_name.'Controller';
	}

	public function getActionName() : string 
	{
		return $this->action_name;
	}

	public function getParams() : array 
	{
		return $this->params;
	}
}
 ?>