<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berita extends CI_Controller
{
	// metode yang pertama kali dijalankan
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		// keamaan admin panel, harus login terlebih dahulu
		$sessionId = $this->session->userdata('session_id');
		if ($sessionId == null) {
			redirect('home');
		}
	}

	public function index()
	{
		$data['head_title'] = "Berita - Admin";
		$data['dt'] = $this->Mberita->getData();

		$this->load->view('admin/headerv', $data);
		$this->load->view('admin/berita/readv');
		$this->load->view('admin/footerv');
	}

	public function add()
	{
		$data['head_title'] = "Tambah User Pengguna - Admin";

		$this->load->view('admin/headerv', $data);
		$this->load->view('admin/users/addv');
		$this->load->view('admin/footerv');
	}

	public function update($getId_user = "0")
	{
		// cek id user
		$cek = $this->Musers->cekId($getId_user);
		if ($getId_user == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Id Tidak ditemukan','error')</script>");
			redirect('admin/users');
			exit();
		}

		$data['id'] = $cek[0]['id_user'];
		$data['nd'] = $cek[0]['nama_depan'];
		$data['nb'] = $cek[0]['nama_belakang'];
		$data['u'] = $cek[0]['username'];

		$level = $cek[0]['level'];
		$data['kasirChecked'] = $level == 'kasir' ? 'checked' : '';
		$data['administratorChecked'] = $level == 'administrator' ? 'checked' : '';

		$data['head_title'] = "Edit User Pengguna - Admin";

		$this->load->view('admin/headerv', $data);
		$this->load->view('admin/users/updatev');
		$this->load->view('admin/footerv');
	}

	public function proses_add()
	{
		// menerima inputan dari bagian view
		$namaDepan = htmlspecialchars($this->input->post('namaDepan'), ENT_QUOTES);
		$namaBelakang = htmlspecialchars($this->input->post('namaBelakang'), ENT_QUOTES);
		$u = htmlspecialchars($this->input->post('u'), ENT_QUOTES);
		$p = htmlspecialchars($this->input->post('p'), ENT_QUOTES);
		$l = htmlspecialchars($this->input->post('level'), ENT_QUOTES);

		// cek username tidak boleh sama
		$cek = $this->Musers->cekUsername($u);
		if (count($cek) >= 1) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Username sudah digunakan','error')</script>");
			redirect('admin/users/add');
			exit();
		}

		// eckripsi password
		$passwordEnkripsi = password_hash($p, PASSWORD_DEFAULT);
		$session_id_user = $this->session->userdata('session_id');

		$dataSimpan = [
			"id_user" => "USE" . mt_rand(10000000000000000, 99999999999999999),
			"nama_depan" => $namaDepan,
			"nama_belakang" => $namaBelakang,
			"username" => $u,
			"password" => $passwordEnkripsi,
			"level" => $l,
		];
		$dataBintang = [
			"tgl_buat" => date('Y-m-d H:i:s'),
			"tgl_update" => "0000-00-00 00:00:00",
			"id_buat" => $session_id_user,
			"id_update" => "",
		];
		$gabungArray = array_merge($dataSimpan, $dataBintang);

		if ($this->Musers->add('tabel_user', $gabungArray)) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Berhasil','Tambah Data Berhasil disimpan','success')</script>");
			redirect('admin/users');
			exit();
		}
		// membuat notifikasi sementara
		$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Gagal','Proses Lambat! Ulangi lagi','error')</script>");
		redirect('admin/users/add');
	}

	public function proses_update()
	{
		// menerima inputan dari bagian view
		$id = htmlspecialchars($this->input->post('id'), ENT_QUOTES);
		$namaDepan = htmlspecialchars($this->input->post('nd'), ENT_QUOTES);
		$namaBelakang = htmlspecialchars($this->input->post('nb'), ENT_QUOTES);
		$u = htmlspecialchars($this->input->post('u'), ENT_QUOTES);
		$l = htmlspecialchars($this->input->post('level'), ENT_QUOTES);

		// cek username tidak boleh sama
		$cek = $this->Musers->cekUsername($u, $id);
		if (count($cek) >= 1) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Username sudah digunakan','error')</script>");
			redirect('admin/users/update/' . $id);
			exit();
		}

		// lolos dari pengecekan username
		$session_id_user = $this->session->userdata('session_id');

		$dataSimpan = [
			"nama_depan" => $namaDepan,
			"nama_belakang" => $namaBelakang,
			"username" => $u,
			"level" => $l,
		];
		$dataBintang = [
			"tgl_update" => date('Y-m-d H:i:s'),
			"id_update" => $session_id_user,
		];

		$gabungArray = array_merge($dataSimpan, $dataBintang);

		if ($this->Musers->update('tabel_user', $gabungArray, 'id_user', $id)) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Berhasil','Edit Data Berhasil disimpan','success')</script>");
			redirect('admin/users');
			exit();
		}
		// membuat notifikasi sementara
		$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Gagal','Proses Lambat! Ulangi lagi','error')</script>");
		redirect('admin/users/update');
	}

	public function proses_delete($getId_user = "0")
	{
		// cek id user
		$cek = $this->Musers->cekId($getId_user);
		if ($getId_user == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Id Tidak ditemukan','error')</script>");
			redirect('admin/users');
			exit();
		}

		if ($this->Musers->delete('tabel_user', $getId_user)) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Berhasil','Hapus Data Berhasil','success')</script>");
			redirect('admin/users');
			exit();
		}

		// membuat notifikasi sementara
		$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Gagal','Proses Lambat! Ulangi lagi','error')</script>");
		redirect('admin/users');
	}
}