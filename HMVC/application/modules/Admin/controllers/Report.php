<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'encryption', 'form_validation', 'security', 'email', 'pagination'));
        $this->load->model(array('Main_model'));
        $this->load->helper(array('admin', 'security', 'super'));
    }

    public function index()
    {
        if (is_admin()) {
            redirect('admin/dashboard');
        } else {
            redirect('admin/login');
        }
    }

    public function packageHistory()
    {
        if (is_admin()) {
            $where = [];
            $config['total_rows'] = $this->Main_model->get_sum('tbl_activation_details', $where, 'ifnull(count(id),0) as sum');
            $config['base_url'] = base_url() . 'admin/package-history';
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
            $records['segment'] = $segment;
            $records['records'] = $this->Main_model->get_limit_records('tbl_activation_details', $where, '*', $config['per_page'], $segment);
            $this->load->view('package-history', $records);
        } else {
            redirect('admin/login');
        }
    }

    public function ActivationHistory()
    {
        if (is_admin()) {
            $response['header'] = 'Activation History';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = [];
            if (!empty($type)) {
                $where = [$type => $value];
            }
            $records = pagination('tbl_activation_details', $where, '*', 'Admin/Report/ActivationHistory', 4, 2);
            $response['path'] =  $records['path'];
            $response['field'] = '<div class="col-4">
                                  <select class="form-control" name="type">
                                      <option value="user_id" ' . $type . ' == "user_id" ? "selected" : "";?>
                                          User ID</option>
                                  </select>
                                </div>
                              <div class="col-4">
                                  <input type="text" name="value" class="form-control text-white float-right"
                                      value="' . $value . '" placeholder="Search">
                              </div>
                              <div class="col-4">
                                  <div class="input-group-append">
                                      <button type="submit" class="btn btn-default">Serach</button>
                                  </div>
                              </div>';
            $response['thead'] = '<tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                                </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $user_id . '</td>
                                <td>' . $package . '</td>
                                <td>' . $topup_date . '</td>
                             </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }
    public function Activationdetails()
    {
        if (is_admin()) {
            $response['header'] = 'Activation Details';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = ['package >' => 5000];
            if (!empty($type)) {
                $where = [$type => $value, 'package >' => 5000];
            }
            $records = pagination('tbl_activation_details', $where, '*', 'Admin/Report/Activationdetails', 4, 2);
            $response['path'] =  $records['path'];
            $response['field'] = '<div class="col-4">
                                  <select class="form-control" name="type">
                                      <option value="user_id" ' . $type . ' == "user_id" ? "selected" : "";?>
                                          User ID</option>
                                  </select>
                                </div>
                              <div class="col-4">
                                  <input type="text" name="value" class="form-control text-white float-right"
                                      value="' . $value . '" placeholder="Search">
                              </div>
                              <div class="col-4">
                                  <div class="input-group-append">
                                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                  </div>
                              </div>';
            $response['thead'] = '<tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                                </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $user_id . '</td>
                                <td>' . $package . '</td>
                                <td>' . $topup_date . '</td>
                             </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }
    public function walletincome()
    {
        if (is_admin()) {
            $response['header'] = 'WalletIncome';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = [];
            if (!empty($type)) {
                $where = [$type => $value];
            }

            $records = pagination('tbl_income_wallet', $where, '*', 'admin/walletincome/', 3, 5, 'desc');
            $response['path'] = $records['path'];
            $response['field'] = '<div class="col-4">
                                   <select class="form-control" name="type">
                                   <option value="user_id" ' . $type . ' == "user_id" ? "selected" : "";?>User ID</option>
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
            $response['thead'] = '<tr>
                                   <th>#</th>
                                   <th>User ID</th>
                                   <th>Name</th>
                                   <th>Available Balance</th>
                                   </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);

                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                                                    <td>' . $i . '</td>
                                                    <td>' . $user_id . '</td>
                                                    <td>' . $amount . '</td>
                                                    <td>' . $created_at . '</td>
                                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }
    public function wallettable()
    {
        if (is_admin()) {
            $response['header'] = 'wallettable';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = [];
            if (!empty($type)) {
                $where = [$type => $value];
            }

            $records = pagination('tbl_wallet', $where, '*', 'admin/wallettable/', 3, 5, 'desc');
            $response['path'] = $records['path'];
            $response['field'] = '<div class="col-4">
                                   <select class="form-control" name="type">
                                   <option value="user_id" ' . $type . ' == "user_id" ? "selected" : "";?>User ID</option>
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
            $response['thead'] = '<tr>
                                   <th>#</th>
                                   <th>User ID</th>
                                   <th>sender</th>
                                   <th>Amount</th>
                                   <th>type</th>
                                   <th>remark</th>
                                   <th>Created at</th>


                                   </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);

                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                                                    <td>' . $i . '</td>
                                                    <td>' . $user_id . '</td>
                                                    <td>' . $sender_id . '</td>
                                                    <td>' . $amount . '</td>
                                                    <td>' . $type . '</td>
                                                    <td>' . $remark . '</td>
                                                    <td>' . $created_at . '</td>


                                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }
    public function incomewallet()
    {
        if (is_admin()) {
            $response['header'] = 'Incomewallet';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $export = $this->input->get('export');
            $where = [];
            // 'amount >' => 0
            if (!empty($type)) {
                $where = [$type => $value,];
            } else {
                $where = array('');
            }

            $records = pagination('tbl_income_wallet', $where, '*', 'admin/incomewallet', 3, 10);
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
            $response['path'] = $records['path'];
            $response['field'] = '<div class="col-4">
                                   <select class="form-control" name="type">
                                   <option value="user_id" ' . $type . ' == "user_id" ? "selected" : "";?>User ID</option>
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
            $response['thead'] = '<tr>
                                   <th>#</th>
                                   <th>User ID</th>

                                   <th>Amount</th>
                                   <th>type</th>
                                   <th>all amount</th>

                                   <th>Created at</th>


                                   </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                // $response['allamount'] = get_sum('tbl_income_wallet', array('user_id' => $user_id), 'ifnull(sum(amount),0) as sum');

                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                                                    <td>' . $i . '</td>
                                                    <td>' . $user_id . '</td>
                                                    <td>' . $amount . '</td>
                                                    <td>' . $type . '</td>

                                                    <td>' . $created_at . '</td>
                                                    </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $response['export'] = TRUE;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }


    public function payout_summarys()
    {
        if (is_admin()) {


            $response['header'] = 'payout summarys';
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $where = [];
            // 'amount >' => 0
            if (!empty($start_date)) {
                $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '" ';
            } else {
            }
            $rowCount = $this->Main_model->payouts_sum2('tbl_income_wallet', $where, 'user_id as user_id');
            // pr($rowCount);
            // die;
            // $rowCount = $this->Main_model->payouts_sum('tbl_income_wallet',  'user_id as user_id');
            $config['total_rows'] = count($rowCount);
            $config['base_url'] = base_url() . 'admin/payout_summarys';
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
            $segment = $this->uri->segment(4);
            $records['records'] = $this->Main_model->payouts_summary($where, $config['per_page'], $segment);
            //    pr($records);
            //    die;
            $response['path'] =  $config['base_url'];
            $searchField  = '<div class="col-4">
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
                                   <th>user id</th>
                                   <th>amount</th>
                                   <th>Action</th>

                                   </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $response['allamount'] = get_sum('tbl_income_wallet', array('user_id' => $user_id), 'ifnull(sum(amount),0) as sum');

                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                                                    <td>' . $i . '</td>
                                                    <td>' . $rec['user_id'] . '</td>
                                                    <td>' .  $response['allamount'] . '</td>
                                                    <td><a href="' . base_url('admin/dateWisePayouts/' . $rec['user_id']) . '">View</a></td>
                                                    </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $segment;
            $response['total_records'] =  $config['total_rows'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function dateWisePayouts($user_id = '')
    {
        if (is_admin()) {
            $response['header'] = 'Datewise Payout Summary';
            $where = ['user_id' => $user_id];

            $records = pagination('tbl_income_wallet', $where, '*', 'admin/dateWisePayouts/' . $user_id, 4, 10);

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

            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }



    public function incomes_all($type = '')
    {
        if (is_admin()) {
            $response['header'] = ucwords(str_replace('_', ' ', $type));
            $type1 = $this->input->get('type1');
            $value = $this->input->get('value');
            $where = array('type' => $type);
            if (!empty($type1)) {
                $where = [$type1 => $value, 'type' => $type];
            }

            $records = pagination('tbl_income_wallet', $where, '*', 'admin/incomes_all/' . $type . '/', 4, 10);

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
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function availableIncome()
    {
        if (is_admin()) {
            $response['header'] = 'Available Income Balance';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = [];
            if (!empty($type)) {
                $where = [$type => $value];
            }
            $records = pagination('tbl_users', $where, '*', 'admin/availableIncome', 3, 10, 'asc');
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
            $response['thead'] = '<tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Available Balance</th>
                             </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $income_balance = $this->Main_model->get_single_record('tbl_income_wallet', 'user_id = "' . $user_id . '"', 'ifnull(sum(amount),0) as income_balance');

                $tbody[$key]  = ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $user_id . '</td>
                                <td>' . $name . '</td>
                                <td>' . $income_balance['income_balance'] . '</td>
                             </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function Achiever_report()
    {
        if (is_admin()) {
            $response['header'] = 'Achiever Gallery';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = [];
            if (!empty($type)) {
                $where = [$type => $value];
            }
            $records = pagination('tbl_achiever', $where, '*', 'Admin/Report/Achiever_report', 4, 10);
            $response['path'] =  $records['path'];
            $response['field'] = '<div class="col-4">

                              </div>';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th> Date</th>
                                    <th>Action</th>

                             </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $button =  '<a href="' . base_url('Admin/Settings/gallery_delete/' . $id) . '" class="btn btn-danger">Delete</a>';

                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                                <td>' . $i . '</td>
                                <td><img src= ' . base_url('uploads/' . $image) . '  width="150px"</td>

                                <td>' . $name . '</td>
                                <td>' . $created_at . '</td>
                                <td>' . $button . '</td>

                             </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }



    public function levels()
    {
        if (is_admin()) {

            $response['header'] = 'levels';
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $where = [];
            // 'amount >' => 0
            if (!empty($start_date)) {
                $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '" ';
            } else {
            }

            $rowCount = $this->Main_model->grouped_by_level2('tbl_sponser_count', $where, 'user_id as user_id');
            //   $rowCount = $this->Main_model->grouped_by_level('tbl_sponser_count',  'user_id as level');
            $config['total_rows'] = count($rowCount);
            $config['base_url'] = base_url() . 'admin/levels';
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
            $records['records'] = $this->Main_model->grouped_by_levels('tbl_sponser_count', $where, $config['per_page'], $segment);
            // echo "<pre>";
            // print_r($records);
            // die;
            //    pr($records);
            //    die;
            $response['path'] =  $config['base_url'];
            $searchField  = '<div class="col-4">
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
                                   <th>level</th>
                                   <th>Action</th>

                                   </tr>';
            $tbody = [];
            $i = 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                                                    <td>' . $i . '</td>
                                                    <td>' . $rec['level'] . '</td>
                                                    <td><a href="' . base_url('admin/groupbylevelz/' . $rec['level']) . '">View</a></td>
                                                    </tr>';
                $i++;
            }

            $response['tbody'] = $tbody;
            $response['segment'] = $i;
            $response['total_records'] = $config['total_rows'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function  groupbylevelz($level = '')
    {
        if (is_admin()) {
            $response['header'] = 'Group by level';
            $where = ['level' => $level];

            $records = pagination('tbl_sponser_count', $where, '*', 'admin/groupbylevelz/' . $level, 4, 5);

            $response['path'] =  $records['path'];
            $response['field'] = '';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>User Id</th>
                                    <th>Downline Id</th>
                                    <th>level</th>
                                    <th>Date</th>

                                 </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $tbody[$key]  = ' <tr>
                                    <td>' . $i . '</td>
                                    <td>' . $user_id . '</td>
                                    <td>' . $downline_id . '</td>
                                    <td>' . $level . '</td>
                                    <td>' . $created_at . '</td>
                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;

            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function enableAnddisable($id)
    {
        if (is_admin()) {
            $product = $this->Main_model->get_single_record('tbl_sponser_count', ['id' => $id], '*');
            if ($product['status'] == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $this->Main_model->update('tbl_sponser_count', ['id' => $id], ['status' => $status]);
            redirect('Admin/Report/generate_report');
        } else {
            redirect('Admin/dashbosrd');
        }
    }
    public function generate_report()
    {
        $data['report_data'] = $this->Main_model->get_report_data('tbl_sponser_count', [], '*');
        $this->load->view('report_view', $data);
    }


    public function groupsusers()
    {
        if (is_admin()) {

            $response['header'] = 'Users Group';
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $where = [];
            // 'amount >' => 0
            if (!empty($start_date)) {
                $where = 'date(created_at) >= "' . $start_date . '" AND date(created_at) <= "' . $end_date . '" ';
            } else {
            }

            $rowCount = $this->Main_model->group('tbl_sponser_count', $where, 'user_id as user_id');
            //   $rowCount = $this->Main_model->grouped_by_level('tbl_sponser_count',  'user_id as level');
            $config['total_rows'] = count($rowCount);
            $config['base_url'] = base_url() . 'admin/groupsusers';
            $config['uri_segment'] = 3;
            $config['per_page'] = 3;
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
            $records['records'] = $this->Main_model->grouped('tbl_sponser_count', $where, $config['per_page'], $segment);
            // echo "<pre>";
            // print_r($records);
            // die;
            //    pr($records);
            //    die;
            $response['path'] =  $config['base_url'];
            $searchField  = '<div class="col-4">
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
                                   <th>User ID</th>
                                   <th>Action</th>

                                   </tr>';
            $tbody = [];
            $i = 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                                                    <td>' . $i . '</td>
                                                    <td>' . $rec['user_id'] . '</td>
                                                    <td><a href="' . base_url('admin/groupuser/' . $rec['user_id']) . '" class="btn btn-info btn-sm">View</a></td>
                                                    </tr>';
                $i++;
            }

            $response['tbody'] = $tbody;
            $response['segment'] = $i;
            $response['total_records'] = $config['total_rows'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function  groupuser($user_id = '')
    {
        if (is_admin()) {
            $response['header'] = 'Group by user id';
            $where = ['user_id' => $user_id];

            $records = pagination('tbl_sponser_count', $where, '*', 'admin/groupuser/' . $user_id, 4, 5);

            $response['path'] =  $records['path'];
            $response['field'] = '';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>User Id</th>
                                    <th>Downline Id</th>
                                    <th>level</th>
                                    <th>Date</th>

                                 </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $tbody[$key]  = ' <tr>
                                    <td>' . $i . '</td>
                                    <td>' . $user_id . '</td>
                                    <td>' . $downline_id . '</td>
                                    <td>' . $level . '</td>
                                    <td>' . $created_at . '</td>
                                 </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $records['segment'];
            $response['total_records'] = $records['total_records'];
            $response['i'] = $i;

            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function myfunction()
    {

        $export = $this->input->get('export');
        $where = [];
        $rowCount = $this->Main_model->grouped_by_users2('tbl_income_wallet', $where, 'user_id as user_id');
        $config['total_rows'] = count($rowCount);
        $config['base_url'] = base_url() . 'admin/myfunction';
        $config['uri_segment'] = 3;
        $config['per_page'] = 5;
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
        $response['segment'] = $segment;
        $response['users'] = $this->Main_model->getmyrecords('tbl_income_wallet', $where, 'user_id, SUM(amount) as balance', $config['per_page'], $segment);

        if ($export == true) {
            $application_type = 'application/' . $export;
            $header = ['#', 'User ID', 'Amount'];
            foreach ($response['users'] as $key => $record) {

                $exr[$key]['i'] = ($key + 1);
                $exr[$key]['user_id'] = $record['user_id'];
                $exr[$key]['balance'] = $record['balance'];
            }
            finalExport($export, $application_type, $header, $exr);
        }

        $response['path'] =  $config['base_url'];
        $response['export'] = true;
        $this->load->view('allincomes', $response);
    }

    public function kycdetails()
    {

        $response['header'] = 'All KYC Details';
        $where = [];

        $response['users'] = $this->Main_model->get_records('tbl_bank_details', $where, '*');
        $this->load->view('details', $response);
    }

    public function statusupdate($id)
    {
        if (is_admin()) {
            $product = $this->Main_model->get_single_record('tbl_bank_details', ['id' => $id], '*');
            if ($product['kyc_status'] == 1) {
                $status = 2;
            } else {
                $status = 0;
            }
            $this->Main_model->update('tbl_bank_details', ['id' => $id], ['kyc_status' => $status]);
            redirect('admin/kycdetails/allrequest');
        } else {
            redirect('Admin/dashbosrd');
        }
    }

    public function statusupdates($id)
    {
        if (is_admin()) {
            $product = $this->Main_model->get_single_record('tbl_bank_details', ['id' => $id], '*');
            if ($product['kyc_status'] == 1) {
                $status = 3;
            } else {
                $status = 0;
            }
            $this->Main_model->update('tbl_bank_details', ['id' => $id], ['kyc_status' => $status]);
            redirect('admin/kycdetails/allrequest');
        } else {
            redirect('Admin/dashbosrd');
        }
    }
    public function imgdata()
    {
        if (is_admin()) {
            $response['users'] = $this->Main_model->getallrecords('tble_image', [], '*');
            $this->load->view('fetch_img', $response);
        }
    }
    public function deleteimg($id)
    {
        if (is_admin()) {
            $data = $this->Main_model->get_file_record('tble_image', ['id' => $id]);
            if ($data) {
                if (file_exists("./uploads/" . $data['image'])) {
                    unlink("./uploads/" . $data['image']);
                }
                $this->Main_model->deleteproduct('tble_image', ['id' => $id]);
                redirect('admin/imgdata');
            }
        }
    }


    public function withdrawtype($type = '')
    {
        if (is_admin()) {

            $field = $this->input->get('type');
            $value = $this->input->get('value');
            if ($type == '') {
                $where = ['credit_type' => 'm_point'];
                $response['status'] = '';
                $withstatus = '';
            }
            if ($type == 'Pending') {
                $where = ['status' => 0, 'credit_type' => 'm_point'];
                $response['status'] = 0;
                $withstatus = 0;
            }
            if ($type == 'approve') {
                $where = ['status' => 1, 'credit_type' => 'm_point'];
                $response['status'] = 1;
                $withstatus = 1;
            }
            if ($type == 'reject') {
                $where = ['status' => 2, 'credit_type' => 'm_point'];
                $response['status'] = 2;
                $withstatus = 2;
            }
            if (!empty($field)) {
                $where = [$field => $value, 'status' => $withstatus];
            }
            if (!empty($field)) {
                if ($type  == 'Pending') {
                    $response['header'] = ' Pending Withdrawal Request';
                    $where = [$field => $value, 'status' => 0];
                    // $where = ['status' => 0, $type => $value];
                } elseif ($type == 'Approved') {
                    $response['header'] = 'Approved Withdrawal  Request';
                    // $where = ['status' => 1, $type => $value];
                    $where = [$field => $value, 'status' => 1];
                } elseif ($type == 'Rejected') {
                    $response['header'] =  ' Rejected Withdrawal  Request';
                    // $where = ['status' => 2, $type => $value];
                    $where = [$field => $value, 'status' => 2];
                } elseif ($type == 'allrequest') {
                    $response['header'] = 'All Withdrawal Request';
                    $where = [$field => $value];
                    // $where = [$type => $value];
                } else {
                    $response['header'] = 'Withdrawal Request';
                    $where = [$field => $value, 'credit_type' => 'brand_awareness', 'status' => $withstatus];
                }
            }
            // if (!empty($field)) {
            //     $where = [$field => $value ];
            // }


            $config['total_rows'] = $this->Main_model->get_sum('tbl_withdraw', $where, 'ifnull(count(id),0) as sum');
            $config['base_url'] = base_url() . 'Admin/Withdraw/withdrawtype/' . $type;
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
            $response['requests'] = $this->Main_model->get_limit_records('tbl_withdraw', $where, '*', $config['per_page'], $segment);

            // $response['requests'] = $this->Main_model->get_records('tbl_withdraw',$where,'*');
            foreach ($response['requests'] as $key => $request) {
                $response['requests'][$key]['user'] = $this->Main_model->get_single_record('tbl_users', array('user_id' => $request['user_id']), 'id,first_name,name,last_name,sponser_id,email,phone');
                $response['requests'][$key]['bank'] = $this->Main_model->get_single_record('tbl_bank_details', array('user_id' => $request['user_id']), '*');
            }
            $response['total_records'] = $config['total_rows'];
            $response['segament'] = $segment;
            $response['type'] = $field;
            $response['value'] = $value;
            // $response['type'] =$response['requests'];

            $this->load->view('withrawalZil', $response);
        } else {
            redirect('Admin/Management/login');
        }
    }



    public function date_weeks()
    {
        if (is_admin()) {


            $response['header'] = 'Week wise report';
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $where = [];
            $rowCount = $this->Main_model->weakwise('tbl_income_wallet', $where, '*,date(created_at) as week');
            $config['total_rows'] = count($rowCount);
            $config['base_url'] = base_url() . 'admin/date_weeks';
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
            $segment = $this->uri->segment(4);
            $records['records'] = $this->Main_model->weakwise2($where, $config['per_page'], $segment);
            //    pr($records);
            //    die;
            $response['path'] =  $config['base_url'];
            $searchField  = '<div class="col-4">
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
                                   <th>Date</th>

                                   <th>Action</th>

                                   </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);

                $tbody[$key]  = ' <tr>
                                                    <td>' . $i . '</td>
                                                    <td>' . $rec['week']  . '</td>
                                                     <td><a href="' . base_url('admin/dateWise/' .urlencode($rec['week'])) . '" class="btn btn-info btn-sm">View</a></td>
                                                    </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $segment;
            $response['total_records'] =  $config['total_rows'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }


    public function dateWise($selected_date = '')
    {
        if (is_admin()) {
            $response['header'] = 'Datewise Payout Summary';

            $end_date = date('Y-m-d', strtotime($selected_date . ' + 7 days'));
            $where = [
                'created_at >=' => $selected_date,
                'created_at <=' => $end_date
            ];

            $records = pagination('tbl_income_wallet', $where, '*', 'admin/dateWise/' . $selected_date, 4, 10);

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

            $this->load->view('reports', $response);
        } else {
            redirect('admin/login');
        }
    }
}
