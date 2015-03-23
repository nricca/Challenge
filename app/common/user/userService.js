/**
 * Created by riccanicola on 18.03.15.
 */
'use strict';

angular.module('challenge')
    .service('userService', function ($http) {

        /**
         * Pubic API
         */
        return {

            register: function (userCredentials, successCallback, errorCallBack) {

                $http({method: 'PUT', url: '/api/user', data: userCredentials})
                    .success(function (data) {
                        successCallback(data);
                    })
                    .error(function (data) {
                        errorCallBack(data);
                    });
            },

            login: function (userCredentials, successCallback, errorCallBack) {

                $http({method: 'POST', url: '/api/login', data: userCredentials})
                    .success(function (data) {
                        successCallback(data);
                    })
                    .error(function (data) {
                        errorCallBack(data);
                    });
            },

            logout: function (successCallback) {

                $http({method: 'GET', url: '/api/logout'})
                    .success(function () {
                        successCallback();
                    });
            }
        }
    });