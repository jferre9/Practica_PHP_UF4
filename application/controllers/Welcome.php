<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/third_party/Facebook/autoload.php';
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\GraphUser;

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
        
        $productors = $this->productor->getAll(array('actiu' => true));
        
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
    
    //test
    
    
    
    
    public function facebook() {
        
        
        $fb = new Facebook\Facebook([
		'app_id'  => '1671043223201499',
		'app_secret' => 'badedf304de0ab738cc3d7b8c1901614',
		'default_graph_version' => 'v2.9'
	]);
        
        
        $helper = $fb->getRedirectLoginHelper();
        
        
        var_dump(site_url('welcome/callback'));
 
        $permissions = ['email','user_location']; // Optional permissions for more permission you need to send your application for review
        $loginUrl = $helper->getLoginUrl(site_url('welcome/callback'), $permissions);
        redirect($loginUrl);
    }
    
    
    
    
    //http://www.phpgang.com/how-to-login-with-facebook-api-sdk-v5-in-php_2879.html
    public function callback() {

        $fb = new Facebook\Facebook([
            'app_id' => '1671043223201499',
            'app_secret' => 'badedf304de0ab738cc3d7b8c1901614',
            'default_graph_version' => 'v2.9'
        ]);
        
        $helper = $fb->getRedirectLoginHelper();  

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error  

            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues  

            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }


        try {
            // Get the Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me?fields=id,name,email,first_name,last_name,hometown', $accessToken);
//  print_r($response);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'ERROR: Graph ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'ERROR: validation fails ' . $e->getMessage();
            exit;
        }
        $me = $response->getGraphUser();
        
        var_dump($accessToken);
//print_r($me);
        echo "Full Name: " . $me->getProperty('name') . "<br>";
        echo "First Name: " . $me->getProperty('first_name') . "<br>";
        echo "Last Name: " . $me->getProperty('last_name') . "<br>";
        echo "City: " . $me->getProperty('hometown') . "<br>";
        echo "Email: " . $me->getProperty('email');
        echo "Facebook ID: <a href='https://www.facebook.com/" . $me->getProperty('id') . "' target='_blank'>" . $me->getProperty('id') . "</a>";
    }
    
    //Demana el municipi
    public function registre_facebook() {
        $this->load->view('registre_facebook');
        $this->load->view('template');
        
    }
    
    public function logout() {
        
    }

}
