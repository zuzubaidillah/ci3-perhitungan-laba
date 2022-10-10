<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Musers extends CI_Model
{
    public function getData()
    {
        $sql = "SELECT * FROM tabel_user ORDER BY nama_depan ASC";
        $querySql = $this->db->query($sql);

        return $querySql->result_array();
    }

    public function add($tb, $data)
    {
        $this->db->insert($tb, $data);
        return $this->db->affected_rows(); // 0 atau 1
    }

    public function update($tb, $data, $kolom, $nilai)
    {
        $this->db->where($kolom, $nilai);
        $this->db->update($tb, $data);
        return $this->db->affected_rows(); // 0 atau 1
    }

    public function delete($tb, $nilai)
    {
        $this->db->where('id_user', $nilai);
        $this->db->delete($tb);
        return $this->db->affected_rows(); // 0 atau 1
    }

    public function cekUsername($username, $id = "")
    {
        if ($id == '') {
            $sql = "SELECT * FROM tabel_user WHERE username='$username'";
        } else {
            $sql = "SELECT * FROM tabel_user WHERE username = '$username' AND id_user != '$id'";
        }
        $querySql = $this->db->query($sql);

        return $querySql->result_array();
    }

    public function getDataKecualiLogin()
    {
        $id = $this->session->userdata('session_id');
        $sql = "SELECT * FROM tabel_user WHERE id_user != '$id' ORDER BY nama_depan ASC";
        $querySql = $this->db->query($sql);

        return $querySql->result_array();
    }

    public function cekId($id)
    {
        $sql = "SELECT * FROM tabel_user WHERE id_user='$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}