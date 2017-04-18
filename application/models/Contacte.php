<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacte extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($registre) {
        $res = $this->db->insert('contacte',$registre);
        
        
    }
    
    public function getAll() {
        return $this->db->get('contacte')->result_array();
    }

}
