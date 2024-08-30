<?php defined('BASEPATH') or exit('No direct script access allowed');

class Activation extends CI_Controller
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
            $response['package'] = $this->User_model->GetRecords('tbl_package', [], '*');
            $this->load->view('activation', $response);
        } else {
            redirect('login');
        }
    }

    public function ActivationAjax()
    {
        $response['csrt'] =  $this->security->get_csrf_hash();
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('package', 'package', 'trim|required|xss_clean');
            $this->form_validation->set_rules('txn_password', 'Transaction Password', 'trim|required|xss_clean');
            if ($this->form_validation->run() != false) {
                $user_id = $this->session->userdata['user_id']; //$data['user_id'];
                $master_key = $data['txn_password'];
                $package = $this->User_model->getSingleRecord('tbl_package', ['id' => $data['id']], '*');
                $activationAmount = $package['price'];
                $user = $this->User_model->getSingleRecord('tbl_users', ['user_id' => $this->session->userdata['user_id']], 'id,user_id,master_key');
                // if (!empty($Checkuser)) {
                if ($master_key == $user['master_key']) {
                    $sendWallet = array(
                        'user_id' => $this->session->userdata['user_id'],
                        'amount' => -$activationAmount,
                        'type' => 'account_activation',
                        'remark' => 'Account Activation Deduction for ' . $user_id,
                    );
                    $this->User_model->add('tbl_wallet', $sendWallet);
                    $topupData = array(
                        'paid_status' => 1,
                        'package_id' => $package['id'],
                        'package_amount' => $activationAmount,
                        'total_package' => $user['total_package'] + $activationAmount,
                        'topup_date' => date('Y-m-d H:i:s'),
                        'capping' => $package['capping'],
                    );
                    $this->User_model->update('tbl_users', array('user_id' => $user_id), $topupData);
                    $activationData = [
                        'user_id' => $user_id,
                        'activater' => $this->session->userdata['user_id'],
                        'package' => $activationAmount,
                        'topup_date' => date('Y-m-d H:i:s'),
                        'type' => 'activate_account',
                    ];
                    $this->User_model->add('tbl_activation_details', $activationData);
                    if ($res == true) {
                        $response = array('status' => 'success', 'message' => 'Account Activate Successfull');
                        echo json_encode($response, true);
                    }
                    return;
                } else {
                    $response = array('status' => 'error', 'message' => 'Incorrect Transaction Password!');
                    echo json_encode($response, true);
                    return;
                }
                // } else {
                //     $response = array('status' => 'error', 'message' => 'Please Enter Valid User ID!');
                // echo json_encode($response, true);
                //     return;
                // }
            } else {
                $response = array('status' => 'error', 'message' => validation_errors());
                echo json_encode($response, true);
                return;
            }
        }
    }
}
