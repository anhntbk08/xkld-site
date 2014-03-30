'use strict';


// Declare app level module which depends on filters, and services
angular.module('SideBar', []).

controller('SideBarController', ['$scope', function($scope) {
      
  }]).
  
directive('sideBarDirective', [function() {
        function link($scope, elm, attrs) {
               
        };
        return {
            restrict: 'EAC',
            link: link,
            templateUrl: "partials/sub-modules/side-bar.html"
        };
    }]);
