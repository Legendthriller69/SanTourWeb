<?php

namespace SanTourWeb\App\Controller;

use SanTourWeb\Library\Mvc\Controller;
use SanTourWeb\Library\Utils\Redirect;

class ControllerLanguage extends Controller
{
    /**
     * Action used to change the language of the application
     */
    public function index()
    {
        $_SESSION['lang'] = $_GET['lang'];
        if (isset($_SERVER['HTTP_REFERER']))
            Redirect::toLastPage();
        else
            Redirect::toAction('index');

    }
}