<?php

namespace SanTourWeb\App\Controller;

use SanTourWeb\Library\Mvc\Controller;
use SanTourWeb\Library\Utils\Redirect;
use SanTourWeb\Library\Utils\Toast;

class ControllerUsers extends Controller
{
    public function index()
    {
        redirectIfNotConnected();

        $users = $this->model->getUsers();
        $roles = $this->model->getUsersRoles();
        $this->view->Set('users', $users);
        $this->view->Set('roles', $roles);
        return $this->view->Render();
    }

    public function add()
    {
        redirectIfNotConnected();

        if (isset($_POST['submit'])) {
            // Checks if the pseudo exists
            if (!$this->model->existsUser($_POST['username'], $_POST['email'])) {
                if ($_POST['password'] == $_POST['passwordConf']) {
                    if (strlen($_POST['password']) >= 6) {
                        $this->model->addUser($_POST['role'], $_POST['username'], $_POST['password'], $_POST['email']);
                        Toast::message('User successfully added !', 'green');
                        Redirect::toAction('users');
                    } else
                        Toast::message(__('The length of the password must be at least of 6 characters !', true), 'red');
                } else
                    Toast::message(__('The password and its confirmation have to match !', true), 'red');
            } else
                Toast::message(__('This username or this e-mail address already exists !', true), 'red');
        }

        $roles = $this->model->getRoles();
        $this->view->Set('roles', $roles);
        return $this->view->Render();
    }

    public function edit()
    {
        redirectIfNotConnected();

        if (!isset($_GET['id']) || empty($_GET['id']))
            Redirect::toAction('users');

        if (isset($_POST['submit'])) {
            $html = '';
            $error = false;

            // Checks if the password is valid
            if ($_POST['changePass'] == 'true') {
                if ($_POST['password'] != $_POST['passwordConf']) {
                    $error = true;
                    $html .= __('The password confirmation does not match !', true) . '<br />';
                }

                // Checks if the length of the password is at least of 6 characters
                if (strlen($_POST['password']) < 6) {
                    $error = true;
                    $html .= __('The length of the password must be at least of 6 characters !', true) . '<br />';
                }
            }

            // Checks if pseudo already exists
            if ($this->model->existsUser($_POST['username'], $_POST['email'], $_POST['id'])) {
                $error = true;
                $html .= __('This username or this e-mail address already exists !', true) . '<br />';
            }

            // If no error, we can update the user
            if (!$error) {
                $this->model->updateUser($_POST['id'], $_POST['role'], $_POST['username'], $_POST['password'], $_POST['email']);
                Toast::message('User successfully updated !', 'green');
                Redirect::toAction('users');
            }

            Toast::message($html, 'red');
        }

        $user = $this->model->getUserById($_GET['id']);
        $roles = $this->model->getRoles();

        $this->view->Set('user', $user);
        $this->view->Set('roles', $roles);
        return $this->view->Render();
    }

    public function delete()
    {
        redirectIfNotConnected();

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->model->deleteUser($_GET['id']);
            Toast::message('User successfully deleted !', 'green');
        }

        Redirect::toAction('users');
    }
}