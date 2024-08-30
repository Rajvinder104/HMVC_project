<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Withdraw extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'encryption', 'form_validation', 'security', 'email', 'pagination'));
        $this->load->model(array('User_model'));
        $this->load->helper(array('user', 'security', 'super'));
        $this->userinfo = userinfo();
    }

    public function index()
    {
        if (is_logged_in()) {
            redirect('dashboard');
        } else {
            redirect('login');
        }
    }


    public function DirectIncomeWithdraw_Wallet()
    {
        //die('this page is accessable');
        //route('dashboard/DirectIncomeWithdraw'); ---------------------------->
        if (is_logged_in()) {
            $response['user'] = get_single_record('tbl_users', array('user_id' => $this->userinfo->user_id), '*');
            $response['tokenValue'] = get_single_record('tbl_token_value', ['id' => 1], 'amount');
            $response['withdrawtiming'] = get_single_record('plan_settings', ['id' => 1], '*');
            $response['admin'] = get_single_record('tbl_admin', ['id' => 1], '*');
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric|xss_clean');
                $this->form_validation->set_rules('master_key', 'Master Key', 'trim|required|xss_clean');
                $this->form_validation->set_rules('wallet_address', 'Wallet Address', 'trim|required|xss_clean');
                if ($this->form_validation->run() != FALSE) {
                    $todayWithdraw = get_single_record('tbl_withdraw', array('user_id' => $this->userinfo->user_id, 'date(created_at)' => date('Y-m-d')), '*');
                    $withdraw_amount = abs($data['amount']);
                    $master_key = $data['master_key'];
                    $balance = get_single_record('tbl_income_wallet', ' user_id = "' . $this->userinfo->user_id . '"', 'ifnull(sum(amount),0) as balance');
                    if (empty($todayWithdraw)) {
                        if ($withdraw_amount >= min_withdraw && $withdraw_amount <= max_withdraw) {
                            if ($balance['balance'] >= $withdraw_amount) {
                                if ($this->userinfo->master_key == $master_key) {
                                    $DirectIncome = array(
                                        'user_id' => $this->userinfo->user_id,
                                        'amount' => -$withdraw_amount,
                                        'type' => 'withdraw_request',
                                        'description' => 'Withdrawal Amount ',
                                        'dollar' => $withdraw_amount,
                                        'token_price' => $response['tokenValue']['amount'],
                                    );
                                    add('tbl_income_wallet', $DirectIncome);
                                    $withdrawArr = array(
                                        'user_id' => $this->userinfo->user_id,
                                        'amount' => $withdraw_amount,
                                        'type' => 'withdraw_request',
                                        'tds' => $withdraw_amount * withdraw_charges / 100,
                                        'admin_charges' => $withdraw_amount * withdraw_charges / 100,
                                        'fund_conversion' => ($withdraw_amount - ($withdraw_amount * 0 / 100)),
                                        'zil_address' => $response['user']['eth_address'],
                                        'payable_amount' => ($withdraw_amount - ($withdraw_amount * withdraw_charges / 100)),
                                        'coin' => 0,
                                        'credit_type' => 'Wallet',
                                    );
                                    add('tbl_withdraw', $withdrawArr);
                                    set_flashdata('withdraw_wallet_message', span_success_simple('Withdraw Requested Successfully'));
                                } else {
                                    set_flashdata('withdraw_wallet_message', span_danger('Invalid Master Key'));
                                }
                            } else {
                                set_flashdata('withdraw_wallet_message', span_info('Insuffcient Balance'));
                            }
                        } else {
                            set_flashdata('withdraw_wallet_message', span_danger('Minimum Withdrawal Amount is ' . currency . min_withdraw . '   and Maximum  ' . currency . max_withdraw));
                        }
                    } else {
                        set_flashdata('withdraw_wallet_message', span_info('Once a withdraw in a day,Please try next sunday'));
                    }
                }
            }
            $response['balance'] = get_single_record('tbl_income_wallet', ' user_id = "' . $this->userinfo->user_id . '"', 'ifnull(sum(amount),0) as balance');
            $this->load->view('withdraw_wallet', $response);
        } else {
            redirect('Dashboard/User/login');
        }
    }

    public function DirectIncomeWithdraw_Bank()
    {
        //die('this page is accessable');
        //route('dashboard/DirectIncomeWithdraw'); ---------------------------->
        if (is_logged_in()) {
            $response['tokenValue'] = get_single_record('tbl_token_value', ['id' => 1], 'amount');
            $response['admin'] = get_single_record('tbl_admin', ['id' => 1], '*');
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric|xss_clean');
                $this->form_validation->set_rules('master_key', 'Master Key', 'trim|required|xss_clean');
                if ($this->form_validation->run() != FALSE) {
                    $leftDirect = get_single_record('tbl_users', array('sponser_id' => $this->userinfo->user_id, 'position' => 'L', 'paid_status' => 1), 'ifnull(count(id),0) as leftDirect');
                    $rightDirect = get_single_record('tbl_users', array('sponser_id' => $this->userinfo->user_id, 'position' => 'R', 'paid_status' => 1), 'ifnull(count(id),0) as rightDirect');
                    $todayWithdraw = get_single_record('tbl_withdraw', array('user_id' => $this->userinfo->user_id, 'date(created_at)' => date('Y-m-d')), '*');
                    $withdraw_amount = abs($data['amount']);
                    $master_key = $data['master_key'];
                    $max_withdraw = $this->userinfo->package_amount * 0.5;
                    $balance = get_single_record('tbl_income_wallet', ' user_id = "' . $this->userinfo->user_id . '" and type ="roi_income"', 'ifnull(sum(amount),0) as balance');
                    if (empty($todayWithdraw)) {
                        // if ($rightDirect['rightDirect'] >= 1 && $leftDirect['leftDirect'] >= 1) {
                            if ($withdraw_amount >= min_withdraw && $withdraw_amount <= $max_withdraw) {
                                if ($withdraw_amount % multiple_withdraw == 0) {
                                    if ($balance['balance'] >= $withdraw_amount) {
                                        if ($this->userinfo->master_key == $master_key) {
                                            $DirectIncome = array(
                                                'user_id' => $this->userinfo->user_id,
                                                'amount' => -$withdraw_amount,
                                                'type' => 'withdraw_request',
                                                'description' => 'Withdrawal Amount ',
                                            );
                                            add('tbl_income_wallet', $DirectIncome);
                                            $withdrawArr = array(
                                                'user_id' => $this->userinfo->user_id,
                                                'amount' => $withdraw_amount,
                                                'type' => 'withdraw_request',
                                                'tds' => $withdraw_amount * 0 / 100,
                                                'admin_charges' => $withdraw_amount * withdraw_charges / 100,
                                                'fund_conversion' => ($withdraw_amount - ($withdraw_amount * 0 / 100)),
                                                'payable_amount' => ($withdraw_amount - ($withdraw_amount * withdraw_charges / 100)),
                                                'coin' => 0,
                                                'credit_type' => 'non_working',
                                            );
                                            add('tbl_withdraw', $withdrawArr);
                                            set_flashdata('withdraw_bank_message', span_success('Withdraw Requested Successfully'));
                                        } else {
                                            set_flashdata('withdraw_bank_message', span_danger('Invalid Master Key'));
                                        }
                                    } else {
                                        set_flashdata('withdraw_bank_message', span_info('Insuffcient Balance'));
                                    }
                                } else {
                                    set_flashdata('withdraw_bank_message', span_info('Multiple Withdraw Amount is ' . multiple_withdraw));
                                }
                            } else {
                                set_flashdata('withdraw_bank_message', span_danger('Minimum Withdrawal Amount is ' . currency . min_withdraw . '   and Maximum  ' . currency . $max_withdraw));
                            }
                        // } else {
                        //     set_flashdata('withdraw_bank_message', span_info('1 Left & 1 Right Direct are required for Withdrawal !'));
                        // }
                    } else {
                        set_flashdata('withdraw_bank_message', span_info('Once a withdraw in a day,Please try next day'));
                    }
                }
            }
            $response['dateWithdraw'] = get_single_record('tbl_withdraw', ' user_id = "' . $this->userinfo->user_id . '" and type ="non_working" order by id DESC LIMIT 1', 'created_at');

            $response['balance'] = get_single_record('tbl_income_wallet', ' user_id = "' . $this->userinfo->user_id . '" and type ="roi_income"', 'ifnull(sum(amount),0) as balance');
            $this->load->view('withdraw_bank_none', $response);
        } else {
            redirect('Dashboard/User/login');
        }
    }



    public function DirectWithdraw_Bank()
    {
        //die('this page is accessable');
        //route('dashboard/DirectIncomeWithdraw'); ---------------------------->
        if (is_logged_in()) {
            $response['tokenValue'] = get_single_record('tbl_token_value', ['id' => 1], 'amount');
            $response['admin'] = get_single_record('tbl_admin', ['id' => 1], '*');
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric|xss_clean');
                $this->form_validation->set_rules('master_key', 'Master Key', 'trim|required|xss_clean');
                if ($this->form_validation->run() != FALSE) {
                    $leftDirect = get_single_record('tbl_users', array('sponser_id' => $this->userinfo->user_id, 'position' => 'L', 'paid_status' => 1), 'ifnull(count(id),0) as leftDirect');
                    $rightDirect = get_single_record('tbl_users', array('sponser_id' => $this->userinfo->user_id, 'position' => 'R', 'paid_status' => 1), 'ifnull(count(id),0) as rightDirect');
                    $todayWithdraw = get_single_record('tbl_withdraw', array('user_id' => $this->userinfo->user_id, 'date(created_at)' => date('Y-m-d')), '*');
                    $withdraw_amount = abs($data['amount']);
                    $master_key = $data['master_key'];
                    $max_withdraw = $this->userinfo->package_amount * 0.5;
                    $balance = get_single_record('tbl_income_wallet', ' user_id = "' . $this->userinfo->user_id . '" and type !="roi_income"', 'ifnull(sum(amount),0) as balance');
                    if (empty($todayWithdraw)) {
                        // if ($rightDirect['rightDirect'] >= 1 && $leftDirect['leftDirect'] >= 1) {
                            if ($withdraw_amount >= min_withdraw && $withdraw_amount <= $max_withdraw) {
                                if ($withdraw_amount % multiple_withdraw == 0) {
                                    if ($balance['balance'] >= $withdraw_amount) {
                                        if ($this->userinfo->master_key == $master_key) {
                                            $DirectIncome = array(
                                                'user_id' => $this->userinfo->user_id,
                                                'amount' => -$withdraw_amount,
                                                'type' => 'withdraw_request',
                                                'description' => 'Withdrawal Amount ',
                                            );
                                            add('tbl_income_wallet', $DirectIncome);
                                            $withdrawArr = array(
                                                'user_id' => $this->userinfo->user_id,
                                                'amount' => $withdraw_amount,
                                                'type' => 'withdraw_request',
                                                'tds' => $withdraw_amount * 0 / 100,
                                                'admin_charges' => $withdraw_amount * withdraw_charges / 100,
                                                'fund_conversion' => ($withdraw_amount - ($withdraw_amount * 0 / 100)),
                                                'payable_amount' => ($withdraw_amount - ($withdraw_amount * withdraw_charges / 100)),
                                                'coin' => 0,
                                                'credit_type' => 'working',
                                            );
                                            add('tbl_withdraw', $withdrawArr);
                                            update('tbl_users',['user_id' => $this->userinfo->user_id], ['withdraw_option' => $data['withdraw_option']]);

                                            set_flashdata('withdraw_bank_message', span_success('Withdraw Requested Successfully'));
                                        } else {
                                            set_flashdata('withdraw_bank_message', span_danger('Invalid Master Key'));
                                        }
                                    } else {
                                        set_flashdata('withdraw_bank_message', span_info('Insuffcient Balance'));
                                    }
                                } else {
                                    set_flashdata('withdraw_bank_message', span_info('Multiple Withdraw Amount is ' . multiple_withdraw));
                                }
                            } else {
                                set_flashdata('withdraw_bank_message', span_danger('Minimum Withdrawal Amount is ' . currency . min_withdraw . '   and Maximum  ' . currency . $max_withdraw));
                            }
                        // } else {
                        //     set_flashdata('withdraw_bank_message', span_info('1 Left & 1 Right Direct are required for Withdrawal !'));
                        // }
                    } else {
                        set_flashdata('withdraw_bank_message', span_info('Once a withdraw in a day,Please try next day'));
                    }
                }
            }
            $response[' '] = get_single_record('tbl_withdraw', ' user_id = "' . $this->userinfo->user_id . '" and type ="working" order by id DESC LIMIT 1', 'created_at');
            $response['balance'] = get_single_record('tbl_income_wallet', ' user_id = "' . $this->userinfo->user_id . '" and type !="roi_income"', 'ifnull(sum(amount),0) as balance');
            $this->load->view('withdraw_bank', $response);
        } else {
            redirect('Dashboard/User/login');
        }
    }

    public function withdrawHistory()
    {
        if (is_logged_in()) {
            $response['header'] = 'Withdraw Summary';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = ['user_id' => $this->userinfo->user_id];
            if (!empty($type)) {
                $where = [$type => $value, 'user_id' => $this->userinfo->user_id];
            }
            $records = pagination('tbl_withdraw', $where, '*', 'dashboard/withdraw-history', 3, 10);

            $response['path'] =  $records['path'];

            $response['field'] =  '';
            $response['thead'] = '<tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Amount</th>
                                <th>Payable Amount</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Remark</th>
                                <th>Date</th>

                             </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;

            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $tbody[$key]  = ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $user_id . '</td>
                                <td>' . $amount . '</td>
                                <td>' . $payable_amount . '</td>
                                <td>' . ($status == 0 ? badge_warning('Pending') : ($status == 1 ? badge_success('Approved') : ($status == 2 ? badge_danger('Rejected') : badge_info('Withdraw')))) . '</td>
                                <td>' . ucwords(str_replace('_', ' ', $type)) . '</td>
                                <td>' . $remark . '</td>
                                <td>' . $created_at . '</td>
                             </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $this->load->view('reports', $response);
        } else {
            redirect('login');
        }
    }

    public function week_wise_payout_summary()
    {
        if (is_logged_in()) {
            $config_incomes = $this->config->item('incomes');
            $response['header'] = 'Week-Wise Payout Summary';

            // Retrieve input parameters
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $export = $this->input->get('export');

            // Build the query conditions
            $user_id = $this->session->userdata['user_id'];
            $where = array('user_id' => $user_id);

            if (!empty($start_date) && !empty($end_date)) {
                $start_date = $this->db->escape($start_date);
                $end_date = $this->db->escape($end_date);
                $where = 'YEARWEEK(created_at, 1) BETWEEN YEARWEEK(' . $start_date . ', 1) AND YEARWEEK(' . $end_date . ', 1) AND type != "withdraw_request" AND user_id = "' . $user_id . '"';
            }

            // Get the total row count for pagination
            $rowCount = $this->User_model->payout_sum_by_week('tbl_income_wallet', $where);
            $config['total_rows'] = count($rowCount);
            $config['base_url'] = base_url() . 'Dashboard/Withdraw/week_wise_payout_summary';
            $config['uri_segment'] = 4;
            $config['per_page'] = 10;
            $config['suffix'] = '?' . http_build_query($_GET);
            $config['attributes'] = array('class' => 'page-link');
            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li class="paginate_button page-item ">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="paginate_button page-item  active"><a href="#" class="page-link">';
            $config['cur_tag_close'] = '</a></li>';
            $config['prev_tag_open'] = '<li class="paginate_button page-item ">';
            $config['prev_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li class="paginate_button page-item">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="paginate_button page-item next">';
            $config['last_tag_close'] = '</li>';
            $config['prev_link'] = 'Previous';
            $config['prev_tag_open'] = '<li class="paginate_button page-item previous">';
            $config['prev_tag_close'] = '</li>';
            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<li  class="paginate_button page-item next">';
            $config['next_tag_close'] = '</li>';
            $this->pagination->initialize($config);

            // Fetch paginated data
            $segment = $this->uri->segment(4); // Adjust segment index as needed
            $records['records'] = $this->User_model->week_wise_payout_summary($where, $config['per_page'], $segment);

            $response['path'] =  $config['base_url'];
            $response['field'] = '
            <div class="col-4">
                <input type="date" name="start_date" class="form-control" value="' . $start_date . '" placeholder="Start Date">
            </div>
            <div class="col-4">
                <input type="date" name="end_date" class="form-control" value="' . $end_date . '" placeholder="End Date">
            </div>
            <div class="col-4">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
            </div>';
            $response['thead'] = '<tr>
            <th>#</th>
            <th>Week</th>
            <th>Action</th>
        </tr>';

            // Generate table rows
            $tbody = [];
            $i = $segment + 1;
            foreach ($records['records'] as $key => $rec) {
                $week_start_date = $rec['week_start_date'];
                $week_end_date = $rec['week_end_date'];
                $tbody[$key]  = '<tr>
                <td>' . $i . '</td>
                <td>' . $week_start_date . ' - ' . $week_end_date . '</td>
                <td><a href="' . base_url('Dashboard/Withdraw/week_wise_datewise_payout/' . $week_start_date) . '">View</a></td>
            </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['total_income'] = '';
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('login');
        }
    }

    public function week_wise_datewise_payout($start_date = '')
    {
        if (is_logged_in()) {
            $response['header'] = 'Datewise Payout Summary for Week';
            $start_date = urldecode($start_date);
            try {
                $start_date_obj = new DateTime($start_date);
            } catch (Exception $e) {
                show_error('Invalid date format provided: ' . $e->getMessage());
                return;
            }
            $end_date_obj = clone $start_date_obj;
            $end_date_obj->modify('sunday this week');
            $end_date = $end_date_obj->format('Y-m-d');
            $where = [
                'created_at >=' => $start_date,
                'created_at <=' => $end_date,
                'user_id' => $this->session->userdata['user_id'],
            ];
            $records = pagination('tbl_income_wallet', $where, '*', 'Dashboard/Withdraw/week_wise_datewise_payout/' . $start_date, 5, 10);
            $response['path'] = $records['path'];
            $response['field'] = '';
            $response['thead'] = '<tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Date</th>
                             </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $tbody[$key] = '<tr>
                                <td>' . $i . '</td>
                                <td>' . $user_id . '</td>
                                <td>' . number_format($amount, 2) . '</td>
                                <td>' . $type . '</td>
                                <td>' . $description . '</td>
                                <td>' . $created_at . '</td>
                             </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['total_income'] = '';
            $this->load->view('reports', $response);
        } else {
            redirect('login');
        }
    }
}
