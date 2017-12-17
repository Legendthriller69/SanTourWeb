<?php

namespace SanTourWeb\App\Model;

use SanTourWeb\Library\Mvc\Model;
use SanTourWeb\Library\Entity\Category;
use SanTourWeb\Library\Utils\Firebase\FirebaseLib;

class ModelCategories extends Model
{
    public function getCategories()
    {
        $firebase = FirebaseLib::getInstance();
        $categoriesDB = json_decode($firebase->get('categories'));
        $categories = array();

        foreach ($categoriesDB as $key => $categoryDB) {
            $tempCategory = new Category($key, $categoryDB->name);

            array_push($categories, $tempCategory);
        }

        return $this->compareCategories($categories);
    }

    private function compareCategories($categories) {
        usort($categories, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return $categories;
    }

    public function addCategory($name)
    {
        $firebase = FirebaseLib::getInstance();
        $firebase->push('categories', array('name' => $name));
    }

    public function updateCategory($id, $name)
    {
        $firebase = FirebaseLib::getInstance();
        $firebase->update('categories/'.$id, array('name' => $name));
    }

    public function deleteCategory($id)
    {
        $firebase = FirebaseLib::getInstance();
        $firebase->delete('categories/'.$id);
    }
}