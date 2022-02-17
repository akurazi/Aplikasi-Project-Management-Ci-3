<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jobdesk extends CI_Controller
{
    public function index()
    {
        $user = $this->session->userdata('id_user');

        $this->db->join('project', 'project.id = x_pelaksana.id_project');
        $this->db->join('aplikasi', 'aplikasi.id_project = project.id');
        $data['project'] = $this->db->get_where('x_pelaksana', 'id_pelaksana = ' . $user);
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('jobdesk/list', $data);
        $this->load->view('template/footer1');
    }

    function detail()
    {
        $user = $this->session->userdata('id_user');
        $id = $this->uri->segment(3);
        $this->db->join('aplikasi', 'aplikasi.id_project = project.id');
        $data['cek'] = $this->db->get_where('project', 'id = ' . $id)->row();
        $this->db->join('x_pelmodul', 'x_pelmodul.id_x_aplikasi = x_aplikasi.id_x_aplikasi');
        $this->db->where('id_pelaksana', $user);
        $data['modul'] = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $data['cek']->id_aplikasi);
       
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('jobdesk/detail', $data);
        $this->load->view('template/footer');
    }

    function updateStatus()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $id_user = $this->input->post('id_user');
        $history = "Mengubah Status";
        $data = $this->Model_requirement->updateStatus($id, $status, $history, $id_user);
        echo json_encode($data);
    }

    function updateKeterangan()
    {
        $id = $this->input->post('id');
        $keterangan = $this->input->post('keterangan');
        $id_user = $this->input->post('id_user');
        $history = "Memberikan Keterangan";
        $data = $this->Model_requirement->updateKeterangan($id, $keterangan, $history, $id_user);
        echo json_encode($data);
    }
}
