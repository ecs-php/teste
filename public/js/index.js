var app  = angular.module('Application', []);


app.controller('IndexController', function ($scope,$http) {


    $scope.winners = [];
    $scope.lottery = [];
    $scope.current_lottery = null;



    $scope.loadWinners = function()
    {
        $http.get('http://www.teste.local/api').then(
            function success(objReturn){
                $scope.winners = objReturn.data.arrWinners;
                $scope.lottery = objReturn.data.arrLottery;
                $scope.current_lottery = objReturn.data.current_lottery;
            },
            function error(objReturn){

            }
        );
    }


    $scope.loadWinners();

});
