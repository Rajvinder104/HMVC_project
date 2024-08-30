<?php defined('BASEPATH') or exit('No direct script access allowed');

class Homecontroller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'pagination']);
        $this->load->model('HomeModel');
    }
    public function add_data()
    {
        if ($this->input->server('REQUEST_METHOD') == "POST") {
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

                $this->HomeModel->add_data('Newdata', $userdata);
            }
        }
        $this->load->view('Homeform');
    }

    public function fetch_data()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $type = $this->input->get('type');
        $value = $this->input->get('value');
        $where = [];
        if (!empty($type)) {
            $where = [$type => $value];
        }
        if (!empty($start_date)) {
            $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '"';
        }
        $config = [
            'base_url' => base_url('Dashboard/Homecontroller/fetch_data'),
            'total_rows' => $this->HomeModel->get_sum('Newdata', $where, 'ifnull(count(id),0) as sum'),
            'per_page' => 3,
            'uri_segment' => 4,
        ];
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = "<ul class='pagination pagination-sm'>";
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
        $response['users'] =  $this->HomeModel->fetch_data('Newdata', $where, '*', $config['per_page'], $this->uri->segment(4));
        $this->load->view('Newtable', $response);
    }


    public function update_data($id)
    {
        if ($this->input->server('REQUEST_METHOD') == "POST") {
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

                $this->HomeModel->update('Newdata', ['id' => $id], $userdata);
            }
        }
        $response['user'] =  $this->HomeModel->get_single_record('Newdata', ['id' => $id], '*');
        $this->load->view('Homeupdate', $response);
    }
    public function delete_data($id)
    {
        $this->HomeModel->delete_data('Newdata', ['id' => $id]);
        redirect(base_url('Dashboard/Homecontroller/fetch_data'));
    }
}
