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

	public function update($getIdBerita = "0")
	{
		// cek id user
		$cek = $this->Mberita->cekId($getIdBerita);
		if ($getIdBerita == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Id Tidak ditemukan','error')</script>");
			redirect('admin/berita');
			exit();
		}

		$data['id_berita'] = $cek[0]['id_berita'];
		$data['judul'] = $cek[0]['judul'];
		$data['gambar'] = $cek[0]['gambar'];
		$data['deskripsi_singkat'] = $cek[0]['deskripsi_singkat'];
		$data['isi'] = $cek[0]['isi'];
		$data['tags'] = $cek[0]['tag'];
		$data['tanggal'] = $cek[0]['tanggal'];

		$data['head_title'] = "Edit Berita - Admin";

		$this->load->view('admin/headerv', $data);
		$this->load->view('admin/berita/updatev');
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
		$slug = url_title($judul, 'dash');
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
		$hasil = $this->proses_upload_gambar($id, 'create');

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
			"judul" => $formatJudul,
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

	private function proses_upload_gambar($id, $jenis)
	{

		$config['upload_path']          = FCPATH . '/upload/berita/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['file_name']            = $id;
		$config['overwrite']            = true; // ketika ada file dengan nama sama maka akan dilakukan replace ditindihi
		$config['max_size']             = 2024; // 2MB

		$this->load->library('upload', $config);

		// cek file yang diupload
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('gambar')) {
			// jika gagal
			$data = $this->upload->display_errors();
			return [false, $data];
		}

		if ($jenis == 'update') {
			// gambar lama akan di lakukan hapus dulu
			array_map('unlink', glob(FCPATH . "/upload/berita/$id.*"));
		}

		// proses uploadnya
		if ($this->upload->do_upload('gambar')) {
			// jika berhasil
			$uploaded_data = $this->upload->data(); // get data yang sudah diupload filenya
			// echo "<pre>";
			// var_dump($uploaded_data);
			// die();
			// $uploaded_data['file_name'] itu digunakan untuk mengambil nilai nama gambarnya
			return [true, $uploaded_data['file_name']];
		}
	}

	public function proses_update()
	{
		// menerima request dari client
		$id_berita = htmlspecialchars($this->input->post('id_berita'), ENT_QUOTES);
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
		$cek = $this->Mberita->cekJudul($formatJudul, $id_berita);
		if (count($cek) >= 1) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Judul: $judul sudah digunakan','error')</script>");
			redirect('admin/berita/update/' . $id_berita);
			exit();
		}

		// data yang akan di update
		$dataSimpan = [
			"judul" => $formatJudul,
			"tanggal" => $tanggal,
			"deskripsi_singkat" => $deskripsi_singkat,
			"isi" => $isi,
			"tag" => $tags,
		];

		// cek apakah ganti gambar juga
		if ($_FILES['gambar']['name'] != '') {
			// ketika gambar di isi
			$hasilGambar = $this->proses_upload_gambar($id_berita, 'update');
			// cek apakah lolos upload
			if (!$hasilGambar[0]) {
				// membuat notifikasi sementara
				$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','" . $hasilGambar[1] . "','error')</script>");
				redirect('admin/berita/update/' . $id_berita);
				exit();
			}
			$dataSimpan['gambar'] = $hasilGambar[1];
		}

		// eckripsi password
		$session_id_user = $this->session->userdata('session_id');

		$dataBintang = [
			"tgl_update" => date('Y-m-d H:i:s'),
			"id_update" => $session_id_user,
		];
		$gabungArray = array_merge($dataSimpan, $dataBintang);

		if ($this->Musers->update('tabel_berita', $gabungArray, 'id_berita', $id_berita)) {
			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Berhasil','Update Data Berhasil disimpan','success')</script>");
			redirect('admin/berita');
			exit();
		}

		// membuat notifikasi sementara
		$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Gagal','Proses Lambat! Ulangi lagi','error')</script>");
		redirect('admin/berita/update');
	}

	public function proses_delete($getId_berita = "0")
	{
		// cek id user
		$cek = $this->Mberita->cekId($getId_berita);
		if ($getId_berita == "0" || count($cek) == 0) {
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Pemberitahuan','Maaf Id Tidak ditemukan','error')</script>");
			redirect('admin/berita');
			exit();
		}

		// proses hapus data di tabel berita
		if ($this->Mberita->delete($getId_berita)) {

			// gambar lama akan di lakukan hapus dulu
			array_map('unlink', glob(FCPATH . "/upload/berita/$getId_berita.*"));

			// membuat notifikasi sementara
			$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Berhasil','Hapus Data Berhasil','success')</script>");
			redirect('admin/berita');
			exit();
		}

		// membuat notifikasi sementara
		$this->session->set_flashdata('notifikasi', "<script>Swal.fire('Gagal','Proses Lambat! Ulangi lagi','error')</script>");
		redirect('admin/berita');
	}
}