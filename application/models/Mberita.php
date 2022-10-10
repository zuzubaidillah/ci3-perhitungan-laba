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

    public function cekJudul($judul, $id_berita = '')
    {
        if ($id_berita == '') {
            $sql = "SELECT * FROM tabel_berita WHERE judul='$judul'";
        } else {
            $sql = "SELECT * FROM tabel_berita WHERE judul = '$judul' AND id_berita != '$id_berita'";
        }
        $querySql = $this->db->query($sql);

        return $querySql->result_array();
    }

    public function cekId($getIdBerita)
    {
        $sql = "SELECT * FROM tabel_berita WHERE id_berita='$getIdBerita'";
        $querySql = $this->db->query($sql);

        return $querySql->result_array();
    }
}