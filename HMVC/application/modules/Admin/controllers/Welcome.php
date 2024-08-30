<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('load_view');
	}

	public function load_data()
	{
		$this->load->library('datatables_server_side', array(
			'table' => 'tbl_sponser_count',
			'primary_key' => 'id',
			'columns' => array('user_id', 'downline_id', 'level'),
			'where' => array()
		));

		$this->datatables_server_side->process();
	}
}