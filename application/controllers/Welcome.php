<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    
    public function __construct() {
        parent::__construct();

        $this->load->model('productor');
    }
    
    
    public function index() {
        $this->load->helper('google_maps');
        $data = array();


        if ($this->input->post('enviar')) {

            $registre['nom'] = $this->input->post('nom');
            $registre['do'] = $this->input->post('do');
            $registre['direccio'] = $this->input->post('direccio');
            $registre['email'] = $this->input->post('email');

            $coordenades = get_coordenades($registre['direccio']);

            if (!$coordenades) {
                $data['error'] = "Direcció no vàlida";
            } else {
                $registre['lat'] = $coordenades['lat'];
                $registre['lng'] = $coordenades['lng'];

                $config['upload_path'] = './public/imatges/productors/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024;
                $config['file_name'] = uniqid();

                $this->load->library('upload', $config);

                //perque funcioni aquesta llibreria s'ha d'activar l'extensió php_fileinfo al php.ini

                if (!$this->upload->do_upload('imatge')) {
                    $data['error'] = $this->upload->display_errors();
                } else {
                    $registre['imatge'] = $this->upload->data('file_name');

                    $this->productor->insertar($registre);
                }
            }
        }
        
        
        $productors = $this->productor->getAll();
        
        $posicions = array();
        
        foreach ($productors as $p) {
            $posicions[] = array('lat'=>$p['lat'],'lng' => $p['lng'], 'nom' => $p['nom']);
        }
        
        $data['posicions'] = $posicions;
        
        

        $data['vista'] = 'home';
        $this->load->view('template', $data);
    }

    public function registre() {
        if ($this->input->post('email') && $this->input->post('pass')) {
            $registre['email'] = $this->input->post('email');
            $registre['pass'] = md5($this->input->post('pass'));
            $registre['nom'] = $this->input->post('nom');
            $registre['cif'] = $this->input->post('cif');
            $registre['municipi'] = $this->input->post('municipi');
            $registre['clau'] = md5(time() + rand());

            var_dump($registre);

            $this->load->model('client');
            $this->client->insertar($registre);
        }

        $data['vista'] = 'registre';
        $this->load->view('template', $data);
    }

}
