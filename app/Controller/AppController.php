<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

	public $components = array(
		'RequestHandler',
		'Session',
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'integracao_ssh',
				'action' => 'login',
				),
			)
		);

	public $helpers = array(
		'Session',
		'Html',
		'Form',
		);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

}
