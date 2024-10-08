
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Withdraw extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'encryption', 'form_validation', 'security', 'email', 'pagination'));
        $this->load->model(array('Main_model'));
        $this->load->helper(array('admin', 'security', 'super'));
    }

    public function WithdrawHistory($status)
    {
        if (is_admin()) {
            $export = $this->input->get('export');
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');

            if ($status  == 'pending') {
                $response['header'] = ' Pending Withdrawal Request';
                $where = ['status' => 0];
            } elseif ($status == 'approved') {
                $response['header'] = 'Approved Withdrawal  Request';
                $where = ['status' => 1];
            } elseif ($status == 'rejected') {
                $response['header'] =  ' Rejected Withdrawal  Request';
                $where = ['status' => 2];
            } elseif ($status == 'allrequest') {
                $response['header'] = 'All Withdrawal Request';
                $where = [];
            } else {
                $response['header'] = 'Withdrawal Request';
                $where = [];
            }

            if (!empty($start_date)) {
                if ($status  == 'pending') {
                    $response['header'] = ' Pending Withdrawal Request';
                    $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '" and status = "0"';
                    // $where = ['status' => 0, $type => $value];
                } elseif ($status == 'approved') {
                    $response['header'] = 'Approved Withdrawal  Request';
                    // $where = ['status' => 1, $type => $value];
                    $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '" and status = "1"';
                } elseif ($status == 'rejected') {
                    $response['header'] =  ' Rejected Withdrawal  Request';
                    // $where = ['status' => 2, $type => $value];
                    $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '" and status = "2"';
                } elseif ($status == 'allrequest') {
                    $response['header'] = 'All Withdrawal Request';
                    $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '" and status != "4"';
                    // $where = [$type => $value];
                } else {
                    $response['header'] = 'Withdrawal Request';
                    $where = [$type => $value];
                }
            }
            $response['status_check'] = $status;

            $records = pagination('tbl_withdraw', $where, '*', 'admin/withdraw-history/' . $status, 4, 10);
            if ($export) {
                $application_type = 'application/' . $export;
                $header = ['#', 'User ID', 'Name', 'Phone', 'Amount', 'Deductions', 'Payable Amount',  'Type', 'Status', 'Bank Name', 'Bank Account Number', 'Account Holder Name ', 'IFSC Code', 'Remark', 'Request Date'];
                $usersss = get_records('tbl_withdraw', array(''), '*');
                foreach ($usersss as $key => $request) {
                    $user = get_single_record('tbl_users', array('user_id' => $request['user_id']), 'id,name,sponser_id,email,phone');
                    $bank = get_single_record('tbl_bank_details', array('user_id' => $request['user_id']), '*');

                    $records_export[$key]['i'] = ($key + 1);
                    $records_export[$key]['user_id'] = $request['user_id'];
                    $records_export[$key]['name'] = $user['name'];
                    $records_export[$key]['phone'] = $user['phone'];
                    $records_export[$key]['amount'] = $request['amount'];
                    $records_export[$key]['charity'] = $request['tds'] + $request['admin_charges'];
                    $records_export[$key]['payable_amount'] = $request['payable_amount'];
                    $records_export[$key]['type'] = ucwords(str_replace('_', ' ', $request['type']));
                    $records_export[$key]['status'] = ($request['status'] == 0 ? 'Pending' : ($request['status'] == 1 ? 'Approved' : ($request['status'] == 2 ? 'Rejected' : 'Withdraw')));
                    $records_export[$key]['bank_name'] = $bank['bank_name'];
                    $records_export[$key]['bank_account_number'] = $bank['bank_account_number'];
                    $records_export[$key]['account_holder_name'] = $bank['account_holder_name'];
                    $records_export[$key]['ifsc_code'] = $bank['ifsc_code'];
                    $records_export[$key]['remark'] = $request['remark'];
                    $records_export[$key]['created_at'] = $request['created_at'];
                }
                finalExport($export, $application_type, $header, $records_export);
            }
            $response['path'] =  $records['path'];
            $searchField = '<div class="col-4">
                                    <input type="date" name="start_date" class="form-control"
                                    value="' . $start_date . '" placeholder="Start Date">
                                </div>
                                <div class="col-4">
                                    <input type="date" name="end_date" class="form-control"
                                    value="' . $end_date . '" placeholder="End Date">
                                </div>
                                <div class="col-4">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>';
            $response['field'] = $searchField;
            $response['thead'] = '<tr>
                                <th>#</th>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Deductions</th>
                                <th>Payable Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>' . (withdraw == 1 ? 'Wallet Address' : 'Bank Details') . '</th>
                                <th>Remark</th>
                                <th>Date</th>
                                <th>Action</th>

                             </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $user = get_single_record('tbl_users', array('user_id' => $user_id), 'id,name,phone,eth_address');
                $bank = get_single_record('tbl_bank_details', array('user_id' => $user_id), '*');
                $btn =  ($status == 0 ? '<button class="btn btn-success WithdrawUser" data-id="' . $id . '" data-user_id="' . $user_id . '">View</button>' : ($status == 1 ?  badge_success('Approved') : ($status == 2 ?  badge_danger('Rejected') : badge_info('Withdraw'))));
                $btn2 =  ($status == 0 ? '<a href=" ' . base_url('Admin/Withdraw/viewpage').'">view</a>' : ($status == 1 ?  badge_success('Approved') : ($status == 2 ?  badge_danger('Rejected') : badge_info('Withdraw'))));
                $tbody[$key]  = ' <tr>
                                <td>' . ($status == 0 ? '<input name="data[]" type="checkbox" value="' . $id . '"/>' : '') . '</td>
                                <td>' . $i . '</td>
                                <td>' . $user_id . '</td>
                                <td>' . $user['name'] . '</td>
                                <td>' . $user['phone'] . '</td>
                                <td>' . $amount . '</td>
                                <td>' . ($tds + $admin_charges) . '</td>
                                <td>' . $payable_amount . '</td>
                                <td>' . ucwords(str_replace('_', ' ', $type)) . '</td>
                                <td>' . ($status == 0 ? badge_warning('Pending') : ($status == 1 ? badge_success('Approved') : ($status == 2 ? badge_danger('Rejected') : badge_info('Withdraw')))) . '</td>
                                <td>' . (withdraw == 1 ? $user['eth_address'] : '<div style="padding:10px" class="card">
                                <div class="card-body">
                                    <p><span>Account Holder Name:- ' . $bank['account_holder_name'] . '</span></p>
                                    <p><span>Bank Name:-' . $bank['bank_name'] . '</span></p>
                                    <p><span>Bank Account Number:-' . $bank['bank_account_number'] . '</span></p>
                                    <p><span>Branch Address:-' . $bank['branch_name'] . '</span></p>
                                    <p><span>IFSC Code:-' . $bank['ifsc_code'] . '</span></p>
                                </div>
                            </div>') . '</td>
                                <td>' . $remark . '</td>
                                <td>' . $created_at . '</td>
                                <td>' . $btn2 . '</td>

                             </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $response['export'] = true;
            $response['script'] = true;
            $this->load->view('withdraw_report', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function viewpage()
    {
        if (is_admin()) {
            $this->load->view('withdraw_view');
        } else {
            redirect('admin/login');
        }
    }


    public function test()
    {
        $this->load->view('javascript');
    }

    function WithdrawUserCheck($id)
    {
        if (is_admin()) {
            $response['success'] = 0;
            $user = get_single_record('tbl_withdraw', array('id' => $id), '*');
            if ($user == true) {
                $response['success'] = 1;
                $response['data'] = $user;
            } else {
                $response['success'] = 0;
                $response['message'] = 'Error While Updating Status';
            }
            echo json_encode($response);
        } else {
            redirect('admin/login');
        }
    }

    public function payout_summary()
    {
        if (is_admin()) {
            $config_incomes = $this->config->item('incomes');
            $response['header'] = 'Payout Summary';
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $export = $this->input->get('export');
            if (!empty($start_date)) {
                $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '" and type != "withdraw_request"';
                $rowCount = $this->Main_model->payout_sum2('tbl_income_wallet', $where, 'date(created_at) as date');
            } else {
                $where = array('type !=' => 'withdraw_request');
                $rowCount = $this->Main_model->payout_sum('tbl_income_wallet',  'date(created_at) as date');
            }
            $config['total_rows'] = count($rowCount);
            $config['base_url'] = base_url() . 'admin/payout-summary';
            $config['uri_segment'] = 3;
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
            $segment = $this->uri->segment(3);
            $records['records'] = $this->Main_model->payout_summary($where, $config['per_page'], $segment);

            if ($export) {
                $application_type = 'application/' . $export;
                $header = ["#", "Date", "Direct Income", "Level Income", "Pool Income", "Total Payout"];
                foreach ($records['records'] as $key => $request) {
                    $incomes = $this->Main_model->get_incomes('tbl_income_wallet', 'date(created_at) = "' . $request['date'] . '"', 'ifnull(sum(amount),0) as sum,type');
                    $calculate = calculate_income($incomes);
                    $records_export[$key]['i'] = ($key + 1);
                    $records_export[$key]['date'] = $request['date'];
                    foreach ($config_incomes as $inc_type => $value) {
                        $records_export[$key][$inc_type] = number_format($calculate[$inc_type], 2);
                        $records_export[$key]['total_payout'] = number_format($calculate['total_payout'], 2);
                    }
                }
                finalExport($export, $application_type, $header, $records_export);
            }

            $response['path'] =  $config['base_url'];
            $searchField = '<div class="col-4">
                                <input type="date" name="start_date" class="form-control"
                                value="' . $start_date . '" placeholder="Start Date">
                            </div>
                            <div class="col-4">
                                <input type="date" name="end_date" class="form-control"
                                value="' . $end_date . '" placeholder="End Date">
                            </div>
                            <div class="col-4">
                                <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-success">Search</button>
                            </div>
                            </div>';
            $response['field'] = $searchField;
            $response['thead'] = '<tr>
                                   <th>#</th>
                                   <th>Date</th>';
            foreach ($config_incomes as $value) {
                $response['thead'] .= '<th>' . $value . '</th>';
            }
            $response['thead'] .=  '<th>Total</th>
                                   <th>Action</th>
                                 </tr>';
            $tbody = [];
            $i = $segment + 1;
            foreach ($records['records'] as $key1 => $rec) {
                extract($rec);
                $incomes = $this->Main_model->get_incomes('tbl_income_wallet', 'date(created_at) = "' . $rec['date'] . '"', 'ifnull(sum(amount),0) as sum,type');
                $calculate = calculate_income($incomes);
                $tbody[$key1]  =  '<tr>
                                   <td>' . $i . '</td>
                                   <td>' . $rec['date'] . '</td>';
                foreach ($config_incomes as $inc_type => $value) {
                    $tbody[$key1] .=  ' <td>' . number_format($calculate[$inc_type], 2) . '</td>';
                }
                $tbody[$key1] .=
                    ' <td>' . number_format($calculate['total_payout'], 2) . '</td>
                                   <td><a href="' . base_url('admin/dateWisePayout/' . $rec['date']) . '">View</a></td>
                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $segment;
            $response['total_records'] = $config['total_rows'];
            $response['i'] = $i;
            $response['export'] = true;
            $response['script'] = false;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function request()
    {
        if (is_admin()) {
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                $this->form_validation->set_rules('main_id', 'ID', 'trim|required|xss_clean');
                $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
                if ($this->form_validation->run() != FALSE) {
                    $request = get_single_record('tbl_withdraw', array('id' => $data['main_id'], 'user_id' => $data['user_id']), '*');
                    if ($request['status'] != 0) {
                        set_flashdata('withdraw_message', span_info_simple('This withdraw request already updated!'));
                        redirect('admin/withdraw-history/allrequest');
                    } else {
                        if ($data['status'] == 1) {
                            $wArr = array(
                                'status' => 1,
                                'remark' => $data['remark'],
                            );
                            $res = update('tbl_withdraw', array('id' => $data['main_id'], 'user_id' => $data['user_id']), $wArr);
                            if ($res) {
                                set_flashdata('withdraw_message', span_success_simple('Withdraw request approved!'));
                                redirect('admin/withdraw-history/allrequest');
                            } else {
                                set_flashdata('withdraw_message', span_danger_simple('Error while approving request!'));
                                redirect('admin/withdraw-history/allrequest');
                            }
                        } elseif ($data['status'] == 2) {
                            $wArr = array(
                                'status' => 2,
                                'remark' => $data['remark'],
                            );
                            $res = update('tbl_withdraw', array('id' => $data['main_id'], 'user_id' => $data['user_id']), $wArr);
                            if ($res) {
                                $productArr = array(
                                    'user_id' => $request['user_id'],
                                    'amount' => $request['amount'],
                                    'type' => $request['type'],
                                    'description' => $data['remark'],
                                );
                                add('tbl_income_wallet', $productArr);
                                set_flashdata('withdraw_message', span_success_simple('Withdraw request rejected!'));
                                redirect('admin/withdraw-history/allrequest');
                            } else {
                                set_flashdata('withdraw_message', span_danger_simple('Error while approving rejection'));
                                redirect('admin/withdraw-history/allrequest');
                            }
                        }
                    }
                } else {
                    set_flashdata('withdraw_message', span_danger_simple(validation_errors()));
                    redirect('admin/withdraw-history/allrequest');
                }
            }
        } else {
            redirect('admin/login');
        }
    }



    public function request2()
    {
        if (is_admin()) {
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                //  $this->form_validation->set_rules('main_id', 'ID', 'trim|required|xss_clean');
                $this->form_validation->set_rules('user_id', 'ID', 'trim|required|xss_clean');
                $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
                if ($this->form_validation->run() != FALSE) {
                    $request = get_single_record('tbl_withdraw', array('user_id' => $data['user_id']), '*');
                    if ($request['status'] != 0) {
                        set_flashdata('withdraw_message', span_info_simple('This withdraw request already updated!'));
                        redirect('admin/withdraw-history/allrequest');
                    } else {
                        if ($data['status'] == 1) {
                            $wArr = array(
                                'status' => 1,
                                'remark' => $data['remark'],
                            );
                            $res = update('tbl_withdraw', array('user_id' => $data['user_id']), $wArr);
                            if ($res) {
                                set_flashdata('withdraw_message', span_success_simple('Withdraw request approved!'));
                                redirect('admin/withdraw-history/allrequest');
                            } else {
                                set_flashdata('withdraw_message', span_danger_simple('Error while approving request!'));
                                redirect('admin/withdraw-history/allrequest');
                            }
                        } elseif ($data['status'] == 2) {
                            $wArr = array(
                                'status' => 2,
                                'remark' => $data['remark'],
                            );
                            $res = update('tbl_withdraw', array('user_id' => $data['user_id']), $wArr);
                            if ($res) {
                                $productArr = array(
                                    'user_id' => $request['user_id'],
                                    'amount' => $request['amount'],
                                    'type' => $request['type'],
                                    'description' => $data['remark'],
                                );
                                add('tbl_income_wallet', $productArr);
                                set_flashdata('withdraw_message', span_success_simple('Withdraw request rejected!'));
                                redirect('admin/withdraw-history/allrequest');
                            } else {
                                set_flashdata('withdraw_message', span_danger_simple('Error while approving rejection'));
                                redirect('admin/withdraw-history/allrequest');
                            }
                        }
                    }
                } else {
                    set_flashdata('withdraw_message', span_danger_simple(validation_errors()));
                    redirect('admin/withdraw-history/allrequest');
                }
            }
        } else {
            redirect('admin/login');
        }
    }



    public function dateWisePayout($date = '')
    {
        if (is_admin()) {
            $response['header'] = 'Datewise Payout Summary';
            $where = ['date(created_at)' => $date];

            $records = pagination('tbl_income_wallet', $where, '*', 'admin/dateWisePayout/' . $date, 4, 10);

            $response['path'] =  $records['path'];
            $response['field'] = '';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>User Id</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th> DESCRIPTION</th>
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
                                    <td>' . ucwords(str_replace('_', ' ', $type)) . '</td>
                                    <td>' . $description . '</td>
                                    <td>' . $created_at . '</td>
                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $response['export'] = false;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }


    public function incomeLedgar()
    {
        if (is_admin()) {
            $response['header'] = 'Income Ledgar';
            $type1 = $this->input->get('type1');
            $value = $this->input->get('value');
            $export = $this->input->get('export');
            if (!empty($type1)) {
                // $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '"';
                $where = [$type1 => $value];
            } else {
                $where = array('');
            }
            $records = pagination('tbl_income_wallet', $where, '*', 'admin/income-ledgar/', 3, 10);
            if ($export) {
                $application_type = 'application/' . $export;
                $header = ['#', 'User ID', 'Amount', 'Type', 'Description', 'Credit Date'];
                foreach ($records['records'] as $key => $record) {
                    $records[$key]['i'] = ($key + 1);
                    $records[$key]['user_id'] = $record['user_id'];
                    $records[$key]['amount'] = $record['amount'];
                    $records[$key]['type'] = $record['type'];
                    $records[$key]['description'] = $record['description'];
                    $records[$key]['created_at'] = $record['created_at'];
                }
                finalExport($export, $application_type, $header, $records);
            }
            $response['path'] =  $records['path'];
            $response['field'] = '<div class="col-4">
                                <select class="form-control" name="type1">
                                    <option value="user_id" ' . $type1 . ' == "user_id" ? "selected" : "";?>
                                        User ID</option>
                                </select>
                                </div>
                                    <div class="col-4">
                                    <input type="text" name="value" class="form-control text-dark float-right"
                                        value="' . $value . '" placeholder="Search">
                                    </div>
                                <div class="col-4">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>User Id</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th> DESCRIPTION</th>
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
                                    <td>' . ucwords(str_replace('_', ' ', $type)) . '</td>
                                    <td>' . str_replace('_', ' ', $description) . '</td>
                                    <td>' . $created_at . '</td>
                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $response['export'] = false;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }


    public function incomes()
    {
        if (is_admin()) {
            $response['header'] = 'Income Ledgar';
            $type1 = $this->input->get('type1');
            $value = $this->input->get('value');
            $where = 'type = "roi_income" OR type = "level_income"';
            if (!empty($type1)) {
                $where = [$type1 => $value, 'type = "roi_income" OR type = "level_income"'];
            }
            $records = pagination('tbl_income_wallet', $where, '*', 'admin/incomes/', 3, 10);

            $response['path'] =  $records['path'];
            $response['field'] = '<div class="col-4">
                                <select class="form-control" name="type1">
                                    <option value="type" ' . $type1 . ' == "type" ? "selected" : "";?>
                                       Type</option>
                                </select>
                                </div>
                                    <div class="col-4">
                                    <input type="text" name="value" class="form-control text-dark float-right"
                                        value="' . $value . '" placeholder="Search">
                                    </div>
                                <div class="col-4">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>User Id</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th> DESCRIPTION</th>
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
                                    <td>' .  $type . '</td>
                                    <td>' . str_replace('_', ' ', $description) . '</td>
                                    <td>' . $created_at . '</td>
                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $response['export'] = false;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }
    public function income($type = '')
    {
        if (is_admin()) {
            $response['header'] = ucwords(str_replace('_', ' ', $type));

            $export = $this->input->get('export');
            $type1 = $this->input->get('type1');
            $value = $this->input->get('value');
            $where = array('type' => $type);
            if (!empty($type1)) {
                $where = [$type1 => $value, 'type' => $type];
            }

            $records = pagination('tbl_income_wallet', $where, '*', 'admin/incomes/' . $type . '/', 4, 10);

            $response['path'] =  $records['path'];
            $response['field'] = '<div class="col-4">
                                    <select class="form-control" name="type1">
                                        <option value="user_id" ' . $type1 . ' == "user_id" ? "selected" : "";?>
                                            User ID</option>
                                    </select>
                                    </div>
                                    <div class="col-4">
                                    <input type="text" name="value" class="form-control text-dark float-right"
                                        value="' . $value . '" placeholder="Search">
                                    </div>
                                    <div class="col-4">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                    </div>';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>User Id</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th> DESCRIPTION</th>
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
                                    <td>' . ucwords(str_replace('_', ' ', $type)) . '</td>
                                    <td>' . $description . '</td>
                                    <td>' . $created_at . '</td>
                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $response['export'] = false;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function today_income($type = '')
    {
        if (is_admin()) {
            $response['header'] = ucwords(str_replace('_', ' ', $type));

            $export = $this->input->get('export');
            $type1 = $this->input->get('type1');
            $value = $this->input->get('value');
            $where = array('type' => $type, 'date(created_at)' => date('Y-m-d'));
            if (!empty($type1)) {
                $where = [$type1 => $value, 'type' => $type, 'date(created_at)' => date('Y-m-d')];
            }

            $records = pagination('tbl_income_wallet', $where, '*', 'admin/today-income/' . $type . '/', 4, 10);
            if ($export) {
                $application_type = 'application/' . $export;
                $header = ['#', 'User ID', 'Amount', 'Type', 'Description', 'Credit Date'];
                foreach ($records['records'] as $key => $record) {
                    $records[$key]['i'] = ($key + 1);
                    $records[$key]['user_id'] = $record['user_id'];
                    $records[$key]['amount'] = $record['amount'];
                    $records[$key]['type'] = $record['type'];
                    $records[$key]['description'] = $record['description'];
                    $records[$key]['created_at'] = $record['created_at'];
                }
                finalExport($export, $application_type, $header, $records);
            }
            $response['path'] =  $records['path'];
            $response['field'] = '<div class="col-4">
                                    <select class="form-control" name="type1">
                                        <option value="user_id" ' . $type1 . ' == "user_id" ? "selected" : "";?>
                                            User ID</option>
                                    </select>
                                    </div>
                                    <div class="col-4">
                                    <input type="text" name="value" class="form-control text-dark float-right"
                                        value="' . $value . '" placeholder="Search">
                                    </div>
                                    <div class="col-4">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                    </div>';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>User Id</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th> DESCRIPTION</th>
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
                                    <td>' . ucwords(str_replace('_', ' ', $type)) . '</td>
                                    <td>' . $description . '</td>
                                    <td>' . $created_at . '</td>
                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $response['export'] = false;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function AddressRequests($status)
    {
        if (is_admin()) {
            $export = $this->input->get('export');
            $type = $this->input->get('type');
            $value = $this->input->get('value');

            if ($status  == 'pending') {
                $response['header'] = ' Pending KYC Request';
                $where = ['kyc_status' => 1];
            } elseif ($status == 'approved') {
                $response['header'] = 'Approved KYC  Request';
                $where = ['kyc_status' => 2];
            } elseif ($status == 'rejected') {
                $response['header'] =  ' Rejected KYC  Request';
                $where = ['kyc_status' => 3];
            } elseif ($status == 'allrequest') {
                $where = ['kyc_status' => 0];
                $response['header'] = 'All KYC Request';
                $where = [];
            } else {
                $response['header'] = 'KYC Request';
                $where = [];
            }


            if (!empty($type)) {
                if ($status  == 'pending') {
                    $response['header'] = ' Pending KYC Request';
                    $where = ['kyc_status' => 1, $type => $value];
                } elseif ($status == 'approved') {
                    $response['header'] = 'Approved KYC  Request';
                    $where = ['kyc_status' => 2, $type => $value];
                } elseif ($status == 'rejected') {
                    $response['header'] =  ' Rejected KYC  Request';
                    $where = ['kyc_status' => 3, $type => $value];
                } elseif ($status == 'allrequest') {
                    $response['header'] = 'All KYC Request';
                    $where = [$type => $value];
                } else {
                    $response['header'] = 'KYC Request';
                    $where = [$type => $value];
                }
            }

            $records = pagination('tbl_bank_details', $where, '*', 'admin/kyc-history/' . $status, 4, 10);
            if ($export) {
                $application_type = 'application/' . $export;
                $header = ['#', 'User ID', 'Bank Name', 'Bank Account Number', 'Account Holder Name', 'Branch Name', 'IFSC Code', 'Status', 'Date'];
                foreach ($records['records'] as $key1 => $request) {
                    $records_export[$key1]['i'] = ($key1 + 1);
                    $records_export[$key1]['user_id'] = $request['user_id'];
                    $records_export[$key1]['bank_name'] = $request['bank_name'];
                    $records_export[$key1]['bank_account_number'] = $request['bank_account_number'];
                    $records_export[$key1]['account_holder_name'] = $request['account_holder_name'];
                    $records_export[$key1]['branch_name'] = $request['branch_name'];
                    $records_export[$key1]['ifsc_code'] = $request['ifsc_code'];
                    $records_export[$key1]['kyc_status'] = ($request['kyc_status'] == 1 ? 'Pending' : ($request['kyc_status'] == 2 ? 'Approved' : ($request['kyc_status'] == 3 ? 'Rejected' : 'KYC')));
                    $records_export[$key1]['created_at'] = $request['created_at'];
                }
                finalExport($export, $application_type, $header, $records_export);
            }
            $response['path'] =  $records['path'];

            $response['field'] = '<div class="col-4">
                        <select class="form-control" name="type">
                            <option value="user_id" ' . $type . ' == "user_id" ? "selected" : "";?>
                                User ID</option>
                        </select>
                        </div>
                        <div class="col-4">
                        <input type="text" name="value" class="form-control float-right"
                            value="' . $value . '" placeholder="Search">
                        </div>
                        <div class="col-4">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>';
            if ($status  == 'pending' || $status == 'allrequest') {
                $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account Number</th>
                                    <th>Account Holder Name</th>
                                    <th>Branch Address</th>
                                    <th>IFSC Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                             </tr>';
            } else {
                $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account Number</th>
                                    <th>Account Holder Name</th>
                                    <th>Branch Address</th>
                                    <th>IFSC Code</th>
                                    <th>Status</th>
                             </tr>';
            }
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                $data = $this->Main_model->get_single_record('tbl_users', ['user_id' => $rec['user_id']], 'name');
                extract($rec);

                // <td><img src="' . base_url('uploads/' . $id_proof) . '" data-image="' . base_url('uploads/' . $id_proof) . '" style="cursor:pointer;" width="150px" class="img-responsive zmimg"></td>
                //                 <td><img src="' . base_url('uploads/' . $id_proof2) . '" data-image="' . base_url('uploads/' . $id_proof2) . '" style="cursor:pointer;" width="150px" class="img-responsive zmimg"></td>
                //                 <td><img src="' . base_url('uploads/' . $id_proof3) . '" data-image="' . base_url('uploads/' . $id_proof3) . '" style="cursor:pointer;" width="150px" class="img-responsive zmimg"></td>
                //                 <td><img src="' . base_url('uploads/' . $id_proof4) . '" data-image="' . base_url('uploads/' . $id_proof4) . '" style="cursor:pointer;" width="150px" class="img-responsive zmimg"></td>
                $approved = '<button class="btn btn-success apvbtn" data-id="' . $id . '" data-status="2">Approve</button>';
                $rejected = '<button class="btn btn-danger apvbtn" data-id="' . $id . '" data-status="3">Reject</button>';
                $tbody[$key]  = ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $user_id . '</td>
                                <td>' . $data['name'] . '</td>
                                <td>' . $bank_name . '</td>
                                <td>' . $bank_account_number . '</td>
                                <td>' . $account_holder_name . '</td>
                                <td>' . $branch_name . '</td>
                                <td>' . $ifsc_code . '</td>
                                <td>' . ($kyc_status == 1 ? badge_warning('Pending') : ($kyc_status == 2 ? badge_success('Approved') : ($kyc_status == 3 ? badge_danger('Rejected') : badge_info('Kyc Not Submit')))) . '</td>
                                <td>' . ($kyc_status == 1 ? $approved . ' ' . $rejected : '') . '</td>

                             </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['export'] = false;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $response['script'] = true;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function ApproveUserAddressRequest($id, $status)
    {
        if (is_admin()) {
            $data['success'] = 0;
            $res = update('tbl_bank_details', array('id' => $id), array('kyc_status' => $status));
            if ($res) {
                if ($status == 2) {
                    $data['message'] = 'Request Accepted Successfully';
                    $data['success'] = 1;
                } elseif ($status == 3) {
                    $data['message'] = 'Request Rejected Successfully';
                    $data['success'] = 1;
                } else {
                    $data['message'] = 'Error While Updating Status';
                    $data['success'] = 0;
                }
            } else {
                $data['message'] = 'Error While Updating Status';
                $data['success'] = 0;
            }
            echo json_encode($data);
        } else {
            redirect('admin/login');
        }
    }


    public function withdrawtypes($status)
    {
        if (is_admin()) {

            $field = $this->input->get('type');
            $value = $this->input->get('value');

            // $name = $this->input->get('name');
            if ($status == 'pending') {
                $response['header'] = ' Pending Withdrawal Request';
                $where = ['tbl_withdraw.status' => 0];
                $response['tbl_withdraw.status'] = 0;
                $withstatus = 0;
            } elseif ($status == 'approve') {
                $response['header'] = 'Approved Withdrawal  Request';
                $where = ['tbl_withdraw.status' => 1];
                $response['tbl_withdraw.status'] = 1;
                $withstatus = 1;
            } elseif ($status == 'reject') {
                $response['header'] =  ' Rejected Withdrawal  Request';
                $where = ['tbl_withdraw.status' => 2];
                $response['tbl_withdraw.status'] = 2;
                $withstatus = 2;
            } else {
                $response['header'] = 'Withdrawal Request';
                $response['tbl_withdraw.status'] = '';
                $withstatus = '';
                $where = [];
            }

            if (!empty($field)) {
                $where = [$field => $value, 'tbl_withdraw.status' => $withstatus];
            }
            if (!empty($field)) {
                if ($status  == 'pending') {
                    $response['header'] = ' Pending Withdrawal Request';
                    $where = [$field => $value, 'tbl_withdraw.status' => 0];
                    // $where = ['status' => 0, $type => $value];
                } elseif ($status == 'approve') {
                    $response['header'] = 'Approved Withdrawal  Request';
                    // $where = ['status' => 1, $type => $value];
                    $where = [$field => $value, 'tbl_withdraw.status' => 1];
                } elseif ($status == 'reject') {
                    $response['header'] =  ' Rejected Withdrawal  Request';
                    // $where = ['status' => 2, $type => $value];
                    $where = [$field => $value, 'tbl_withdraw.status' => 2];
                } elseif ($status == ' ') {
                    $response['header'] = 'All Withdrawal Request';
                    $where = [$field => $value];
                    // $where = [$type => $value];
                } else {
                    $response['header'] = 'Withdrawal Request';
                    $where = [$field => $value, 'tbl_withdraw.status' => $withstatus];
                }
            }
            // if (!empty($field)) {
            //     $where = [$field => $value ];
            // }


            $config['total_rows'] = $this->Main_model->get_sums($where);
            $config['base_url'] =  base_url() . 'Admin/Withdraw/withdrawtypes/' . $status;
            $config['uri_segment'] = 5;
            $config['per_page'] = 10;
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
            $segment = $this->uri->segment(5);
            $response['requests'] = $this->Main_model->get_data_from_jointbls($where, $config['per_page'], $segment);
            // echo '<pre>' ;
            // print_r( $response['requests']);
            $response['path'] =  $config['base_url'];

            $response['total_records'] = $config['total_rows'];
            $response['segament'] = $segment;
            $response['type'] = $field;
            $response['value'] = $value;
            // $response['type'] =$response['requests'];

            $this->load->view('withdrawrequest', $response);
        } else {
            redirect('Admin/Management/login');
        }
    }

    public function non_withdraw_history()
    {
        if (is_admin()) {
            $response['header'] = 'Non Withdraw Summary';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = [];
            if (!empty($type) && !empty($value)) {
                $where = [$type => $value];
            }

            $config['total_rows'] = $this->Main_model->nonwithdraw($where);

            $config['base_url'] = base_url() . 'admin/non-withdraw-history';
            $config['uri_segment'] = 3;
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
            $segment = $this->uri->segment(3);
            $records['records'] = $this->Main_model->nonwithdraw2($config['per_page'], $segment, $where);

            $response['path'] =  $config['base_url'];
            $searchField = '<div class="col-4">
                            <select class="form-control" name="type">
                                <option value="user_id" ' . ($type == "user_id" ? "selected" : "") . '>User ID</option>
                            </select>
                            </div>
                            <div class="col-4">
                            <input type="text" name="value" class="form-control float-right"
                                value="' . $value . '" placeholder="Search">
                            </div>
                            <div class="col-4">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>';
            $response['field'] = $searchField;
            $response['thead'] = '<tr>
                                       <th>#</th>
                                       <th>User Id</th>
                                       <th>Sponser Id</th>
                                       <th>Name</th>
                                       <th>Created At</th>
                                       <th>Updated At</th>

                                 </tr>';

            $tbody = [];
            $i = $segment + 1;
            foreach ($records['records'] as $key1 => $rec) {
                extract($rec);
                $tbody[$key1]  =  '<tr>
                                   <td>' . $i . '</td>
                                   <td>' . $user_id . '</td>
                                   <td>' . $sponser_id . '</td>
                                   <td>' . $name . '</td>
                                   <td>' . $created_at . '</td>
                                   <td>' . $updated_at . '</td>
                                   </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $segment;
            $response['total_records'] = $config['total_rows'];
            $response['i'] = $i;
            $response['export'] = true;
            $response['script'] = false;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }
    public function Setwithdrawtiming()
    {
        if (is_admin()) {
            $response = array();
            $response['header'] = 'Set Withdraw Timing';

            // Open the form
            $response['form_open'] = form_open(base_url('admin/set-withdraw-timing'));

            // Define form fields
            $response['form'] = [

                'start_withdraw_time' => form_label('Start Time', 'start_withdraw_time') . form_input(array(
                    'type' => 'time',
                    'name' => 'start_withdraw_time',
                    'id' => 'end_withdraw_time',
                    'class' => 'form-control'
                )),
                'end_withdraw_time' => form_label('End Time', 'end_withdraw_time') . form_input(array(
                    'type' => 'time',
                    'name' => 'end_withdraw_time',
                    'id' => 'end_withdraw_time',
                    'class' => 'form-control'
                )),
            ];
            $response['form_button'] = form_submit('updatewithdrawtiming', 'Update', "class='btn btn-primary'");

            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());

                $this->form_validation->set_rules('start_withdraw_time', 'Start Time', 'trim|required|xss_clean');
                $this->form_validation->set_rules('end_withdraw_time', 'End Time', 'trim|required|xss_clean');

                if ($this->form_validation->run() != FALSE) {
                    $packArr = array(
                        'start_withdraw_time' => $data['start_withdraw_time'],
                        'end_withdraw_time' => $data['end_withdraw_time'],
                    );
                    $res = update('plan_settings', array('id' => 1), $packArr);

                    if ($res == TRUE) {
                        set_flashdata('message', span_success(' Withdraw Timing Updated Successfully'));
                    } else {
                        set_flashdata('message', span_danger('Error While Updating Withdraw Timing Settings. Please Try Again...'));
                    }
                    redirect('admin/set-withdraw-timing');
                }
            }

            // Load the form view
            $this->load->view('forms', $response);
        } else {
            redirect('admin/login');
        }
    }
}
