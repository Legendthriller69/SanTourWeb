<?php

namespace SanTourWeb\Library\Mvc;

class View {

    public $viewPath;
    public $viewData;
    public $layoutPath;
    public $controller;
    public $currentController;
    public $currentAction;

    public function __construct($ctr, $act) {
        $this->currentController = $ctr;
        $this->currentAction = $act;
        $this->viewData = array();
        $this->viewPath = APPPATH.DS.'view'.DS.$ctr.DS.'view-'.$act.'.php';
        $this->layoutPath = APPPATH.DS.'view'.DS.'_shared'.DS.'view-main.php';
    }

    public function SetController($ctr) {
        $this->controller = $ctr;
    }

    public function Set($key, $value) {
        $this->viewData[$key] = $value;
    }

    public function Uset($key) {
        unset($this->viewData[$key]);
    }

    public function SetView($path) {
        $this->viewPath = $path;
    }

    public function SetLayout($path) {
        $this->layoutPath = $path;
    }

    public function RenderPartial() {
        extract($this->viewData);
        ob_start();
        include($this->viewPath);
        return ob_get_clean();
    }

    public function Render() {
        $html = $this->RenderPartial();
        ob_start();
        include($this->layoutPath);
        unset($html);
        return ob_get_clean();
    }
}