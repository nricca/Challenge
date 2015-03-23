/**
 * Created by riccanicola on 18.03.15.
 */
'use strict';

angular.module('challenge')
    .service('bookService', function ($resource, $modal, errorService) {

        var Book = $resource(
            '/api/book/:bookId',
            {
                bookId: '@bookId'
            },
            {
                save: {
                    method: 'PUT'
                },
                update: {
                    method: 'POST'
                },
                borrow: {
                    method: 'POST',
                    url: '/api/book/:bookId/borrow'
                }
            }
        );

        /**
         * Open modal in order to create or edit a book
         * @param successCallback
         */
        function openBookModal(book, successCallback) {
            var modalInstance = $modal.open({
                templateUrl: 'common/book/book-popup.html',
                controller: function ($scope, $modalInstance, book) {

                    $scope.book = book != null ? angular.copy(book) : new Book();
                    $scope.isEditMode = $scope.book.hasOwnProperty('bookId')

                    function bookSuccess(data) {
                        $modalInstance.close(data);
                    }

                    function bookError(error) {
                        if (error.status === 401) {
                            errorService.addAlert('Vous devez être administrateur pour effectuer cette opération');
                        }
                        $scope.cancel();
                    }

                    $scope.delete = function () {
                        $scope.book.$delete(function () {
                            bookSuccess();
                        }, bookError);
                    }

                    $scope.save = function () {
                        if ($scope.isEditMode) {
                            $scope.book.$update(bookSuccess, bookError);
                        } else {
                            $scope.book.$save(bookSuccess, bookError);
                        }
                    }

                    $scope.cancel = function () {
                        $modalInstance.dismiss('cancel');
                    }
                },
                resolve: {
                    book: function () {
                        return book;
                    }
                }
            });

            modalInstance.result.then(successCallback);
        }

        /**
         * Pubic API
         */
        return {

            getBooks: function (successCallback) {
                Book.query(successCallback);
            },

            addBook: function (successCallback) {
                openBookModal(null, successCallback);
            },

            editBook: function (book, successCallback) {
                openBookModal(book, successCallback);
            },

            borrowBook: function (book, successCallback) {
                book.$borrow(successCallback, function(error) {
                    if (error.status === 401) {
                        errorService.addAlert('Vous devez être connecté pour effectuer cette opération');
                    }
                });
            }
        }
    });