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
		$data['head_title'] = "Tambah Berita - Admin";

		$this->load->view('admin/headerv', $data);
		$this->load->view('admin/berita/addv');
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
		$tanggal = htmlspecialchars($this->input->post('tanggal'), ENT_QUOTES);
		$judul = htmlspecialchars($this->input->post('judul'), ENT_QUOTES);
		$tags = htmlspecialchars($this->input->post('tags'), ENT_QUOTES);
		$deskripsi_singkat = htmlspecialchars($this->input->post('deskripsi_singkat'), ENT_QUOTES);
		$isi = $this->input->post('isi');

		// cek judul
		// judul jadikan url slug
		$slug = url_title($judul, 'dash', true);

		// cek judul yang sudah ada sesuai judul
		$cek = $this->Mberita->cekJudul($judul);
		if (count($cek) >= 1) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Judul: $judul sudah digunakan','error')</script>");
			redirect('admin/berita/add');
			exit();
		}

		// upload gambar
		$this->proses_upload_gambar();
	}

	private function proses_upload_gambar()
	{
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