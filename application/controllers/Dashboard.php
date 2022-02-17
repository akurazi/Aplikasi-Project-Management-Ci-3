<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
        $data['project'] = $this->Model_project->hitungProject();
        $data['modul'] = $this->Model_project->hitungModul();
        $data['sub'] = $this->Model_project->hitungSub();
        $this->db->order_by('id', 'DESC');
        $data['history'] = $this->db->get('history', 5);
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard', $data);
        $this->load->view('template/footer');
    }

    public function test()
    {
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('welcome_message');
        $this->load->view('template/footer');
    }
}
