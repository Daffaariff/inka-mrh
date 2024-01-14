<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sub_kategori_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Load the database library
    }

    public function get_sub_categories_by_kategori_id($id_kategori)
    {
        $this->db->where('id_kategori', $id_kategori);
        $query = $this->db->get('sub_kategori');

        return $query->result();
    }
    public function get_sub_kategori_by_id($sub_kategori_id)
    {
        // Fetch a single sub-category from the database based on the provided ID
        $this->db->where('id', $sub_kategori_id);
        $query = $this->db->get('sub_kategori');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
}
