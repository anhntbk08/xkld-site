'use strict';
// Declare app level module which depends on filters, and services
angular.module('TopOrderSlider', ['App.services', 'config']).
controller('OrderSliderController', ['$scope', 'GeneralService', 'SERVICE_URL', function($scope, GeneralService, SERVICE_URL) {
    $scope.articles = [	];
    GeneralService.
        getData(SERVICE_URL.get_top_five_order).
        then(function(data){
            var temp = data.posts;
			var defaultUrl = "assets/images/_slider/{{$index}}.jpg";
            for (var ii in temp){
				temp[ii].post_link = temp[ii].guid.split("?")[1];
				temp[ii].post_img = uploaded_img_url + temp[ii].post_img;
				
			}
			$scope.articles = temp;
        });
        
  }]).
  
directive('topOrderSliderDirective', [function() {
        function link($scope, elm, attrs) {
            $scope.$watch("articles", function(){
               $('#mainFlexslider').flexslider({
                    animation: "fade",
                    prevText: '<i class="fa fa-angle-left icon-large"></i>',
                    nextText: '<i class="fa fa-angle-right icon-large"></i>',
                    manualControls: "#main-slider-control-nav li"
                }); 
            });
			$scope.render = function(e) {
				return $(e).html();
			}
        };
        return {
            restrict: 'EAC',
            link: link,
            templateUrl: "partials/sub-modules/top-order-slider.html"
        };
    }]);
