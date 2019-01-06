<?php

namespace Controllers;

use Core\Http\RequestInterface;
use Core\View\View;
use Core\View\ViewInterface;
use Models\ViewModels\UserRegisterViewModel;
use Services\User\UserServiceInterface;

class UsersController
{
//    private $request;
//
//    /**
//     * UsersController constructor.
//     * @param $request
//     */
//    public function __construct(RequestInterface $request)
//    {
//        $this->request = $request;
//    }
//
//    public function test() : void  {
//        echo 'test here';
//    }

//    public function register(string  $username, string $password) : void
//    {
//        $viewModel = new UserRegisterViewModel($username, $password);
//        $view = new View($this->request);
//        $view->render('users/register', $viewModel);
//    }

    public function register(UserServiceInterface $userService, ViewInterface $view) : void
    {
        $userService->register(['chushki']);
    }
}