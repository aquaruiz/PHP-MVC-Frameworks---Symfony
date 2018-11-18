<?php 

namespace Service;

use \Model\UserRegisterFormModel;
use \Repository\UserRepository;

class UserService
{
	private $user_repo;

	public function __construct(UserRepository $user_repo){
		$this->user_repo = $user_repo;
	}

	public function register(UserRegisterFormModel $user_model)
	{
		$this->user_repo->insert($user_model);
	}
}
 ?>