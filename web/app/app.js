"use strict"

angular.module('App', [
    'ngRoute',
    'App.menu',
    'App.home',
    'App.login',
    'App.users',
    'App.registers'
])
    .config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {
        $locationProvider.hashPrefix('!');

        $routeProvider.otherwise({redirectTo: '/home'});
    }])
