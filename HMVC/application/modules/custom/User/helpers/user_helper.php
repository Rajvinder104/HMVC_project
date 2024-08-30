<?php
// File: application/helpers/login_check_helper.php

if (!function_exists('is_user_logged_in')) {
    function is_user_logged_in()
    {
        $CI = &get_instance();
        $CI->load->library('session');
        if (isset($CI->session->userdata['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('pagination')) {
    function pagination($table, $where, $select, $base_url, $segment, $per_page)
    {

        $CI = &get_instance();
        $CI->load->library('pagination');
        $CI->load->model('User_model');
        $config['total_rows'] = $CI->User_model->GetSum($table, $where, 'ifnull(count(id),0) as sum');
        $config['base_url'] = base_url($base_url);
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $segment;
        $CI->pagination->initialize($config);
        $segment = $CI->uri->segment($segment);
        $records = $CI->User_model->GetLimitRecords($table, $where, $select, $config['per_page'], $segment);
        return $records;
    }
}
