<?php
/**
 * Created by PhpStorm.
 * User: vesel
 * Date: 11/12/2018
 * Time: 9:30 PM
 */

namespace Service;

use Repository\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $user_repo;

    /**
     * UserService constructor.
     * @param UserRepository $user_repo
     */
    public function __construct(UserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function register(\Model\UserRegisterFormModel $user_model)
    {
        $this->user_repo->insert($user_model);
    }
}