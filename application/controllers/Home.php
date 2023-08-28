<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function index()
    {
        // Load the Arsip_model
        $this->load->model('Arsip_model');

        // Fetch the total count of documents from the arsip table
        $data['total_dokumen'] = $this->Arsip_model->get_total_dokumen();

        // Load the view for the Home page
        $data['title'] = 'Home | MRH INKA';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('home', $data); // Load the "home" view with the total count
        $this->load->view('templates/footer');
    }
}
