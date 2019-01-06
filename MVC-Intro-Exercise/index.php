<?php
// https://github.com/RoYaLBG/ANSR_Framework

spl_autoload_register();

$entrypoint = basename(__FILE__);
$self = $_SERVER['PHP_SELF'];
$junk = str_replace($entrypoint, '', $self);
$uri = $_SERVER['REQUEST_URI'];
$significantUri = str_replace($junk, '', $uri);
$significantUri = str_replace([$_SERVER['QUERY_STRING'], '?'], '', $significantUri);
$uriParts = explode('/', $significantUri);

$controllerName = array_shift($uriParts);
$actionName = array_shift($uriParts);
$arguments = $uriParts;

$app = new \Core\Application($controllerName, $actionName, $arguments);
$app->start();
?>