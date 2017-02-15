<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controler das funções da API
require_once APPPATH.'/controllers/REST_Controller.php';

class API_Controller extends REST_Controller
{
    protected $token;

    public function __construct()
    {
        parent::__construct();
    }

    protected function token_validation()
    {
        // Verify Header
        if (isset($this->_head_args['token']) && !empty($this->_head_args['token'])) {
            $this->token = $this->_head_args['token'];

            if ($this->token != TOKEN) {
                $response = [
                    'success' => false,
                    'message' => $this->lang->line('text_rest_unauthorized'),
                ];

                $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $response = [
                'success' => false,
                'message' => $this->lang->line('text_rest_unauthorized'),
            ];

            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}
