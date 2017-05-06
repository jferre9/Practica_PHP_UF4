<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($registre) {
        $registre['clau'] = md5(uniqid());
        $res = $this->db->insert('client',$registre);
    }
    
    //data es un array de ids
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
    
    public function getByEmail($email) {
        $this->db->select('*');
        $this->db->from('client');
        $this->db->where('email',$email);
        return $this->db->get()->first_row('array');
    }
    
    public function login($email,$pass) {
        $this->db->select('*');
        $this->db->from('client');
        $this->db->where(array('email'=>$email,'pass'=>md5($pass)));
        $query = $this->db->get();
        return $query->first_row('array');
    }
    
    public function login_facebook($email) {
        $this->db->select('*');
        $this->db->from('client');
        $this->db->where(array('email'=>$email));
        $this->db->where('facebook_id is not NULL',NULL,FALSE);
        $query = $this->db->get();
        return $query->first_row('array');
    }
    
}
