<?php

namespace SanTourWeb\App\Model;

use Kreait\Firebase;
use SanTourWeb\Library\Entity\User;
use SanTourWeb\Library\Entity\Role;
use SanTourWeb\Library\Mvc\Model;

class ModelIndex extends Model
{
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

    public function connectUser($mail, $password)
    {
        $firebase = Firebase::getInstance();
        $auth = $firebase->getAuth();
        $firebaseUser = $auth->getUserByEmailAndPassword($mail, $password);
        if ($firebaseUser != null) {
            $user = $this->getUserById($firebaseUser->getUid());
            $role = $this->getRoleById($user->getIdRole());
            if ($role->getName() == 'admin')
                return $user;
        }
        return null;
    }

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

    public function getRoleById($id)
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();
        $roleDB = $database->getReference('roles/' . $id)->getValue();

        return new Role($id, $roleDB['name']);
    }
}