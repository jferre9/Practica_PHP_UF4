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
        $this->load->model('client');
        $this->load->model('producte');
    }

    public function index() {
        
        $this->load->helper('google_maps');
        $data = array();
    if ($this->session->missatge) {
        $data['missatge'] = $this->session->missatge;
    }
    if ($this->session->error) {
        $data['error'] = $this->session->error;
    }

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

        $productors = $this->productor->getAll(array('actiu' => true, 'eliminat' => false));

        $posicions = array();

        foreach ($productors as $p) {
            $posicions[] = array('lat' => $p['lat'], 'lng' => $p['lng'], 'nom' => $p['nom']);
        }

        $data['posicions'] = $posicions;



        $data['vista'] = 'home';
        $this->load->view('template', $data);
    }

    public function registre() {
        $data = array();
        if ($this->input->post('email') && $this->input->post('pass')) {
            $registre['email'] = $this->input->post('email');
            $registre['pass'] = md5($this->input->post('pass'));
            $registre['nom'] = $this->input->post('nom');
            $registre['cif'] = $this->input->post('cif');
            $registre['municipi'] = $this->input->post('municipi');

            if (!$this->client->getByEmail($registre['email'])) {
            $this->load->model('client');
            $this->client->insertar($registre);
            $this->session->set_flashdata('missatge','Registrat correctament');
            redirect('welcome');
            }
            $data['error'] = 'Ja exiteix un usuari amb aquest email';
        }

        $data['vista'] = 'registre';
        $this->load->view('template', $data);
    }

    //redirigeix a la url de login amb facebook
    public function facebook() {


        $fb = new Facebook\Facebook([
            'app_id' => '1671043223201499',
            'app_secret' => 'badedf304de0ab738cc3d7b8c1901614',
            'default_graph_version' => 'v2.9'
        ]);


        $helper = $fb->getRedirectLoginHelper();


        //var_dump(site_url('welcome/callback'));

        $permissions = ['email']; // Optional permissions for more permission you need to send your application for review
        $loginUrl = $helper->getLoginUrl(site_url('welcome/callback'), $permissions);
        redirect($loginUrl);
    }

    
    public function login() {
        $this->session->usuari = NULL;
        $email = $this->input->post('email');
        $pass = $this->input->post('pass');
        if (!$email || !$pass) {
            $this->session->set_flashdata('error','Usuari o contrassenya incorrectes');
            redirect('welcome');
        }
        $usuari = $this->client->login($email,$pass);
        if (!$usuari) {
            $this->session->set_flashdata('error','Usuari o contrassenya incorrectes');
            redirect('welcome');
        }
        $this->session->usuari = $usuari;
        redirect('welcome');
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
            $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken);
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


        $email = $me->getProperty('email');
        $idFacebook = $me->getProperty('id');
        //comprovo si ja s'ha registrat;
        $usuari = $this->client->login_facebook($email);
        if ($usuari) {
            //ja està registrat
            $this->session->usuari = $usuari;
            redirect('welcome');
        } else {
            //redirecciono a la pagina per demanar dades adicionals i completar el registre
            $this->session->accessToken = $accessToken;
            redirect('welcome/registre_facebook');
        }


        var_dump($accessToken);
        echo "Full Name: " . $me->getProperty('name') . "<br>";
        echo "First Name: " . $me->getProperty('first_name') . "<br>";
        echo "Last Name: " . $me->getProperty('last_name') . "<br>";
        echo "Email: " . $me->getProperty('email');
        echo "Facebook ID: <a href='https://www.facebook.com/" . $me->getProperty('id') . "' target='_blank'>" . $me->getProperty('id') . "</a>";
    }

    //Demana el municipi
    public function registre_facebook() {
        if (!$this->session->accessToken) {
            redirect('welcome');
        }

        $fb = new Facebook\Facebook([
            'app_id' => '1671043223201499',
            'app_secret' => 'badedf304de0ab738cc3d7b8c1901614',
            'default_graph_version' => 'v2.9'
        ]);

        try {
            // Get the Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $this->session->accessToken);
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

        $nom = $me->getProperty('name');

        if ($this->input->post('cif') && $this->input->post('municipi')) {
            $registre['email'] = $me->getProperty('email');
            $registre['nom'] = $nom;
            $registre['pass'] = ''; //no es podra accedir mai per email i password perque no coincidira al fer l'md5
            $registre['cif'] = $this->input->post('cif');
            $registre['municipi'] = $this->input->post('municipi');
            $registre['facebook_id'] = $me->getProperty('id');
            $this->client->insertar($registre);
            $usuari = $this->client->login_facebook($registre['email']);
            if (!$usuari) {
                exit('Error al registrar per facebook');
            }
            $this->session->usuari = $usuari;
            redirect('welcome');
        }

        $data['nom'] = $nom;
        $data['vista'] = 'registre_facebook';
        $this->load->view('template', $data);
    }

    public function usuari() {
        if (!$this->session->usuari)
            redirect('welcome');
        $data['usuari'] = $this->session->usuari;
        $data['vista'] = 'usuari';
        $this->load->view('template', $data);
    }

    public function logout() {
        $this->session->accessToken = NULL;
        $this->session->usuari = NULL;
        redirect('welcome');
    }

    

    public function carta() {

        $data['productes'] = $this->producte->llista_detalls();
        $content = $this->load->view('carta_vins', $data, TRUE);
        //var_dump($content);
        require_once APPPATH . '/third_party/html2pdf/vendor/autoload.php';
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'es');
//      $html2pdf->setModeDebug();
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($content);
            $html2pdf->Output('exemple00.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

}
