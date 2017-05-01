<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($registre) {
        $res = $this->db->insert('client',$registre);
    }
    
    public function getMunicipis($data) {
        $this->db->select('municipi');
        $this->db->from('client');
        $this->db->where_in('id',$data);
        $query = $this->db->get();
        $resultat = array();
        
        foreach ($query->result_array() as $key => $value) {
            $resultat[] = $value['municipi'];
        }
        return $resultat;
    }
    
    public function keyExist($key) {
        $query = $this->db->get_where('client',array('clau'=>$key));
        return $query->num_rows();
    }
    
}
