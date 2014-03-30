'use strict';

/* Controllers */

angular.module('App.controllers', ['App.services']).
  controller('HomeController', [function() {

  }])
  .controller('OrderDetailController', ['GeneralService', 'SERVICE_URL', '$sce', '$location', '$scope',
	function(GeneralService, SERVICE_URL, $sce, $location, $scope) {
		GeneralService.
					getData(SERVICE_URL.get_post_by_id, {id: $location.$$search['p']}).
					then(function(data){
						var temp = data.posts;
						for (var ii in temp){
							temp[ii].post_content = $sce.trustAsHtml(temp[ii].post_content);
						}
						if (!temp || !temp.length)
							temp = [{}]
						$scope.article = temp[0];
					});
	  }])
  .controller('StaticPageController', [function() {

  }])
   .controller('CategoryController', ['$scope', '$location', function($scope, $location) {
		var fixTitle = {
			4: "Xuât́ khẩu Nhật Bản",
			5: "Xuât́ khẩu Đài Loan",
			6: "Thông tin chính sách",
			7: "Thông tin mới XKLD"
		};
		$scope.category = {
			type: $location.$$search['cat'],
			title: fixTitle[$location.$$search['cat']],
			number: "all"
		}
  }]);