<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller

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

    function listproject()
    {
        $this->db->join('base_status', 'base_status.id_status = project.status', 'left');
        $this->db->join('aplikasi', 'aplikasi.id_project = project.id');
        $this->db->order_by('id', 'DESC');
        $data['project'] = $this->db->get('project');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('project/list', $data);
        $this->load->view('template/footer1');
    }

    //detail project
    function detail()
    {
        $id = $this->uri->segment(3);
        $user = $this->session->userdata('status');
        if ($user == 3) {
            $this->db->where('id_status !=', 1);
            $this->db->where('id_status !=', 5);
            $data['status'] = $this->db->get('base_status');
        } else {
            $data['status'] = $this->db->get('base_status');
        }
        $data['cek'] = $this->db->get_where('project', 'id = ' . $id)->row();
        $data['aplikasi'] = $this->db->get_where('aplikasi', array('id_project' => $id));
        $data['kontrak'] = $this->db->get_where('kontrak', 'id_kontrak =' . $id)->row();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('project/detail', $data);
        $this->load->view('template/footer');
    }

    function status()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $data = $this->Model_project->status($id, $status);
        echo true;
    }

    function keterangan()
    {
        $id = $_POST['id'];
        $ket = $_POST['keterangan'];
        $data = $this->Model_project->keterangan($id, $ket);
        echo true;
    }


    //tambah project
    public function add()
    {
        if (isset($_POST['submit'])) {
            $this->Model_project->save();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-text">Penambahan Project Berhasil</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></div>
            </div>');
            redirect('Project/listproject');
        } else {
            $data['kontrak'] = $this->db->get('kontrak');
            $data['aplikasi'] = $this->db->get('base_aplikasi');
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('project/add', $data);
            $this->load->view('template/footer');
        }
    }

    //edit project
    public function edit()
    {
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])) {
            $this->Model_project->edit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-text">Project Berhasil di Update</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </div>');
            redirect('Project/listproject');
        }
        $data['aplikasi'] = $this->db->get('base_aplikasi');
        $data['cek'] = $this->db->get_where('project', 'id = ' . $id)->row_array();

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('project/edit', $data);
        $this->load->view('template/footer');
    }

    //hapus project
    public function delete()
    {
        $id = $this->uri->segment(3);
        $this->Model_project->delete($id);
        redirect('Project/listproject');
    }

    //halaman modul
    //halaman list Modul
    public function listmodul()
    {
        $this->db->where('status <', 3);
        $this->db->order_by('id', 'DESC');
        $data['project'] = $this->db->get('project');
        $data['modul'] = $this->db->get('modul');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('project/list_modul', $data);
        $this->load->view('template/footer');
    }

    public function coba()
    {
        $this->db->where('status <', 3);
        $this->db->order_by('id', 'DESC');
        $data['project'] = $this->db->get('project');
        $data['modul'] = $this->db->get('modul');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('coba', $data);
        $this->load->view('template/footer');
    }

    public  function mod()
    {

        $id = $_GET['id'];
        $m = $this->db->get('modul');
        foreach ($m->result_array() as $mm) {
            $this->db->where('id_aplikasi', $id);
            $this->db->where('id_modul =', $mm['id_modul']);
            $d = $this->db->get('x_aplikasi');
            if ($d->num_rows() > 0) {
                //echo $mm['nama_modul'] . "<br>";
            } else {

                echo "<option value='" . $mm['id_modul'] . "'>" . $mm['nama_modul'] . "</option>";
            }
        }
    }

    //menampilkan project
    public function aplikasiX()
    {
        $id = $_GET['id'];
        $aplikasi = $this->db->get_where('aplikasi', 'id_project = ' . $id)->result();
        foreach ($aplikasi as $d) {
            echo "<option value='" . $d->id_aplikasi . "'>" . $d->nama_aplikasi . "</option>";
        }
    }

    //menampilkan modul 
    public function modul()
    {
        $id = $_GET['id'];
        $apli = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $id);
        $no = 1;
        foreach ($apli->result() as $we) {
            echo "<tr>
                    <td>" . $no . "</td>
                    <td>" . $we->nama_modul . "</td>
                    <td><button class='btn btn-danger btn-sm' onclick='hapus(" . $we->id_x_aplikasi . ")'><i class='fa fa-trash'></i></button></td>
                </tr>";
            $no++;
        }
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


    public function hapusModul()
    {
        $id = $_GET['id'];
        $hapus = $this->db->delete('x_aplikasi', 'id_x_aplikasi = ' . $id);
        echo json_encode($hapus);
    }

    //end halaman modul

    //halaman submodul
    //list submodul
    public function listSubModul()
    {
        $this->db->join('project', 'project.id = aplikasi.id_project');
        $this->db->where('project.status <', 3);
        $this->db->order_by('id', 'DESC');
        $data['aplikasi'] = $this->db->get('aplikasi');
        $data['modul'] = $this->db->get('modul');
        $data['sub_modul'] = $this->db->get('base_submodul');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('project/list_SubModul', $data);
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

    //halaman sub modul menampilkan table submodul
    public function sub_modul()
    {
        $id = $_GET['id'];
        $modul = $this->db->get_where('sub_modul', 'id_x_aplikasi = ' . $id);
        $no = 1;
        foreach ($modul->result() as $d) {
            echo "<tr>
                     <td>$no</td>
                     <td>" . strtoupper($d->nama_sub) . "</td>
                     <td><button class='btn btn-sm btn-danger' onclick='hapus(" . $d->id_sub . ")'><i class='fa fa-trash'></i></button></td>
                     </tr>";
            $no++;
        }
    }

    //halaman sub modul get modul dan aplikasi untuk nambah submodul
    public function get_data_modul()
    {
        $id = $this->input->get('id');
        $data = $this->Model_aplikasi->get_data_modul($id);
        echo json_encode($data);
    }

    //halaman sub modul untuk menambah sub_modul ke table submodul
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

    //halaman sub modul untuk menghapus sub_modul
    public function hapusSub()
    {
        $id = $_GET['id'];
        $cek = $this->db->delete('sub_modul', 'id_sub = ' . $id);
        echo json_encode($cek);
    }

    public  function sub()
    {

        $id = $_GET['id'];
        $m = $this->db->get('base_submodul');
        foreach ($m->result_array() as $mm) {
            $this->db->where('id_x_aplikasi', $id);
            $this->db->where('id_bSub =', $mm['id_bSub']);
            $d = $this->db->get('sub_modul');
            if ($d->num_rows() > 0) {
                //echo $mm['nama_modul'] . "<br>";
            } else {

                echo "<option value='" . $mm['id_bSub'] . "'>" . $mm['nama_sub'] . "</option>";
            }
        }
    }


    //halaman kontrak
    //list kontrak
    public function listKontrak()
    {
        $data['kontrak'] = $this->db->get('base_kontrak');
        $this->db->where('status <', 3);
        $this->db->order_by('id', 'DESC');
        $data['project'] = $this->db->get('project');
        $data['modul'] = $this->db->get('modul');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('project/list_kontrak', $data);
        $this->load->view('template/footer1');
    }

    //menampilkan kontrak
    public function tampilKontrak()
    {
        $id = $_GET['id'];
        $this->db->join('base_kontrak', 'base_kontrak.id_bKontrak = kontrak.nama_kontrak');
        $kontrak = $this->db->get_where('kontrak', 'id_project = ' . $id);
        if ($kontrak->num_rows() > 0) {
            $wa = $kontrak->row_array();
            echo "<tr>
                    <td>Kontrak</td>
                    <td>" . $wa['lama'] . " " . $wa['satuan'] . "</td>
                </tr>
                <tr>
                    <td>Mulai</td><td> " . $wa['mulai'] . "</td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td> " . $wa['selesai'] . "</td>
                </tr>
                <tr>
                    <td><a href='#' class='btn btn-sm btn-warning mt-3' onclick='editKontrak(" . $wa['id_kontrak'] . ")'>Edit Kontrak</a></td>
                    <td><a href='#' onclick='hapusKontrak(" . $wa['id_kontrak'] . ")' class='btn btn-sm btn-danger mt-3'>Hapus Kontrak</a></td>
                </tr>";
        } else {
            echo "Kontrak : <a href='#' class='btn btn-sm btn-success' onclick='tambahKontrak()'>Tambah Kontrak</a>
            ";
        }
    }

    public function tambahKontrak()
    {
        $id = $_POST['id'];
        $kontrak = $_POST['kontrak'];
        $mulai = $_POST['mulai'];
        $date = new DateTime($mulai);
        $w = $this->db->get_where('base_kontrak', 'id_bKontrak = ' . $kontrak)->row();
        if ($w->satuan == "Tahun") {
            $date2 = $date->add(new DateInterval('P' . $w->lama . 'Y'));
            $cek = $date2->format('Y-m-d');
        } else if ($w->satuan == "Bulan") {
            $date2 = $date->add(new DateInterval('P' . $w->lama . 'M'));
            $cek = $date2->format('Y-m-d');
        }
        $data1 = array('id_project' => $id, 'nama_kontrak' => $kontrak, 'mulai' => $mulai, 'selesai' => $cek);
        $table = 'kontrak';
        $data = $this->Model_project->tambah($table, $data1);
        echo json_encode($data);
    }

    public function get_kontrak()
    {
        $id = $_GET['id'];
        $data = $this->Model_project->get_kontrak($id);
        echo json_encode($data);
    }

    public function updateKontrak()
    {
        $id = $_POST['id'];
        $kontrak = $_POST['kontrak'];
        $mulai = $_POST['mulai'];
        $date = new DateTime($mulai);
        $w = $this->db->get_where('base_kontrak', 'id_bKontrak = ' . $kontrak)->row();
        if ($w->satuan == "Tahun") {
            $date2 = $date->add(new DateInterval('P' . $w->lama . 'Y'));
            $cek = $date2->format('Y-m-d');
        } else if ($w->satuan == "Bulan") {
            $date2 = $date->add(new DateInterval('P' . $w->lama . 'M'));
            $cek = $date2->format('Y-m-d');
        }
        $data1 =
            [
                'nama_kontrak'  => $kontrak,
                'mulai'         => $mulai,
                'selesai'       => $cek
            ];
        $data = $this->Model_project->updateKontrak($id, $data1);
        echo json_encode($data);
    }

    public function deleteKontrak()
    {
        $id = $_GET['id'];
        $this->db->delete('kontrak', 'id_kontrak =' . $id);
        echo true;
    }



    //list dokumen di aplikasi
    public function tampilDokumen()
    {
        $id = $_GET['id'];
        $kontrak = $this->db->get_where('x_kontrak', 'id_project = ' . $id);
        $no = 1;
        foreach ($kontrak->result() as $d) {
            echo "<tr>
                <td>$no</td>
                <td>" . strtoupper($d->nama_dokumen) . "</td>
                <td>" . strtoupper($d->jenis_dokumen) . "</td>
                <td>
                <a href='" . base_url($d->file) . "' target='_blank' class='btn btn-sm btn-info'><i class='fa fa-eye'></i></a>
                <a href='" . base_url($d->file) . "' download target='_blank' class='btn btn-sm btn-info'><i class='fa fa-download'></i></a>
                <button  onclick='hapus(" . $d->id_x_kontrak . ")' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button></td>
                </tr>";
            $no++;
        }
    }

    //menampilkan data untuk menambahkan dokumen
    public function get_project()
    {
        $id = $this->input->get('id');
        $data = $this->Model_project->get_data_p($id);
        echo json_encode($data);
    }

    //mengupload dokumen pada kontrak
    public function save()
    {
        $config['upload_path']          = './assets/uploads/images/';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 2048;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file')) {
            $error = $this->upload->display_errors();
            echo json_encode(array('msg' => $error, 'success' => false));
        } else {
            $data = array('upload_data' => $this->upload->data());
            $nama = $config['upload_path'] . $this->upload->data('file_name');

            $data = array(
                'jenis_dokumen' => $this->input->post('jenis'),
                'nama_dokumen'  => $this->input->post('nama_dokumen'),
                'id_project'    => $this->input->post('id'),
                'file'          => $nama
            );

            $table = "x_kontrak";
            $this->Model_project->tambah($table, $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> <div class="alert-text">Data Berhasil Ditambahkan !!!</div>
        </div>'
            );
            echo json_encode(array('msg' => "Success", 'success' => true));
        }
    }

    //menghapus dokumen
    public function deleteDokumen()
    {
        $id = $_GET['id'];
        $data = $this->db->get_where('x_kontrak', 'id_x_kontrak = ' . $id)->row_array();
        $path = $data['file'];
        unlink($path);
        $cek = $this->db->delete('x_kontrak', 'id_x_kontrak =' . $id);
        echo json_encode($cek);
    }


    //halaman pelaksana project
    public function listPelaksana()
    {
        $this->db->where('status <', 3);
        $this->db->order_by('id', 'DESC');
        $data['project'] = $this->db->get('project');
        $this->db->where('id_level != 1');
        $data['level'] = $this->db->get('level_user');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('project/list_pelaksana', $data);
        $this->load->view('template/footer1');
    }

    public function get_data_p()
    {
        $id = $this->input->get('id');
        $data = $this->Model_project->get_data_p($id);
        echo json_encode($data);
    }


    //menampilkan penjab di project
    public function penjab()
    {
        $id = $_GET['id'];
        $this->db->join('user', 'user.id = x_pelaksana.id_pelaksana');
        $this->db->where('id_project = ' . $id);
        $this->db->where('user.status =2');
        $user = $this->db->get('x_pelaksana')->result();
        foreach ($user as $ui) {
            echo  $ui->nama . "&nbsp;&nbsp;<button onclick='hapus(" . $ui->id_x_pelaksana . ")' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button>&nbsp;";
        }
    }

    //menampilkan pic di project
    public function pic()
    {
        $id = $_GET['id'];
        $id = $_GET['id'];
        $this->db->join('user', 'user.id = x_pelaksana.id_pelaksana');
        $this->db->where('id_project = ' . $id);
        $this->db->where('user.status =3');
        $user = $this->db->get('x_pelaksana')->result();
        foreach ($user as $ui) {
            echo  $ui->nama . "&nbsp;&nbsp;<button onclick='hapus(" . $ui->id_x_pelaksana . ")' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button>&nbsp;";
        }
    }

    //menampilkan programmer di project
    public function programmer()
    {
        $id = $_GET['id'];
        $id = $_GET['id'];
        $this->db->join('user', 'user.id = x_pelaksana.id_pelaksana');
        $this->db->where('id_project = ' . $id);
        $this->db->where('user.status =4');
        $user = $this->db->get('x_pelaksana')->result();
        foreach ($user as $ui) {
            echo  $ui->nama . "&nbsp;&nbsp;<button onclick='hapus(" . $ui->id_x_pelaksana . ")' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button>&nbsp;";
        }
    }

    //get jabatan ketika mau ditambahkan
    public function pelaksana()
    {
        $id = $_GET['id'];
        $jabatan = $_GET['jabatan'];
        $q = $this->db->get_where('user', 'status ="' . $jabatan . '"');
        foreach ($q->result() as $t) {
            $cek = $this->db->get_where('x_pelaksana', ['id_pelaksana ' => $t->id, 'id_project' => $id]);
            if ($cek->num_rows() > 0) {
            } else {
                echo "<option value=" . $t->id . ">" . $t->nama . "</option>";
            }
        }
    }

    //tambah pelaksana di projek
    public function tambahPelaksana()
    {
        $id_project = $this->input->post('id_project');
        $nama = $this->input->post('nama');
        $data1 = array(
            'id_project' => $id_project,
            'id_pelaksana' => $nama
        );
        $table = 'x_pelaksana';
        $data = $this->Model_project->tambah($table, $data1);
        echo json_encode($data);
    }

    public function hapusPelaksana()
    {
        $id = $_GET['id'];
        var_dump($id);
        $cek = $this->db->delete('x_pelaksana', 'id_x_pelaksana =' . $id);
        echo json_encode($cek);
    }
    //end pelaksana


    //halaman Pelaksana Modul
    public function listPelaksanaModul()
    {
        $this->db->where('status <', 3);
        $this->db->order_by('id', 'DESC');
        $data['project'] = $this->db->get('project');
        $data['pelaksana'] = $this->db->get_where('pelaksana', 'jabatan = "programmer"');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('project/list_pelmodul', $data);
        $this->load->view('template/footer');
    }

    //menampilkan pelaksana modul
    public function pel_modul()
    {
        $id = $_GET['id'];
        $apli = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $id);
        $no = 1;
        foreach ($apli->result() as $w) {
            $pelaksana = $this->db->get_where('x_pelmodul', 'id_x_aplikasi = ' . $w->id_x_aplikasi);
            $pe = $pelaksana->num_rows();

            if ($pe > 0) {
                echo "<tr>
                <td rowspan='" . $pe . "'>" . $no++ . "</td>
                <td rowspan='" . $pe . "'>" . $w->nama_modul . "</td>";

                foreach ($pelaksana->result() as $yu) {
                    echo "<td>" . $yu->nama_pelaksana . "</td>
                        <td><button onclick='hapus(" . $yu->id_xPel . ")' class='btn btn-xs btn-danger' ><i class='fa fa-trash'></i></button> </td></tr>";
                }
            } else {
                echo "<tr>
                        <td>" . $no++ . "</td>
                        <td>" . $w->nama_modul . "</td>
                        <td></td>
                        <td></td>";
            }
            echo "</tr>";
        }
    }

    //mendapatkan data untuk tambah pelaksana
    public function get_data_m()
    {
        $id = $_GET['id'];
        $data = $this->Model_project->get_data_m($id);
        echo json_encode($data);
    }

    //menampilkan modul untuk tambah pelaksana 
    public function tampilModul()
    {
        $id = $_GET['id'];
        $modul = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $id);
        echo "  <option selected disabled>-Silahkan Pilih-</option>";
        foreach ($modul->result() as $w) {
            echo "<option  value='" . $w->id_x_aplikasi . "'>" . $w->nama_modul . "</option>";
        }
    }

    //tambah pelaksana modul
    public function tambahPelaksanaModul()
    {
        $idx = $_POST['idx'];
        $id_pelaksana = $_POST['id_pelaksana'];
        $user = $this->db->get_where('user', 'id = ' . $id_pelaksana)->row_array();
        $data1 = array(
            'id_x_aplikasi' => $idx,
            'id_pelaksana' => $id_pelaksana,
            'nama_pelaksana' => $user['nama']
        );
        $table = 'x_pelmodul';
        $data = $this->Model_project->tambah($table, $data1);
        echo json_encode($data);
    }

    //hapus pelaksana modul
    public function hapusPelaksanaModul()
    {
        $id = $_GET['id'];
        $cek = $this->db->delete('x_pelmodul', 'id_xPel = ' . $id);
        echo json_encode($cek);
    }

    //tampil pelaksana di halaman
    public function pro()
    {
        $id = $_GET['id'];
        $modul = $_GET['modul'];
        $id_project = $_GET['id_project'];
        $this->db->join('user', 'user.id = x_pelaksana.id_pelaksana');
        $pel = $this->db->get_where('x_pelaksana', ['id_project' => $id_project, 'status' => 4]);
        foreach ($pel->result() as $p) {
            $cek = $this->db->get_where('x_pelmodul', ['id_x_aplikasi' => $modul, 'id_pelaksana' => $p->id_pelaksana]);
            if ($cek->num_rows() > 0) {
            } else {
                echo "<option value='" . $p->id . "'>" . $p->nama . "</option>";
            }
        }
    }


    //halaman durasi
    //tampilan list durasi
    public function listDurasi()
    {
        $this->db->where('status <', 3);
        $this->db->order_by('id', 'DESC');
        $data['project'] = $this->db->get('project');
        $data['modul'] = $this->db->get('modul');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('project/list_durasi', $data);
        $this->load->view('template/footer');
    }

    public function durasi()
    {
        $id = $_GET['id'];
        $data = $this->db->get_where('x_aplikasi', 'id_aplikasi =' . $id);
        $no = 1;
        foreach ($data->result() as $we) {
            echo "<tr>
                    <td>" . $no++ . "</td>
                    <td>" . $we->nama_modul . "</td>";
            $dur = $this->db->get_where('durasi', 'id_x_aplikasi =' . $we->id_x_aplikasi)->row_array();
            if ($dur) {
                echo "   <td>" . $dur['durasi'] . " hari</td>
                    <td>" . $dur['mulai'] . "</td>
                    <td>" . $dur['selesai'] . "</td>
                    <td><button class='btn btn-sm btn-warning' onclick='edit(" . $dur['id_durasi'] . ")'>Edit</button>  
                    <button onclick='hapus(" . $dur['id_durasi'] . ")' class='btn btn-sm btn-danger'>Hapus</button></td>
                   </tr>";
            } else {
                echo "<td></td>
                <td></td>
                <td></td>
                <td><button class='btn btn-sm btn-success' onclick='tambah(" . $we->id_x_aplikasi . ")'>Tambah Durasi</button></td>
                </tr>";
            }
        }
    }

    public function get_durasi()
    {
        $id = $_GET['id'];
        $data = $this->Model_project->get_durasi($id);
        echo  json_encode($data);
    }

    public function tambahDurasi()
    {
        $id = $_POST['id'];
        $durasi = $_POST['durasi'];
        $mulai = $_POST['mulai'];
        $date = new DateTime($mulai);
        $date2 = $date->add(new DateInterval('P' . $durasi . 'D'));
        $cek = $date2->format('Y-m-d');


        $data1 = array(
            'id_x_aplikasi' => $id,
            'durasi' => $durasi,
            'mulai' => $mulai,
            'selesai' => $cek
        );


        $table = 'durasi';
        $data = $this->Model_project->tambah($table, $data1);
        echo json_encode($data);
    }

    public function get_durasi1()
    {
        $id = $_GET['id'];
        $data = $this->Model_project->get_durasi1($id);
        echo  json_encode($data);
    }

    public function updateDurasi()
    {
        $id = $_POST['id'];
        $durasi = $_POST['durasi'];
        $mulai  = $_POST['mulai'];
        $date = new DateTime($mulai);
        $date2 = $date->add(new DateInterval('P' . $durasi . 'D'));
        $cek = $date2->format('Y-m-d');
        $data = array(
            'durasi' => $durasi,
            'mulai' => $mulai,
            'selesai' => $cek
        );

        $kirim = $this->Model_project->updateDurasi($id, $data);
        echo json_encode($kirim);
    }

    public function hapusDurasi()
    {
        $id = $_GET['id'];
        $cek = $this->db->delete('durasi', 'id_durasi = ' . $id);
        echo json_encode($cek);
    }
}
