<?php

namespace SanTourWeb\Library\Entity;

/**
 * Class PodCategory
 * @package SanTourWeb\Library\Entity
 */
class PodCategory {
    private $idCategory;
    private $value;

    /**
     * PodCategories constructor.
     * @param $idCategory
     * @param $value
     */
    public function __construct($idCategory, $value)
    {
        $this->idCategory = $idCategory;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }

    /**
     * @param mixed $idCategory
     */
    public function setIdCategory($idCategory)
    {
        $this->idCategory = $idCategory;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}