'use strict';

/* Directives */
var directives = angular.module('App.directives', []);

directives.directive('headerDirective', [function() {
        return function(scope, elm, attrs) {
           
        };
    }]);


directives.directive('listOrdersDirective', [function() {
        function link($scope, elm, attrs) {
            $scope.$watch("articles", function(){
               $('#mainFlexslider').flexslider({
                    animation: "fade",
                    prevText: '<i class="fa fa-angle-left icon-large"></i>',
                    nextText: '<i class="fa fa-angle-right icon-large"></i>',
                    manualControls: "#main-slider-control-nav li"
                }); 
            });            
        };

        return {
            restrict: 'EAC',
            link: link,
            templateUrl: "partials/sub-modules/top-order-slider.html"
        };
    }]);


directives.directive('headerNavigation', [function() {
        function link($scope, elm, attrs) {
            var example = $('#sf-menu').superfish({
                    delay: 400,
                    animation: {opacity: 'show', height: 'show'},
                    speed: 'fast',
                    autoArrows: false
                });
            $('#sf-menu > li').click(function(){
                $('#sf-menu > li').removeClass("current");
                $(this).addClass("current");
            })
        };

        return {
            restrict: 'EAC',
            link: link
        };
    }]);

directives.directive('orderListDirective', ['GeneralService', 'SERVICE_URL', '$sce', function(GeneralService, SERVICE_URL, $sce) {
        function link($scope, elm, attrs) {
		   $scope.category = attrs.category;
		   $scope.type = attrs.type;
		   $scope.number = attrs.number;
		   
		   var url = SERVICE_URL.get_top_five_order_with_category;
		   if (attrs.number == "all"){
			url = SERVICE_URL.get_all_orders_with_category;
		   }
		   
		   $scope.articles = [];
			GeneralService.
				getData(url, {category: $scope.type}).
				then(function(data){
					var temp = data.posts;
					for (var ii in temp){
						temp[ii].post_content = $sce.trustAsHtml(temp[ii].post_content);
						temp[ii].post_link = temp[ii].guid.split("?")[1];
						temp[ii].post_img = uploaded_img_url + temp[ii].post_img;
					}
					$scope.articles = temp;
				});
        };
        
        return {
            restrict: 'EAC',
            link: link,
			scope: {
			},
            templateUrl: "partials/sub-modules/order-list.html"
        };
    }]);
	

directives.directive('orderHightLightBottomDirective', ['GeneralService', 'SERVICE_URL', '$sce', function(GeneralService, SERVICE_URL, $sce) {
        function link($scope, elm, attrs) {
			
		   $scope.category = attrs.category;
		   $scope.type = attrs.type;		   
		   $scope.article = {};
		   
			GeneralService.
				getData(SERVICE_URL.get_top_five_order_with_category, {category: $scope.type}).
				then(function(data){
					var temp = data.posts;
					for (var ii in temp){
						temp[ii].post_content = $sce.trustAsHtml(temp[ii].post_content);
						temp[ii].post_link = temp[ii].guid.split("?")[1];
						temp[ii].post_img = uploaded_img_url + temp[ii].post_img;
					}
					if (!temp)
						temp = [{}]
					$scope.article = temp[0];
				});
        };
        
        return {
            restrict: 'EAC',
            link: link,
			scope: {
			},
            templateUrl: "partials/sub-modules/bottom-hight-ligh.html"
        };
    }]);	