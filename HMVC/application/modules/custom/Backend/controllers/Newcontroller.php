<?php defined('BASEPATH') or exit('No direct script access allowed');

class Newcontroller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'pagination']);
       // $this->load->helper('form');
        $this->load->model('NewModel');
    }
    public function add_data()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == TRUE) {
                $userdata = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                ];

                $this->NewModel->add_data('Newdata', $userdata);
            }
        }
        $this->load->view('Newform');
    }
    public function fetch_data()
    {
        $config = [
            'base_url' => base_url('Backend/Newcontroller/fetch_data/'),
            'total_rows' => $this->NewModel->getTotalRows('Newdata'),
            'per_page' => 2,
            'uri_segment' => 4,
        ];
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="paginate_button page-item ">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="paginate_button page-item  active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="paginate_button page-item ">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="paginate_button page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="paginate_button page-item next">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="paginate_button page-item previous">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li  class="paginate_button page-item next">';
        $config['next_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $response['users'] =  $this->NewModel->fetch_data('Newdata', [], '*', $config['per_page'], $this->uri->segment(4));
        $this->load->view('Newtable', $response);
    }
    public function update_data($id)
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == TRUE) {
                $userdata = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                ];

                $this->NewModel->update('Newdata', ['id' => $id], $userdata);
            }
        }
        $response['user'] =  $this->NewModel->update_data('Newdata', ['id' => $id], '*');
        $this->load->view('Newupdate', $response);
    }
    public function delete_data($id)
    {
        $this->NewModel->delete_data('Newdata', ['id' => $id]);
        redirect('Backend/Newcontroller/fetch_data');
    }
}
