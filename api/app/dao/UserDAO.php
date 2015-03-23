<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 18.03.15
 * Time: 22:11
 */

namespace dao;

require_once "AbstractDAO.php";

class UserDAO extends AbstractDAO
{

    /**
     * Add a new user on the database
     * @param $name
     * @param $email
     * @param $password
     * @return mixed
     */
    public function createUser($name, $email, $password)
    {
        try {
            $sql = "INSERT INTO Tbl_User (name, email, password) VALUES (:name, :email, :password)";

            $db = $this->ds->getDBConnection();
            $db->beginTransaction();

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            $userId = $db->lastInsertId();

            $db->commit();

            return $userId;

        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                $this->app->halt(409, "EMAIL_ALREADY_EXISTS");
            } else {
                $this->app->halt(500, $e);
            }
        }
    }

    /**
     * Retrieves user by email and password
     * @param $email
     * @param $password
     * @return mixed
     */
    public function getUserByEmailAndPassword($email, $password)
    {
        $sql = "SELECT id_user AS userId, name, IF(admin, 'admin', 'user') AS role FROM Tbl_User WHERE email = :email AND password = :password";

        $db = $this->ds->getDBConnection();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
}