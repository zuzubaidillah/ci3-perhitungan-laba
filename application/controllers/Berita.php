<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berita extends CI_Controller
{
	public function index()
	{
		$data['head_title'] = "Berita";
		$data['dtBerita'] = $this->Mberita->getData();

		$this->load->view('public/headerv', $data);
		$this->load->view('public/beritav');
		$this->load->view('public/footerv');
	}
}