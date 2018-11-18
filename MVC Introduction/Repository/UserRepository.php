<?php 
namespace Repository;

use \Model\UserRegisterFormModel;

class UserRepository
{
	public function insert(UserRegisterFormModel $user_model)
	{
		$db = new \PDO();
		$db->prepare(
			'INSERT INTO users (USER_NAME, PASSWORD) VALUES (:username, :password)';
		);
			//.....
	}
}
 ?>