<?php

spl_autoload_register();

$self = str_replace(basename(__FILE__),'',$_SERVER['PHP_SELF']);
$url_parts = explode('/',
    str_replace($self,'',$_SERVER['REQUEST_URI']));


$controller_name = ucfirst(array_shift($url_parts));
$action_name = array_shift($url_parts);
$params = $url_parts;

$request = new \Core\Request\Request($controller_name,$action_name,$params);
$view = new \Core\View\View($request);

$app = new \Core\App\Application($request);
$app->run($view);
