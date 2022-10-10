<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	// metode yang pertama kali dijalankan
	public function __construct()
	{
		parent::__construct();
		// keamaan admin panel, harus login terlebih dahulu
		$sessionId = $this->session->userdata('session_id');
		if ($sessionId == null) {
			redirect('home');
		}
	}

	public function index()
	{
		$data['head_title'] = "Dashboard";

		$this->load->view('admin/headerv', $data);
		$this->load->view('admin/dashboardv');
		$this->load->view('admin/footerv');
	}
}