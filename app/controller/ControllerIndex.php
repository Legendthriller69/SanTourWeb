<?php

namespace SanTourWeb\App\Controller;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use SanTourWeb\Library\Mvc\Controller;
use SanTourWeb\Library\Utils\Firebase\FirebaseLib;
use SanTourWeb\Library\Utils\Toast;
use SanTourWeb\Library\Utils\Redirect;

class ControllerIndex extends Controller
{
    public function index()
    {
        if (isset($_SESSION['connected']) && $_SESSION['connected'])
            Redirect::toAction('tracks');
        else {
            if (isset($_POST['submit'])) {
                $UID = $this->model->connectUser($_POST['email'], $_POST['password']);
                if ($UID != null) {
                    $_SESSION['connected'] = true;
                    $_SESSION['user'] = $this->model->getUserById($UID);
                    Redirect::toAction('tracks');
                } else
                    Toast::message(__('The combination username/password does not match', true), 'red');
            }

            return $this->view->Render();
        }
    }

    public function example()
    {
        return $this->view->Render();
    }

    public function logout()
    {
        redirectIfNotConnected();

        unset($_SESSION['connected']);
        unset($_SESSION['user']);
        Redirect::toAction('index');
    }
}