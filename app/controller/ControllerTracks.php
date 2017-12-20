<?php

namespace SanTourWeb\App\Controller;

use SanTourWeb\Library\Mvc\Controller;
use SanTourWeb\Library\Utils\Toast;
use SanTourWeb\Library\Utils\Redirect;

class ControllerTracks extends Controller
{
    public function index()
    {
        redirectIfNotConnected();

        $tracks = $this->model->getTracks();
        $users = $this->model->getTracksUsers();
        $types = $this->model->getTracksTypes();

        $this->view->Set('tracks', $tracks);
        $this->view->Set('users', $users);
        $this->view->Set('types', $types);

        return $this->view->Render();
    }

    public function details()
    {
        redirectIfNotConnected();

        if (!isset($_GET['id']) || empty($_GET['id']))
            Redirect::toLastPage();

        $track = $this->model->getTrackById($_GET['id']);
        $user = $this->model->getUserById($track->getIdUser());
        $type = $this->model->getTypeById($track->getIdType());
        $categories = $this->model->getTracksCategories($_GET['id']);

        $this->view->Set('track', $track);
        $this->view->Set('user', $user);
        $this->view->Set('type', $type);
        $this->view->Set('categories', $categories);

        return $this->view->Render();
    }

    public function delete()
    {
        redirectIfNotConnected();

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->model->deleteTrack($_GET['id']);
            Toast::message(__('Track successfully deleted !', true), 'green');
            Redirect::toAction('tracks');
        } else
            Toast::message(__('Suppression failed !', true), 'red');

        return $this->view->Render();
    }
}