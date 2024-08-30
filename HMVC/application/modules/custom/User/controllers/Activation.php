<?php defined('BASEPATH') or exit('No direct script access allowed');

class Activation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'form_validation', 'security', 'email', 'pagination'));
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
        $response['csrt'] = $this->security->get_csrf_hash();
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->security->xss_clean($this->input->post());
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required|xss_clean');
            $this->form_validation->set_rules('package_id', 'Package ', 'trim|required|xss_clean');
            if ($this->form_validation->run() != false) {
                $user_id = $data['user_id'];
                $package = $this->User_model->GetSingleRecord('tbl_package', ['id' => $data['package_id']], '*');
                $activationAmount = $package['price'];
                $user = $this->User_model->GetSingleRecord('tbl_users', ['user_id' => $this->session->userdata['user_id']], 'id,user_id,master_key');
                $wallet_balance = $this->User_model->GetSingleRecord('tbl_wallet', ['user_id' => $this->session->userdata['user_id']], 'ifnull(sum(amount),0) as balance');
                $Checkuser = $this->User_model->GetSingleRecord('tbl_users', ['user_id' => $data['user_id']], '*');
                if (!empty($Checkuser)) {
                    if ($wallet_balance['balance'] >= $activationAmount) {
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
                            'total_package' => $Checkuser['total_package'] + $activationAmount,
                            'topup_date' => date('Y-m-d H:i:s'),
                        );
                        $this->User_model->Update('tbl_users', array('user_id' => $user_id), $topupData);
                        $activationData = [
                            'user_id' => $user_id,
                            'activater' => $this->session->userdata['user_id'],
                            'package' => $activationAmount,
                            'topup_date' => date('Y-m-d H:i:s'),
                            'type' => 'activate_account',
                        ];
                        $this->User_model->add('tbl_activation_details', $activationData);
                        $RoiGenerate = [
                            'user_id' => $user_id,
                            'amount' => $activationAmount,
                            'roi_amount' => $activationAmount * $package['binary'],
                            'days' => 5,
                            'total_days' => 5,
                            'type' => 'roi_income',
                        ];
                        $this->User_model->add('tbl_roi', $RoiGenerate);
                        $sponsor = $this->User_model->GetSingleRecord('tbl_users', ['user_id' => $Checkuser['sponsor_id']], '*');
                        if ($sponsor['paid_status'] == 1) {
                            $Direct_income = array(
                                'user_id' => $sponsor['user_id'],
                                'amount' => $activationAmount * $package['direct_income'],
                                'type' => 'direct_income',
                                'description' => 'Direct Income from Activation of Member ' . $user_id,
                            );
                            $this->User_model->add('tbl_income_wallet', $Direct_income);
                            // $this->User_model->update('tbl_income_wallet', ['user_id' => $sponsor['user_id']], ['direct_amount' => $activationAmount * $package['direct_income']]);
                        }
                        $this->level_income($sponsor['sponsor_id'], $user_id, $activationAmount, $package['level_income']);
                        $response = array('status' => 'success', 'message' => 'Account Activate Successfull');
                        echo json_encode($response, true);
                        return;
                    } else {
                        $response = array('status' => 'error', 'message' => 'Insufficient Balance!');
                        echo json_encode($response, true);
                        return;
                    }
                } else {
                    $response = array('status' => 'error', 'message' => 'Please Enter Valid User ID!');
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


    private function level_income($sponsor_id, $activate_id, $activationAmount, $level_income)
    {
        $incomes = explode(',', $level_income);
        foreach ($incomes as $key => $income) {
            $sponser = $this->User_model->GetSingleRecord('tbl_users', ['user_id' => $sponsor_id], '*');
            if (!empty($sponser['user_id'])) {
                if ($sponser['paid_status'] == 1) {
                    $level_income = array(
                        'user_id' => $sponser['user_id'],
                        'amount' => $activationAmount * $income,
                        'type' => 'level_income',
                        'description' => 'Level Income from Activation of Member ' . $activate_id . ' At level ' . ($key + 2),
                    );
                    // print_r($level_income);
                    $this->User_model->add('tbl_income_wallet', $level_income);
                }
                $sponsor_id = $sponser['sponsor_id'];
            }
        }
    }
}