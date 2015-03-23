<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 16.02.14
 * Time: 07:48
 */

namespace helper;


class PropertiesHelper {

    private $properties;

    /**
     * Read the conf.ini file and retrieves database's configuration
     */
    public function __construct() {
        $this->properties = parse_ini_file( __DIR__  . "/../conf.ini", true);
    }

    // Database
    // -----------------------------------------------------------------------------

    public function getDBHost() {
        return $this->properties["database"]["dbhost"];
    }

    public function getDBUser() {
        return $this->properties["database"]["dbuser"];
    }

    public function getDBPass() {
        return $this->properties["database"]["dbpass"];
    }

    public function getDBName() {
        return $this->properties["database"]["dbname"];
    }
} 