<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productor extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($registre) {
        $res = $this->db->insert('productor',$registre);
    }
    
    public function getAll() {
        return $this->db->get('productor')->result_array();
    }

}
