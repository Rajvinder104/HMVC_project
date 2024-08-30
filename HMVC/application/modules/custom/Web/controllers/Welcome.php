<?php defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
	}

	public function index()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$data = $this->server->xss_clean($this->input->post());
			print_r($data);
			$addDeta = [
				'email' => $data['email'],
				'password' => $data['password'],
			];
			$this->Main_model->add('users', $addDeta);
		}
		$response['data'] = $this->Main_model->get_single_record('users', [], '*');
		$this->load->view('welcome_message', $response);
	}
}
