<?php defined('BASEPATH') or exit('No direct script access allowed');

class Withdraw extends CI_Controller
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
}
