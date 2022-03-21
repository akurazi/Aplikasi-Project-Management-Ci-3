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
        $data['akan'] = $this->Model_project->akan()->result();
        $data['sedang'] = $this->Model_project->sedang()->result();
        $data['selesai'] = $this->Model_project->selesai()->result();
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

    public function wik()
    {
        $prefs['template'] = array(
            'table_open'           => '<table class="calendar">',
            'cal_cell_start'       => '<td class="day">',
            'cal_cell_start_today' => '<td class="today">'
        );

        $this->load->library('calendar', $prefs);

        echo $this->calendar->generate();
    }
}
