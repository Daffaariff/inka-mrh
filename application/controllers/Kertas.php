<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kertas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Kategori_model');
        $this->load->model('Sub_kategori_model');
        $this->load->model('Arsip_model'); // Load the Arsip_model
    }

    public function index()
    {
        $id_kategori = $this->input->get('id'); // Get the id parameter from the URL

        if ($id_kategori) {
            // Fetch sub-categories by the ID of the category
            $data['title'] = 'Kertas Kerja | MRH INKA';
            $data['sub_categories'] = $this->Sub_kategori_model->get_sub_categories_by_kategori_id($id_kategori);


            $this->load->view('templates/header', $data);
            $this->load->view('templates/nav');
            $this->load->view('kertas/sub_kategori', $data);
            $this->load->view('templates/footer');
        } else {
            // Fetch all categories
            $data['title'] = 'Kertas Kerja | MRH INKA';
            $data['categories'] = $this->Kategori_model->get_all_categories();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/nav');
            $this->load->view('kertas/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function sub_kategori($id_kategori = 'null')
    {
        // Load the Sub_kategori_model (assuming you already have this model)
        $this->load->model('Sub_kategori_model');

        // Fetch sub-categories by the ID of the category
        $data['title'] = 'Kertas Kerja | MRH INKA';
        $data['sub_categories'] = $this->Sub_kategori_model->get_sub_categories_by_kategori_id($id_kategori);
        $data['kategori'] = $this->Kategori_model->get_category_by_id($id_kategori);

        // Load the view to display the sub-categories
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('kertas/sub_kategori', $data);
        $this->load->view('templates/footer');
    }

    public function arsip()
    {
        $kategori_id = $this->uri->segment(3);
        $sub_kategori_id = $this->uri->segment(4);

        if (!$kategori_id || !$sub_kategori_id) {
            // Redirect to the appropriate page if the IDs are not provided
            redirect('kertas');
        }

        $this->load->model('Sub_kategori_model');
        $data['sub_kategori'] = $this->Sub_kategori_model->get_sub_kategori_by_id($sub_kategori_id);

        // Fetch arsip data by the IDs of the kategori and sub_kategori using the Arsip_model
        $data['title'] = 'Arsip | MRH INKA';
        $data['arsip_data'] = $this->Arsip_model->get_arsip_by_kategori_sub_kategori($kategori_id, $sub_kategori_id);

        // Load the view to display the arsip data
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('kertas/arsip', $data);
        $this->load->view('templates/footer');
    }

    public function add_arsip()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('no_arsip', 'No Arsip', 'required');
        $this->form_validation->set_rules('nama_file', 'Nama File', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('sub_kategori', 'Sub Kategori', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan halaman dengan pesan error
            $data['title'] = 'Tambah file | MRH INKA';
            $data['kategori_data'] = $this->Kategori_model->get_all_categories();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/nav');
            $this->load->view('kertas/add_arsip', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika validasi berhasil, proses penyimpanan data dan file arsip
            $data = array(
                'no_arsip' => $this->input->post('no_arsip'),
                'nama_file' => $_FILES['file_arsip']['name'], // Nama asli file yang diunggah oleh pengguna
                'file_arsip' => $this->generate_unique_filename($_FILES['file_arsip']['name']), // Nama file unik untuk menyimpan di server
                'deskripsi' => $this->input->post('deskripsi'),
                'tgl_upload' => date('Y-m-d H:i:s'), // Tanggal upload saat ini
                'tgl_update' => date('Y-m-d'), // Tanggal update saat ini
                'id_kategori' => $this->input->post('kategori'), // Get the selected category ID
                'id_sub_kategori' => $this->input->post('sub_kategori'), // Get the selected sub-category ID
            );

            // Lakukan penyimpanan data ke database menggunakan Arsip_model
            $this->Arsip_model->insert_arsip($data);

            // Proses upload file arsip
            $config['upload_path'] = FCPATH . 'file-arsip/'; // Lokasi folder untuk menyimpan file arsip
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx'; // Jenis file yang diizinkan untuk diunggah
            $config['max_size'] = 5000; // Ukuran maksimal file (dalam kilobyte)
            $config['file_name'] = $data['file_arsip']; // Gunakan nama unik yang telah dihasilkan sebelumnya

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_arsip')) {
                // Jika proses upload gagal, tampilkan pesan error
                $error = array('error' => $this->upload->display_errors());
                $data['title'] = 'tambah file | MRH INKA';
                $data['kategori_data'] = $this->Kategori_model->get_all_categories();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/nav');
                $this->load->view('kertas/add_arsip', $data);
                $this->load->view('templates/footer');
            } else {
                // Jika proses upload berhasil, arahkan kembali ke halaman arsip
                redirect('kertas/arsip/' . $data['id_kategori'] . '/' . $data['id_sub_kategori']);
            }
        }
    }

    private function generate_unique_filename($original_name)
    {
        $extension = pathinfo($original_name, PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        return $filename;
    }

    public function get_subkategori_by_kategori($kategori_id)
    {
        $this->load->model('Sub_kategori_model');
        $subkategori_data = $this->Sub_kategori_model->get_sub_categories_by_kategori_id($kategori_id);
        echo json_encode($subkategori_data);
    }

    public function detail($arsip_id)
    {
        // Load the Arsip_model
        $this->load->model('Arsip_model');

        // Fetch arsip data by the ID
        $data['title'] = 'Detail | MRH INKA';
        $data['arsip'] = $this->Arsip_model->get_arsip_by_id($arsip_id);

        if (!$data['arsip']) {
            // Redirect to the appropriate page if the arsip ID does not exist
            redirect('kertas');
        }

        // Load the view to display the detail page within the "arsip" view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('kertas/detail', $data); // Load the "arsip" view with the detail section
        $this->load->view('templates/footer');
    }



    public function delete_arsip($arsip_id)
    {
        // Load the Arsip_model
        $this->load->model('Arsip_model');

        // Get the arsip data by its ID
        $arsip = $this->Arsip_model->get_arsip_by_id($arsip_id);

        if (!$arsip) {
            // If the arsip data is not found, redirect to the arsip list page
            redirect('kertas');
        }

        // Delete the file from the file-arsip folder
        $file_path = FCPATH . 'file-arsip/' . $arsip->file_arsip;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the arsip data from the database
        $this->Arsip_model->delete_arsip($arsip_id);

        // Redirect back to the arsip list page
        redirect('kertas/arsip/' . $arsip->id_kategori . '/' . $arsip->id_sub_kategori);
    }

    // Kertas.php
    public function edit_arsip($arsip_id)
    {
        // Load the Arsip_model
        $this->load->model('Arsip_model');

        // Get the arsip data by its ID
        $arsip = $this->Arsip_model->get_arsip_by_id($arsip_id);

        if (!$arsip) {
            // If the arsip data is not found, redirect to the arsip list page
            redirect('kertas');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('no_arsip', 'No Arsip', 'required');
        $this->form_validation->set_rules('nama_file', 'Nama File', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

        if ($this->form_validation->run() == FALSE) {
            // If validation fails, reload the edit page with the arsip data
            $data['title'] = 'Edit file | MRH INKA';
            $data['arsip'] = $arsip;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/nav');
            $this->load->view('kertas/edit_arsip', $data);
            $this->load->view('templates/footer');
        } else {
            // If validation succeeds, process the form data

            // Set the updated values from the form data
            $data = array(
                'no_arsip' => $this->input->post('no_arsip'),
                'nama_file' => $this->input->post('nama_file'),
                'deskripsi' => $this->input->post('deskripsi'),
                'tgl_update' => date('Y-m-d H:i:s'), // Set the current date and time as the update date
            );

            // Check if a new file is uploaded and update the file name in the database
            if ($_FILES['file_arsip']['name']) {
                // Delete the old file from the file-arsip folder
                $file_path = FCPATH . 'file-arsip/' . $arsip->file_arsip;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }

                // Set the new file name
                $data['file_arsip'] = $_FILES['file_arsip']['name'];
            }

            // Update the arsip data in the database
            $this->Arsip_model->update_arsip($arsip_id, $data);

            // If a new file is uploaded, move it to the file-arsip folder
            if ($_FILES['file_arsip']['name']) {
                $config['upload_path'] = FCPATH . 'file-arsip/';
                $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
                $config['max_size'] = 5000;
                $config['file_name'] = uniqid();

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file_arsip')) {
                    // If the file upload fails, reload the edit page with the arsip data and an error message
                    $error = array('error' => $this->upload->display_errors());
                    $data['arsip'] = $arsip;
                    $data['error'] = $error['error'];
                    $data['title'] = 'Edit file | MRH INKA';
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/nav');
                    $this->load->view('kertas/edit_arsip', $data);
                    $this->load->view('templates/footer');
                    return;
                }
            }

            // Redirect back to the arsip list page
            redirect('kertas/arsip/' . $arsip->id_kategori . '/' . $arsip->id_sub_kategori);
        }
    }

    public function search_arsip()
    {
        $search_query = $this->input->get('search_query');
        $data['title'] = 'Search | MRH INKA';
        if ($search_query) {
            // Jika terdapat inputan pencarian, ambil data arsip berdasarkan nama arsip atau nomor arsip
            $data['arsip_data'] = $this->Arsip_model->search_arsip($search_query);
        } else {
            // Jika tidak ada inputan pencarian, tampilkan notifikasi dan refresh halaman
            $this->session->set_flashdata('notification', 'Pencarian tidak ada.');
            redirect('kertas/arsip');
        }

        // Load view untuk menampilkan hasil pencarian
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('kertas/arsip', $data);
        $this->load->view('templates/footer');
    }
}
