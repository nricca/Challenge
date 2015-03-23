<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 19.03.15
 * Time: 10:41
 */

$app->post('/login', function () use ($app) {

    $params = $app->request()->getBody();

    $email = isset($params['email']) ? $params['email'] : null;
    $password = isset($params['password']) ? $params['password'] : null;

    echo json_encode($app->sessionService->login($email, $password));
});

$app->get('/logout', $authorize('user'), function () use ($app) {
    $app->sessionService->logout();
});