<?php

namespace SanTourWeb\App\Model;

use SanTourWeb\Library\Mvc\Model;
use SanTourWeb\Library\Entity\Category;
use SanTourWeb\Library\Utils\Firebase\FirebaseLib;

class ModelCategories extends Model
{
    /**
     * Get back the list of all categories
     * @return mixed The list of categories
     */
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

    /**
     * Private method used to sort the categories by alphabetical order
     * @param $categories List of categories to sort
     * @return mixed The categories sorted
     */
    private function compareCategories($categories) {
        usort($categories, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return $categories;
    }

    /**
     * Method used to add a new category
     * @param $name Name of the category
     */
    public function addCategory($name)
    {
        $firebase = FirebaseLib::getInstance();
        $firebase->push('categories', array('name' => $name));
    }

    /**
     * Method used to update a category
     * @param $id Id of the category
     * @param $name Name of the category
     */
    public function updateCategory($id, $name)
    {
        $firebase = FirebaseLib::getInstance();
        $firebase->update('categories/'.$id, array('name' => $name));
    }

    /**
     * Method used to delete a category
     * @param $id Id of the category
     */
    public function deleteCategory($id)
    {
        $firebase = FirebaseLib::getInstance();
        $firebase->delete('categories/'.$id);
    }
}