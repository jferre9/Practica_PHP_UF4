<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends CI_Controller {

    
    public function __construct() {
        parent::__construct();

        $this->load->model('productor');
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
        
        
    }
    
    public function productes() {
        
    }

}
