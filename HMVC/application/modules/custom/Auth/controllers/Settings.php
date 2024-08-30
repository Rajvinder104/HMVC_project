<?php defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'form_validation', 'security', 'email'));
        $this->load->model(array('Auth_model'));
        $this->load->helper(array('security', 'admin'));
    }


       function getStatus()
    {
        if (is_admin()) {
            $response['success'] = 0;
            $response['admin'] = $this->Main_model->get_single_record('tbl_admin', array('id' => 1), 'withdraw_status');
            $response['success'] = 1;
            $response['data'] = $response['admin'];
            echo json_encode($response);
        } else {
            redirect('Admin/Management/login');
        }
    }


function WithdrawStatus($status)
    {
        if (is_admin()) {
            $response['success'] = 0;
            $updres = $this->Main_model->update('tbl_admin', array('id' => 1), array('withdraw_status' => $status));
            if ($updres == true) {
                $response['success'] = 1;
                $response['message'] = 'Successfully';
            } else {
                $response['message'] = 'Error While Updating Withdraw';
            }
            echo json_encode($response);
        } else {
            redirect('Admin/Management/login');
        }
    }

}