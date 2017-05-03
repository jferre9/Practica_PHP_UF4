<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productor extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($registre) {
        $res = $this->db->insert('productor',$registre);
    }
    
    public function getAll($where = FALSE) {
        if ($where) {
            $this->db->where($where);
            echo "qweqweqwe";
        }
        return $this->db->get('productor')->result_array();
    }
    
    public function get($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('productor');
        return $query->first_row('array');
    }
    public function update($id, $data) {
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('productor');
    }
    
    public function acceptar($id) {
        $this->update($id, array('actiu'=>'1'));
    }
    
    public function eliminar($id) {
        $this->update($id, array('eliminat'=>'1'));
    }
    

}
