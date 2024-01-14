<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arsip_model extends CI_Model
{
    private $table = 'arsip';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Insert a new arsip record
    public function insert_arsip($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update an existing arsip record
    public function update_arsip($arsip_id, $data)
    {
        $this->db->where('id', $arsip_id);
        return $this->db->update($this->table, $data);
    }

    // Get all arsip records
    public function get_all_arsip()
    {
        return $this->db->get($this->table)->result();
    }

    // Get arsip records by kategori_id and sub_kategori_id
    public function get_arsip_by_kategori_sub_kategori($kategori_id, $sub_kategori_id)
    {
        $this->db->where('id_kategori', $kategori_id);
        $this->db->where('id_sub_kategori', $sub_kategori_id);
        return $this->db->get($this->table)->result();
    }

    public function get_arsip_by_id($arsip_id)
    {
        $this->db->select('arsip.*, kategori.nama_kategori, sub_kategori.nama_sub_kategori');
        $this->db->from('arsip');
        $this->db->join('kategori', 'kategori.id = arsip.id_kategori');
        $this->db->join('sub_kategori', 'sub_kategori.id = arsip.id_sub_kategori');
        $this->db->where('arsip.id', $arsip_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function get_total_dokumen()
    {
        // Fetch the total count of documents from the arsip table
        return $this->db->count_all('arsip');
    }

    // Delete an arsip record
    public function delete_arsip($arsip_id)
    {
        $this->db->where('id', $arsip_id);
        return $this->db->delete($this->table);
    }

    public function search_arsip($search_query)
    {
        // Query untuk mencari arsip berdasarkan nama arsip atau nomor arsip
        $this->db->like('nama_file', $search_query);
        $this->db->or_like('no_arsip', $search_query);
        $query = $this->db->get('arsip');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
}
