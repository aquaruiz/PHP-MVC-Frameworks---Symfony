<?php 

namespace Controller;

use \Core\View\View;
use \Core\View\ViewInterface;

class UsersController
{
	private $view;

	public function __construct(ViewInterface $view){
		$this->view = $view;
	}

	public function profile(){
		$this->view->render();
	}

	public function register(string $first_name, string $last_name){
		echo $first_name;
		$this->view->render();
	}
}
 ?>