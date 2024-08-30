<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'form_validation', 'security', 'email',  'pagination'));
        $this->load->model(array('User_model'));
        $this->load->helper(array('security', 'user'));
    }

    public function index()
    {
        if (is_user_logged_in()) {
            $response['user'] = $this->User_model->GetSingleRecord('tbl_users', [], '*');
            $this->load->view('index', $response);
        } else {
            redirect('login');
        }
    }
    public function JsonData()
    {
        $response['user'] = $this->User_model->GetSingleRecord('tbl_users', [], '*');
        echo json_encode($response, true);
    }

    public function login()
    {
        $this->load->view('login');
    }

    public function LoginAjax()
    {
        $response['message'] = '';
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->security->xss_clean($this->input->post());
            $user = $this->User_model->GetSingleRecord('tbl_users', array('user_id' => $data['user_id'], 'password' => $data['password']), 'id,user_id,role,name,disabled');

            if (!empty($user)) {
                $this->session->set_userdata('user_id', $user['user_id']);
                $this->session->set_userdata('role', $user['role']);
                $response = array('status' => 'success', 'message' => 'Login Successfull!');
                echo json_encode($response, true);
                return;
            } else {
                $response = array('status' => 'error', 'message' => 'Invalid Details!');
                echo json_encode($response, true);
                return;
            }
        }
    }
}
