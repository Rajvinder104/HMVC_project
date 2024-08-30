<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'encryption', 'form_validation', 'security', 'email', 'pagination'));
        $this->load->model(array('Main_model'));
        $this->load->helper(array('admin', 'super', 'security'));
    }

    public function index()
    {
        if (is_admin()) {
            redirect('admin/dashboard');
        } else {
            redirect('admin/login');
        }
    }

    public function news()
    {
        if (is_admin()) {
            $response['header'] = '<a href="' . base_url('admin/create-news') . '" class="btn btn-success">Create New</a>';
            $where = array();
            $records = pagination('tbl_news', $where, '*', 'admin/news/', 3, 10);
            $response['path'] =  $records['path'];
            $response['field'] = '';
            $response['thead'] = '<tr>
                                    <th>#</th>
                                    <th>News</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                             </tr>';
            $tbody = [];
            $i = $records['segment'] + 1;
            foreach ($records['records'] as $key => $rec) {
                extract($rec);
                $tbody[$key]  = ' <tr>
                                <td>' . $i . '</td>
                                <td>' . $news . '</td>
                                <td>' . $created_at . '</td>
                                <td><a href="' . base_url('admin/edit-news/' . $id) . '" class="btn btn-primary">Edit</a> <a href="' . base_url('admin/delete-news/' . $id) . '" class="btn btn-danger">Delete</a></td>
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

    public function deleteNews($id)
    {
        if (is_admin()) {
            $get = get_single_record('tbl_news', array('id' => $id), '*');
            if (!empty($get['id'])) {
                $delete = $this->Main_model->delete('tbl_news', $id);
                if ($delete) {
                    set_flashdata('message', span_info('News Deleted Successfully!'));
                } else {
                    set_flashdata('message', span_danger('Request not found!'));
                }
            } else {
                set_flashdata('message', span_danger('Invaild Request ID!'));
            }
            redirect('admin/news');
        } else {
            redirect('admin/login');
        }
    }

    public function token_value()
    {
        if (is_admin()) {
            $response = array();
            $response['form_open'] = form_open(base_url('admin/buy-price'));
            $token_value = get_single_record('tbl_token_value', array(), '*');
            $response['form'] = [
                'token_value' => form_label('Token Value', 'token_value') . form_input(array('type' => 'text', 'name' => 'token_value', 'value' => '' . $token_value['amount'] . '', 'id' => 'token_value', 'class' => 'form-control', 'placeholder' => 'Token Value')),
            ];
            $response['form_button'] = form_submit('token', 'Update', "class='btn btn-success'");
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $promoArr = array(
                    'amount' => $this->input->post('token_value'),
                );
                $res = update('tbl_token_value', array('id' => 1), $promoArr);
                if ($res) {
                    set_flashdata('message', span_success('Buy value Updated Successfully'));
                    redirect('admin/buy-price');
                } else {
                    set_flashdata('message', span_danger('Error While Updating Buy value Please Try Again ...'));
                }
            }
            $response['header'] = 'Update Token Value';
            $this->load->view('forms', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function sellValue()
    {
        if (is_admin()) {
            $response = array();
            $response['form_open'] = form_open(base_url('admin/sell-value'));
            $sellValue = get_single_record('tbl_token_value', array(), '*');
            $response['form'] = [
                'sellValue' => form_label('Sell Value', 'sellValue') . form_input(array('type' => 'text', 'name' => 'sellValue', 'value' => '' . $sellValue['sellValue'] . '', 'id' => 'sellValue', 'class' => 'form-control', 'placeholder' => 'Token Value')),
            ];
            $response['form_button'] = form_submit('token', 'Update', "class='btn btn-success'");
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $promoArr = array(
                    'sellValue' => $this->input->post('sellValue'),
                );
                $res = update('tbl_token_value', array('id' => 1), $promoArr);
                if ($res) {
                    set_flashdata('message', span_success('Sell value Updated Successfully'));
                    redirect('admin/sell-value');
                } else {
                    set_flashdata('message', span_danger('Error While Updating Sell value Please Try Again ...'));
                }
            }
            $response['header'] = 'Update Sell Value';
            $this->load->view('forms', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function EditUser($user_id)
    {
        if (is_admin()) {
            $response = array();
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                if ($data['form_type'] == 'personal') {
                    // $this->form_validation->set_rules('otp', 'OTP', 'trim|required|numeric|xss_clean');
                    $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('direct', 'Directs', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('phone', 'Phone', 'trim|numeric|required|xss_clean');
                    $this->form_validation->set_rules('leftPower', 'Left Power', 'trim|numeric|required|xss_clean');
                    $this->form_validation->set_rules('rightPower', 'Right Power', 'trim|numeric|required|xss_clean');
                    if ($this->form_validation->run() != FALSE) {
                        // if(!empty($_SESSION['otp']) && $data['otp'] == $_SESSION['otp']){
                        $UserData = array(
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'phone' => $data['phone'],
                            'directs' => $data['direct'],
                            'leftPower' => $data['leftPower'],
                            'rightPower' => $data['rightPower'],
                        );
                        $res = update('tbl_users', array('user_id' => $user_id), $UserData);
                        if ($res == TRUE) {
                            set_flashdata('personal_message', span_success('User Details Updated Successfully'));
                        } else {
                            set_flashdata('personal_message', span_danger('Error While Updating Please Try Again...'));
                        }
                        // }else {
                        //     set_flashdata('personal_message', 'Invaild OTP!');
                        // }
                    }
                } elseif ($data['form_type'] == 'password') {
                    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
                    if ($this->form_validation->run() != FALSE) {
                        $UserData = array(
                            'password' => $data['password']
                        );
                        $res = update('tbl_users', array('user_id' => $user_id), $UserData);
                        if ($res == TRUE) {
                            set_flashdata('password_message', span_success('Password Updated Successfully'));
                        } else {
                            set_flashdata('password_message', span_danger('Error While Updating Please Try Again...'));
                        }
                    }
                } elseif ($data['form_type'] == 'master_key') {
                    $this->form_validation->set_rules('master_key', 'Transaction Password', 'trim|required|xss_clean');
                    if ($this->form_validation->run() != FALSE) {
                        $UserData = array(
                            'master_key' => $data['master_key']
                        );
                        $res = update('tbl_users', array('user_id' => $user_id), $UserData);
                        if ($res == TRUE) {
                            set_flashdata('trx_message', span_success('Transaction Password Updated Successfully'));
                        } else {
                            set_flashdata('trx_message', span_danger('Error While Updating Please Try Again...'));
                        }
                    }
                } elseif ($data['form_type'] == 'walletAddress') {
                    $this->form_validation->set_rules('eth_address', 'Etherum Address', 'trim|required|xss_clean');
                    //$this->form_validation->set_rules('master_key', 'Transaction Password', 'trim|required|xss_clean');
                    if ($this->form_validation->run() != FALSE) {
                        $UserData = array(
                            'eth_address' => $data['eth_address']
                        );
                        $res = update('tbl_users', array('user_id' => $user_id), $UserData);
                        if ($res == TRUE) {
                            set_flashdata('addressMessage', span_success('Address Updated Successfully'));
                        } else {
                            set_flashdata('addressMessage', span_danger('Error While Updating Please Try Again...'));
                        }
                    }
                } else {
                    // pr($data,true);
                    $this->form_validation->set_rules('account_holder_name', 'Account Holder Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('bank_account_number', 'Bank Account Number', 'trim|numeric|required|xss_clean');
                    $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'trim|required|xss_clean');
                    if ($this->form_validation->run() != FALSE) {
                        $UserData = array(
                            'account_holder_name' => $data['account_holder_name'],
                            'bank_name' => $data['bank_name'],
                            'bank_account_number' => $data['bank_account_number'],
                            'branch_name' => $data['branch_name'],
                            'ifsc_code' => $data['ifsc_code'],
                        );
                        $res = update('tbl_bank_details', array('user_id' => $user_id), $UserData);
                        if ($res == TRUE) {
                            set_flashdata('bank_message', span_success('BANK Details Updated Successfully'));
                        } else {
                            set_flashdata('bank_message', span_danger('Error While Updating Please Try Again...'));
                        }
                    }
                }
            }
            $response['user'] = get_single_record('tbl_users', array('user_id' => $user_id), '*');
            $response['user']['bank'] = get_single_record('tbl_bank_details', array('user_id' => $user_id), '*');
            $this->load->view('edit_user', $response);
        } else {
            redirect('admin/login');
        }
    }


    public function CreateNews()
    {
        if (is_admin()) {
            $response = array();
            $response['header'] = 'Create News';
            $response['form_open'] = form_open(base_url('admin/create-news'));
            $response['form'] = [
                'title' => form_label('Title', 'title') . form_input(array('type' => 'text', 'name' => 'title', 'id' => 'title', 'class' => 'form-control', 'placeholder' => 'Title')),
                'news' => form_label('News', 'news') . form_textarea(array('type' => 'text', 'name' => 'news', 'id' => 'news', 'class' => 'form-control', 'rows' => 5, 'cols' => 3)),
            ];
            $response['form_button'] = form_submit('createNews', 'Create', "class='btn btn-primary'");
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
                $this->form_validation->set_rules('news', 'News', 'trim|required|xss_clean');
                if ($this->form_validation->run() != FALSE) {
                    $packArr = array(
                        'title' => $data['title'],
                        'news' => $data['news'],
                    );
                    $res = add('tbl_news', $packArr);
                    if ($res == TRUE) {
                        set_flashdata('message', span_success('News Added Successfully'));
                        redirect('admin/news');
                    } else {
                        set_flashdata('message', span_danger('Error While Creating News  Please Try Again ...'));
                    }
                }
            }
            $this->load->view('forms', $response);
        } else {
            redirect('admin/login');
        }
    }


    public function editNews($id)
    {
        if (is_admin()) {
            $response = array();
            $response['header'] = 'Edit News';
            $check = get_single_record('tbl_news', array('id' => $id), '*');
            $response['form_open'] = form_open(base_url('admin/edit-news/' . $id));
            $response['form'] = [
                'title' => form_label('Title', 'title') . form_input(array('type' => 'text', 'name' => 'title', 'id' => 'title', 'class' => 'form-control', 'placeholder' => 'Title', 'value' => $check['title'])),
                'news' => form_label('News', 'news') . form_textarea(array('type' => 'text', 'name' => 'news', 'id' => 'news', 'class' => 'form-control', 'rows' => 5, 'cols' => 3, 'value' => $check['news'])),
            ];
            $response['form_button'] = form_submit('updateNews', 'Update', "class='btn btn-primary'");
            $response['news'] = get_single_record('tbl_news', array('id' => trim(addslashes($id))), '*');
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
                $this->form_validation->set_rules('news', 'News', 'trim|required|xss_clean');
                if ($this->form_validation->run() != FALSE) {
                    $packArr = array(
                        'title' => $data['title'],
                        'news' => $data['news'],
                    );
                    $res = update('tbl_news', array('id' => $id), $packArr);
                    if ($res == TRUE) {
                        set_flashdata('message', span_success('News Edit Successfully'));
                    } else {
                        set_flashdata('message', span_danger('Error While Creating News  Please Try Again ...'));
                    }
                    redirect('Admin/Settings/editNews/' . $id);
                }
            }
            $this->load->view('forms', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function popup_upload()
    {
        if (is_admin()) {
            $response = array();
            $popup = get_single_record('tbl_popup', array('id' => 1), '*');
            $btn = '<div class="toggle"><button class="btn_popup" role="switch" value="test val" aria-pressed="' .  ($popup['status'] == 1 ? 'false' : 'true') . '" aria-checked="true" id="switch" aria-describedby="state"></button>
                <span id="state" aria-live="assertive" aria-atomic="true">' . ($popup['status'] == 1 ? 'OFF' : 'ON') . '</span><input type="hidden" aria-hidden="true" value="Subscribed">
            </div><input class="form-control" type="hidden" id="statusValue" style="width: 100px;">';
            $response['header'] = ' Popup  Setting' . $btn . '';
            $response['form_open'] = form_open_multipart(base_url('admin/popup'));
            $response['form'] = [
                'caption' => form_label('Caption', 'caption') . form_input(array('type' => 'text', 'name' => 'caption', 'id' => 'caption', 'class' => 'form-control', 'placeholder' => 'Caption')),
                'type' => form_label('Type', 'type') . form_dropdown('type', ['image'  => 'Image', 'video'  => 'Video'], 'image', ['class' => 'form-control']),
                'media' => form_label('Media', 'media') . form_input(array('type' => 'file', 'name' => 'media', 'id' => 'media', 'class' => 'form-control')),
            ];
            $response['form_button'] = form_submit('popup_upload', 'Update', "class='btn btn-primary'");
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'doc|pdf|jpg|jpeg|png';
                $config['file_name'] = 'popup' . time();
                if ($this->input->post('type') == 'image') {
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('media')) {
                        set_flashdata('message', $this->upload->display_errors());
                    } else {
                        $data = array('upload_data' => $this->upload->data());
                        $promoArr = array(
                            'caption' => $this->input->post('caption'),
                            'media' => $data['upload_data']['file_name'],
                            'type' => 'image'
                        );
                        $res = update('tbl_popup', array('id' => 1), $promoArr);
                        if ($res) {
                            set_flashdata('message', span_success('Popup Update Successfully'));
                        } else {
                            set_flashdata('message', span_danger('Error While Updating Popup Please Try Again ...'));
                        }
                    }
                } else {
                    $promoArr = array(
                        'caption' => $this->input->post('caption'),
                        'media' => $this->input->post('media'),
                        'type' => 'video'
                    );
                    $res = update('tbl_popup', array('id' => 1), $promoArr);
                    if ($res) {
                        set_flashdata('message', span_success('Video Updated Successfully'));
                    } else {
                        set_flashdata('message', span_danger('Error While Adding Popup Please Try Again ...'));
                    }
                }
            }
            $response['popup'] = true;
            $this->load->view('forms', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function upload_qrcode()
    {
        if (is_admin()) {
            $response = array();
            $response['header'] = ' QR Code Update';
            $response['form_open'] = form_open_multipart(base_url('admin/qrcode'));
            $response['form'] = [
                'type' => form_label('Type', 'type') . form_dropdown('type', ['image'  => 'Image'], 'image', ['class' => 'form-control']),
                'media' => form_label('Media', 'media') . form_input(array('type' => 'file', 'name' => 'media', 'id' => 'media', 'class' => 'form-control')),
            ];
            $response['form_button'] = form_submit('popup_upload', 'Update', "class='btn btn-primary'");
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'doc|pdf|jpg|jpeg|png';
                $config['file_name'] = 'qrcode' . time();
                if ($this->input->post('type') == 'image') {
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('media')) {
                        set_flashdata('message', $this->upload->display_errors());
                    } else {
                        $data = array('upload_data' => $this->upload->data());
                        $promoArr = array(
                            'media' => $data['upload_data']['file_name'],
                            'type' => 'image'
                        );
                        $res = update('tbl_qrcode', array('id' => 1), $promoArr);
                        if ($res) {
                            set_flashdata('message', span_success('Qr Code Update Successfully'));
                        } else {
                            set_flashdata('message', span_danger('Error While Updating Popup Please Try Again ...'));
                        }
                    }
                }
            }
            $response['popup'] = false;
            $this->load->view('forms', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function getStatus()
    {
        if (is_admin()) {
            $response['success'] = 0;
            $response['popup'] = get_single_record('tbl_popup', array('id' => 1), '*');
            $response['success'] = 1;
            $response['data'] = $response['popup'];
            echo json_encode($response);
        } else {
            redirect('admin/login');
        }
    }

    public function popupSetting($status)
    {
        if (is_admin()) {
            $response['success'] = 0;
            $updres = update('tbl_popup', array('id' => 1), array('status' => $status));
            if ($updres == true) {
                $response['success'] = 1;
                $response['message'] = 'Successfully';
            } else {
                $response['message'] = 'Error While Updating Withdraw';
            }
            echo json_encode($response);
        } else {
            redirect('admin/login');
        }
    }

    public function passwordReset()
    {
        if (is_admin()) {
            $response = array();
            $message = 'reset-password';
            $response['script'] = true;
            $response['header'] = 'PASSWORD MANAGEMENT';
            $response['form_open'] = form_open(base_url('admin/reset-password'));
            $response['form'] = [
                'cpassword' => form_label('Current Password', 'cpassword') . form_input(array('type' => 'password', 'name' => 'cpassword', 'id' => 'cpassword', 'class' => 'form-control', 'placeholder' => 'Enter Current Password')),
                'npassword' => form_label('New Password', 'npassword') . form_input(array('type' => 'password', 'name' => 'npassword', 'id' => 'npassword', 'class' => 'form-control',  'placeholder' => 'Enter New Password')),
                'vpassword' => form_label('Verify Password', 'vpassword') . form_input(array('type' => 'password', 'name' => 'vpassword', 'id' => 'vpassword', 'class' => 'form-control',  'placeholder' => 'Enter Verify Password')),
                // 'otp' => form_label('OTP', 'otp') . form_input(array('type' => 'text', 'name' => 'otp', 'id' => 'otp_input', 'class' => 'form-control', 'style' => 'display: block;',  'placeholder' => 'Enter OTP')),
            ];
            $response['form_button'] = form_submit('reset-password', 'Update', ['class' => 'btn btn-info', 'id' => 'reset-password', 'style' => 'display: block;']);

            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());
                $this->form_validation->set_rules('cpassword', 'Current Password', 'trim|required|xss_clean');
                $this->form_validation->set_rules('npassword', 'New Password', 'trim|required|xss_clean');
                $this->form_validation->set_rules('vpassword', 'Verify Password', 'trim|required|xss_clean');
                if ($this->form_validation->run() != false) {
                    $cpassword = $data['cpassword'];
                    $npassword = $data['npassword'];
                    $vpassword = $data['vpassword'];
                    $user = get_single_record('tbl_admin', array('id' => 1), 'id,password');
                    if ($npassword !== $vpassword) {
                        set_flashdata($message, span_danger('Verify Password Does Not Match'));
                    } elseif ($cpassword !== $user['password']) {
                        set_flashdata($message, span_danger('Wrong Current Password'));
                    } else {
                        $updres = update('tbl_admin', array('id' => 1), array('password' => $vpassword));
                        if ($updres == true) {
                            set_flashdata($message, span_success('Password Updated Successfully'));
                        } else {
                            set_flashdata($message, span_danger('There is an error while Changing Password Please Try Again'));
                        }
                    }
                }
            }
            $response['message'] = $message;
            $this->load->view('forms', $response);
        } else {
            redirect('admin/login');
        }
    }

    function Add_image()
    {
        if (is_admin()) {
            $response = array();
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());

                $this->form_validation->set_rules('image', 'Image', 'trim|required|xss_clean');

                $data = html_escape($data);
                // if($data['type'] == 'image'){
                if (!empty($_FILES['Pimage']['name'])) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg';
                    $config['file_name'] = 'image' . time();
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('Pimage')) {
                        $this->session->set_flashdata('message', $this->upload->display_errors());
                    } else {
                        $fileData = array('upload_data' => $this->upload->data());
                        $userData['image'] = $fileData['upload_data']['file_name'];
                        $userData['name']  = $data['name'];
                        $updres = $this->Main_model->add('tbl_achiever', $userData);
                        if ($updres == true) {
                            $this->session->set_flashdata('message', 'Image Uploaded Successfully');
                        } else {
                            $this->session->set_flashdata('message', 'There is an error while uploading Image, Please try Again ..');
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', 'There is an error while uploading Image, Please try Again ..');
                }
                // }
            }
            $response['product'] = $this->Main_model->get_single_record('tbl_achiever', [], '*');
            // $response['users'] = 1;
            $response['header'] = 'Add Achiever Image';
            $this->load->view('edit_image.php', $response);
        } else {
            redirect('admin/login');
        }
    }


    public function Achiever_report()
    {
        if (is_admin()) {
            $field = $this->input->get('type');
            $value = $this->input->get('value');
            // $export = $this->input->get('export');
            $where = array($field => $value);
            // pr($where,true);
            if (empty($where[$field]))
                $where = array();
            $config['total_rows'] = $this->Main_model->get_sum('tbl_achiever', $where, 'ifnull(count(id),0) as sum');
            $config['base_url'] = base_url() . 'Admin/Settings/Achiever_report';
            $config['uri_segment'] = 4;
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
            $segment = $this->uri->segment(4);
            $response['users'] = $this->Main_model->get_limit_records('tbl_achiever', $where, '*', $config['per_page'], $segment);
            $response['segament'] = $segment;
            $response['type'] = $field;
            $response['value'] = $value;
            $response['total_records'] = $config['total_rows'];
            $this->load->view('Achiever_report', $response);
        } else {
            redirect('admin/login');
        }
    }

    public function gallery_delete($id)
    {
        if (is_admin()) {
            $this->Main_model->delete('tbl_achiever', $id);
            redirect('admin/Achiever-report');
        } else {
            redirect('admin/login');
        }
    }

    public function UpdateButton($field, $status)
    {
        if (is_admin()) {
            $updres = update('tbl_settings', array('id' => 1), array($field => $status));
            if ($updres == true) {
                redirect('admin/dashboard');
            } else {
                redirect('admin/dashboard');
            }
        } else {
            redirect('admin/login');
        }
    }
    public function Addimage()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // die('wtf');
            $this->form_validation->set_rules('name', 'Name', 'required');

            if (empty($_FILES['document']['name'])) {
                $this->form_validation->set_rules('document', 'Image', 'required');
                redirect('admin/Addimage');
            }
            if ($this->form_validation->run()) {

                $config['upload_path'] = './uploads';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('document')) {
                    $error['err'] = $this->upload->display_errors();
                    $this->load->view('add_image.php', $error);
                } else {
                    $data = $this->upload->data();
                    // print_r($data);
                    // die('sdfgdbgfd');
                    $validdata = $this->input->post();

                    $validdata['image'] = $data['file_name'];

                    $updres =    $this->Main_model->update('tble_image', [], $validdata);

                    if ($updres == true) {
                        $this->session->set_flashdata('message', 'Image Uploaded Successfully');
                    } else {
                        $this->session->set_flashdata('message', 'There is an error while uploading Image, Please try Again ..');
                    }
                }
            }
        }
        $user['report_data'] =  $this->Main_model->get_report_data('tbl_admin', [], '*');
        $this->load->view('add_image', $user);
    }
    public function enableAnddisable($id)
    {
        if (is_admin()) {
            $product = $this->Main_model->get_single_record('tbl_admin', ['id' => $id], '*');
            if ($product['status'] == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $this->Main_model->update('tbl_admin', ['id' => $id], ['status' => $status]);
            redirect('admin/Addimage');
        } else {
            redirect('admin/dashbosrd');
        }
    }
    public function UpdateBtn($field, $status)
    {
        if (is_admin()) {
            $updres = update('tble_image', array('id' => 1), array($field => $status));
            if ($updres == true) {
                redirect('admin/Addimage');
            } else {
                redirect('admin/Addimage');
            }
        } else {
            redirect('admin/login');
        }
    }
    public function uploaddocument($id)
    {
        if (is_admin()) {
            // $message = "KYC-update";
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $data = $this->security->xss_clean($this->input->post());

                $this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
                $this->form_validation->set_rules('bank_account_number', 'Account Number', 'required|trim');
                $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'required|trim|xss_clean');
                $this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');

                if ($this->form_validation->run() == TRUE) {
                    $usersData = [
                        'bank_name' => $data['bank_name'],
                        'bank_account_number' => $data['bank_account_number'],
                        'ifsc_code' => $data['ifsc_code'],
                        'branch_name' => $data['branch_name'],
                        'kyc_status' => $data['kyc_status']

                    ];

                    //  $updres = $this->User_model->update('tbl_bank_details', ['user_id' => $this->session->userdata['user_id']], $usersData);
                    $updres =  $this->Main_model->update('tbl_bank_details', ['id' => $id], $usersData);
                    if ($updres == true) {

                        $this->session->set_flashdata('message', span_success('Account Details Updated Successfully'));
                        // redirect('admin/uploaddocument/'. $id);
                    } else {
                        $this->session->set_flashdata('message', 'Verify There is an error while Updating Account Details Please Try Again');
                    }
                } else {
                    $this->session->set_flashdata('message', span_danger(validation_errors()));
                }
            }

            $response['user'] = get_single_record('tbl_bank_details', ['id' => $id], '*');
            $this->load->view('kycform', $response);
        }
    }
    public function uploadimg()
    {
        if (is_admin()) {
            if ($this->input->server("REQUEST_METHOD") == "POST") {
                $this->form_validation->set_rules('name', 'Name', 'required|trim');
                if (empty($_FILES['document']['name'])) {
                    $this->form_validation->set_rules('document', 'Document', 'required|trim');
                    redirect('admin/uploadimg');
                }
                if ($this->form_validation->run()) {

                    $config['upload_path'] = './uploads';
                    $config['allowed_types'] = 'gif|jpg|png';

                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('document')) {
                        $error['err'] = $this->upload->display_errors();
                        $this->load->view('Myuploads.php', $error);
                    } else {
                        $data = $this->upload->data();
                       
                        $validdata = $this->input->post();
                 
                        $validdata['image'] = $data['file_name'];
                        // print_r($validdata['image']);
                        // die('sdfgdbgfd');
                        $updres =    $this->Main_model->add('tble_image', $validdata);

                        if ($updres == true) {
                            $this->session->set_flashdata('message', span_success('Image Uploaded Successfully'));
                        } else {
                            $this->session->set_flashdata('message', 'There is an error while uploading Image, Please try Again ..');
                        }
                    }
                }
            }
            $this->load->view('Myuploads');
        }
    }
}
