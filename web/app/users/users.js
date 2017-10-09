'use strict';

angular.module('App.users', ['ngRoute'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/users', {
            templateUrl: 'app/users/users.html',
            controller: 'UsersCtrl'
        }).when('/users/add', {
            templateUrl: 'app/users/usersform.html',
            controller: 'UsersFormCtrl'
        }).when('/users/edit/:id', {
            templateUrl: 'app/users/usersform.html',
            controller: 'UsersFormCtrl'
        });
    }])
    .controller('UsersCtrl', ['$scope', '$http', '$location', function ($scope, $http, $location) {
        var vm = $scope.vm = this;

        vm.users = [];
        vm.findAll = function () {
            $http({
                method: 'GET',
                url: '/api/users',
            }).then(function (response) {
                    vm.users = response.data;
            }, function (err) {
                console.log(err);
            });
        };

        vm.delete = function (id) {
            if(confirm('Tem certeza?')){
                $http({
                    method: 'DELETE',
                    url: '/api/users/' + id,
                }).then(function (response) {
                    if(response.data.success){
                        vm.findAll();
                    }
                }, function (err) {
                    console.log(err);
                });
            }
        }

        vm.findAll();

    }])
    .controller('UsersFormCtrl', ['$scope', '$http', '$location', '$routeParams', function ($scope, $http, $location, $routeParams) {
        var vm = $scope.vm = this;
        vm.form = {};
        vm.url = '/api/users/save';
        vm.method = 'POST';
        var id = $routeParams.id;

        vm.find = function (id) {
            $http({
                method: 'GET',
                url: '/api/users/' + id,
            }).then(function (response) {
                vm.form = response.data;
                vm.form.password = 'do not change the password';
            }, function (err) {
                console.log(err);
            });
        };

        vm.save = function () {
            if(vm.form.password == 'do not change the password'){
                delete vm.form.password;
            }
            $http({
                method: vm.method,
                url: vm.url,
                data: vm.form
            }).then(function (response) {
                if(response.data){
                    $location.path('/users')
                }
            }, function (err) {
                console.log(err);
            });
        };

        if(id){
            vm.find(id);
            vm.url = '/api/users/save/' + id;
            vm.method = 'PUT';
        }

    }]);
