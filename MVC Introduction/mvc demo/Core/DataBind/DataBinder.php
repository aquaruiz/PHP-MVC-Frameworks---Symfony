<?php
/**
 * Created by PhpStorm.
 * User: vesel
 * Date: 11/12/2018
 * Time: 9:46 PM
 */

namespace Core\DataBind;


class DataBinder
{
    public function bind($data,$class){
        //$this->params;
        $action_data = new \ReflectionMethod($controller_name, $this->request->getActionName());
        $aparams = $action_data->getParameters();
        $params = [];
        foreach ($aparams as $param) {
            $class = $param->getClass();
            if ($class) {
                // new UserRegisterFormModel()
                $class_name = $class->getName();
                $param_obj = new $class_name();
                $properties = new \ReflectionClass($param_obj);
                foreach ($properties->getProperties() as $property) {
                    $property_name = $property->getName();
                    if (array_key_exists($property_name, $_POST)) {
                        $setter = 'set'.implode(array_map(function($element){return ucfirst($element);},explode('_',$property_name)));
                        $param_obj->$setter($_POST[$property_name]);
                    }
                }
            }
            $params[] = $param_obj;
        }
    }
}