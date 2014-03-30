'use strict';

/* Services */

angular.module('App.services', [])
 
.factory("GeneralService", ['$http', '$q', function($http, $q){
  return {
      getData: function(url, params){
          var deferred = $q.defer();
          $http({
            method: 'GET',
            url: url,
            params: params
          }).
          success(function(data, status, headers, config) {
            deferred.resolve(data);
          }).
          error(function(data, status, headers, config) {
            deferred.resolve(data);
          });
          return deferred.promise;
      },
      postData: function(url, data){
            var deferred = $q.defer();

            $http({
                method: 'POST',
                url: url,
                data: data
            }).
            success(function(data, status, headers, config) {
                deferred.resolve(data);
            }).
            error(function(data, status, headers, config) {
                deferred.resolve(data);
            });

            return deferred.promise;
      }
  }
}])


