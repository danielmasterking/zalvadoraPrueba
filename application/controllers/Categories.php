<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Categories_model');
    }

    public function index() {
        $data['categories'] = $this->Categories_model->get_all_categories();
        $this->render('categories/index', $data);
    }   

    private function render($vista, $data = []) {
        $this->load->view('layout/header', $data);
        $this->load->view($vista, $data);
        $this->load->view('layout/footer', $data);
    }

    

    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nombre de la Categoría', 'required|is_unique[categories.name]');
            $this->form_validation->set_message('is_unique', 'El nombre de la categoría ya existe.');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio.');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('categories/create');
                return;
            }

            $category_data = array(
                'name' => $this->security->xss_clean($this->input->post('name'))
            );

            $this->Categories_model->create_category($category_data);
            redirect('categories');
        } else {
            $data['action'] = 'create';
            $data['method'] = $this->router->method;
            $this->render('categories/create', $data);
        }
    }


    public function edit($category_id) {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nombre de la Categoría', 'required|is_unique[categories.name]');
            $this->form_validation->set_message('is_unique', 'El nombre de la categoría ya existe.');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio.');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('categories/edit/' . $category_id);
                return;
            }

            $category_data = array(
                'name' => $this->security->xss_clean($this->input->post('name'))
            );

            $this->Categories_model->update_category($category_id, $category_data);
            redirect('categories');
        } else {
            $data['category'] = $this->Categories_model->get_category($category_id);
            $data['action'] = 'edit/' . $category_id;
            $data['method'] = $this->router->method;
            $this->render('categories/create', $data);
        }
    }

    public function delete($category_id) {
        if ($this->Categories_model->validateProductsInCategory($category_id)) {
            $this->session->set_flashdata('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
            redirect('categories');
            return;
        }

        $this->Categories_model->delete_category($category_id);
        redirect('categories');
    }
}