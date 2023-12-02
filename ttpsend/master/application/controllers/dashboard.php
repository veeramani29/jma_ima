<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	

		public function __construct()
		{
		parent::__construct();
		$this->load->model('Login_Model');
		
		}

	public function index()
	{

		


		$this->load->view('dashboard');
	}

	public function test()
	{

		


		$this->load->view('a');
	}

	

	
}
