<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mberita extends CI_Model
{
    public function getData()
    {
        $sql = "SELECT * FROM tabel_berita ORDER BY tgl_buat DESC";
        $querySql = $this->db->query($sql);

        return $querySql->result_array();
    }

    public function cekJudul($judul)
    {
        $sql = "SELECT * FROM tabel_berita WHERE judul='$judul'";
        $querySql = $this->db->query($sql);

        return $querySql->result_array();
    }
}