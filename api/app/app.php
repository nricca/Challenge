<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 15.03.15
 * Time: 17:26
 */

require_once "helper/PropertiesHelper.php";
require_once "dao/DataSource.php";
require_once "dao/UserDAO.php";
require_once "dao/BookDAO.php";
require_once "dao/BorrowDAO.php";
require_once "service/UserService.php";
require_once "service/SessionService.php";
require_once "service/BookService.php";


// Start and run the Slim application
$app = new \Slim\Slim(
    array(
        'debug' => true
    )
);
$app->add(new \Slim\Middleware\ContentTypes());


// Token Authentication Middleware
// -----------------------------------------------------------------------------
// Halt the response if the token is not valid.

$authorize = function ($role = "user") use ($app) {
    return function () use ($role, $app) {

        if (empty($_SESSION)) {
            session_start();
        }

        // First, check to see if the user is logged in at all
        if (!empty($_SESSION['user'])) {

            // Next, validate the role to make sure they can access the route
            if ($_SESSION['user']->role == $role ||
                $_SESSION['user']->role == 'admin'
            ) {
                //User is logged in and has the correct permissions... Nice!
                return true;
            } else {
                // If a user is logged in, but doesn't have permissions, return 403
                $app->halt(403, 'You shall not pass!');
            }
        } else {
            // If a user is not logged in at all, return a 401
            $app->halt(401, 'You shall not pass!');
        }
    };
};

// Dependency Injection
// -----------------------------------------------------------------------------

$app->container->singleton('properties', function () use ($app) {
    return new \helper\PropertiesHelper();
});

$app->container->singleton('dataSource', function () use ($app) {
    return new \dao\DataSource(
        $app->properties->getDBHost(),
        $app->properties->getDBUser(),
        $app->properties->getDBPass(),
        $app->properties->getDBName()
    );
});

$app->container->singleton('userDAO', function () use ($app) {
    return new \dao\UserDAO($app);
});

$app->container->singleton('bookDAO', function () use ($app) {
    return new \dao\BookDAO($app);
});

$app->container->singleton('borrowDAO', function () use ($app) {
    return new \dao\BorrowDAO($app);
});

$app->container->singleton('userService', function () use ($app) {
    return new \service\UserService($app);
});

$app->container->singleton('sessionService', function () use ($app) {
    return new \service\SessionService($app);
});

$app->container->singleton('bookService', function () use ($app) {
    return new \service\BookService($app);
});

// Routes
// -----------------------------------------------------------------------------

include("route/userRoute.php");
include("route/sessionRoute.php");
include("route/bookRoute.php");


$app->run();
