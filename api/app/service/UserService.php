<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 15.03.15
 * Time: 18:25
 */

namespace service;

require_once "AbstractService.php";

class UserService extends AbstractService
{
    /**
     * Register a new user
     * @param $name
     * @param $email
     * @param $password
     * @return \stdClass
     */
    public function createUser($name, $email, $password)
    {
        if ($email != null && $email != null && $password != null) {

            // add the user on db
            $userId = $this->app->userDAO->createUser($name, $email, sha1($password));

            $user = new \stdClass();
            $user->userId = $userId;
            $user->name = $name;
            $user->role = 'user';

            $this->app->sessionService->logUser($user);

            return $user;

        } else {
            $this->app->halt(400, 'Invalid parameters');
        }
    }
}