<?php defined('BASEPATH') or exit('No direct script access allowed');
class Formcontroller extends MX_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->model('Form_Model');
  }

  public function index()
  {
    $this->load->view('Form');
  }
    public function my_fun()
  {
   
    if($this->input->server('REQUEST_METHOD') == 'POST'){

      if (empty($_FILES['userfile']['name'])) {
        $this->form_validation->set_rules('userfile', 'Image', 'required');
      }
      if ($this->form_validation->run()) {

        $config['upload_path']  = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']             = 10000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
          $error['err'] = $this->upload->display_errors();
          $this->load->view('Form', $error);
        } else {
          $data =  $this->upload->data();
          $postdata = $this->input->post();
          $postdata['image'] = $data['file_name'];
          $this->Form_Model->add_data($postdata);
          echo "<script>alert('Data Inserted Successfully')</script>";
        }
      } 
    }
    $this->load->view('Form.php');
  }
}
