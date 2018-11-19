<?php
/**
 * Created by PhpStorm.
 * User: vesel
 * Date: 11/12/2018
 * Time: 8:39 PM
 */

namespace Model;


class UserRegisterFormModel
{

    /**
     * @var string
     */
    private $user_name;

    /**
     * @var string
     */
    private $password;

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user_name;
    }

    /**
     * @param string $user_name
     */
    public function setUserName(string $user_name): void
    {
        $this->user_name = $user_name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}