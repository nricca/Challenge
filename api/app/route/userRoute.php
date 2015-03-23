<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 15.03.15
 * Time: 18:18
 */

$app->put('/user', function () use ($app) {

    $user = $app->request()->getBody();

    $name = isset($user['name']) ? $user['name'] : null;
    $email = isset($user['email']) ? $user['email'] : null;
    $password = isset($user['password']) ? $user['password'] : null;

    echo json_encode($app->userService->createUser($name, $email, $password));
});