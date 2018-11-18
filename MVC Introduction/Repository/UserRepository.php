<?php 
namespace Repository;

use \Model\UserRegisterFormModel;
use \PDO;

class UserRepository
{
	private $db;

	public function __construct(\PDO $db){
		$this->db = $db;
	}

	public function insert(UserRegisterFormModel $user_model)
	{
		$this->db->prepare(
			'INSERT INTO users (USER_NAME, PASSWORD) VALUES (:username, :password)';
		);
			//.....
	}
}
 ?>