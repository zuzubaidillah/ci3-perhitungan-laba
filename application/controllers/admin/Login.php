<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	// metode yang pertama kali dijalankan
	public function __construct()
	{
		parent::__construct();
		// maka session harus dijalankan, apabila ada session maka dia dilarang untuk login.
		if ($this->session->userdata('session_id') != null) {
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Kamu sudah login','info')</script>");
			redirect('admin/dashboard');
			exit();
		}
	}

	public function index()
	{

		// cek tabel user
		$cek = $this->Musers->getData();
		if (count($cek) == 0) {
			redirect('admin/login/registrasi');
		}

		$this->load->view('admin/loginv');
	}

	public function registrasi()
	{
		// cek tabel user
		$cek = $this->Musers->getData();
		if (count($cek) >= 1) {
			redirect('admin/login');
		}

		$this->load->view('admin/registrasiv');
	}

	public function proses_add_registrasi()
	{
		// mengambil nilai yang dikirim
		$u = htmlspecialchars($this->input->post('u'), ENT_QUOTES);
		$p = htmlspecialchars($this->input->post('p'), ENT_QUOTES);
		$nd = htmlspecialchars($this->input->post('nd'), ENT_QUOTES);
		$nb = htmlspecialchars($this->input->post('nb'), ENT_QUOTES);
		$passwordEncript = password_hash($p, PASSWORD_DEFAULT);

		// data disimpan
		$dtSimpan = [
			"id_user" => "USE" . mt_rand(10000000000000000, 99999999999999999),
			"nama_depan" => $nd,
			"nama_belakang" => $nb,
			"username" => $u,
			"password" => $passwordEncript,
			"level" => "administrator",
		];
		$dtBintang = [
			"tgl_buat" => date("Y-m-d H:i:s"),
			"tgl_update" => "0000-00-00 00:00:00",
			"id_buat" => "",
			"id_update" => "",
		];

		$gabungArraySimpan = array_merge($dtSimpan, $dtBintang);

		if ($this->Musers->add('tabel_user', $gabungArraySimpan)) {
			$this->session->set_flashdata('notifikasi', "<script type='text/javascript'>
			Swal.fire(
				'Berhasil',
				'Registrasi berhasil disimpan',
				'success'
			)</script>");
			redirect('admin/login');
			exit();
		}
		$this->session->set_flashdata('notifikasi', "<script type='text/javascript'>
		Swal.fire(
			'Gagal',
			'Proses Registrasi Gagal',
			'error'
		)</script>");
		redirect('admin/login/registrasi');
	}

	public function cek_login()
	{
		// menerima inputan dari bagian view
		$u = htmlspecialchars($this->input->post('u'), ENT_QUOTES);
		$p = htmlspecialchars($this->input->post('p'), ENT_QUOTES);

		// cek username
		$cekUser = $this->Musers->cekUsername($u);

		// percabangan, 
		if (count($cekUser) == 0) {
			// proses username salah
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Gagal','Username Salah!','error')</script>");
			redirect('admin/login');
			exit();
		}

		// proses ketika username bernilai benar

		// cek password
		if (password_verify($p, $cekUser[0]['password'])) {
			// ketika password benar

			// membuat data untuk dijadikan session
			$ses = [
				"session_id" => $cekUser[0]['id_user'],
				"session_namafull" => $cekUser[0]['nama_depan'] . ' ' . $cekUser[0]['nama_belakang'],
				"session_level" => $cekUser[0]['level']
			];
			// proses membuat session di CI3 pada php
			$this->session->set_userdata($ses);

			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Berhasil','Selamat Datang di Website Perhitungan Laba!','success')</script>");
			redirect('admin/dashboard');
			exit();
		} else {
			// ketika password salah
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Gagal','Password Salah!','error')</script>");
			redirect('admin/login');
			exit();
		}
	}
}