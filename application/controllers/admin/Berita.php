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
		$formatJudul = str_replace('-', ' ', $slug);

		// cek judul yang sudah ada sesuai judul
		$cek = $this->Mberita->cekJudul($formatJudul);
		if (count($cek) >= 1) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Judul: $judul sudah digunakan','error')</script>");
			redirect('admin/berita/add');
			exit();
		}

		// upload gambar
		$id = "BER" . mt_rand(10000000000000000, 99999999999999999);
		$hasil = $this->proses_upload_gambar($id);

		// cek apakah lolos upload
		if (!$hasil[0]) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','" . $hasil[1] . "','error')</script>");
			redirect('admin/berita/add');
			exit();
		}

		$session_id_user = $this->session->userdata('session_id');

		$dataSimpan = [
			"id_berita" => $id,
			"gambar" => $hasil[1],
			"judul" => $judul,
			"tanggal" => $tanggal,
			"deskripsi_singkat" => $deskripsi_singkat,
			"isi" => $isi,
			"dilihat" => 0,
			"tag" => $tags,
		];
		$dataBintang = [
			"tgl_buat" => date('Y-m-d H:i:s'),
			"tgl_update" => "0000-00-00 00:00:00",
			"id_buat" => $session_id_user,
			"id_update" => "",
		];
		$gabungArray = array_merge($dataSimpan, $dataBintang);

		if ($this->Musers->add('tabel_berita', $gabungArray)) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Berhasil','Tambah Data Berhasil disimpan','success')</script>");
			redirect('admin/berita');
			exit();
		}
		// membuat notifikasi sementara
		$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Gagal','Proses Lambat! Ulangi lagi','error')</script>");
		redirect('admin/berita/add');
	}

	private function proses_upload_gambar($file_name)
	{
		$config['upload_path']          = FCPATH . '/upload/berita/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['file_name']            = $file_name;
		$config['overwrite']            = true; // ketika ada file dengan nama sama maka akan dilakukan replace ditindihi
		$config['max_size']             = 2024; // 2MB

		$this->load->library('upload', $config);

		// proses uploadnya
		if ($this->upload->do_upload('gambar')) {
			// jika berhasil
			$uploaded_data = $this->upload->data(); // get data yang sudah diupload filenya
			// $uploaded_data['file_name'] itu digunakan untuk mengambil nilai nama gambarnya
			return [true, $uploaded_data['file_name']];
		} else {
			// jika gagal
			$data = $this->upload->display_errors();
			return [false, $data];
		}
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