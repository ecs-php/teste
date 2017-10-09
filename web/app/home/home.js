'use strict';

angular.module('App.home', ['ngRoute'])
.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.when('/home', {
        templateUrl: 'app/home/home.html',
        controller: 'HomeCtrl'
    });
}])
.controller('HomeCtrl', ['$scope', '$http', function ($scope, $http) {
    var vm = $scope.vm = this;
}]);