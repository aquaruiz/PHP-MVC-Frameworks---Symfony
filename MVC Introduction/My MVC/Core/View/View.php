<?php

namespace Core\View;

use \Core\View\ViewInterface;
use \Model\UserRegisterFormModel;
use \Core\Request\Request;

class View implements ViewInterface
{
	private $request;

	public function __construct(Request $request){
		$this->request = $request;
	}

	public function render($model = null){
		include($_SERVER['DOCUMENT_ROOT'] . '/View/'.$this->request->getControllerName() . '/' . $this->request->getActionName().'.php');
	}
}
?>