<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 18.03.15
 * Time: 22:11
 */

namespace dao;

require_once "AbstractDAO.php";

class BorrowDAO extends AbstractDAO
{

    /**
     * Borrow a book
     * @param $bookId
     * @param $userId
     * @return mixed
     */
    public function createBorrow($bookId, $userId)
    {
        $sql = "INSERT INTO Tbl_Borrow (id_book, id_user) VALUES (:bookId, :userId)";

        $db = $this->ds->getDBConnection();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bookId', $bookId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $bookId;
    }
}