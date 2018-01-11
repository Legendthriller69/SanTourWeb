<?php

namespace SanTourWeb\App\Controller;

use SanTourWeb\Library\Mvc\Controller;
use SanTourWeb\Library\Utils\Toast;
use SanTourWeb\Library\Utils\Redirect;

class ControllerCategories extends Controller
{
    /**
     * Homepage of the categories section
     * Contains
     *  - the list of categories
     *  - a form to add a new category
     * @return mixed
     */
    public function index()
    {
        redirectIfNotConnected();

        if (isset($_POST['submit'])) {
            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $this->model->addCategory($_POST['name']);
                Toast::message(__('Category successfully added !', true), 'green');
            } else
                Toast::message(__('Adding failed !', true), 'red');
        }

        if (isset($_POST['submitEdit'])) {
            if (isset($_POST['editId']) && !empty($_POST['editId']) && isset($_POST['editName']) && !empty($_POST['editName'])) {
                $this->model->updateCategory($_POST['editId'], $_POST['editName']);
                Toast::message(__('Category successfully updated !', true), 'green');
            } else
                Toast::message(__('Updating failed !', true), 'red');
        }

        $categories = $this->model->getCategories();
        $this->view->Set('categories', $categories);
        return $this->view->Render();
    }

    /**
     * Action used to delete a category
     * @return mixed
     */
    public function delete()
    {
        redirectIfNotConnected();

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->model->deleteCategory($_GET['id']);
            Toast::message(__('Category successfully deleted !', true), 'green');
        }

        Redirect::toAction('categories');
    }
}