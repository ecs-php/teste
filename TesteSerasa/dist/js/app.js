var nomeApp = 'appSerasa';
var app = angular.module(nomeApp, []);

app.run(['$rootScope', '$http', function ($rootScope, $http) {
    $rootScope.next_date = '14/09';
    $rootScope.winners = [];
    $rootScope.nextDates = [];
    $rootScope.url = 'https://www.youtube.com/embed/_1CrH9F7byE?modestbranding=1&rel=0&controls=0&showinfo=0&html5=1&autoplay=1';


    $rootScope.setVideo = function () {
      angular.element('#myVideoModal').off('shown.bs.modal').on('shown.bs.modal', function () {
        angular.element('#myVideoModal iframe').attr('src', $rootScope.url);
      });
      angular.element('#myVideoModal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
        angular.element('#myVideoModal iframe').attr('src', '');
      });
    }

    $rootScope.getWinners = function () {
//      $http.get('.dist/data/data_winners.json')
//              .then(function (response) {
//                $rootScope.winners = response.data.winners;
//              }, function (error) {
//                console.log(error);
//              });
      $rootScope.winners = [
        {
          "date": "17/08",
          "city": "São Paulo - SP",
          "info": "Número sorteado: 053484058978-9"
        },
        {
          "date": "17/08",
          "city": "São Paulo - SP",
          "info": "Número sorteado: 053484058978-9"
        },
        {
          "date": "17/08",
          "city": "São Paulo - SP",
          "info": "Número sorteado: 053484058978-9"
        },
        {
          "date": "17/08",
          "city": "São Paulo - SP",
          "info": "Número sorteado: 053484058978-9"
        },
        {
          "date": "17/08",
          "city": "São Paulo - SP",
          "info": "Número sorteado: 053484058978-9"
        },
        {
          "date": "17/08",
          "city": "São Paulo - SP",
          "info": "Número sorteado: 053484058978-9"
        }
      ];
    };

    $rootScope.getNextDates = function () {
//      $http.get('./dist/data/next_dates.json')
//              .then(function (response) {
//                $rootScope.nextDates = response.data.nextDates;
//              }, function (error) {
//                console.log(error);
//              });
      $rootScope.nextDates = [
        {
          "date": "17/08",
          "status": "Y"
        },
        {
          "date": "24/08",
          "status": "Y"
        },
        {
          "date": "31/08",
          "status": "Y"
        },
        {
          "date": "7/09",
          "status": "Y"
        },
        {
          "date": "7/09",
          "status": "Y"
        },
        {
          "date": "17/08",
          "status": "Y"
        },
        {
          "date": "24/08",
          "status": "Y"
        },
        {
          "date": "31/08",
          "status": "N"
        },
        {
          "date": "7/09",
          "status": "N"
        },
        {
          "date": "7/09",
          "status": "N"
        },
        {
          "date": "17/08",
          "status": "N"
        },
        {
          "date": "24/08",
          "status": "N"
        },
        {
          "date": "31/08",
          "status": "N"
        },
        {
          "date": "7/09",
          "status": "N"
        },
        {
          "date": "7/09",
          "status": "N"
        },
        {
          "date": "17/08",
          "status": "N"
        },
        {
          "date": "24/08",
          "status": "N"
        },
        {
          "date": "31/08",
          "status": "N"
        },
        {
          "date": "7/09",
          "status": "N"
        },
        {
          "date": "7/09",
          "status": "N"
        }
      ];
    };

    $rootScope.getWinners();
    $rootScope.getNextDates();
    $rootScope.setVideo();
  }
]);