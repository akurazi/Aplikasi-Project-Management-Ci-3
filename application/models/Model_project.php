<?php
class Model_project extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    //dashboard

    function akan()
    {
        $this->db->join('history_project', 'history_project.id_project = project.id');
        $this->db->join('user', 'user.id =  history_project.id_user');
        $this->db->group_by('id_project');
        return $this->db->get_where('project', 'project.status = 1');
    }

    function sedang()
    {
        $this->db->join('history_project', 'history_project.id_project = project.id');
        $this->db->join('user', 'user.id =  history_project.id_user');
        $this->db->group_by('id_project');
        return $this->db->get_where('project', array('project.status >' => 1, 'project.status < 6'));
    }

    function selesai()
    {
        $this->db->join('history_project', 'history_project.id_project = project.id');
        $this->db->join('user', 'user.id =  history_project.id_user');
        $this->db->group_by('id_project');
        return $this->db->get_where('project', 'project.status = 6');
    }

    function hitungProject()
    {
        $q = $this->db->get('project');
        return $jumlah = $q->num_rows();
    }

    function hitungModul()
    {
        $q = $this->db->get('modul');
        return $jumlah = $q->num_rows();
    }

    function hitungSub()
    {
        $q = $this->db->get('sub_modul');
        return $jumlah = $q->num_rows();
    }
    //end dashboard

    //pelaksana
    function savee($data1, $table)
    {

        $hasil = $this->db->insert($table, $data1);
        return $hasil;
    }

    //get data untuk edit pelaksana
    function get_data($id)
    {
        $this->db->join('level_user', 'level_user.id_level = user.status');
        $has = $this->db->get_where('user', 'id =' . $id)->result();
        foreach ($has as $e) {
            $hasil = array(
                'id'    => $e->id,
                'email' => $e->email,
                'password' => $e->password,
                'nama'  => $e->nama,
                'jabatan'   => $e->id_level
            );
        }
        return $hasil;
    }

    function update($data1, $table, $id)
    {

        $this->db->where('id', $id);
        $hasil = $this->db->update($table, $data1);
        return $hasil;
    }

    function deletee($kode)
    {
        return $this->db->delete('user', 'id = ' . $kode);
    }

    //get data untuk tambah pelaksana
    function get_data_p($id)
    {
        $has = $this->db->get_where('project', 'id = ' . $id)->result();
        foreach ($has as $e) {
            $hasil = array(
                'id'    => $e->id,
                'nama'  => $e->nama_project,
            );
        }
        return $hasil;
    }

    function penjab($id)
    {
        $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
        $this->db->where('id_project = ' . $id);
        $this->db->where('pelaksana.jabatan ="penjab"');
        $user = $this->db->get('x_pelaksana')->row();
        $hasil = array(
            'penjab' => $user->nama,
        );
        return $hasil;
    }


    //end pelaksana

    //get data pelaksana pada modul
    function get_data_m($id)
    {
        $this->db->join('aplikasi', 'aplikasi.id_aplikasi = x_aplikasi.id_aplikasi');
        $this->db->join('project', 'project.id = aplikasi.id_project');
        $has = $this->db->get_where('x_aplikasi', 'x_aplikasi.id_aplikasi = ' . $id)->result();

        //$has = $this->db->get()->result();
        foreach ($has as $e) {
            $hasil = array(
                'id'    => $e->id_aplikasi,
                'id_project'    => $e->id,
                'nama_project' => $e->nama_project,
                'nama_aplikasi'  => $e->nama_aplikasi,
                'nama_modul'    => $e->nama_modul
            );
        }
        return $hasil;
    }

    function tambahPelaksanaModul($id, $id_pelaksana)
    {
        $data = array(
            'id_pelaksana' => $id_pelaksana
        );
        $this->db->where('id_x_aplikasi', $id);
        $hasil = $this->db->update('x_aplikasi', $data);
        return $hasil;
    }

    //project
    function save()
    {
        $nama = $this->input->post('nama');
        $jenis = $this->input->post('jenis');
        $aplikasi = $this->input->post('aplikasi');
        $marketing = $this->input->post('marketing');
        $created = date('Y-m-d');

        //dapatkan nama aplikasi
        $d = $this->db->get_where('base_aplikasi', 'id_bAplikasi = ' . $aplikasi)->row_array();
        $nama_aplikasi = $d['nama_aplikasi'];
        //dapatkan id_project 
        $id = $this->db->query("SELECT id FROM project ORDER BY id DESC limit 1 ")->row_array();
        $tmp = $id['id'];
        $pro = $tmp + 1;

        //input ke tabel project
        $data = array(
            'nama_project'      => $nama,
            'jenis_project'     => $jenis,
            'marketing'         => $marketing,
            'created'           => $created
        );
        $this->db->insert('project', $data);

        //input ke tabel aplikasi
        $data1 = array(
            'nama_aplikasi' => $nama_aplikasi,
            'id_project' => $pro
        );
        $this->db->insert('aplikasi', $data1);
    }

    function edit()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $jenis = $this->input->post('jenis');
        $aplikasi = $this->input->post('aplikasi');
        $marketing = $this->input->post('marketing');

        $data = array(
            'nama_project'      => $nama,
            'jenis_project'     => $jenis,
            'marketing'         => $marketing
        );
        $this->db->where('id', $id);
        $this->db->update('project', $data);

        //update aplikasi
        $d = $this->db->get_where('base_aplikasi', 'id_bAplikasi = ' . $aplikasi)->row_array();
        $nama_aplikasi = $d['nama_aplikasi'];

        $data1 = array(
            'nama_aplikasi' => $nama_aplikasi,
        );

        $this->db->where('id_project', $id);
        $this->db->update('aplikasi', $data1);
    }

    function status($id, $status)
    {
        $data1 = array('status' => $status);
        $this->db->where('id', $id);
        $this->db->update('project', $data1);

        $data = array(
            'history' => 'Mengubah Status',
            'id_project' => $id,
            'id_user' => $this->session->userdata('id_user'),
        );

        $this->db->insert('history_project', $data);
    }

    function keterangan($id, $ket)
    {
        $data1 = array('keterangan' => $ket);
        $this->db->where('id', $id);
        $this->db->update('project', $data1);

        $data = array(
            'history' => 'Memberi Keterangan ' . $ket,
            'id_project' => $id,
            'id_user' => $this->session->userdata('id_user'),
        );

        $this->db->insert('history_project', $data);
    }

    function delete($id)
    {
        return $this->db->delete('project', 'id = ' . $id);
    }
    //end project

    function tambah($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    //kontrak
    //get kontrak untuk di edit
    function get_kontrak($id)
    {
        $this->db->join('project', 'project.id = kontrak.id_project');
        $wak = $this->db->get_where('kontrak', 'id_kontrak = ' . $id);
        foreach ($wak->result() as $q) {
            $hasil = array(
                'id' => $q->id_kontrak,
                'nama' => $q->nama_kontrak,
                'project' => $q->nama_project,
                'mulai'   => $q->mulai
            );
        }
        return $hasil;
    }

    //update kontrak
    function updateKontrak($id, $data1)
    {
        //$q = array('nama_kontrak' => $kontrak);
        $this->db->where('id_kontrak', $id);
        return $this->db->update('kontrak', $data1);
    }

    //get durasi
    function get_durasi($id)
    {
        $this->db->join('aplikasi', 'aplikasi.id_aplikasi = x_aplikasi.id_aplikasi');
        $has = $this->db->get_where('x_aplikasi', 'id_x_aplikasi =' . $id)->result();
        foreach ($has as $e) {
            $hasil = array(
                'id'    => $e->id_x_aplikasi,
                'nama_aplikasi' => $e->nama_aplikasi,
                'nama_modul'  => $e->nama_modul

            );
        }
        return $hasil;
    }


    function get_durasi1($id)
    {
        $this->db->join('x_aplikasi', 'x_aplikasi.id_x_aplikasi = durasi.id_x_aplikasi');
        $cek = $this->db->get_where('durasi', 'id_durasi =' . $id);
        foreach ($cek->result() as $g) {
            $hasil = array(
                'id' => $g->id_durasi,
                'durasi' => $g->durasi,
                'modul' => $g->nama_modul,
                'mulai' => $g->mulai
            );
        }
        return $hasil;
    }

    function updateDurasi($id, $data)
    {
        $this->db->where('id_durasi', $id);
        return $this->db->update('durasi', $data);
    }
}
