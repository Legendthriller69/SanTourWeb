<?php

namespace SanTourWeb\Library\Entity;

/**
 * Class Track
 * @package SanTourWeb\Library\Entity
 */
class Track {
    private $id;
    private $idType;
    private $idUser;
    private $name;
    private $description;
    private $distance;
    private $duration;
    private $pods;
    private $pois;
    private $positions;

    /**
     * Track constructor.
     * @param $id
     * @param $idType
     * @param $idUser
     * @param $name
     * @param $description
     * @param $distance
     * @param $duration
     * @param $positions
     */
    public function __construct($id, $idType, $idUser, $name, $description, $distance, $duration)
    {
        $this->id = $id;
        $this->idType = $idType;
        $this->idUser = $idUser;
        $this->name = $name;
        $this->description = $description;
        $this->distance = $distance;
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdType()
    {
        return $this->idType;
    }

    /**
     * @param mixed $idType
     */
    public function setIdType($idType)
    {
        $this->idType = $idType;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getPods()
    {
        return $this->pods;
    }

    /**
     * @param mixed $pods
     */
    public function setPods($pods)
    {
        $this->pods = $pods;
    }

    /**
     * @return mixed
     */
    public function getPois()
    {
        return $this->pois;
    }

    /**
     * @param mixed $pois
     */
    public function setPois($pois)
    {
        $this->pois = $pois;
    }

    /**
     * @return mixed
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @param mixed $positions
     */
    public function setPositions($positions)
    {
        $this->positions = $positions;
    }
}