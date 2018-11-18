<?php 
spl_autoload_register(function($className) {

    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . $className . '.php';

});

$self = str_replace(basename(__FILE__), "", $_SERVER['PHP_SELF']);
$url_parts = explode("/", str_replace($self, "", $_SERVER['REQUEST_URI']));
$url_parts = array_filter(explode("/", $_SERVER['REQUEST_URI']), "strlen");
$controller_name = ucfirst(array_shift($url_parts)); 
$action_name = array_shift($url_parts);
$params = $url_parts;

$view = new \Core\View\View($controller_name, $action_name);
// echo '<pre>';
// print_r($view);
// echo '</pre>';

$controller_name = '\\Controller\\'.$controller_name.'Controller';

$controller = new $controller_name($view);
call_user_func_array([$controller, $action_name], $params);
// $controller->$action_name();
?>