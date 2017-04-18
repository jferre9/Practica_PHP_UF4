<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('productor');
        $this->load->model('contacte');
//        $this->load->model('producte')
    }

    public function index() {


        $data = array();

        if ($this->input->post('email') == 'admin' && $this->input->post('pass') == 'admin') {
            $this->session->admin = TRUE;
        }

        if ($this->session->admin) {

            if ($this->input->post('enviar')) {
                
                $registre['nom'] = $this->input->post('nom');
                $registre['do'] = $this->input->post('do');
                $registre['lat'] = $this->input->post('lat');
                $registre['lon'] = $this->input->post('lon');
                

                $config['upload_path'] = './public/imatges/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024;
                $config['file_name'] = uniqid();

                $this->load->library('upload', $config);

                //perque funcioni aquesta llibreria s'ha d'activar l'extensió php_fileinfo al php.ini

                if (!$this->upload->do_upload('imatge')) {
                    $data['error'] = array('error' => $this->upload->display_errors());
                } else {
                    $registre['imatge'] = $this->upload->data('file_name');
                    
                    $this->productor->insertar($registre);
                }
            }




            $data['productors'] = $this->productor->getAll();

            $data['vista'] = 'admin/home';
            $this->load->view('template', $data); //file_name
        } else {
            $this->load->view('admin/login');
        }
    }

    public function productor($nom) {
        if (!$this->session->admin) {
            redirect('admin');
        }
    }

}
