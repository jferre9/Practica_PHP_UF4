<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('productor');
        $this->load->model('producte');
        $this->load->model('comanda');
        $this->load->model('client');
    }

    public function index() {


        $data = array();

        if ($this->input->post('email') == 'admin' && $this->input->post('pass') == 'admin') {
            $this->session->admin = TRUE;
        }

        if ($this->session->admin) {
            //TODO Borrar
            if ($this->input->post('enviar')) {

                $registre['nom'] = $this->input->post('nom');
                $registre['do'] = $this->input->post('do');
                $registre['direccio'] = $this->input->post('direccio');
                $registre['email'] = $this->input->post('email');


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




            $data['productors'] = $this->productor->getAll();

            $data['vista'] = 'admin/home';
            $this->load->view('template', $data); //file_name
        } else {
            $this->load->view('admin/login');
        }
    }

    /* Veure llista de productes
     * Afegir-los
     * Link a modificar o 
     */

    public function productor($id) {
        if (!$this->session->admin) {
            redirect('admin');
        }
        $productor = $this->productor->get($id);
        if (!$productor) {
            redirect('admin');
        }

        if ($this->input->post('enviar')) {
            $registre['nom'] = $this->input->post('nom');
            $registre['descripcio'] = $this->input->post('descripcio');
            $registre['preu'] = $this->input->post('preu');
            $registre['preu_final'] = $this->input->post('preu_final');
            $registre['productor_id'] = $id;

            $config['upload_path'] = './public/imatges/productes/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1024;
            $config['file_name'] = uniqid();

            $this->load->library('upload', $config);

            //perque funcioni aquesta llibreria s'ha d'activar l'extensió php_fileinfo al php.ini

            if (!$this->upload->do_upload('imatge')) {
                $data['error'] = $this->upload->display_errors();
                var_dump($data['error']);
            } else {
                $registre['imatge'] = $this->upload->data('file_name');

                $this->producte->insertar($registre);
            }
        }





        $productes = $this->producte->llista_productor($id);

        $data['productor'] = $productor;
        $data['productes'] = $productes;

        

        $data['vista'] = 'admin/productor';
        $this->load->view('admin/template', $data);
    }

    public function eliminar_productor($id) {
        if (!$this->session->admin) {
            redirect('admin');
        }
        $productor = $this->productor->get($id);
        if ($productor) {
            $this->productor->eliminar($id);
        }
        redirect('admin');
    }
    
    public function comandes() {
        
        $data['comandesPendents'] = $this->comanda->llista(FALSE);
        $data['comandesFinalitzades'] = $this->comanda->llista(TRUE);
        $data['vista'] = 'admin/comandes';
        $this->load->view('admin/template', $data);
    }
    
    public function finalitzar($id) {
        $this->comanda->fintalitzar($id);
    }
    
    public function ruta() {
        if (!$this->input->post('ruta')) redirect('admin/comandes');
        
        $this->load->helper('google_maps');
        
        $clients = array_keys($this->input->post('ruta'));
        
        $waypoints = $this->client->getMunicipis($clients);
        
        $data['inici'] = 'Igualada';
        $data['final'] = 'Igualada';
        $data['waypoints'] = $waypoints;
        $data['vista'] = 'admin/ruta';
        $this->load->view('admin/template',$data);
        
        
    }

}
