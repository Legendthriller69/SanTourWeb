<?php

namespace SanTourWeb\App\Controller;

use SanTourWeb\Library\Mvc\Controller;
use SanTourWeb\Library\Utils\Toast;
use SanTourWeb\Library\Utils\Redirect;

class ControllerTracks extends Controller
{
    public function index()
    {
        $tracks = $this->model->getTracks();
        $users = $this->model->getTracksUsers();
        $this->view->Set('tracks', $tracks);
        $this->view->Set('users', $users);
        return $this->view->Render();
    }

    public function details()
    {
        if (!isset($_GET['id']) || empty($_GET['id']))
            Redirect::toLastPage();
        $track = $this->model->getTrackById($_GET['id']);
        $user = $this->model->getUserById($track->getIdUser());
        $this->view->Set('track', $track);
        $this->view->Set('user', $user);
        return $this->view->Render();
    }

    public function delete()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->model->deleteTrack($_GET['id']);
            Toast::message(__('Track successfully deleted !', true), 'green');
            Redirect::toAction('tracks');
        } else
            Toast::message(__('Suppression failed !', true), 'red');

        return $this->view->Render();
    }
}