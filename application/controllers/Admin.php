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




            $data['productors'] = $this->productor->getAll(array('actiu'=>'1','eliminat'=>0));

            $data['vista'] = 'admin/home';
            $this->load->view('admin/template', $data); //file_name
        } else {
            $this->load->view('admin/login');
        }
    }

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
    
    public function eliminar_producte($id) {
        if (!$this->session->admin) {
            redirect('admin');
        }
        $productor = $this->producte->get($id);
        if ($productor) {
            $this->producte->eliminar($id);
        }
        $productor = $this->input->get('productor');
        if ($productor) {
            redirect("admin/productor/$productor");
        }
        redirect('admin');
    }
    
    public function comandes() {
        if (!$this->session->admin) {
            redirect('admin');
        }
        $data['comandesPendents'] = $this->comanda->llista(FALSE);
        $data['comandesFinalitzades'] = $this->comanda->llista(TRUE);
        $data['vista'] = 'admin/comandes';
        $this->load->view('admin/template', $data);
    }
    
    public function nous_productors() {
        if (!$this->session->admin) {
            redirect('admin');
        }
        $data['productors'] = $this->productor->getAll(array('actiu'=>0,'eliminat'=>0));
        
        $data['vista'] = 'admin/nous_productors';
        $this->load->view('admin/template', $data);
    }
    
    public function acceptar_productor($id) {
        if (!$this->session->admin) {
            redirect('admin');
        }
        $this->productor->acceptar($id);
        redirect('admin/nous_productors');
    }
    
    public function editar_productor($id) {
        if (!$this->session->admin) {
            redirect('admin');
        }
        $productor = $this->productor->get($id);
        if (!$productor) {
            redirect('admin');
        }
        
        $this->load->helper('google_maps');
        
        
        $data['productor'] = $productor;
        
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
                
                $error = FALSE;
                if ($this->input->post('imatge')) {

                    $config['upload_path'] = './public/imatges/productors/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = 1024;
                    $config['file_name'] = uniqid();

                    $this->load->library('upload', $config);

                    //perque funcioni aquesta llibreria s'ha d'activar l'extensió php_fileinfo al php.ini

                    if (!$this->upload->do_upload('imatge')) {
                        $data['error'] = $this->upload->display_errors();
                        $error = TRUE;
                    } else {
                        $registre['imatge'] = $this->upload->data('file_name');

                    }
                }
                if (!$error) {
                    $this->productor->update($id,$registre);
                    redirect('admin/productor/'.$productor['id']);
                }
            }
        }
        
        
        
        
        $data['vista'] = 'admin/editar_productor';
        $this->load->view('admin/template',$data);
    }
    
    public function finalitzar($id) {
        if (!$this->session->admin) {
            redirect('admin');
        }
        $this->comanda->fintalitzar($id);
    }
    
    public function ruta() {
        if (!$this->session->admin) {
            redirect('admin');
        }
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

    public function logout() {
        $this->session->admin = NULL;
        redirect('welcome');
    }
}
