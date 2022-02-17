<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Aplikasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $user_session = $this->session->userdata('id_user');
        if (!$user_session) {
            redirect('auth');
        }
    }
    public function index()
    {
    }

    public function listproduk()
    {
        $data['aplikasi'] = $this->db->get('base_aplikasi');
        $data['modul']  = $this->db->get('modul');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('aplikasi/list_aplikasi', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        $nama = $this->input->post('nama');
        $data1 = array('nama_aplikasi' => $nama);
        $table = 'base_aplikasi';
        $data = $this->Model_aplikasi->tambah($table, $data1);
        echo json_encode($data);
    }

    public function get_data()
    {
        $id = $this->input->get('id');
        $data = $this->Model_aplikasi->get_data($id);
        echo json_encode($data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $data = $this->Model_aplikasi->update($id, $nama);
        echo json_encode($data);
    }

    public function deleteAplikasi()
    {
        $id = $this->uri->segment(3);
        $this->db->delete('base_aplikasi', 'id_bAplikasi = ' . $id);
        redirect('Aplikasi/listproduk');
    }

    public function tambahXaplikasi()
    {
        $id = $this->input->post('id_aplikasi');
        $modul = $this->input->post('id_modul');
        $data1 = array('id_modul' => $modul,  'id_aplikasi' => $id);
        $table = 'x_aplikasi';
        $data = $this->Model_aplikasi->tambah($table, $data1);
        echo json_encode($data);
    }

    public function deleteXmodul()
    {
        $id = $this->uri->segment(3);
        $this->db->delete('x_modul', 'id_x_modul =' . $id);
        redirect('Aplikasi/listModul');
    }

    //Halaman Modul 
    //list modul
    public function listModul()
    {
        $data['project'] = $this->db->get('project');
        $data['modul'] = $this->db->get('modul');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('aplikasi/list_Modul', $data);
        $this->load->view('template/footer');
    }

    //tambah modul
    public function addModul()
    {
        $nama = $this->input->post('nama');
        $data1 = array('nama_modul' => $nama);
        $table = 'modul';
        $data = $this->Model_aplikasi->tambah($table, $data1);
        echo json_encode($data);
    }

    //halaman modul get data modul
    public function get_dataModul()
    {
        $id = $this->input->get('id');
        $data = $this->Model_aplikasi->get_dataModul($id);
        echo json_encode($data);
    }

    //update modul 
    public function updateModul()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $data = $this->Model_aplikasi->updateModul($id, $nama);
        echo json_encode($data);
    }

    //hapus modul
    public function deleteModul()
    {
        $id = $this->uri->segment(3);
        $this->db->delete('modul', 'id_modul =' . $id);
        redirect('Aplikasi/listModul');
    }

    // halaman modul get data aplikasi dari tabel project 
    public function aplikasiX()
    {
        $id = $_GET['id'];
        $aplikasi = $this->db->get_where('aplikasi', 'id_project = ' . $id)->result();
        foreach ($aplikasi as $d) {
            echo "<option value='" . $d->id_aplikasi . "'>" . $d->nama_aplikasi . "</option>";
        }
    }

    //halaman modul get data project dan aplikasi untuk tambah modul
    public function get_data_m()
    {
        $id = $_GET['id'];
        $data = $this->Model_aplikasi->get_data_m($id);
        echo json_encode($data);
    }

    //tambah modul pada aplikasi
    public function tambahModul()
    {
        $id_aplikasi = $this->input->post('id');
        $id_modul = $this->input->post('id_modul');
        $d = $this->db->get_where('modul', 'id_modul = ' . $id_modul)->row_array();
        $nama_modul = $d['nama_modul'];
        $data1 = array('id_modul' => $id_modul, 'nama_modul' => $nama_modul, 'id_aplikasi' => $id_aplikasi);
        $table = 'x_aplikasi';
        $data = $this->Model_aplikasi->tambah($table, $data1);
        echo json_encode($data);
    }

    public function deleteXaplikasi()
    {
        $id = $this->uri->segment(3);
        $this->db->delete('x_aplikasi', 'id_x_aplikasi = ' . $id);
        redirect('Aplikasi/listmodul');
    }
    //end Halaman Modul


    //Halaman sub Modul 
    //list sub modul halaman sub modul
    public function listSubModul()
    {
        $data['submodul'] = $this->db->get('base_submodul');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('aplikasi/list_SubModul', $data);
        $this->load->view('template/footer');
    }

    // halaman sub modul get data modul dari tabel aplikasi 
    public function modulX()
    {
        $id = $_GET['id'];
        $this->db->join('modul', 'modul.id_modul = x_aplikasi.id_modul');
        $modul = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $id)->result();
        //var_dump($modul);
        foreach ($modul as $d) {
            echo "<option value='" . $d->id_x_aplikasi . "'>" . $d->nama_modul . "</option>";
        }
    }

    //halaman sub modul base submodul
    public function sub_modul()
    {
        $id = $_GET['id'];
        $modul = $this->db->get_where('sub_modul', 'id_x_aplikasi = ' . $id);
        $no = 1;
        foreach ($modul->result() as $d) {
            echo "<tr>
                     <td>$no</td>
                     <td>" . strtoupper($d->nama_sub) . "</td>
                     <td><a href='hapusSub/" . $d->id_sub . "' onclick='return confirm(\"Are you sure you want to do this?\")' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a></td>
                     </tr>";
            $no++;
        }
    }

    //halaman sub modul get data modul dan aplikasi untuk tambah sub_modul
    public function get_data_modul()
    {
        $id = $this->input->get('id');
        $data = $this->Model_aplikasi->get_data_modul($id);
        echo json_encode($data);
    }

    //halaman sub modul untuk get data untuk  edit base submodul
    public function get_data_submodul()
    {
        $id = $this->input->get('id');
        $data = $this->Model_aplikasi->get_data_submodul($id);
        echo json_encode($data);
    }

    //halaman sub modul untuk update base sub modul 
    public function updateSubModul()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $data = $this->Model_aplikasi->updateSubModul($id, $nama);
        echo json_encode($data);
    }

    //halaman sub modul untuk menambah sub_modul ke modul dan aplikasi
    public function tambahSubModul()
    {
        $id = $this->input->post('id');
        $sub = $this->input->post('nama');
        $q = $this->db->get_where('base_submodul', 'id_bSub =' . $sub)->row_array();
        $nama = $q['nama_sub'];
        $data1 = array('id_x_aplikasi' => $id, 'id_bSub' => $sub,  'nama_sub' => $nama);
        $table = 'sub_modul';
        $data = $this->Model_aplikasi->tambah($table, $data1);
        echo json_encode($data);
    }

    //hapus sub modul di base data

    public function hapusSub()
    {
        $id = $this->uri->segment(3);
        $this->db->delete('base_submodul', 'id_bSub = ' . $id);
        redirect('Aplikasi/listsubmodul');
    }

    //End halaman sub modul

    public function tambahSub()
    {
        $nama = $this->input->post('nama');
        $data1 = array('nama_sub' => $nama);
        $table = 'base_submodul';
        $data = $this->Model_aplikasi->tambah($table, $data1);
        echo json_encode($data);
    }

    public function deleteSub()
    {
        $id = $this->uri->segment(3);
        $this->db->delete('sub_modul', 'id_sub =' . $id);
        redirect('Aplikasi/listSub');
    }
}
