<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Requirement extends CI_Controller
{
    public function index()
    {

        $data['project'] = $this->db->get('requirement');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('requirement/list', $data);
        $this->load->view('template/footer1');
    }

    public function tambah()
    {
        $requirement = $this->input->post('nama');
        $data = $this->Model_requirement->save($requirement);
        echo json_encode($data);
    }

    public function get_data()
    {
        $id = $this->input->get('id');
        $data = $this->Model_requirement->get_data($id);
        echo json_encode($data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $data = $this->Model_requirement->update($id, $nama);
        echo json_encode($data);
    }

    public function delete()
    {
        $id = $this->uri->segment(3);
        $this->Model_requirement->delete($id);
        redirect('Requirement');
    }
}
