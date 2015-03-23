/**
 * Created by riccanicola on 16.03.15.
 */

'use strict';

angular.module('challenge')
    .controller('MainCtrl', function ($scope, $rootScope, userService, bookService) {

        $scope.user;
        $scope.credentials = {};
        $scope.loginMode = true;
        $scope.loginError = false;
        $scope.emailAlreadyExists = false;
        $scope.books = [];
        $scope.search = {};

        function successCallback(user) {
            $scope.user = user;
            $scope.isAdmin = user.role === 'admin';
            $scope.isUser = user.role === 'user';
        }

        function registerErrorCallback(error) {
            $scope.emailAlreadyExists = error === 'EMAIL_ALREADY_EXISTS';
        }

        function loginErrorCallback(error) {
            $scope.loginError = error === 'USER_NOT_FOUND';
        }

        function removeAccents(value) {
            return value
                .replace(/á/g, 'a')
                .replace(/â/g, 'a')
                .replace(/é/g, 'e')
                .replace(/è/g, 'e')
                .replace(/ê/g, 'e')
                .replace(/í/g, 'i')
                .replace(/ï/g, 'i')
                .replace(/ì/g, 'i')
                .replace(/ó/g, 'o')
                .replace(/ô/g, 'o')
                .replace(/ú/g, 'u')
                .replace(/ü/g, 'u')
                .replace(/ç/g, 'c')
                .replace(/ß/g, 's');
        }


        /**
         * Toggle between login and register form
         */
        $scope.toggleLogin = function () {
            $scope.loginMode = !$scope.loginMode;
        };

        /**
         * Authenticate a user
         */
        $scope.login = function () {
            $scope.loginError = false;
            $scope.emailAlreadyExists = false;
            userService.login($scope.credentials, successCallback, loginErrorCallback);
        };

        /**
         * Register a new user
         */
        $scope.register = function () {
            $scope.loginError = false;
            $scope.emailAlreadyExists = false;
            userService.register($scope.credentials, successCallback, registerErrorCallback);
        };

        /**
         * Log out user and remove it from memory
         */
        $scope.logout = function () {
            userService.logout(function () {
                $scope.user = undefined;
                $scope.isAdmin = false;
                $scope.isUser = false;
            });
        };

        /**
         * Add a new book
         * @param book
         */
        $scope.addBook = function () {
            bookService.addBook(function (newBook) {
                $scope.books.push(newBook);
            })
        };

        /**
         * Update or remove an existing book
         * @param book
         */
        $scope.editBook = function (book) {
            bookService.editBook(book, function (updatedBook) {
                if (updatedBook != undefined) {
                    $scope.books[$scope.books.indexOf(book)] = updatedBook;
                } else {
                    $scope.books.splice($scope.books.indexOf(book), 1);
                }
            });
        };

        /**
         * Borrow a book
         * @param book
         */
        $scope.borrowBook = function (book) {
            bookService.borrowBook(book, function (updatedBook) {
                $scope.books[$scope.books.indexOf(book)] = updatedBook;
            });
        };

        /**
         * Remove alert
         * @param index
         */
        $scope.closeAlert = function (index) {
            $scope.alerts.splice(index, 1);
        };

        /**
         * Filter function for books
         * @param book
         * @returns {boolean}
         */
        $scope.filterFunction = function (book) {
            if ($scope.search.text) {
                var search = removeAccents($scope.search.text).toLowerCase();
                var title = removeAccents(book.title).toLowerCase();
                var author = removeAccents(book.author).toLowerCase();
                return title.indexOf(search) > -1 || author.indexOf(search) > -1;
            }
            return true;
        }


        /**
         * Refresh alerts when event is broadcast
         */
        $rootScope.$on('errorService:newError', function (event, alerts) {
            $scope.alerts = alerts;
        });


        /**
         * Load books when dom's ready
         */
        bookService.getBooks(function (data) {
            $scope.books = data;
        });

    });