<?php
/**
 * Created by PhpStorm.
 * User: vesel
 * Date: 11/12/2018
 * Time: 8:05 PM
 */

namespace Core\View;


interface ViewInterface
{
    public function render($model = null);
}