<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 15.03.15
 * Time: 18:28
 */

namespace service;


abstract class AbstractService {

    protected $app;

    /**
     * @param Slim application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }
}