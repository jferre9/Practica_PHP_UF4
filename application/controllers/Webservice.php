<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends CI_Controller {

    
    public function __construct() {
        parent::__construct();

        $this->load->model('producte');
        $this->load->model('client');
        $this->load->model('comanda');
        
        header('Content-Type: application/json');
        
        
        $key = $this->input->get('key');
        if (!$key || !$this->client->keyExist($key)) {
            $resposta = array('status'=>'error','message'=>'La clau no és vàlida');
            echo json_encode($resposta);
            exit;
        }
    }
    
    
    public function comandes() {
        $resposta = array('status'=>'ok','comandes'=> $this->comanda->webservice($this->input->get('key')));
        echo json_encode($resposta);
    }
    
    public function productes() {
        $resposta = array('status'=>'ok','comandes'=> $this->producte->llista_detalls());
        echo json_encode($resposta);
    }

}
