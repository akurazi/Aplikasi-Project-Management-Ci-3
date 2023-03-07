<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pelaksana extends CI_Controller
{
    public function index()
    {
    }

    public function list($user)
    {

        $data['level'] = $this->db->get_where('level_user', 'id_level != 1');
        $this->db->join('level_user', 'level_user.id_level = user.status');
        $this->db->where('level_user.nama_level', $user);
        $data['user'] = $this->db->get_where('user');

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pelaksana/list', $data);
        $this->load->view('template/footer1');
    }

    public function tambah()
    {
        $nama = $this->input->post('nama');
        $jabatan = $this->input->post('jabatan');
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $table = "user";
        $data1 = [
            'email' => $email,
            'password'  => $password,
            'nama'      => $nama,
            'status'    => $jabatan
        ];

        $data = $this->Model_project->savee($data1, $table);
    }

    public function update()
    {
        if ($this->input->post('password')) {
            $data1 = [
                'email' => $this->input->post('email'),
                'password'  => md5($this->input->post('password')),
                'nama'      => $this->input->post('nama'),
                'status'    => $this->input->post('jabatan')
            ];
        } else {
            $data1 = [
                'email' => $this->input->post('email'),
                'nama'      => $this->input->post('nama'),
                'status'    => $this->input->post('jabatan')
            ];
        }
        $id = $this->input->post('id');
        $table = "user";
        $data = $this->Model_project->update($data1, $table, $id);
        echo json_encode($data);
    }

    public function get_data()
    {
        $id = $this->input->get('id');
        $data = $this->Model_project->get_data($id);
        echo json_encode($data);
    }

    public function hapus()
    {
        $kode = $this->input->post('kode');
        $data = $this->Model_project->deletee($kode);
        echo json_encode($data);
    }

    public function get_data_p()
    {
        $id = $this->input->get('id');
        $data = $this->Model_project->get_data_p($id);
        echo json_encode($data);
    }


    public function hapusSub()
    {
        $s = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $this->db->delete('x_pelaksana', 'id_x_pelaksana = ' . $id);
        redirect('Pelaksana/list/' . $s);
    }
}
