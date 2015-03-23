<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 18.03.15
 * Time: 22:13
 */

namespace dao;

/**
 * Abstract class that contains Slim's application and the data source.
 * Class AbstractDAO
 * @package dao
 */
class AbstractDAO
{
    protected $app;
    protected $ds;

    /**
     * @param Slim application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->ds = $app->dataSource;
    }
}