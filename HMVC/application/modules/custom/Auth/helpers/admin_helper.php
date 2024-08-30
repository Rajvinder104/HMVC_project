<?php

if (!function_exists('is_admin_logged_in')) {
    function is_admin_logged_in()
    {
        $CI = &get_instance();
        $CI->load->library('session');
        if (isset($CI->session->userdata['admin_id'])) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('pr')) {

    function pr($array, $die = false)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
        if ($die)
            die();
    }
}

if (!function_exists('pagination')) {
    function pagination($table, $where, $select, $base_url, $segment, $per_page)
    {
        $CI = &get_instance();
        $CI->load->library('pagination');
        $CI->load->model('Auth_model');
        $config['total_rows'] = $CI->Auth_model->GetSum($table, $where, 'ifnull(count(id),0) as sum');
        $config['base_url'] = base_url($base_url);
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $segment;
        $CI->pagination->initialize($config);
        $segment = $CI->uri->segment($segment);
        $records = $CI->Auth_model->GetLimitRecords($table, $where, $select, $config['per_page'], $segment);
        return $records;
    }
}