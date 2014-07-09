'use strict';


// Declare app level module which depends on filters, and services
angular.module('App', [
  'ngRoute',
  'App.filters',
  'App.services',
  'App.directives',
  'App.controllers',
  'TopOrderSlider',
  "SideBar"
]).
        
config(['$routeProvider', '$httpProvider', '$locationProvider', function($routeProvider, $httpProvider, $locationProvider) {
  $locationProvider.hashPrefix('!');
  $routeProvider.when('/home', {templateUrl: 'partials/home.html', controller: 'HomeController'});
  $routeProvider.when('/intro', {templateUrl: 'partials/intro.html', controller: 'StaticPageController'});
  $routeProvider.when('/category', {templateUrl: 'partials/category.html', controller: 'CategoryController'});
  $routeProvider.when('/order-detail', {templateUrl: 'partials/order-detail.html', controller: 'OrderDetailController'});
  $routeProvider.when('/contact', {templateUrl: 'partials/contact.html', controller: 'StaticPageController'});
  $routeProvider.otherwise({redirectTo: '/home'});

   // allow cross origin angularjs
  // in default angularjs doesn't support corss origin
  delete $httpProvider.defaults.headers.common['X-Requested-With'];

  /*
   * make upload data to server angularjs type like this
   *  field1 : value1
   *  field2 : value2
   *  /////
   *  in default angularjs will post data like
   *  {
   *      field1 : value1
   *      field2 : value2
   *  }
   */
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
  // Override $http service's default transformRequest
  $httpProvider.defaults.transformRequest = [function(data)
      {
          /**
           * The workhorse; converts an object to x-www-form-urlencoded serialization.
           * @param {Object} obj
           * @return {String}
           */
          var param = function(obj) {
              var query = '';
              var name, value, fullSubName, subName, subValue, innerObj, i;

              for (name in obj)
              {
                  value = obj[name];

                  if (value instanceof Array)
                  {
                      for (i = 0; i < value.length; ++i)
                      {
                          subValue = value[i];
                          fullSubName = name + '[' + i + ']';
                          innerObj = {};
                          innerObj[fullSubName] = subValue;
                          query += param(innerObj) + '&';
                      }
                  }
                  else if (value instanceof Object)
                  {
                      for (subName in value)
                      {
                          subValue = value[subName];
                          fullSubName = name + '[' + subName + ']';
                          innerObj = {};
                          innerObj[fullSubName] = subValue;
                          query += param(innerObj) + '&';
                      }
                  }
                  else if (value !== undefined && value !== null)
                  {
                      query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                  }
              }

              return query.length ? query.substr(0, query.length - 1) : query;
          };

          return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
      }];
}]);


	
function htmlspecialchars_decode(string, quote_style) {
  //       discuss at: http://phpjs.org/functions/htmlspecialchars_decode/
  //      original by: Mirek Slugen
  //      improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //      bugfixed by: Mateusz "loonquawl" Zalega
  //      bugfixed by: Onno Marsman
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //         input by: ReverseSyntax
  //         input by: Slawomir Kaniecki
  //         input by: Scott Cariss
  //         input by: Francois
  //         input by: Ratheous
  //         input by: Mailfaker (http://www.weedem.fr/)
  //       revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  //        example 1: htmlspecialchars_decode("<p>this -&gt; &quot;</p>", 'ENT_NOQUOTES');
  //        returns 1: '<p>this -> &quot;</p>'
  //        example 2: htmlspecialchars_decode("&amp;quot;");
  //        returns 2: '&quot;'

  var optTemp = 0,
    i = 0,
    noquotes = false;
  if (typeof quote_style === 'undefined') {
    quote_style = 2;
  }
  string = string.toString()
    .replace(/&lt;/g, '<')
    .replace(/&gt;/g, '>');
  var OPTS = {
    'ENT_NOQUOTES': 0,
    'ENT_HTML_QUOTE_SINGLE': 1,
    'ENT_HTML_QUOTE_DOUBLE': 2,
    'ENT_COMPAT': 2,
    'ENT_QUOTES': 3,
    'ENT_IGNORE': 4
  };
  if (quote_style === 0) {
    noquotes = true;
  }
  if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
    quote_style = [].concat(quote_style);
    for (i = 0; i < quote_style.length; i++) {
      // Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
      if (OPTS[quote_style[i]] === 0) {
        noquotes = true;
      } else if (OPTS[quote_style[i]]) {
        optTemp = optTemp | OPTS[quote_style[i]];
      }
    }
    quote_style = optTemp;
  }
  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
    string = string.replace(/&#0*39;/g, "'"); // PHP doesn't currently escape if more than one 0, but it should
    // string = string.replace(/&apos;|&#x0*27;/g, "'"); // This would also be useful here, but not a part of PHP
  }
  if (!noquotes) {
    string = string.replace(/&quot;/g, '"');
  }
  // Put this in last place to avoid escape being double-decoded
  string = string.replace(/&amp;/g, '&');

  return string;
}