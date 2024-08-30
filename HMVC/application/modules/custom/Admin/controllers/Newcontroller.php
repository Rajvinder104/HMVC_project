<?php defined('BASEPATH') or exit('No direct script access allowed');

class Newcontroller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('NewModel');
        $this->load->library(['form_validation', 'pagination']);
    }
    // insert-data
    public function insert_data()
    {
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $data = $this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run() == TRUE) {
                $usersdata = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password']
                ];
                $this->NewModel->insert_data('datatable', $usersdata);
            }
        }

        $this->load->view('insertform');
    }

    // fetch_data

    public function fetch_data()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $type = $this->input->get('select');
        $value = $this->input->get('searching');
        $where = [];

        if (!empty($start_date)) {

            $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '"';
        }
        if (!empty($type)) {
            $where = [$type => $value];
        }
        $config = [
            'base_url' => base_url('Admin/Newcontroller/fetch_data/'),
            'total_rows' => $this->NewModel->get_sum('datatable', $where, 'ifnull(count(id),0) as sum'),
            'uri_segment' => 4,
            'per_page' => 3,
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
        $response['users'] = $this->NewModel->fetch_data('datatable', $where, '*', $config['per_page'], $this->uri->segment(4));
        $this->load->view('Newtable', $response);
    }

    // update_data

    public function update_data($id)
    {
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $data = $this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run() == TRUE) {
                $usersdata = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password']
                ];
                $this->NewModel->update('datatable', ['id' => $id], $usersdata);
            }
        }
        $response['user'] = $this->NewModel->get_single_record('datatable', ['id' => $id], '*');
        $this->load->view('updateform', $response);
    }

    // delete_data

    public function delete_data($id)
    {
        $this->NewModel->delete_data('datatable', ['id' => $id]);
        redirect('Admin/Newcontroller/fetch_data');
    }
}
