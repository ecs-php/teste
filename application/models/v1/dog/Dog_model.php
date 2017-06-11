<?php

/*
 * Dog Model
 *
 * @package         Radar REST API
 * @category        Models
 * @author          Victor Santiago
 * @version         1.0
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dog_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {

        if ($this->insert_dog($data)) {
            $response['code'] = 201;
            $response['response']['success'] = true;
            $response['response']['message'] = $this->lang->line('text_inserted_dog_successfully');

            return $response;
        } else {
            $response['code'] = 400;
            $response['response']['success'] = false;
            $response['response']['message'] = $this->lang->line('error_inserting_dog');

            return $response;
        }
    }

    private function insert_dog($data)
    {
        $data['dt_insert'] = date("Y-m-d H:i:s");
        if($this->db->insert(TB_DOG, $data)){
            return true;
        }

        return false;
    }

    public function search($id = null)
    {

        if(isset($id)){
            $sql = "SELECT * FROM ".TB_DOG." WHERE ID =".$id;
        } else {
            $sql = "SELECT * FROM ".TB_DOG;
        }

        $query = $this->db->query($sql);

        if (count($query->result()) > 0) {
            $response['code'] = 200;
            $response['dados']['success'] = true;
            $response['dados']['response'] = $query->result();

            return $response;
        }

        $response['code'] = 204;
        $response['dados']['success'] = true;
        $response['dados']['response'] = null;

        return $response;
    }

    public function update($data)
    {

        if ($this->update_dog($data)) {
            $response['code'] = 200;
            $response['response']['success'] = true;
            $response['response']['message'] = $this->lang->line('text_dog_successfully_changed');

            return $response;
        } else {
            $response['code'] = 400;
            $response['response']['success'] = false;
            $response['response']['message'] = null;

            return $response;
        }
    }

    private function update_dog($data)
    {
        $data['dt_update'] = date("Y-m-d H:i:s");

        $this->db->where('id', $data['id']);

        if ($this->db->update(TB_DOG, $data)){
            return true;
        }

        return false;
    }

    public function delete($data)
    {

        if ($this->delete_dog($data)) {
            $response['code'] = 200;
            $response['response']['success'] = true;
            $response['response']['message'] = $this->lang->line('text_dog_successfully_changed');

            return $response;
        } else {
            $response['code'] = 400;
            $response['response']['success'] = false;
            $response['response']['message'] = null;

            return $response;
        }
    }

    private function delete_dog($data)
    {
        $this->db->where('id', $data['id']);

        if($this->db->delete(TB_DOG, $data)){
            return true;
        }

        return false;
    }
}
