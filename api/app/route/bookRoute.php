<?php
/**
 * Created by PhpStorm.
 * User: riccanicola
 * Date: 15.03.15
 * Time: 18:18
 */

$app->get('/book', function () use ($app) {
    echo json_encode($app->bookService->getBooks());
});

$app->put('/book', $authorize('admin'), function () use ($app) {

    $book = $app->request()->getBody();

    $title = isset($book['title']) ? $book['title'] : null;
    $author = isset($book['author']) ? $book['author'] : null;

    echo json_encode($app->bookService->createBook($title, $author));
});

$app->post('/book/:bookId', $authorize('admin'), function () use ($app) {

    $book = $app->request()->getBody();

    $bookId = isset($book['bookId']) ? $book['bookId'] : null;
    $title = isset($book['title']) ? $book['title'] : null;
    $author = isset($book['author']) ? $book['author'] : null;

    echo json_encode($app->bookService->updateBook($bookId, $title, $author));
});

$app->post('/book/:bookId/borrow', $authorize('user'), function ($bookId) use ($app) {
    echo json_encode($app->bookService->borrowBook($bookId));
});

$app->delete('/book/:bookId', $authorize('admin'), function ($bookId) use ($app) {
    $app->bookService->deleteBook($bookId);
});