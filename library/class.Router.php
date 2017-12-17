<?php

namespace SanTourWeb\Library;

use SanTourWeb\Library\Mvc\View;
use SanTourWeb\Library\Mvc\Model;

define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_ACTION', 'index');

class Router
{
    public function CallHook()
    {
        $params = array();
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            $url = $_GET['url'];
            $params = explode('/', $url);
        }

        $ctr = isset($params[0]) && !empty($params[0]) ? $params[0] : DEFAULT_CONTROLLER;
        $action = isset($params[1]) && !empty($params[1]) ? $params[1] : DEFAULT_ACTION;

        $controllerClassName = 'SanTourWeb\\App\\Controller\\Controller' . ucfirst($ctr);

        if (class_exists($controllerClassName)) {
            $model = self::GetModel($ctr);
            $view = self::GetView($ctr, $action);
            $controller = new $controllerClassName($ctr, $action, $model, $view);
            if (method_exists($controller, $action)) {
                echo $controller->$action();
                exit;
            }
        }
        echo error_404();
        exit;
    }

    public static function GetModel($controller)
    {
        $modelName = 'SanTourWeb\\App\\Model\\Model' . ucfirst($controller);
        if (class_exists($modelName)) {
            return new $modelName();
        }
        return new Model();
    }

    public static function GetView($c, $a)
    {
        return new View($c, $a);
    }

    public function SetErrorReporting()
    {
        $debugLevel = DEBUG_LEVEL;
        if ($debugLevel == 2) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else if ($debugLevel == 1) {
            error_reporting(E_ALL ^ E_STRICT ^ E_WARNING);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
        }
    }
}