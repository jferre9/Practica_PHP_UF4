<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comanda extends CI_Model {

    public function __construct() {
        parent::__construct();
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

}
