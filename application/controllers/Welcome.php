<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    public function index() {
        
        if ($this->input->post('email') && $this->input->post('nom') && $this->input->post('telf')) {
            $this->load->model('contacte');
            
            $registre['email'] = $this->input->post('email');
            $registre['nom'] = $this->input->post('nom');
            $registre['telf'] = $this->input->post('telf');
            
            $this->contacte->insertar($registre);
        }
        
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
            $registre['clau'] = md5(time()+rand());
            
            var_dump($registre);
            
            $this->load->model('client');
            $this->client->insertar($registre);
        }
        
        $data['vista'] = 'registre';
        $this->load->view('template', $data);
    }
    
    
    
}
