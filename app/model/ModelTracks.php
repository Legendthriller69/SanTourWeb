<?php

namespace SanTourWeb\App\Model;

use SanTourWeb\Library\Entity\Category;
use SanTourWeb\Library\Entity\Track;
use SanTourWeb\Library\Entity\Pod;
use SanTourWeb\Library\Entity\PodCategory;
use SanTourWeb\Library\Entity\Poi;
use SanTourWeb\Library\Entity\Position;
use SanTourWeb\Library\Entity\User;
use SanTourWeb\Library\Entity\Type;
use SanTourWeb\Library\Utils\Firebase\FirebaseLib;
use SanTourWeb\Library\Mvc\Model;

class ModelTracks extends Model
{
    /**
     * Method used to get the list of the tracks
     * @return mixed List of tracks
     */
    public function getTracks()
    {
        $firebase = FirebaseLib::getInstance();
        $tracksDB = json_decode($firebase->get('tracks'));
        $tracks = array();

        foreach ($tracksDB as $key => $trackDB) {
            $tempTrack = new Track($key, $trackDB->idType, $trackDB->idUser, $trackDB->name, $trackDB->description, $trackDB->distance, $trackDB->duration);

            array_push($tracks, $tempTrack);
        }

        return $this->compareTracks($tracks);
    }

    /**
     * Method used to get the information about the user of each track
     * @return array List of users
     */
    public function getTracksUsers()
    {
        $firebase = FirebaseLib::getInstance();
        $tracks = $this->getTracks();

        $users = array();
        foreach ($tracks as $track) {
            $tempUser = json_decode($firebase->get('users/' . $track->getIdUser()));
            $user = new User($track->getIdUser(), $tempUser->idRole, $tempUser->username, $tempUser->mail);
            array_push($users, $user);
        }

        return $users;
    }

    /**
     * Method used to get the information about the type of each track
     * @return array List of types
     */
    public function getTracksTypes()
    {
        $firebase = FirebaseLib::getInstance();
        $tracks = $this->getTracks();

        $types = array();
        foreach ($tracks as $track) {
            $tempType = json_decode($firebase->get('types/' . $track->getIdType()));
            $type = new Type($track->getIdType(), $tempType->name);
            array_push($types, $type);
        }

        return $types;
    }

    /**
     * Method used to get the information about the category of each track
     * @param $id
     * @return array
     */
    public function getTracksCategories($id)
    {
        $firebase = FirebaseLib::getInstance();
        $pods = $this->getTrackById($id)->getPods();

        $categories = array();
        if (isset($pods)) {
            foreach ($pods as $pod) {
                foreach ($pod->getPodCategories() as $podCategory) {
                    $tempCategory = json_decode($firebase->get('categories/' . $podCategory->getIdCategory()));
                    array_push($categories, new Category($podCategory->getIdCategory(), $tempCategory->name));
                }
            }
        }

        return $categories;
    }

    /**
     * Method used to sort the tracks by its distance
     * @param $tracks List of tracks
     * @return mixed The list of tracks sorted
     */
    private function compareTracks($tracks)
    {
        usort($tracks, function ($a, $b) {
            return strcmp($b->getDistance(), $a->getDistance());
        });

        return $tracks;
    }

    /**
     * Method used to get a track by its id
     * @param $id Id of the track
     * @return Track Recovered track
     */
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

        return $track;
    }

    /**
     * Method used to get a category by its id
     * @param $id id of the category
     * @return Category Recovered category
     */
    public function getCategoryById($id)
    {
        $firebase = FirebaseLib::getInstance();
        $categoryDB = json_decode($firebase->get('categories/' . $id));

        return new Category($id, $categoryDB->name);
    }

    /**
     * Method used to get a user by its id
     * @param $id id of the user
     * @return User Recovered user
     */
    public function getUserById($id)
    {
        $firebase = FirebaseLib::getInstance();
        $userDB = json_decode($firebase->get('users/' . $id));

        return new User($id, $userDB->idRole, $userDB->username, $userDB->mail);
    }

    /**
     * Method used to get a type by its id
     * @param $id id of the type
     * @return Type Recovered type
     */
    public function getTypeById($id)
    {
        $firebase = FirebaseLib::getInstance();
        $typeDB = json_decode($firebase->get('types/' . $id));

        return new Type($id, $typeDB->name);
    }

    /**
     * Method used to delete a track
     * @param $id Id of the track
     */
    public function deleteTrack($id)
    {
        $firebase = FirebaseLib::getInstance();
        $firebase->delete('tracks/' . $id);
    }
}