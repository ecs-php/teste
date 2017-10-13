<!DOCTYPE html>
<html lang="pt-br">
  	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Serasa Experian</title>
    
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
  	
  		<div ng-controller="clientsController" >
      		<header>
          		<nav class="navbar navbar-default">
                	<div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                        	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            	<span class="sr-only">Toggle navigation</span>
                            	<span class="icon-bar"></span>
                            	<span class="icon-bar"></span>
                            	<span class="icon-bar"></span>
                          	</button>
                          <a class="navbar-brand" href="#" ><img id="main-logo" src="assets/images/logo.png" alt="Serasa Experian"></a>
                        </div>
                        
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        	<ul class="nav navbar-nav navbar-right">
                            	<li><a href="#" ng-click="logout()"><i class="fa fa-sign-out"></i> Sair</a></li>
                          	</ul>
                        </div><!-- /.navbar-collapse -->                
                  	</div><!-- /.container-fluid -->
                </nav>
            </header>
            
            <div class="container-fluid">
            	<div class="section-title">
            		<h1>Lista de Clientes</h1>
            	</div>
            	
    			<hr>
    			
    			<div ng-init="loadList()">
    				<div class="row">
        				<div class="col-md-8">
        					<button class="btn btn-primary" id="btn-add-client"><i class="fa fa-plus"></i> Cadastrar novo cliente</button>
        				</div>
        				<div class="col-md-4">
        					<form ng-submit="loadList()">
            					<div class="input-group">
                                	<input type="text" class="form-control" placeholder="Pesquisar pelo ID..." ng-model="ID">
                                  	<span class="input-group-btn">
                                   		<button class="btn btn-default" type="submit" title="Buscar"><i class="fa fa-search"></i></button>
                                   		<button class="btn btn-default" type="button" ng-click="refresh()" title="Recarregar"><i class="fa fa-refresh"></i></button>
                                  	</span>
                                </div><!-- /input-group -->
                            </form>
        				</div>
    				</div>
    			
                	<table id="table-clients" class="table table-hover table-responsive table-striped">
                    	<thead>
                        	<tr>
                          		<th>ID</th>
                          		<th>Nome</th>
                          		<th>E-mail</th>
                          		<th>Telefone</th>
                          		<th>Nascimento</th>
                          		<th></th>
                        	</tr>
                      	</thead>
                      	
                      	<tbody>
                      		<tr>
                      			<td><button class="btn btn-default btn-sm" id="btn-close-client"><i class="fa fa-times"></i></button></td>
                      			<td><input type="text" class="form-control input-sm" ng-model="name" placeholder="Nome"></td>
                      			<td><input type="text" class="form-control input-sm" ng-model="email" placeholder="E-mail"></td>
                      			<td><input type="text" class="form-control input-sm mask-phone" ng-model="phone" placeholder="Telefone"></td>
                      			<td><input type="text" class="form-control input-sm mask-date" ng-model="date_birth" placeholder="Data de Nascimento"></td>
                      			<td><button class="btn btn-primary btn-sm btn-block" type="submit" ng-click="sendPost()">Salvar</button></td>
                      		</tr>
                        	<tr ng-repeat="item in clients">
                        		<td>
                        			<input type="hidden" ng-model="item.ID" class="form-control input-sm input-repeat">
                        			<span class="span-repeat">{[{item.ID}]}</span>
                        		</td>
                          		<td>
                          			<input type="text" ng-model="item.name" class="form-control input-sm input-repeat ir_{[{$index}]}">
                          			<span class="span-repeat sr_{[{$index}]}">{[{item.name}]}</span>
                          		</td>
                          		<td>
                          			<input type="text" ng-model="item.email" class="form-control input-sm input-repeat ir_{[{$index}]}">
                          			<span class="span-repeat sr_{[{$index}]}">{[{item.email}]}</span>
                          		</td>
                          		<td>
                          			<input type="text" ng-model="item.phone" class="form-control input-sm mask-phone input-repeat ir_{[{$index}]}">
                          			<span class="span-repeat sr_{[{$index}]}">{[{item.phone}]}</span>
                          		</td>
                          		<td>
                          			<input type="text" ng-model="item.date_birth_format" class="form-control input-sm mask-date input-repeat ir_{[{$index}]}">
                          			<span class="span-repeat sr_{[{$index}]}">{[{item.date_birth_format}]}</span>
                          		</td>
                          		<td>
                          			<button class="btn btn-sm btn-warning btn-edit-row btn-er_{[{$index}]}" ng-click="editRow($index)" title="Editar registro "><i class="fa fa-edit"></i> Editar</button>
                          			<button class="btn btn-sm btn-danger btn-delete_{[{$index}]}" ng-click="deleteClient(this)" title="Excluir registro"><i class="fa fa-times"></i> Excluir</button>
                          			
                          			<button class="btn btn-sm btn-success btn-repeat-save btn-rps_{[{$index}]}" ng-click="editPost(this)" title="Salvar alterações"><i class="fa fa-check"></i> Salvar</button>
                          			<button class="btn btn-sm btn-default btn-repeat-cancel btn-cnl_{[{$index}]}" ng-click="editRowCancel()"><i class="fa fa-times"></i> Cancelar</button>
                          		</td>
                        	</tr>
                      	</tbody>
                    </table>
                    
                    
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

			app.controller('clientsController', function($scope, $http){
				$scope.ID = '';
				$scope.name = '';
            	$scope.email = '';
            	$scope.phone = '';
            	$scope.date_birth = '';
				
				$scope.loadList = function(){
					var data = {ID:$scope.ID};

					$http.get('clients', {params:data}).then(function(response){
						$scope.clients = response.data;
					});
				}				

				$scope.refresh = function(){
					$scope.ID = '';
					$scope.loadList();
				}

				$scope.editRow = function(index){
					$('.ir_' + index).show();
					$('.ir_' + index).eq(0).focus();
					$('.sr_' + index).hide();
					$('.btn-rps_' + index).show();
					$('.btn-er_' + index).hide();
					$('.btn-delete_' + index).hide();
					$('.btn-cnl_' + index).show();
				}

				$scope.editRowCancel = function(){
					$scope.loadList();
				}
				
				$scope.sendPost = function(){
					if(!$scope.name){
						alert('Digite o nome');
						return;
					}
					
					var data = {
		            	name: $scope.name,
		            	email: $scope.email,
		            	phone: $scope.phone,
		            	date_birth: $scope.date_birth
		            };

		            if($scope.date_birth){
			            data.date_birth = date2bd($scope.date_birth);
			        }

					$scope.name = '';	
					$scope.email = '';
					$scope.phone = '';
					$scope.date_birth = '';

					$http.post('clients-action', data).then(function(response){
						$scope.loadList();
						$('#table-clients tbody tr:eq(0)').hide();
					});
				}

				$scope.editPost = function(e){
					if(!e.item.ID){
						alert('Digite o nome');
						return;
					}
					
					var data = {
						ID: e.item.ID,
		            	name: e.item.name,
		            	email: e.item.email,
		            	phone: e.item.phone,
		            	date_birth: e.item.date_birth_format
		            };

		            if(e.item.date_birth_format){
			            data.date_birth = date2bd(e.item.date_birth_format);
			        }

		            $http.put('clients-action', data).then(function(response){
						$scope.loadList();
					});
				}

				$scope.deleteClient = function(e){
					if(confirm('Deseja excluir o contato ' + e.item.name + '?')){
						$http.delete('clients-action/' + e.item.ID).then(function(response){
							$scope.loadList();
						});
					}
				}

				$scope.logout = function(){
					$http.get('logout').then(function(response){
						if(response.data.logout){
							window.location.href = 'login';
						}
					});
				}
				
			});

			function date2bd(string){
				return string.split('/').reverse().join('-');
			}
			
			$(function(){
				$('#table-clients tbody tr:eq(0)').hide();
				
				$('#btn-add-client').click(function(){
					$('#table-clients tbody tr:eq(0)').show(0, function(){
						$(this).find('input:eq(0)').focus();
					});
				});

				$('#btn-close-client').click(function(){
					$('#table-clients tbody tr:eq(0)').hide();
				});

				var SPMaskBehavior = function (val) {
				  return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
				},
				spOptions = {
				  onKeyPress: function(val, e, field, options) {
				      field.mask(SPMaskBehavior.apply({}, arguments), options);
				    }
				};
								
				$('.mask-phone').mask(SPMaskBehavior, spOptions);
				$('.mask-date').mask('00/00/0000');
			});
        </script>
  	</body>
</html>