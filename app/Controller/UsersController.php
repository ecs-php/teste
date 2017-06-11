<?php
App::uses('Controller', 'Controller');

class UsersController extends AppController {

	public $token = '1020304050'; // código que valida a autenticação ao webservice

	public function list()
	{
		$this->autoRender = false;
		if($this->request->query['token'] != $this->token) {
			return json_encode(array('return' => 'error_token'));
		}
		$conditions = array();
		if(!empty($this->request->query['id'])) {
			$conditions['User.id'] = $this->request->query['id'];
		}
		$users = $this->User->find('all', array('conditions' => $conditions));
		echo json_encode($users);
	}	

	public function alter()
	{
		$this->autoRender = false;
		if(empty($this->request->query['token']) || $this->request->query['token'] != $this->token) {
			return json_encode(array('return' => 'error_token'));
		}
		if(!empty($this->request->query)) {
			foreach ($this->request->query as $key => $value) {
				$data['User'][$key] = urldecode($value);
			}
			if($this->User->save($data)) {
				$return = array('return' => 'success');
			} else {
				$return = array('return' => 'error');
			}
		} else {
			$return = array('return' => 'error');
		}
		return json_encode($return);
	}

	public function delete()
	{
		$this->autoRender = false;
		if($this->request->query['token'] != $this->token) {
			return json_encode(array('return' => 'error_token'));
		}
		if($this->User->delete($this->request->query['id'])) {
			$return = array('return' => 'success'); 
		} else {
			$return = array('return' => 'error');
		}
		return $return;
	}

}
