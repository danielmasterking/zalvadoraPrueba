<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
    }

    public function index() {
        $data['users'] = $this->Users_model->get_all_users();
        if($this->session->userdata('data')){
            $sessionData = $this->session->userdata('data');
            if($sessionData['role'] != 'admin'){
                
                redirect('auth/accessDenied');
                return;
            }
        }
        
        $this->render('users/index', $data);
    }


    private function render($vista, $data = []) {
        $this->load->view('layout/header', $data);
        $this->load->view($vista, $data);
        $this->load->view('layout/footer', $data);
    }

  

    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nombre', 'required');
            $this->form_validation->set_rules('email', 'Correo Electrónico', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[6]');
            $this->form_validation->set_rules('role', 'Rol', 'required');


            $this->form_validation->set_message('valid_email', 'Debes ingresar un correo válido.');
            $this->form_validation->set_message('min_length', 'al menos 6 caracteres en la contraseña.');
            $this->form_validation->set_message('is_unique', 'El correo electrónico ya está registrado.');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio.');


            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('users/create');
                return;
            }

            $user_data = array(
                'name' => $this->security->xss_clean($this->input->post('name')),
                'email' => $this->security->xss_clean($this->input->post('email')),
                'password' => password_hash($this->security->xss_clean($this->input->post('password')), PASSWORD_BCRYPT),
                'role' => $this->input->post('role')
            );
            $this->Users_model->create_user($user_data);
            $this->session->set_flashdata('success', 'Ususario creado exitosamente.');
            redirect('users');
        } else {

            $data['action'] = 'create';
            $data['method'] = $this->router->method;
            $this->render('users/create', $data);
        }
    }

    public function edit($user_id) {
        if ($this->input->post()) {
            $sessionData = $this->session->userdata('data');
            $this->form_validation->set_rules('name', 'Nombre', 'required');
            $this->form_validation->set_rules('email', 'Correo Electrónico', 'required|valid_email');
            $this->form_validation->set_rules('role', 'Rol', 'required');


            $this->form_validation->set_message('valid_email', 'Debes ingresar un correo válido.');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio.');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('users/edit/' . $user_id);
                return;
            }
            
            $user_data = array(
                'name' => $this->security->xss_clean($this->input->post('name')),
                'email' => $this->security->xss_clean($this->input->post('email')),
                'role' => $this->input->post('role')
            );
            if ($this->input->post('password')) {
                $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            }
            $this->Users_model->update_user($user_id, $user_data);
            if($sessionData['user_id'] == $user_id){
                $sessionData['username'] = $this->input->post('name');
                $sessionData['email'] = $this->input->post('email');
                $sessionData['role'] = $this->input->post('role');
                $this->session->set_userdata('data',$sessionData);

            }

            $this->session->set_flashdata('success', 'Usuario actualizado exitosamente.');
            redirect('users');
        } else {
            $data['user'] = $this->Users_model->get_user($user_id);
            $data['action'] = 'edit/' . $user_id;
            $data['method'] = $this->router->method;
            $this->render('users/create', $data);
        }
    }

    public function delete($user_id) {
        $this->Users_model->delete_user($user_id);
        $this->session->set_flashdata('success', 'Usuario eliminado exitosamente.');
        redirect('users');
    }
}