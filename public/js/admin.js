var cms = angular.module('cms', ['ngRoute', 'mainctrl', 'ui.numeric']);
cms.config(function($routeProvider, $locationProvider) { 
	$routeProvider.
      when('/', {
        templateUrl: 'pages/dashboard.php',
        controller: 'MainCtrl',
        resolve: {
          function() {
            
          }          
        }
      }).
      otherwise({ redirectTo: '/' });
});