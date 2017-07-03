var app = angular.module('myApp');
app.controller('s01Ctrl', function($scope, $http, $uibModal, $rootScope) {   
    
    
    //Search consumer list
    $scope.listConsumers = function(){ 
      $http({
        url: './api/rest.php/list',
        method: "GET",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).then(function successCallback(response) {
          if(response.data != 'null'){
            $scope.consumers = response.data;
          }else{
            $scope.consumers = [{c_name:"",c_cpf:"Nenhum registro encontrado",c_birth_f:"",c_cphone:"",c_id:""}];
          }          
        }, function errorCallback(response) {
         
        });
     } 

     $scope.listConsumers();

     $rootScope.$on("listConsumersS01",$scope.listConsumers);
        
    //Open modal to include a new consumer    
    $scope.newConsumer = function() {
      $rootScope.id_edit = '';
        
        $scope.reg_name      = '';  
        $scope.reg_cpf      = '';  
        $scope.reg_birth      = '';  
        $scope.reg_cphone      = '';  


        var modalInstance = $uibModal.open({
          templateUrl: "modal_register",
          controller: "mdController",
          controllerAs: '$ctrl',
          keyboard :false,
          scope: $scope
        });
    
      };

     $scope.editConsumer = function($prm_id){
      $rootScope.id_edit = $prm_id;
          $http({
            url: './api/rest.php/list/'+$prm_id,
            method: "GET",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).then(function successCallback(response) {
              $scope.reg_name      = response.data[0].c_name;
              $scope.reg_cpf      = response.data[0].c_cpf;
              $scope.reg_birth      = new Date(response.data[0].c_birth);
              $scope.reg_cphone      = response.data[0].c_cphone;

              var modalInstance = $uibModal.open({
                templateUrl: "modal_register",
                controller: "mdController",
                controllerAs: '$ctrl',
                keyboard :false,
                scope: $scope
              });
            }, function errorCallback(response) {
             
            });
     } 

     $scope.deleteConsumer = function($prm_id){
        $rootScope.id_delete = $prm_id;
        var modalInstance = $uibModal.open({
          templateUrl: 'modal_delete',
          controller: 'RequisitaExclusaoCtrl',
          controllerAs: '$ctrl_delete',
        });
    }
  
});

app.controller('mdController', function($scope, $http, $uibModalInstance, $rootScope, $filter) {
     var $ctrl = this;   
        
    $scope.dateOptions = {
        dateDisabled: false,
        formatYear: 'yy',
        startingDay: 1
      };
    
    $scope.format = 'dd/MM/yyyy';
    
    $scope.open1 = function() {
        $scope.popup1.opened = true;
      };
      
      $scope.popup1 = {
        opened: false
      };      
   
      
    $ctrl.save = function () {
        if($scope.form_cad.$invalid){
            angular.forEach($scope.form_cad.$error, function (field) {
                angular.forEach(field, function(errorField){
                    errorField.$setTouched();
                })
            });
        }else{ 
           $ctrl.realizaCadastro();            
        }
        
      };
    
      $ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
      };
      
      $ctrl.realizaCadastro = function (){                
        
      var d = $scope.reg_birth;
      var dF = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
          $http({
             url: './api/rest.php/save'+(($rootScope.id_edit != '')?"/"+$rootScope.id_edit:''),
            method: "POST",
            data: 'c_name='+$scope.reg_name+ 
                    '&c_cpf='+$scope.reg_cpf+
                    '&c_birth='+dF+
                    '&c_cphone='+$scope.reg_cphone,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            
          }).then(function successCallback(response) {
                if(response.data.result == 'success'){
                  $rootScope.$emit('listConsumersS01');
                   $uibModalInstance.dismiss('cancel');                
                }
                 alert(response.data.message);
               
            }, function errorCallback(response) {
             
            });
        }
      
});


app.controller('RequisitaExclusaoCtrl', function($scope, $uibModalInstance, $rootScope, $http) {
     

     var $ctrl = this;

     $ctrl.delete = function () {

      $http({
           url: './api/rest.php/delete/'+$rootScope.id_delete,
          method: "DELETE",
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          
        }).then(function successCallback(response) {
             $rootScope.$emit('listConsumersS01');
             $uibModalInstance.dismiss('cancel');
             alert(response.data.message);
          }, function errorCallback(response) {
           
          });      
        

      };

      $ctrl.cancel = function () {
        $uibModalInstance.close();
        $uibModalInstance.dismiss('cancel');
      };

        
      
});