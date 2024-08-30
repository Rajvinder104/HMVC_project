<?php defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'form_validation', 'security', 'email',  'pagination'));
        $this->load->model(array('User_model'));
        $this->load->helper(array('security'));
    }


    public function index()
    {
        $sponsor_id = $this->input->get('sponsor_id');
        if ($sponsor_id == '') {
            $sponsor_id = '';
        }
        $response['sponsor_id'] = $sponsor_id;
        $this->load->view('register', $response);
    }

    public function indexAjax()
    {
        $sponsor_id = $this->input->get('sponsor_id');
        if ($sponsor_id == '') {
            $sponsor_id = '';
        }
        $response['sponsor_id'] = $sponsor_id;
        $response['csrt'] =  $this->security->get_csrf_hash();
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('sponsor_id', 'Sponsor ID', 'trim|required|xss_clean');
            if ($this->form_validation->run() != false) {
                $sponsor = $this->User_model->GetSingleRecord('tbl_users', ['user_id' => $data['sponsor_id']], 'user_id');
                if (!empty($sponsor)) {
                    $user_id = $this->GenerateUserId();
                    $addData['user_id'] = $user_id;
                    $addData['sponsor_id'] = $data['sponsor_id'];
                    $addData['name'] = 'Testing';
                    $addData['master_key'] = rand(9999, 0000);
                    $addData['password'] = rand(999999, 000000);
                    $res = $this->User_model->add('tbl_users', $addData);
                    $res = $this->User_model->add('tbl_bank_details', array('user_id' => $addData['user_id']));
                    $res = $this->User_model->add('tbl_incomes', array('user_id' => $addData['user_id']));
                    if ($res == true) {
                        $this->AddSponserCount($addData['user_id'], $addData['user_id'], $level = 1);

                        // $user = $this->User_model->GetSingleRecord('tbl_users', array('user_id' => $addData['user_id']), 'id,user_id,role');
                        // $this->session->set_userdata('user_id', $user['user_id']);
                        // $this->session->set_userdata('role', $user['role']);

                        $response['register_msg'] = 'Dear ' . $addData['name'] . ' , Your Account Successfully created. User ID :  ' . $addData['user_id'] . ' Password : ' . $addData['password'] . ' Transaction Password : ' . $addData['master_key'];
                        $response = array('status' => 'success', 'message' => $response['register_msg']);
                        // $this->load->view('success', $response);
                        echo json_encode($response, true);
                        return;
                    } else {
                        $response = array('status' => 'error', 'message' => 'Error while Registration please try Again!');
                        echo json_encode($response, true);
                        return;
                    }
                } else {
                    $response = array('status' => 'error', 'message' => 'Please Enter Valid Sponsor ID!');
                    echo json_encode($response, true);
                    return;
                }
            } else {
                $response = array('status' => 'error', 'message' => validation_errors());
                echo json_encode($response, true);
                return;
            }
        }
    }

    public function GenerateUserId()
    {
        $user_id = 'WR' . rand(9999, 0000);
        $cheCk = $this->User_model->GetSingleRecord('tbl_users', ['user_id' => $user_id], 'user_id');
        if (!empty($cheCk)) {
            return $this->GenerateUserId();
        } else {
            return $user_id;
        }
    }

    public function AddSponserCount($user, $downline, $level)
    {
        $cheCk = $this->User_model->GetSingleRecord('tbl_users', ['user_id' => $user], 'id,user_id,sponsor_id');
        if ($cheCk['sponsor_id'] != '' && $cheCk['sponsor_id'] != 'none') {
            $DownArr = [
                'user_id' => $cheCk['sponsor_id'],
                'downline_id' => $downline,
                'position' => '',
                'level' => $level
            ];
            $this->User_model->add('tbl_sponser_count', $DownArr);
            $user = $cheCk['sponsor_id'];
            $this->AddSponserCount($user, $downline, $level + 1);
        }
    }
}
