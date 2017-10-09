'use strict';

angular.module('App.registers', ['ngRoute'])
.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.when('/registers', {
        templateUrl: 'app/registers/registers.html',
        controller: 'RegistersCtrl'
    });
}])
.controller('RegistersCtrl', ['$scope', '$http', function ($scope, $http) {
    var vm = $scope.vm = this;
    vm.registers = {};

    vm.findAll = function () {
        $http({
            method: 'GET',
            url: '/api/registers',
        }).then(function (response) {
            vm.registers = response.data;
        }, function (err) {
            console.log(err);
        });
    };

    vm.findAll();

}]);