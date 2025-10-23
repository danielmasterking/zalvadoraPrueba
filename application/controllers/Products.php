<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Products_model');
        $this->load->model('Categories_model');
    }

    public function index() {
        
        $search = $this->security->xss_clean($this->input->get('search'));
        $config['base_url'] = site_url('products/index') . '?';
        $config['total_rows'] = $this->Products_model->count_all($search);
        $config['per_page'] = 5;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config = array_merge($config, $this->ConfigPagination());
        $this->pagination->initialize($config);

        $page = $this->input->get('page');
        $data['results'] = $this->Products_model->get_all_products($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->render('products/index', $data);
    }


    private function ConfigPagination() {
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['first_link'] = 'Primero';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Último';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = ['class' => 'page-link'];


        return $config;
    }

    private function render($vista, $data = []) {
        $this->load->view('layout/header', $data);
        $this->load->view($vista, $data);
        $this->load->view('layout/footer', $data);
    }
  

    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nombre', 'required');
            $this->form_validation->set_rules('price', 'Precio', 'required|numeric');
            $this->form_validation->set_rules('sku', 'SKU', 'required|is_unique[products.sku]');
            $this->form_validation->set_rules('category_id', 'Categoría', 'required|integer');

            $this->form_validation->set_message('numeric', 'El campo %s debe ser un número.');
            $this->form_validation->set_message('is_unique', 'El SKU ya está registrado.');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio.');
            $this->form_validation->set_message('integer', 'El campo %s debe ser un número entero.');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('products/create');
                return;
            }

            $product_data = array(
                'name' => $this->security->xss_clean($this->input->post('name')),
                'price' => $this->security->xss_clean($this->input->post('price')),
                'sku' => $this->security->xss_clean($this->input->post('sku')),
                'category_id' => $this->input->post('category_id')
            );

            $this->Products_model->create_product($product_data);
            $this->session->set_flashdata('success', 'Producto creado exitosamente.');
            redirect('products');
        } else {
            $categories = $this->Categories_model->get_all_categories();
            $data['categories'] = $categories;
            $data['action'] = 'create';
            $data['method'] = $this->router->method;
            $this->render('products/create', $data);
        }
    }

    public function edit($product_id) {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nombre', 'required');
            $this->form_validation->set_rules('price', 'Precio', 'required|numeric');
            $this->form_validation->set_rules('category_id', 'Categoría', 'required|integer');

            $this->form_validation->set_message('numeric', 'El campo %s debe ser un número.');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio.');
            $this->form_validation->set_message('integer', 'El campo %s debe ser un número entero.');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('products/edit/'.$product_id);
                return;
            }
            $product_data = array(
                'name' => $this->security->xss_clean($this->input->post('name')),
                'price' => $this->security->xss_clean($this->input->post('price')),
                'category_id' => $this->input->post('category_id')
            );
            $this->Products_model->update_product($product_id, $product_data);
            $this->session->set_flashdata('success', 'Producto actualizado exitosamente.');
            redirect('products');
        } else {    
            $data['product'] = $this->Products_model->get_product($product_id);
            $data['categories'] = $this->Categories_model->get_all_categories();
            $data['action'] = 'edit/' . $product_id;
            $data['method'] = $this->router->method;

            $this->render('products/create', $data);
        }
    }

    public function delete($product_id) {
        $this->Products_model->delete_product($product_id);
        $this->session->set_flashdata('success', 'Producto eliminado exitosamente.');
        redirect('products');
    }
}