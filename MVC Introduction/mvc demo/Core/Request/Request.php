<?php
/**
 * Created by PhpStorm.
 * User: vesel
 * Date: 11/12/2018
 * Time: 9:40 PM
 */

namespace Core\Request;


class Request
{
    /**
     * @var string
     */
    private $controller_name;

    /**
     * @var string
     */
    private $action_name;

    /**
     * @var array
     */
    private $params;

    /**
     * Request constructor.
     * @param string $controller_name
     * @param string $action_name
     * @param array $params
     */
    public function __construct(string $controller_name, string $action_name, array $params)
    {
        $this->controller_name = $controller_name;
        $this->action_name = $action_name;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controller_name;
    }

    public function getFullControllerName(): string{
        return 'Controller\\' . $this->controller_name . 'Controller';
    }
    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->action_name;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

}