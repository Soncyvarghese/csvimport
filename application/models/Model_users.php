<?php

class Model_users extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function createUsers($data) {
        if ($data) {
            $insert = $this->db->insert('users', $data);
            return ($insert == true) ? true : false;
        }
    }
	 public function getEmployeeData() {       
            $data = $this->db->get('users')->result_array();
			//print_r($data);die;
            return $data;
        
    }
}