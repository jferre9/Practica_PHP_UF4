<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($registre) {
        $res = $this->db->insert('client',$registre);
        
    }

}
