<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        
    }

    public function index() {
        if ($this->session->userdata('data')) {
           
            redirect('users');
            
        } else {
           
            $this->load->view('auth/login');
        }
        
        
    }

    
    public function accessDenied() {
        $this->render('auth/access_denied');
    }

    private function render($vista, $data = []) {
        $this->load->view('layout/header', $data);
        $this->load->view($vista, $data);
        $this->load->view('layout/footer', $data);
    }

    public function authenticate() {
        $this->form_validation->set_rules('username', 'Correo Electrónico', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');
        $this->form_validation->set_message('valid_email', 'Debes ingresar un correo válido.');

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if($this->form_validation->run()) {

            
            $user = $this->Users_model->get_user_by_email($username);
        
        
            if (!empty($user) &&  password_verify($password, $user->password)) {
             
                
                $this->session->set_userdata('data', [
                    'user_id' => $user->id,
                    'username' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]);
                redirect('auth');
            }else {
                
                $this->session->set_flashdata('error', 'Credenciales inválidas. Por favor, intenta de nuevo.');
                redirect('auth');
            }
        
        }


        $errores = validation_errors('<li>', '</li>');

        
        $this->session->set_flashdata('error', '<ul class="text-danger">'.$errores.'</ul>');

        redirect('auth');
    }

    public function logout() {
        $this->session->unset_userdata('data');
        redirect('auth');
    }
}