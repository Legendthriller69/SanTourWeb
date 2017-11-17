<?php

namespace SanTourWeb\Library\Mvc;

class Controller
{
    protected $currentController;
    protected $currentAction;

    protected $model;
    public $view;

    public function __construct($currentController, $currentAction, $model, $view)
    {
        $this->currentController = $currentController;
        $this->currentAction = $currentAction;
        $this->model = $model;
        $this->view = $view;
    }

    public function getCurrentController()
    {
        return $this->currentController;
    }

    public function getCurrentAction()
    {
        return $this->currentAction;
    }
}