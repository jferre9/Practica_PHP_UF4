<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producte extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($registre) {
        $res = $this->db->insert('producte',$registre);
    }
    
    public function getAll($where = FALSE) {
        if ($where) {
            $this->db->where($where);
        }
        
        return $this->db->get('producte')->result_array();
    }
    
    public function get($id) {
        $this->db->select('*');
        $this->db->where(array('id'=> $id,'eliminat'=>'0'));
        $query = $this->db->get('producte');
        return $query->first_row('array');
    }
    
    public function llista_productor($id) {
        $this->db->select('*');
        $this->db->where(array('productor_id' => $id, 'eliminat'=>'0'));
        $query = $this->db->get('producte');
        return $query->result_array();
    }
    
    public function llista_detalls() {
        $this->db->select('producte.id,producte.nom,producte.descripcio,producte.preu,producte.preu_final,producte.imatge,productor.nom as productor,productor.do');
        $this->db->from('producte');
        $this->db->join('productor','producte.productor_id = productor.id');
        $this->db->where(array('producte.eliminat'=>'0','productor.eliminat'=>'0'));
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function eliminar($id) {
        $this->db->set('eliminat','1');
        $this->db->where('id',$id);
        $this->db->update('producte');
    }
    
    
}
