<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crudecontroller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation','session');
        $this->load->model('CrudeModel');
    }


    public function add_data()
    {
        if ($this->input->server('REQUEST_METHOD') == "POST") {

            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if (empty($_FILES['user']['name'])) {
                $this->form_validation->set_rules('user', 'image', 'required');
            }

            if ($this->form_validation->run()) {
                $config['upload_path'] = './uploads';
                $config['allowed_types'] = '*';
                $config['max_size'] = 10000;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('user')) {
                    $error['err'] = $this->upload->display_errors();
                    $this->load->view('crudeform', $error);
                } else {
                    $data = $this->upload->data();
                    $insertdata = $this->input->post();
                    $insertdata['image'] = $data['file_name'];
                    $check = $this->CrudeModel->add_data($insertdata);
                    if ($check) {
                        redirect('Backend/Crudecontroller/users');
                    } else {
                    }
                    echo "<script>alert('Data Inserted Successfully')</script>";
                }
            }
        }
        $this->load->view('crudeform');
    }

    public function users()
    {

        $response['users'] = $this->CrudeModel->get_records('crudeform', [], '*');
        // $response['users'] = $this->CrudeModel->get_records('form', [], '*');
        $this->load->view('crudetable', $response);
    }




    public function update_data($id)
    {
        $response = [];
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $data = $this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            if ($this->form_validation->run() == true) {
                $userData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                ];
                $this->CrudeModel->update('crudeform', ['id' => $id], $userData);
                echo 'Succss';
                // $this->session->set_flashata('update_message', 'Success');
            }
        }

        $response['user'] = $this->CrudeModel->get_single_record('crudeform', ['id' => $id], '*');
        $this->load->view('crudeform', $response);
    }
}
