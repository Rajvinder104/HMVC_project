<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'pagination'));
        $this->load->model(array('User_model'));
        $this->load->helper(array('user', 'super'));
    }
    public function walletincome()
    {
        if (is_logged_in()) {
            // pr($this->session->userdata['user_id']);
            // die;
            $response['header'] = 'WalletIncome';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = ['user_id' => $this->session->userdata['user_id']];
            if (!empty($type)) {
                $where = [$type => $value];
            }

            $records = pagination('tbl_income_wallet', $where, '*', 'dashboard/walletincome', 3, 5, 'desc');
            $response['path'] = $records['path'];
            $response['field'] = ' ';
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
            redirect('login');
        }
    }

    public function wallettable()
    {
        if (is_logged_in()) {
            $response['header'] = 'wallettable';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = ['user_id' => $this->session->userdata['user_id']];
            if (!empty($type)) {
                $where = [$type => $value];
            }

            $records = pagination('tbl_wallet', $where, '*', 'dashboard/wallettable/', 3, 5, 'desc');
            $response['path'] = $records['path'];
            $response['field'] = '';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>type</th>
                                    <th>remark</th>
                                    <th>Created At</th>

                                    </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);

                // $button =  form_open().form_hidden('orderID',$order_id).form_submit(['type' => 'submit','class' => 'btn btn-success','value' => 'Withdraw']);
                $tbody[$key]  = ' <tr>
                    <td>' . $i . '</td>
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
            redirect('login');
        }
    }

    public function incomewallet()
    {
        if (is_logged_in()) {
            $response['header'] = 'Incomewallet';
            $type = $this->input->get('type');
            $value = $this->input->get('value');
            $where = ['user_id' => $this->session->userdata['user_id'], 'type' => 'direct_income'];
            if (!empty($type)) {
                $where = [$type => $value];
            }

            $records = pagination('tbl_income_wallet', $where, '*', 'dashboard/incomewallet/', 3, 5, 'desc');
            $response['path'] = $records['path'];
            $response['field'] = '';
            $response['thead'] = '<tr>
                                   <th>#</th>
                                   <th>User ID</th>

                                   <th>Amount</th>
                                   <th>type</th>

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
            $this->load->view('reports', $response);
        } else {
            redirect('login');
        }
    }



    public function levels()
    {
        if (is_logged_in()) {


            $response['header'] = 'levels';
            $where = [];
            // 'amount >' => 0

            $rowCount = $this->User_model->grouped_by_level2('tbl_sponser_count', $where, 'user_id as level');
            // $rowCount = $this->User_model->grouped_by_level('tbl_sponser_count',  'user_id as level');
            $config['total_rows'] = count($rowCount);
            $config['base_url'] = base_url() . 'dashboard/levels';
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
            $records['records'] = $this->User_model->grouped_by_levels($where, $config['per_page'], $segment);
            //    pr($records);
            //    die;
            $response['path'] =  $config['base_url'];
            $searchField  = ' ';
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
                                                    <td><a href="' . base_url('dashboard/groupbylevelz/' . $rec['level']) . '">View</a></td>
                                                    </tr>';
                $i++;
            }
            $response['tbody'] = $tbody;
            $response['segment'] = $i;
            $response['total_records'] = $config['total_rows'];
            $response['i'] = $i;
            $this->load->view('reports', $response);
        } else {
            redirect('login');
        }
    }

    public function  groupbylevelz($level = '')
    {
        if (is_logged_in()) {
            $response['header'] = 'Group by level';
            $where = ['level' => $level, 'user_id' => $this->session->userdata['user_id']];

            $records = pagination('tbl_sponser_count', $where, '*', 'dashboard/groupbylevelz/' . $level, 4, 10);

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
            redirect('login');
        }
    }
    public function grouplevel()
    {
        $where = [];
        $rowCount = $this->User_model->grouped_by_level2('tbl_sponser_count', $where, 'level as level');
        $config['total_rows'] = count($rowCount);
        $config['base_url'] = base_url() . 'dashboard/grouplevel/';
        $config['uri_segment'] = 3;
        $config['per_page'] = 2;
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

        $response['allrecords'] = $this->User_model->groupslevel($where ,$config['per_page'], $segment);
        $response['segment'] = $segment;
        $this->load->view('level_report', $response);
    }

    public function records($level){
        $where = ['level' => $level, 'user_id' => $this->session->userdata['user_id']];
        $config['total_rows'] = $this->User_model->get_sum('tbl_sponser_count', $where, 'ifnull(count(id),0) as sum');
        // pr($config['total_rows']);
        // die;
        $config['base_url'] = base_url() . 'dashboard/records/'. $level;
        $config['uri_segment'] = 4;
        $config['per_page'] = 2;
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
        $response['segment'] = $segment;
        $response['users'] = $this->User_model->getrecords('tbl_sponser_count',$where,'*',$config['per_page'], $segment);
        $this->load->view('all_data',$response);
    }
}
