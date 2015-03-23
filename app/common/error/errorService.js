/**
 * Created by riccanicola on 19.03.15.
 */
'use strict';

angular.module('challenge')
    .service('errorService', function ($rootScope) {

        var _alerts = [];

        /**
         * Pubic API
         */
        return {

            addAlert: function (message) {
                _alerts.push(
                    {
                        type : 'danger',
                        message : message
                    }
                );

                $rootScope.$broadcast('errorService:newError', _alerts);
            },

            getAlerts: function() {
                return _alerts;
            }
        }
    });