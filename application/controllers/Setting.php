<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function index()
    {
    }


    //halaman menu
    public function menu()
    {
        $data['menu'] = $this->db->get_where('menu', 'is_main =0');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('setting/list_menu', $data);
        $this->load->view('template/footer1');
    }

    public function tambah()
    {
        $nama = $this->input->post('nama');
        $link = $this->input->post('link');
        $icon = $this->input->post('icon');
        $table = 'menu';
        $data1 = array('nama_menu' => $nama, 'link' => $link, 'icon' => $icon);
        $data = $this->Model_requirement->tambah($table, $data1);
        echo json_encode($data);
    }

    public function get_menu()
    {
        $id = $this->input->get('id');
        $data = $this->Model_requirement->get_menu($id);
        echo json_encode($data);
    }

    public function updateMenu()
    {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $link = $_POST['link'];
        $icon = $_POST['icon'];
        $data = $this->Model_requirement->updateMenu($id, $nama, $link, $icon);
        echo json_encode($data);
    }

    public function hapusMenu($id)
    {
        $this->db->delete('menu', 'id_menu = ' . $id);
        redirect('Setting/Menu');
    }

    //end menu

    //halaman sub menu
    public function submenu()
    {
        $data['menuu']       = $this->db->get_where('menu', 'is_main =0');
        $data['submenu']    = $this->db->get_where('menu', 'is_main !=0 ');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('setting/list_submenu', $data);
        $this->load->view('template/footer1');
    }

    public function tambahSub()
    {
        $nama = $this->input->post('nama');
        $link = $this->input->post('link');
        $icon = $this->input->post('icon');
        $menu = $this->input->post('menu');
        $table = 'menu';
        $data1 = array('nama_menu' => $nama, 'link' => $link, 'icon' => $icon, 'is_main' => $menu);
        $data = $this->Model_requirement->tambah($table, $data1);
        echo json_encode($data);
    }

    public function get_submenu()
    {
        $id = $this->input->get('id');
        $data = $this->Model_requirement->get_submenu($id);
        echo json_encode($data);
    }

    public function updateSubmenu()
    {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $link = $_POST['link'];
        $icon = $_POST['icon'];
        $menu = $_POST['menu'];
        $data = $this->Model_requirement->updateSubmenu($id, $nama, $link, $icon, $menu);
        echo json_encode($data);
    }

    public function hapusSubmenu($id)
    {
        $this->db->delete('sub_menu', 'id_submenu =' . $id);
        redirect('Setting/submenu');
    }
    //end  sub menu

    public function rule()
    {
        $data['level'] = $this->db->get('level_user');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('setting/rule', $data);
        $this->load->view('template/footer');
    }

    public function get_rule()
    {
        $id = $_GET['id'];
        $menu = $this->db->get_where('menu', 'is_main = 0');
        foreach ($menu->result() as $me) {
            echo "
                <tr>
                    <td><b>" . $me->nama_menu . "</td>
                    <td>" . $me->link . "</td>
                    <td align='center'><input type='checkbox' ";
            $this->check_akses($id, $me->id_menu);
            echo " onclick='addMenu($me->id_menu)'></td>
                        </tr>";
            $sub = $this->db->get_where('menu', 'is_main =' . $me->id_menu);
            foreach ($sub->result() as $su) {
                echo "<tr>
                        <td>" . $su->nama_menu . "</td>
                        <td>" . $su->link . "</td>
                        <td align='center'><input type='checkbox' ";
                $this->check_akses($id, $su->id_menu);
                echo " onclick='addRule($su->id_menu)'></td>
                    </tr>";
            }
        }
    }

    public function  check_akses($level, $menu)
    {
        $data = array('id_level' => $level, 'id_menu' => $menu);
        $chek = $this->db->get_where('x_rule', $data);
        if ($chek->num_rows() > 0) {
            echo "checked";
        }
    }

    function addrule()
    {
        $level_user = $_GET['level_user'];
        $id_menu    = $_GET['id_menu'];
        $data       = array('id_level' => $level_user, 'id_menu' => $id_menu);
        $chek       = $this->db->get_where('x_rule', $data);
        if ($chek->num_rows() < 1) {
            $main = $this->db->get_where('menu', 'id_menu =' . $id_menu)->row_array();
            $data1 = ['id_level' => $level_user, 'id_menu' => $main['is_main']];
            $this->db->insert('x_rule', $data1);
            $this->db->insert('x_rule', $data);
            echo "berhasil memberikan akses menu";
        } else {
            $this->db->where('id_menu', $id_menu);
            $this->db->where('id_level', $level_user);
            $this->db->delete('x_rule');
            echo " berhasil delete akses menu";
        }
    }

    function addmenu()
    {
        $level = $_GET['level_user'];
        $id_menu = $_GET['id_menu'];
        $menu =  $this->db->get_where('menu', 'is_main =' . $id_menu)->result();
        foreach ($menu as $me) {
            $data = array('id_level' => $level, 'id_menu' => $me->id_menu);
            $chek       = $this->db->get_where('x_rule', $data);
            if ($chek->num_rows() < 1) {
                $this->db->insert('x_rule', $data);
            } else {
                $this->db->where('id_menu', $me->id_menu);
                $this->db->where('id_level', $level);
                $this->db->delete('x_rule');
            }
        }
        $data1 = ['id_level' => $level, 'id_menu' => $id_menu];
        $chek1       = $this->db->get_where('x_rule', $data1);
        if ($chek1->num_rows() < 1) {

            $this->db->insert('x_rule', $data1);
        } else {
            $this->db->where('id_menu', $id_menu);
            $this->db->where('id_level', $level);
            $this->db->delete('x_rule');
        }
    }
}
