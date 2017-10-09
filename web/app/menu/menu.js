'use strict';

angular.module('App.menu',[])
    .controller('MenuCtrl', ['$scope', '$http', '$location', '$route', function ($scope, $http, $location, $route) {
        var vm = $scope.vm = this;
        vm.userTupe = 'none';
        vm.user = {};
        vm.administrativeMenus = {
            'admin': [
                {
                    'route': '#!/home',
                    'name': 'Home'
                },
                {
                    'route': '#!/registers',
                    'name': 'Registration'
                },
                {
                    'route': '#!/users',
                    'name': 'Users'
                }
            ],
            'editor': [
                {
                    'route': '#!/home',
                    'name': 'Home'
                },
                {
                    'route': '#!/registers',
                    'name': 'Registration'
                }
            ]
        };

        vm.menus = {};
        vm.findUser = function () {
            vm.userType = 'none';
            $http({
                method: 'GET',
                url: '/api/users/userloggedin',
            }).then(function (response) {
                if(response.data.user == null){
                    vm.menus = {};
                    $location.path('/login');
                } else {
                    vm.user = response.data.user;
                    vm.menus = vm.administrativeMenus['admin'];
                    $location.path('/home');
                }
            }, function (err) {
                console.log(err);
            });
        }

        vm.logout = function () {
            $http({
                method: 'GET',
                url: '/api/users/logout',
            }).then(function (response) {
                if(response.data){
                    vm.menus = {};
                    $location.path('/login');
                }
            }, function (err) {
                console.log(err);
            });
        }

        vm.findUser();

    }]);