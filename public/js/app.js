'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', ['myApp.filters', 'myApp.services', 'myApp.directives']).
  config(['$routeProvider', function($routeProvider) {
    $routeProvider.when('/view1', {templateUrl: 'partials/partial1.ejs', controller: MyCtrl1});
    $routeProvider.when('/view2', {templateUrl: 'partials/partial2.ejs', controller: MyCtrl2});
    $routeProvider.when('/view3', {templateUrl: 'partials/partial3.ejs', controller: MyCtrl3});
    $routeProvider.when('/view4', {templateUrl: 'partials/partial4.ejs', controller: MyCtrl4});
    $routeProvider.otherwise({redirectTo: '/view1'});
  }]);
