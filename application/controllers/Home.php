<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function index()
	{
		$data['head_title'] = "Home";

		$this->load->view('public/headerv', $data);
		$this->load->view('public/homev');
		$this->load->view('public/footerv');
	}
}