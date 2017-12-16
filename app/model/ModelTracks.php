<?php

namespace SanTourWeb\App\Model;

use SanTourWeb\Library\Entity\Category;
use SanTourWeb\Library\Entity\Track;
use SanTourWeb\Library\Entity\Pod;
use SanTourWeb\Library\Entity\PodCategory;
use SanTourWeb\Library\Entity\Poi;
use SanTourWeb\Library\Entity\Position;
use SanTourWeb\Library\Entity\User;
use SanTourWeb\Library\Utils\Firebase\FirebaseLib;
use SanTourWeb\Library\Mvc\Model;

class ModelTracks extends Model
{
    public function getTracks()
    {
        $firebase = FirebaseLib::getInstance();
        $tracksDB = json_decode($firebase->get('tracks'));
        $tracks = array();

        foreach ($tracksDB as $key => $trackDB) {
            $tempTrack = new Track($key, $trackDB->idType, $trackDB->idUser, $trackDB->name, $trackDB->description, $trackDB->distance, $trackDB->duration);

            array_push($tracks, $tempTrack);
        }

        usort($tracks, function($a, $b) {
            return strcmp($b->getDistance(), $a->getDistance());
        });

        return $tracks;
    }

    public function getTrackById($id)
    {
        $firebase = FirebaseLib::getInstance();
        $trackDB = json_decode($firebase->get('tracks/' . $id));

        $track = new Track($id, $trackDB->idType, $trackDB->idUser, $trackDB->name, $trackDB->description, $trackDB->distance, $trackDB->duration);

        if (isset($trackDB->pods)) {
            $pods = array();
            foreach ($trackDB->pods as $pod) {
                $position = new Position($pod->position->latitude, $pod->position->longitude, $pod->position->altitude, $pod->position->dateTime);
                $podCategories = array();
                foreach ($pod->podCategories as $podCategory)
                    array_push($podCategories, new PodCategory($podCategory->idCategory, $podCategory->value));
                array_push($pods, new Pod($pod->name, $pod->description, $pod->picture, $position, $podCategories));
            }

            $track->setPods($pods);
        }

        if (isset($trackDB->pois)) {
            $pois = array();
            foreach ($trackDB->pois as $poi) {
                $position = new Position($poi->position->latitude, $poi->position->longitude, $poi->position->altitude, $poi->position->dateTime);
                array_push($pois, new Poi($poi->name, $poi->description, $poi->picture, $position));
            }

            $track->setPois($pois);
        }

        if (isset($trackDB->positions)) {
            $positions = array();
            foreach ($trackDB->positions as $key => $position) {
                array_push($positions, new Position($position->latitude, $position->longitude, $position->altitude, $position->dateTime));
            }
        }

        $track->setPositions($positions);

//        echo 'Track :<br />';
//        echo 'Id : ' . $track->getId() . '<br />';
//        echo 'idType : ' . $track->getIdType() . '<br />';
//        echo 'idUser : ' . $this->getUserById($track->getIdUser())->getUsername() . '<br />';
//        echo 'name : ' . $track->getName() . '<br />';
//        echo 'description : ' . $track->getDescription() . '<br />';
//        echo 'distance : ' . $track->getDistance() . '<br />';
//        echo 'duration : ' . $track->getDuration() . '<br />';
//        echo '<br />';
//        $i = 1;
//        foreach ($pods as $pod) {
//            echo 'POD ' . $i . ' : <br />';
//            echo 'Nom : ' . $pod->getName() . ', Description : ' . $pod->getDescription() . ', Picture : ' . $pod->getPicture() . '<br />';
//            echo 'Latitude : ' . $pod->getPosition()->getLatitude() . ', Longitude : ' . $pod->getPosition()->getLongitude() . ', Altitude : ' . $pod->getPosition()->getAltitude() . ', DateTime : ' . $pod->getPosition()->getDateTime() . '<br />';
//            foreach ($pod->getPodCategories() as $podCategory) {
//                $category = $this->getCategoryById($podCategory->getIdCategory());
//                echo 'Category : ' . $category->getName() . ', Value : ' . $podCategory->getValue() . '<br />';
//            }
//            echo '<br />';
//            $i++;
//        }
//        $i = 1;
//        foreach ($pois as $poi) {
//            echo 'POI ' . $i . ' : <br />';
//            echo 'Nom : ' . $poi->getName() . ', Description : ' . $poi->getDescription() . '<br />';
//            echo 'Latitude : ' . $poi->getPosition()->getLatitude() . ', Longitude : ' . $poi->getPosition()->getLongitude() . ', Altitude : ' . $poi->getPosition()->getAltitude() . ', DateTime : ' . $poi->getPosition()->getDateTime() . '<br />';
//            echo '<br />';
//            $i++;
//        }
//        $i = 1;
//        foreach ($positions as $position) {
//            echo 'Position ' . $i . ' : <br />';
//            echo 'Latitude : ' . $position->getLatitude() . ', Longitude : ' . $position->getLongitude() . ', Altitude : ' . $position->getAltitude() . ', DateTime : ' . $position->getDateTime() . '<br />';
//            echo '<br />';
//            $i++;
//        }

        return $track;
    }

    public function getCategoryById($id)
    {
        $firebase = FirebaseLib::getInstance();
        $categoriesDB = json_decode($firebase->get('categories'));

        foreach ($categoriesDB as $key => $categoryDB) {
            if ($key == $id)
                return new Category($key, $categoryDB->name);
        }
    }

    public function getUserById($id)
    {
        $firebase = FirebaseLib::getInstance();
        $usersDB = json_decode($firebase->get('users'));

        foreach ($usersDB as $key => $userDB) {
            if ($key == $id)
                return new User($key, $userDB->idRole, $userDB->username, $userDB->mail);
        }
    }

    public function getTracksUsers()
    {
        $firebase = FirebaseLib::getInstance();
        $tracksDB = json_decode($firebase->get('tracks'));

        $users = array();
        foreach ($tracksDB as $trackDB) {
            $tempUser = json_decode($firebase->get('users/' . $trackDB->idUser));
            $user = new User($trackDB->idUser, $tempUser->idRole, $tempUser->username, $tempUser->mail);
            array_push($users, $user);
        }

        return $users;
    }

    public function deleteTrack($id)
    {
        $firebase = FirebaseLib::getInstance();
        $firebase->delete('tracks/' . $id);
    }
}