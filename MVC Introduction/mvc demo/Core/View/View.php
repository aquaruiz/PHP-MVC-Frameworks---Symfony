<?php
/**
 * Created by PhpStorm.
 * User: vesel
 * Date: 11/12/2018
 * Time: 8:06 PM
 */

namespace Core\View;


use Core\Request\Request;

class View implements ViewInterface
{

    /**
     * @var Request
     */
    private $request;

    /**
     * View constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function render($model = null)
    {
        include('View/'
            . $this->request->getControllerName()
            . '/' . $this->request->getActionName()
            . '.php');
    }
}