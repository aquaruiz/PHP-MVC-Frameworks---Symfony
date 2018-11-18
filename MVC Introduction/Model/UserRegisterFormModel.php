<?php 

namespace Model;

class UserRegisterFormModel
{
	private $user_name;
	private $password;

	public function getUserName() : string {
		return $this->user_name;
	}

	public function setUserName(string $user_name) {
		$this->user_name = $user_name;
	}

	public function getPassword() : string {
		return $this->password;
	}

	public function setPassword(string $password) {
		$this->password = $password;
	}
}
 ?>





