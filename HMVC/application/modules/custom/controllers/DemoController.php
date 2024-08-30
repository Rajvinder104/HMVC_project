<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crudecontroller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation','session');
        $this->load->model('DemoModel');
    }

    
}