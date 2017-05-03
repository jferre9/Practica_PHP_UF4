<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//http://html2pdf.fr/es/example
class Comanda extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function llista($finalitzada) {
        $this->db->select('client.nom as client,comanda.*');
        $this->db->from('comanda');
        $this->db->join('client','client.id = comanda.client_id');
        if ($finalitzada) {
            $this->db->where('comanda.finalitzada','1');
        } else {
            $this->db->where('comanda.finalitzada','0');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function inserir($carro, $client_id) {
        try {
            $this->db->trans_start();

            $preu = 0;
            foreach ($carro as $c) {
                $preu += ($c['preu'] * $c['quantitat']);
            }

            $comanda = array('client_id' => $client_id, 'preu_total' => $preu);
            $this->db->set('data', 'NOW()', FALSE);
            $this->db->insert('comanda', $comanda);

            $comanda_id = $this->db->insert_id();

            foreach ($carro as $c) {
                $detall = array('producte_id' => $c['id'],
                    'comanda_id' => $comanda_id, 'quantitat' => $c['quantitat'],
                    'preu' => $c['preu']);
                $this->db->insert('detall', $detall);
            }

            $this->db->trans_complete();
            return TRUE;
            
        } catch (Exception $ex) {
            echo "Error " . $ex->getMessage() . "<br>";
            return FALSE;
        }
    }
    
    public function webservice($key) {
        
        $this->db->select('comanda.*');
        $this->db->from('comanda');
        $this->db->join('client','client.id = comanda.client_id');
        $this->db->where(array('client.clau'=>$key,'finalitzada'=> '1'));
        $query = $this->db->get();
        
        
        
        $comandesFinalitzades = array();
        foreach ($query->result_array() as $c) {
            $comanda = array('data'=> $c['data'],'preu'=>$c['preu_total']);
            $this->db->select('producte.nom,detall.quantitat,detall.preu');
            $this->db->from('detall');
            $this->db->join('comanda','comanda.id = detall.comanda_id');
            $this->db->join('producte','producte.id = detall.producte_id');
            $this->db->where(array('comanda.id'=>$c['id']));
            $consulta = $this->db->get();
            
            $comanda['detalls'] = $consulta->result_array();
            $comandesFinalitzades[] = $comanda;
        }
        
        /*********************************************************/
        
        $this->db->select('comanda.*');
        $this->db->from('comanda');
        $this->db->join('client','client.id = comanda.client_id');
        $this->db->where(array('client.clau'=>$key,'finalitzada'=> '0'));
        $query = $this->db->get();
        
        
        
        $comandesPendents = array();
        foreach ($query->result_array() as $c) {
            $comanda = array('data'=> $c['data'],'preu'=>$c['preu_total']);
            $this->db->select('producte.nom,detall.quantitat,detall.preu');
            $this->db->from('detall');
            $this->db->join('comanda','comanda.id = detall.comanda_id');
            $this->db->join('producte','producte.id = detall.producte_id');
            $this->db->where(array('comanda.id'=>$c['id']));
            $consulta = $this->db->get();
            
            $comanda['detalls'] = $consulta->result_array();
            $comandesPendents[] = $comanda;
        }
        
        return array('finalitzades'=>$comandesFinalitzades,'pendents'=>$comandesPendents);
        
        
    }
    
    


}
