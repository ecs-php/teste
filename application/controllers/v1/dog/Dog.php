<?php

/*
 * Dog Class Controller
 *
 * @package         Dog REST API
 * @category        Controllers
 * @author          Victor Santiago
 * @version         1.0
 */

defined('BASEPATH') or exit('No direct script access allowed');

// API Controller
require_once APPPATH.'/controllers/API_Controller.php';

class Dog extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('v1/dog/dog_model');
    }

    /**
     *  Early checks
     *
     * @param int array $this->post(), $this->get(), $this->patch()
     * @param int int   $status
     */
    protected function early_checks()
    {
        $this->token_validation();
        $this->input_validation();
    }

    /**
     * Search
     *
     * @param array $dados
     */
    public function index_get()
    {
        if ($this->get('id') && !empty($this->get('id'))) {
            $response = $this->dog_model->search($this->get('id'));
        } else {
            $response = $this->dog_model->search();
        }

        $this->response($response['dados'], $response['code']);
    }

    /**
     * Insert
     *
     * @param int   $status
     * @param array $dados
     */
    public function index_post()
    {
        $response = $this->dog_model->insert($this->post());
        $this->response($response['response'], $response['code']);
    }

    /**
     * Update
     *
     * @param array $dados
     */
    public function index_patch()
    {
        $response = $this->dog_model->update($this->patch());
        $this->response($response['response'], $response['code']);
    }

    /**
     * Delete
     *
     * @param int $dados
     */
    public function index_delete()
    {
        $response = $this->dog_model->delete($this->get());
        $this->response($response['response'], $response['code']);
    }

    /**
     * Input Validation
     *
     * @param $this->method;
     *
     * @return validate data
     */
    protected function input_validation()
    {
        switch ($this->input->method()) {
            case 'get':
                //Data Validation
                $this->get_validation($this->get());
                break;

            case 'post':
                //Data Validation
                $this->post_validation($this->post());
                break;

            case 'patch':
                //Data Validation
                $this->patch_validation($this->patch());
                break;

            case 'delete':
                //Data Validation
                $this->delete_validation($this->get());
                break;

            default:
                $this->response(null, 501);
                break;
        }
    }

    /**
     * [GET] Validation.
     *
     * @param array $data
     */
    protected function get_validation($data)
    {

    }

    /**
     * [POST] Validation.
     *
     * @param array $data
     */
    protected function post_validation($data)
    {

    }

    /**
     * [PATCH] Validation.
     *
     * @param array $data
     */
    protected function patch_validation($data)
    {
         switch (true) {
            case empty($data['id']):
                $this->response(array('success' => false, 'message' => $this->lang->line('error_empty_id')), REST_Controller::HTTP_BAD_REQUEST);
                break;

        }
    }

     /**
      * [DELETE] Validation.
      *
      * @param array $data
      */
     protected function delete_validation($data)
     {
         switch (true) {
            case empty($data['id']):
                $this->response(array('success' => false, 'message' => $this->lang->line('error_empty_id')), REST_Controller::HTTP_BAD_REQUEST);
                break;

        }
     }
}
