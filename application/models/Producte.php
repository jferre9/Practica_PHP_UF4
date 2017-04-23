<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productor extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($registre) {
        $res = $this->db->insert('producte',$registre);
    }
    
    public function getAll() {
        return $this->db->get('producte')->result_array();
    }
    
    public function get($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('producte');
        return $query->first_row();
    }
    
    public function llista_productor($id) {
        $this->db->select('*');
        $this->db->where('productor_id', $id);
        $query = $this->db->get('producte');
        return $query->result_array();
    }

}
