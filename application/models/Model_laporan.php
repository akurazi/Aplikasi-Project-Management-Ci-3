<?php
class Model_laporan extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    function project($id = NULL)
    {
        if ($id != null) {
            $project = $this->db->get_where('project', 'id =' . $id);
        } else {
            $project = $this->db->get('project');
        }
        return $project;
    }

    function aplikasi($de = NULL)
    {
        if ($de != NULL) {
            $a = $this->db->get_where('aplikasi', 'id_project = ' . $de);
        } else {
            $a = $this->db->get('aplikasi');
        }
        return $a;
    }



    function modul($q = NULL)
    {
        if ($q != NULL) {
            $mod = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $q);
        } else {
            $mod = $this->db->get('x_aplikasi');
        }
        return $mod;
    }

    function pelaksana($id, $d)
    {
        $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
        $this->db->where('pelaksana.jabatan = "' . $d . '"');
        $pen = $this->db->get_where('x_pelaksana', 'id_project =' . $id);
        return $pen;
    }

    function pelaksanaa($id = NULL)
    {
        if ($id != NULL) {
            $pelaksana = $this->db->get_where('pelaksana', ['id_pelaksana' => $id, 'jabatan' => 'programmer']);
        } else {
            $pelaksana = $this->db->get_where('pelaksana', 'jabatan = "programmer"');
        }
        return $pelaksana;
    }

    function pro($id)
    {
        $this->db->join('project', 'project.id = x_pelaksana.id_project');
        $this->db->join('aplikasi', 'aplikasi.id_project = project.id');
        return  $this->db->get_where('x_pelaksana', 'id_pelaksana = ' . $id);
    }
}
