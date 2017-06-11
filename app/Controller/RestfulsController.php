<?php
App::uses('Controller', 'Controller');

class RestfulsController extends AppController {

	public $token = '1020304050'; // código que valida a autenticação ao webservice

	public function index()
	{
		$params = 'token='.$this->token.'&';

		// insere os parametros cajo haja no filtro de busca
		if(!empty($this->request->query)) {
			foreach ($this->request->query as $key => $value) {
				$params .= $key . '=' . $value . '&';
			}

			// disponibiza os dados digitados para o form
			$this->request->data['Restful'] = $this->request->query;
		} 

		// faz a requisição com o webservice para trazer os dados
		$users = file_get_contents( Router::url('/', true) . 'users' . DS . 'list?' . $params );
		$json = $users; 
		$users = json_decode($users); // decodifica os dados recebidos para serem enviados para a view

		// caso haja erro de autenticação executa o metodo errorValidation
		if(isset($users->return) && $users->return = 'error_token') {
			$this->errorValidation();
			$users = array(); // limpa a variavel
		} 

		$this->set(compact('users')); // disponibiliza os dados para a view
		$this->set(compact('json')); // disponibiliza o Json para a view
	}	

	public function add()
	{	
		// se for uma chamada get execute
		if(!empty($this->request->query)) {

			// se existir parametros, filtre-os
			$params = 'token='.$this->token.'&';
			foreach ($this->request->query as $key => $value) {
				$params .= $key . '=' . urlencode($value) . '&';
			}

			// faz a requisição com o webservice e envia os dados via get, e recebe o retorno do processo
			$user = file_get_contents( Router::url('/', true) . 'users' . DS . 'alter?' . $params );
			$json = $user;
			$user = json_decode($user); // decodifica os dados recebidos

			// caso haja erro de autenticação executa o metodo errorValidation
			if($user->return == 'error_token') {
				$this->errorValidation(true);
			} else {

				// se retornar sucesso
				if($user->return == 'success') {
					$this->Session->setFlash(NULL, 'success');
					return $this->redirect(array('action' => 'index'));
				} else {
					// se retornar com um erro
					$this->Session->setFlash(NULL, 'danger');
				}
				// disponibiza os dados digitados para o form
				$this->request->data['Restful'] = $this->request->query;
			}
		}

		$this->set(compact('json')); // disponibiliza o Json para a view
		
	}

	public function edit($id = null)
	{
		// se for uma chamada get execute
		if(!empty($this->request->query)) {

			// se existir parametros, filtre-os
			$params = 'token='.$this->token.'&';
			foreach ($this->request->query as $key => $value) {
				$params .= $key . '=' . urlencode($value) . '&';
			}

			// faz a requisição com o webservice e envia os dados via get, e recebe o retorno do processo
			$user = file_get_contents( Router::url('/', true) . 'users' . DS . 'alter?' . $params );
			$json = $user;
			$user = json_decode($user); // decodifica os dados recebidos

			// caso haja erro de autenticação executa o metodo errorValidation
			if($user->return == 'error_token') {
				$this->errorValidation(true);
			} else {

				// se retornar sucesso
				if($user->return == 'success') {
					$this->Session->setFlash(NULL, 'success');
					return $this->redirect(array('action' => 'index'));
				} else {
					// se retornar com um erro
					$this->Session->setFlash(NULL, 'danger');
				}
				// disponibiza os dados digitados para o form
				$this->request->data['Restful'] = $this->request->query;
			}
		} else {

			// faz a requisição com o webservice, lista o usuário selecionado, trás seus dados e preenche o form
			$user = file_get_contents( Router::url('/', true) . 'users' . DS . 'list?token='.$this->token.'&id='.$id);
			$json = $user;
			$user = json_decode($user); // decodifica os dados recebidos

			// caso haja erro de autenticação executa o metodo errorValidation
			if(!empty($user->return) && $user->return == 'error_token') {
				$this->errorValidation(true);
			} else {
				// disponibiza os dados recebidos para o form
				$this->request->data['Restful'] = (array)$user[0]->User;
			}
		}
		$this->set(compact('json'));
		
	}

	public function delete($id = null)
	{
		// faz a requisição com o webservice e envia o id do usuario a ser excluido
		$return = file_get_contents( Router::url('/', true) . 'users' . DS . 'delete?token='.$this->token.'&id='.$id );
		$return = json_decode($return); // decodifica os dados recebidos

		// caso haja erro de autenticação executa o metodo errorValidation
		if($return->return == 'error_token') {
			$this->errorValidation(true);
		} else { 
			if($return->return == 'success') {
				// se retornar sucesso
				$this->Session->setFlash(NULL, 'delete');
			} else {
				// se retornaR erro
				$this->Session->setFlash(NULL, 'danger');
			}
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function errorValidation($redirect = false)
	{
		$this->Session->setFlash(NULL, 'error_token');
		if($redirect) return $this->redirect(array('action' => 'index'));
	}

}

