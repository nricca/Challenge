<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 15.03.15
 * Time: 18:25
 */

namespace service;

require_once "AbstractService.php";

class SessionService extends AbstractService
{
    /**
     * Register the user on session
     * @param $user
     */
    public function logUser($user)
    {
        if (empty($_SESSION)) {
            session_start();
        }

        $_SESSION['user'] = clone $user;
    }

    /**
     * Authenticate a user
     * @param $email
     * @param $password
     * @return mixed
     */
    public function login($email, $password)
    {
        if (!empty($email) && !empty($password)) {
            // encrypt the password
            $password = sha1($password);

            // Get user
            $user = $this->app->userDAO->getUserByEmailAndPassword($email, $password);

            if ($user != null) {

                self::logUser($user);

                return $user;
            } else {
                $this->app->halt(404, "USER_NOT_FOUND");
            }
        } else {
            $this->app->halt(400, 'Invalid parameters');
        }
    }

    /**
     * Delete cookie and remove user from session
     */
    public function logout()
    {
        unset($_SESSION['user']);
        $this->app->deleteCookie('PHPSESSID');
    }
}