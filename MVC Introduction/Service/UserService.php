<?php 

namespace Service;

use \Model\UserRegisterFormModel;
use \Repository\UserRepository;

class UserService
{
	public function register(UserRegisterFormModel $user_model)
	{
		$user_repo = new UserRepository();
		$user_repo->insert($user_model);
	}
}
 ?>