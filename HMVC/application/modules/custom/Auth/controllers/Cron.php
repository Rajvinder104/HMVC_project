<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'form_validation', 'security', 'email'));
        $this->load->model(array('Auth_model'));
        $this->load->helper(array('security', 'admin'));
    }

    public function roiCron()
    {
        $roiUsers = $this->Auth_model->GetRecords('tbl_roi', ['days >' => 0], '*');
        foreach ($roiUsers as $key => $user) {
            // $income = $this->Auth_model->GetSingleRecord('tbl_incomes', ['user_id' => $user['user_id']], 'ifnull(sum(roi_amount),0) as balance');
            $pending_day = $user['days'] - 1;
            $total_days = ($user['total_days'] + 1) - $user['days'];
            $RoiIncome = [
                'user_id' => $user['user_id'],
                'amount' => $user['roi_amount'],
                'type' => $user['type'],
                'description' => 'Roi Income at day ' . $total_days,
            ];
            $this->Auth_model->add('tbl_income_wallet', $RoiIncome);
            // $this->Auth_model->update('tbl_incomes', ['user_id' => $user['user_id']], ['roi_amount' => $user['roi_amount'] + $income['balance']]);
            $this->Auth_model->update('tbl_roi', ['user_id' => $user['user_id']], ['days' => $pending_day]);
        }
        pr($roiUsers);
    }
}