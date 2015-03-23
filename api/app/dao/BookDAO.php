<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 18.03.15
 * Time: 22:11
 */

namespace dao;

require_once "AbstractDAO.php";

class BookDAO extends AbstractDAO
{

    /**
     * Gets all books
     * @return mixed
     */
    public function getBooks()
    {
        $sql = "SELECT b.id_book AS bookId, b.title, b.author, u.name AS owner
        FROM Tbl_Book b
        LEFT JOIN Tbl_Borrow w ON b.id_book = w.id_book
        LEFT JOIN Tbl_User u ON w.id_user = u.id_user";

        $db = $this->ds->getDBConnection();

        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Gets a book
     * @param $bookId
     * @return mixed
     */
    public function getBookById($bookId)
    {
        $sql = "SELECT b.id_book AS bookId, b.title, b.author, u.name AS owner
        FROM Tbl_Book b
        LEFT JOIN Tbl_Borrow w ON b.id_book = w.id_book
        LEFT JOIN Tbl_User u ON w.id_user = u.id_user
        WHERE b.id_book = :bookId";

        $db = $this->ds->getDBConnection();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bookId', $bookId);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Create a new book
     * @param $title
     * @param $author
     * @return mixed
     */
    public function createBook($title, $author)
    {
        $sql = "INSERT INTO Tbl_Book (title, author) VALUES (:title, :author)";

        $db = $this->ds->getDBConnection();
        $db->beginTransaction();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->execute();

        $bookId = $db->lastInsertId();

        $db->commit();

        return $bookId;
    }

    /**
     * Update a book
     * @param $bookId
     * @param $title
     * @param $author
     */
    public function updateBook($bookId, $title, $author)
    {
        $sql = "UPDATE Tbl_Book SET title = :title, author = :author WHERE id_book = :bookId";

        $db = $this->ds->getDBConnection();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bookId', $bookId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->execute();
    }

    /**
     * Delete a book
     * @param $bookId
     */
    public function deleteBook($bookId)
    {
        $sql = "DELETE FROM Tbl_Book WHERE id_book = :bookId";

        $db = $this->ds->getDBConnection();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bookId', $bookId);
        $stmt->execute();
    }
}