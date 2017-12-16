<?php

namespace SanTourWeb\Library\Entity;

class Pod {
    private $name;
    private $description;
    private $picture;
    private $position;
    private $podCategories;

    public function __construct($name, $description, $picture, $position, $podCategories)
    {
        $this->name = $name;
        $this->description = $description;
        $this->picture = $picture;
        $this->position = $position;
        $this->podCategories = $podCategories;
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
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPodCategories()
    {
        return $this->podCategories;
    }

    /**
     * @param mixed $podCategories
     */
    public function setPodCategories($podCategories)
    {
        $this->podCategories = $podCategories;
    }
}