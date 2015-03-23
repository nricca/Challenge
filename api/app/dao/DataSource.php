<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 18.03.15
 * Time: 22:12
 */

namespace dao;

class DataSource {

    private $dHost;
    private $dbUser;
    private $dbPass;
    private $dbName;
    private $dbh;

    /**
     * Constuctor
     * @param Pimple $di
     */
    public function __construct($dbHost, $dbUser, $dbPass, $dbName)
    {
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
    }

    /**
     * Close database connection
     */
    public function __destruct()
    {
        $this->dbh = null;
    }

    /**
     * Singleton
     * Get database connection
     *
     * @return dbh
     */
    public function getDBConnection()
    {
        if (!$this->dbh) {
            $this->dbh = new \PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
            $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $this->dbh;
    }
}