<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Load the database library
    }

    public function get_all_categories()
    {
        // Fetch all categories from the database
        $query = $this->db->get('kategori');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    public function get_category_by_id($category_id)
    {
        // Fetch a single category from the database based on the provided ID
        $this->db->where('id', $category_id);
        $query = $this->db->get('kategori');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
}
