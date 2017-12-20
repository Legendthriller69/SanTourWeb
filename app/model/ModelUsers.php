<?php

namespace SanTourWeb\App\Model;

use Kreait\Firebase;
use SanTourWeb\Library\Mvc\Model;
use SanTourWeb\Library\Entity\User;
use SanTourWeb\Library\Entity\Role;

class ModelUsers extends Model
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

        return $this->compareUsers($users);
    }

    public function getUsersRoles()
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();
        $users = $this->getUsers();

        $roles = array();
        foreach ($users as $key => $user) {
            $tempRole = $database->getReference('roles/' . $user->getIdRole())->getValue();
            $role = new Role($user->getIdRole(), $tempRole['name']);

            array_push($roles, $role);
        }

        return $roles;
    }

    public function getUserById($id)
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();
        $userDB = $database->getReference('users/' . $id)->getValue();

        return new User($id, $userDB['idRole'], $userDB['username'], $userDB['mail']);
    }

    public function getRoles()
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();
        $rolesDB = $database->getReference('roles')->getValue();

        $roles = array();
        foreach ($rolesDB as $key => $roleDB) {
            $role = new Role($key, $roleDB['name']);

            array_push($roles, $role);
        }

        return $this->compareRoles($roles);
    }

    private function compareRoles($roles) {
        usort($roles, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return $roles;
    }

    private function compareUsers($users) {
        usort($users, function ($a, $b) {
            return strcmp($a->getUsername(), $b->getUsername());
        });

        return $users;
    }

    public function addUser($idRole, $username, $password, $mail)
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();

        // Firebase insertion
        $auth = $firebase->getAuth();
        $user = $auth->createUserWithEmailAndPassword($mail, $password);

        // Database insertion
        $UID = $user->getUid();

        $user = array(
            'idRole' => $idRole,
            'username' => $username,
            'mail' => $mail
        );

        $database->getReference('users/' . $UID)->set($user);
    }

    public function updateUser($id, $idRole, $username, $password, $mail)
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();

        // Firebase updating
        $auth = $firebase->getAuth();
        $firebaseUser = $auth->getUser($id);

        $firebaseMail = $database->getReference('users/' . $id)->getChild('mail')->getValue();
        if ($firebaseMail != $mail)
            $auth->changeUserEmail($firebaseUser, $mail);

        if ($password != null)
            $auth->changeUserPassword($firebaseUser, $password);

        // Database updating
        $user = array(
            'idRole' => $idRole,
            'username' => $username,
            'mail' => $mail
        );

        $database->getReference('users/' . $id)->set($user);
    }

    public function deleteUser($id)
    {
        // Firebase deleting
        $firebase = Firebase::getInstance();
        $auth = $firebase->getAuth();
        $firebaseUser = $auth->getUser($id);
        $auth->deleteUser($firebaseUser);

        //Database deleting
        $database = $firebase->getDatabase();
        $database->getReference('users/' . $id)->remove();
    }

    public function existsUser($username, $mail, $id = 0)
    {
        $users = $this->getUsers();

        foreach ($users as $user) {
            if ($user->getUsername() == $username || $user->getMail() == $mail) {
                if ($user->getId() !== $id) {
                    return true;
                }
            }
        }
        return false;
    }
}