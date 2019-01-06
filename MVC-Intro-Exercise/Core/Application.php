<?php

namespace Core;

use Core\Http\Request;
use Core\Http\RequestInterface;

class Application
{
    private $controllerName;
    private $actionName;
    private $params = [];

    public function __construct($controllerName, $actionName, array $params)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->params = $params;
    }

    public function start() : void
    {
        $request = $this->initiateRequester();
        $fullQualifiesName = 'Controllers\\' . ucfirst($this->controllerName) . 'Controller';
        $controller = new $fullQualifiesName($request);
//        var_dump($controller);
        //$controller->$actionName($arguments);

        $methodInfo = new \ReflectionMethod($fullQualifiesName, $this->actionName);
        var_dump($methodInfo->getParameters());

        call_user_func_array(
            [$controller, $this->actionName],
            $this->params
        );
    }

    private function initiateRequester() : RequestInterface
    {
        return new Request($this->controllerName, $this->actionName, $_SERVER['QUERY_STRING']);
    }
}