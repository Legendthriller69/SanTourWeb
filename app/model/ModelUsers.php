<?php

namespace SanTourWeb\App\Model;

use Kreait\Firebase;
use SanTourWeb\Library\Mvc\Model;
use SanTourWeb\Library\Entity\User;
use SanTourWeb\Library\Entity\Role;

class ModelUsers extends Model
{
    /**
     * Method used to get the list of users
     * @return mixed List of users
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

        return $this->compareUsers($users);
    }

    /**
     * Method used to get the role for each user
     * @return array List of roles
     */
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

    /**
     * Method used to get a user by its id
     * @param $id Id of the user
     * @return User Recovered user
     */
    public function getUserById($id)
    {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();
        $userDB = $database->getReference('users/' . $id)->getValue();

        return new User($id, $userDB['idRole'], $userDB['username'], $userDB['mail']);
    }

    /**
     * Method used to get the list of roles
     * @return mixed List of roles
     */
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

    /**
     * Method used to sort the roles by alphabetical order
     * @param $roles List of roles
     * @return mixed List of roles sorted
     */
    private function compareRoles($roles) {
        usort($roles, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return $roles;
    }

    /**
     * Method used to sort the users by alphabetical order
     * @param $users List of users
     * @return mixed List of users sorted
     */
    private function compareUsers($users) {
        usort($users, function ($a, $b) {
            return strcmp($a->getUsername(), $b->getUsername());
        });

        return $users;
    }

    /**
     * Method used to add a new user
     * @param $idRole Id of the user's role
     * @param $username Username of the user
     * @param $password Password of the user
     * @param $mail E-mail of the user
     */
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

    /**
     * Method used to update a user
     * @param $id Id of the user
     * @param $idRole New role of the user
     * @param $username New username of the user
     * @param $password New password of the user
     * @param $mail New e-mail address of the user
     */
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

    /**
     * Method used to delete a user
     * @param $id Id of the user
     */
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

    /**
     * Method used to check if a user (its username, e-mail address or id) already exists
     * @param $username Username of the user
     * @param $mail E-mail E-mail address of the user
     * @param int $id Id of the user
     * @return bool True if exists, False if not.
     */
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