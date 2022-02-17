<?php
class Model_requirement extends CI_Model
{

    function updateStatus($id, $status, $history, $id_user)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data1 = array('history' => $history, 'id_sub' => $id, 'id_user' => $id_user, 'update_at' => mdate('%Y-%m-%d %H:%i:%s', now()));
        $this->db->insert('history', $data1);
        $data = array('status' =>  $status);
        $this->db->where('id_sub', $id);
        return $this->db->update('sub_modul', $data);
    }

    function updateKeterangan($id, $keterangan,  $history, $id_user)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data1 = array('history' => $history, 'id_user' => $id_user, 'update_at' => mdate('%Y-%m-%d %H:%i:%s', now()), 'id_sub' => $id);
        $this->db->insert('history', $data1);
        $data = array('keterangan' => $keterangan, 'updated_at' => mdate('%Y-%m-%d %H:%i:%s', now()));
        $this->db->where('id_sub', $id);
        return $this->db->update('sub_modul', $data);
    }

    function save($requirement)
    {
        return $hasil = $this->db->insert('requirement', array('nama_requirement' => $requirement));
    }

    function get_data($id)
    {
        $has = $this->db->get_where('requirement', 'id_requirement = ' . $id)->result();
        foreach ($has as $c) {
            $hasil = array(
                'id'        => $c->id_requirement,
                'nama_requirement' => $c->nama_requirement
            );
        }
        return $hasil;
    }



    function tambah($table, $data1)
    {
        return $hasil = $this->db->insert($table, $data1);
    }

    function get_menu($id)
    {
        $has = $this->db->get_where('menu', 'id_menu = ' . $id)->result();
        foreach ($has as $c) {
            $hasil = array(
                'id'        => $c->id_menu,
                'nama' => $c->nama_menu,
                'link' => $c->link,
                'icon' => $c->icon
            );
        }
        return $hasil;
    }

    function updateMenu($id, $nama, $link, $icon)
    {
        $da = array(
            'nama_menu' => $nama,
            'link' => $link,
            'icon' => $icon
        );

        $this->db->where('id_menu', $id);
        return $this->db->update('menu', $da);
    }

    function get_submenu($id)
    {
        $has = $this->db->get_where('menu', 'id_menu = ' . $id)->result();
        foreach ($has as $c) {
            $hasil = array(
                'id'        => $c->id_menu,
                'nama' => $c->nama_menu,
                'link' => $c->link,
                'icon' => $c->icon,
                'menuu' => $c->is_main
            );
        }
        return $hasil;
    }

    function updateSubmenu($id, $nama, $link, $icon, $menu)
    {
        $da = array(
            'nama_menu' => $nama,
            'link' => $link,
            'icon' => $icon,
            'is_main' => $menu
        );

        $this->db->where('id_menu', $id);
        return $this->db->update('menu', $da);
    }
}
