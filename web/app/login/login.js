'use strict';

angular.module('App.login', ['ngRoute'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/login', {
            templateUrl: 'app/login/login.html',
            controller: 'LoginCtrl'
        });
    }])
    .controller('LoginCtrl', ['$scope', '$http', '$location', function ($scope, $http, $location) {
        var vm = $scope.vm = this;
        vm.username = null;
        vm.password = null;

        vm.errorMessage = false;

        vm.login = function () {
            vm.errorMessage = false;
            $http({
                method: 'POST',
                url: '/api/users/login',
                data: {
                    username: vm.username,
                    password: vm.password
                }
            }).then(function (response) {
                var data = response.data;
                if(data.success){
                    location.reload();
                } else {
                    vm.errorMessage = data.error;
                }
            }, function (err) {
                console.log(err);
            });
        }
    }]);