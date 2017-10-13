<!DOCTYPE html>
<html lang="pt-br">
  	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Serasa Experian - Login</title>
    
        <!-- Bootstrap -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
    	
    	<!-- Favicon -->
    	<link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    	
    	<!-- Font Awesome -->
    	<link href="assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    	
    	<!-- Angular JS -->
    	<script src="assets/js/angular.min.js"></script>
    	
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
  	</head>
  	
  	<body ng-app="myApp">
  		
  		<div id="login-section" ng-controller="loginController">
  			
  			<div class="container">
  				<div class="row">
  					<div class="col-sm-4 col-md-offset-4">
              			<div class="panel panel-default panel-login">
                        	<div class="panel-heading text-center"><img src="assets/images/logo.png" alt="Serasa Experian"></div>
                          	<div class="panel-body">
                          		
                          		<form name="formLogin" ng-submit="login()">
                          			<div class="form-group">
                          				<input class="form-control" type="text" ng-model="user" autofocus="autofocus" placeholder="Digite seu login">
                          			</div>
                          			
                          			<div class="form-group">
                          				<input class="form-control" type="password" ng-model="pass" placeholder="Digite sua senha">
                          			</div>
                          			
                          			<div class="form-group">
                          				<button class="btn btn-success btn-block btn-lg"><i class="fa fa-lock"></i> Entrar</button>
                          			</div>
                          		</form>
                          	</div>
                        </div>			
  					</div>
  				</div>
  			</div>
  		</div>
  		
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    	<script src="assets/js/jquery.min.js"></script>
    	
        <!-- Include all compiled plugins (below), or include individual files as needed -->
    	<script src="assets/js/bootstrap.min.js"></script>
    	<script src="assets/plugins/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></Script>
    	
    	<script>
    		// É definido o Objeto $interpolateProvider com os símbolos '{[{ }]}' para não causar confito com o Twig
			var app = angular.module('myApp', []).config(function($interpolateProvider){
				$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
			});

			app.controller('loginController', function($scope, $http){
				$scope.login = function(){
					if(!$scope.user){
						alert('Digite seu login!');
						return;
					}

					if(!$scope.pass){
						alert('Digite sua senha!');
						return;
					}

					var data = {
						user:$scope.user,
						pass:$scope.pass
					};

					$http.post('session', data).then(function(response){
						if(response.data.auth){
							window.location.href = './';	
						}else{
							alert('Login ou senha incorreto!');
						}
					});
				}
			});
		</script>
  	</body>
</html>