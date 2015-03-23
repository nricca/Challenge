<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 15.03.15
 * Time: 18:25
 */

namespace service;

require_once "AbstractService.php";

class BookService extends AbstractService
{
    /**
     * Retrieves all books from DB
     * @return mixed
     */
    public function getBooks()
    {
        return $this->app->bookDAO->getBooks();;
    }

    /**
     * Create a new book
     * @param $title
     * @param $author
     * @return \stdClass
     */
    public function createBook($title, $author)
    {
        if ($title != null && $author != null) {

            $bookId = $this->app->bookDAO->createBook($title, $author);

            $book = new \stdClass();
            $book->bookId = $bookId;
            $book->title = $title;
            $book->author = $author;

            return $book;

        } else {
            $this->app->halt(400, 'Invalid parameters');
        }
    }

    /**
     * Update a book
     * @param $bookId
     * @param $title
     * @param $author
     * @return \stdClass
     */
    public function updateBook($bookId, $title, $author)
    {
        if ($bookId != null && $title != null && $author != null) {

            $this->app->bookDAO->updateBook($bookId, $title, $author);

            return $this->app->bookDAO->getBookById($bookId);

        } else {
            $this->app->halt(400, 'Invalid parameters');
        }
    }


    /**
     * Borrow a book
     * @param $bookId
     * @param $title
     * @param $author
     * @return \stdClass
     */
    public function borrowBook($bookId)
    {
        if ($bookId != null) {

            $this->app->borrowDAO->createBorrow($bookId, $_SESSION["user"]->userId);

            return $this->app->bookDAO->getBookById($bookId);

        } else {
            $this->app->halt(400, 'Invalid parameters');
        }
    }

    /**
     * Delete a book
     * @param $bookId
     */
    public function deleteBook($bookId)
    {
        if ($bookId != null) {
            $this->app->bookDAO->deleteBook($bookId);

        } else {
            $this->app->halt(400, 'Invalid parameters');
        }
    }
}