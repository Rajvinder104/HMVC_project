<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testcontroller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TestModel');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    public function index()
    {

        $data['sum'] = $this->TestModel->sum();
        $data['sub'] = $this->TestModel->sub();
        $this->load->view('Testview', $data);
        $this->load->view('Testform.php');
    }

    public function my_fun()
    {
        $collect =  $this->TestModel->arrayData();
        $row =  $this->TestModel->arrayData2();

        echo "Name :-" . " " . $row['name'] . "<br>";
        echo "Password :-" . " " . $row['password'] . "<br>";
        echo "Age :-" . " " . $row['age'] . "<br>" . "<br>";

        foreach ($collect as $value) {
            echo "Name :-" . " " . $value['name'] . "<br>";
            echo "Password :-" . " " . $value['password'] . "<br>";
            echo "Age :-" . " " . $value['age'] . "<br>" . "<br>";
        }
    }

    public function my_fun2()
    {
        $collect =  $this->TestModel->objectData();
        $rowobject =  $this->TestModel->objectData2();
        echo "Name :-" . " " . $rowobject->name . "<br>";
        echo "Password :-" . " " . $rowobject->password . "<br>";
        echo "Age :-" . " " . $rowobject->age . "<br>" . "<br>";

        foreach ($collect as $value) {
            echo "Name :-" . " " . $value->name . "<br>";
            echo "Password :-" . " " . $value->password . "<br>";
            echo "Age :-" . " " . $value->age . "<br>" . "<br>";
        }
    }

    public function formdata()
    {

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password Confirmation', 'required');

            if (empty($_FILES['document']['name'])) {
                $this->form_validation->set_rules('document', 'Image', 'required');
            }

            if ($this->form_validation->run()) {

                $config['upload_path'] = './uploads';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 1024;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('document')) {

                    $error['err'] = $this->upload->display_errors();
                    $this->load->view('Testform.php', $error);
                } else {
                    $data = $this->upload->data();
                    $validdata = $this->input->post();
                    $validdata['image'] = $data['file_name'];
                    $this->TestModel->formdata($validdata);
                    echo "<script>alert('Data Inserted Successfully')</script>";
                }
            }
        }
        $this->load->view('Testform.php');
    }

}
