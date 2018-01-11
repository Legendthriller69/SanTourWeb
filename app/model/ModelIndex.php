<?php

namespace SanTourWeb\App\Model;

use Kreait\Firebase;
use SanTourWeb\Library\Entity\User;
use SanTourWeb\Library\Entity\Role;
use SanTourWeb\Library\Mvc\Model;
use Kreait\Firebase\Exception\AuthException;
use SanTourWeb\Library\Utils\Redirect;
use SanTourWeb\Library\Utils\Toast;

class ModelIndex extends Model
{
    /**
     * Method used to get the list of users
     * @return array The list of users
     */
    public function getUsers()
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();
        $usersDB = $database->getReference('users')->getValue();
        $users = array();

        foreach ($usersDB as $key => $userDB) {
            $tempUser = new User($key, $userDB['idRole'], $userDB['username'], $userDB['mail']);

            array_push($users, $tempUser);
        }

        return $users;
    }

    /**
     * Method used to connect the user with firebase
     * @param $mail Mail address of the user
     * @param $password Password of the user
     * @return bool|User If true, returns the user. If false, returns false
     */
    public function connectUser($mail, $password)
    {
        $firebase = Firebase::getInstance();
        $auth = $firebase->getAuth();
        try {
            $firebaseUser = $auth->getUserByEmailAndPassword($mail, $password);
            $user = $this->getUserById($firebaseUser->getUid());
            $role = $this->getRoleById($user->getIdRole());
            if ($role->getName() == 'admin')
                return $user;
        } catch (AuthException $e) {
            return false;
        }
    }

    /**
     * Method used to get one user by his id
     * @param $id Id of the user
     * @return User Recovered user
     */
    public function getUserById($id)
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();
        $usersDB = $database->getReference('users')->getValue();

        foreach ($usersDB as $key => $userDB) {
            if ($key == $id)
                return new User($id, $userDB['idRole'], $userDB['username'], $userDB['mail']);
        }
    }

    /**
     * Method used to get one role by its id
     * @param $id Id of the user
     * @return Role Recovered role
     */
    public function getRoleById($id)
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();
        $roleDB = $database->getReference('roles/' . $id)->getValue();

        return new Role($id, $roleDB['name']);
    }
}