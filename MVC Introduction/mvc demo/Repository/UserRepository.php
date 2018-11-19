<?php
/**
 * Created by PhpStorm.
 * User: vesel
 * Date: 11/12/2018
 * Time: 9:30 PM
 */

namespace Repository;


class UserRepository
{

    /**
     * @var PDO
     */
    private $db;

    /**
     * UserRepository constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function insert(\Model\UserRegisterFormModel $user_model)
    {
        $this->db->prepare('INSERT INTO user(USER_NAME,PASSWORD) VALUES(:username,:password)');
        //....
    }
}