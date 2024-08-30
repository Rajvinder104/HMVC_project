<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller extends MX_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->library(['form_validation', 'pagination']);
      $this->load->model('model');
   }
   public function add_data()
   {
      if ($this->input->server('REQUEST_METHOD') == "POST") {

         $data = $this->security->xss_clean($this->input->post());
         $this->form_validation->set_rules('name', 'Name', 'required|trim');
         $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
         $this->form_validation->set_rules('password', 'Password', 'required|trim');

         if ($this->form_validation->run() == true) {
            $usersdata = [
               'name' => $data['name'],
               'email' => $data['email'],
               'password' => $data['password'],
            ];

            $this->model->add_data('personal', $usersdata);
         }
      }
      $this->load->view('form');
   }
   public function fetch_data()
   {

      $type = $this->input->get('select');
      $value = $this->input->get('searching');
      $where = [];
      if (!empty($type)) {
         $where = [$type => $value];
      }

      $config = [
         'base_url' => base_url('site/controller/fetch_data/'),
         'total_rows' => $this->model->get_sum('personal', $where, 'ifnull(count(id),0) as sum'),
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
      $response['users'] = $this->model->get_all_records('personal', $where, '*', $config['per_page'], $this->uri->segment(4));
      $this->load->view('alldata', $response);
   }
   public function update_data($id)
   {
      if ($this->input->server('REQUEST_METHOD') == "POST") {

         $data = $this->security->xss_clean($this->input->post());
         $this->form_validation->set_rules('name', 'Name', 'required|trim');
         $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
         $this->form_validation->set_rules('password', 'Password', 'required|trim');

         if ($this->form_validation->run() == true) {
            $usersdata = [
               'name' => $data['name'],
               'email' => $data['email'],
               'password' => $data['password'],
            ];

            $this->model->update('personal', ['id' => $id], $usersdata);
         }
      }
      $response['user'] = $this->model->get_single_record('personal', ['id' => $id], '*');
      $this->load->view('update', $response);
   }
   public function delete_data($id)
   {
      $this->model->delete_data('personal', ['id' => $id]);
      redirect('site/controller/fetch_data');
   }
}
