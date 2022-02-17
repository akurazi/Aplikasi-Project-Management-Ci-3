<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $this->load->view('login');
    }
    function checkLogin()
    {
        $email = $this->input->post('email');
        $a = md5($this->input->post('password'));
        $user = $this->db->get_where('user', array('email' => $email, 'password' => $a))->row_array();
        if (!empty($user)) {
            $data_session = array(
                'id_user' => $user['id'],
                'nama'  => $user['nama'],
                'status'    => $user['status']
            );
            $this->session->set_userdata($data_session);
            redirect('Dashboard');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Login Gagal!</div>');
            redirect('auth');
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kamu Sudah Logout!</div>');
        redirect('auth');
    }
}
