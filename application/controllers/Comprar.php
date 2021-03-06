<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comprar extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('producte');
        $this->load->model('comanda');
        if (!$this->session->usuari) redirect('welcome');
    }

    public function index() {
        $productes = $this->producte->llista_detalls();
        
        $data['productes'] = $productes;
        $data['vista'] = 'comprar';
        $this->load->view('template', $data);
    }
    
    public function carro() {
        //http://bootsnipp.com/snippets/featured/responsive-shopping-cart
        
        $carro = $this->session->carro;
        if (!$carro) $carro = array();
        
        $quantitat = $this->input->post('quantitat');
        if ($this->input->post('quantitat') && is_numeric($quantitat) && intval($quantitat) > 0) {
            $producte = $this->producte->get($this->input->post('id'));
            if ($producte) {
                $trobat = FALSE;
                for ($i = 0; $i < count($carro); $i++) {
                    if ($carro[$i]['id'] === $producte['id']) {
                        $carro[$i]['quantitat'] += intval($quantitat);
                        $trobat = TRUE;
                        break;
                    }
                }
                if (!$trobat) {
                    $producte['quantitat'] = intval($quantitat);
                    $carro[] = $producte;
                }
                
                
            }
        }
        $this->session->carro = $carro;
        
        $total = 0;
        foreach ($carro as $p) {
            $total += $p['quantitat']*$p['preu'];
        }
        
        $data['total'] = $total;
        $data['carro'] = $carro;
        $data['vista'] = 'carro';
        $this->load->view('template', $data);
    }
    
    public function borrar_carro($id) {
        $carro = $this->session->carro;
        if (!$carro) redirect ('comprar');
        for ($i = 0; $i < count($carro); $i++) {
            if ($carro[$i]['id'] === $id) {
                array_splice($carro, $i,1);
                break;
            }
        }
        $this->session->carro = $carro;
        redirect('comprar/carro');
    }
    
    public function checkout() {
        if (count($this->session->carro) === 0) {
            redirect('comprar');
        }
        $this->comanda->inserir($this->session->carro,$this->session->usuari['id']);
        $this->session->carro = NULL;
        $this->session->set_flashdata('missatge','Compra finalitzada');
        redirect('comprar');
    }
    
    public function prova() {
        $this->load->view('prova');
    }
    
    


}
