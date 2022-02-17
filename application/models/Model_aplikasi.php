<?php
class Model_aplikasi extends CI_Model
{
    function tambah($table, $data1)
    {
        return $hasil = $this->db->insert($table, $data1);
    }

    function get_data($id)
    {
        $has = $this->db->get_where('base_aplikasi', 'id_bAplikasi =' . $id)->result();
        foreach ($has as $e) {
            $hasil = array(
                'id'    => $e->id_bAplikasi,
                'nama'  => $e->nama_aplikasi,
            );
        }
        return $hasil;
    }


    function update($id, $nama)
    {
        $this->db->where('id_bAplikasi', $id);
        return $hasil = $this->db->update('base_aplikasi', array('nama_aplikasi' => $nama));
    }

    //Halaman Modul
    function get_dataModul($id)
    {
        $has = $this->db->get_where('modul', 'id_modul =' . $id)->result();
        foreach ($has as $e) {
            $hasil = array(
                'id'    => $e->id_modul,
                'nama'  => $e->nama_modul,
            );
        }
        return $hasil;
    }

    function updateModul($id, $nama)
    {
        $this->db->where('id_modul', $id);
        return $hasil = $this->db->update('modul', array('nama_modul' => $nama));
    }

    function get_data_m($id)
    {
        $this->db->select('*');
        $this->db->from('aplikasi');
        $this->db->join('project', 'project.id = aplikasi.id_project');
        $this->db->where('aplikasi.id_aplikasi =' . $id);
        $has = $this->db->get()->result();
        foreach ($has as $e) {
            $hasil = array(
                'id'    => $id,
                'nama_project' => $e->nama_project,
                'nama_aplikasi'  => $e->nama_aplikasi
            );
        }
        return $hasil;
    }
    //End Halaman Modul



    //halaman Sub Modul
    function get_data_modul($id)
    {
        $this->db->join('aplikasi', 'aplikasi.id_aplikasi = x_aplikasi.id_aplikasi');
        $this->db->join('modul', 'modul.id_modul = x_aplikasi.id_modul');
        $has = $this->db->get_where('x_aplikasi', 'id_x_aplikasi =' . $id)->result();
        foreach ($has as $e) {
            $hasil = array(
                'id'    => $e->id_x_aplikasi,
                'nama'  => $e->nama_aplikasi,
                'nama_modul' => $e->nama_modul

            );
        }
        return $hasil;
    }

    function get_data_submodul($id)
    {
        $has = $this->db->get_where('base_submodul', 'id_bSub =' . $id)->result();
        foreach ($has as $e) {
            $hasil = array(
                'id'    => $e->id_bSub,
                'nama'  => $e->nama_sub,
            );
        }
        return $hasil;
    }

    function updateSubModul($id, $nama)
    {
        $this->db->where('id_bSub', $id);
        return $hasil = $this->db->update('base_submodul', array('nama_sub' => $nama));
    }

    //end sub Mdul

}
