<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= base_url('assets'); ?>/img/durio.png" alt="Durio Indigo Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Durio Indigo</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php
                $hal = $this->uri->segment(1);
                $id = $this->session->userdata("id_user");
                $q = "SELECT * FROM menu WHERE id_menu in(select id_menu from x_rule where id_level= $id) and is_main=0";
                $menu = $this->db->query($q);
                foreach ($menu->result() as $m) :
                    $this->db->select('a.nama_menu, a.link, a.icon');
                    $this->db->from('menu a');
                    $this->db->join('x_rule b', 'b.id_menu = a.id_menu');
                    $this->db->where('b.id_level', $id);
                    $this->db->where('a.is_main', $m->id_menu);
                    $submenu = $this->db->get();
                ?>
                    <li class="nav-item has-treeview 
                    <?php if ($m->link == $hal) {
                        echo "menu-open";
                    } ?>">
                        <a href="<?= base_url($m->link) ?>" class="nav-link <?php if ($m->link == $hal) {
                                                                                echo "active";
                                                                            } ?>">
                            <i class="nav-icon <?= $m->icon ?>"></i>
                            <p>
                                <?= $m->nama_menu ?>
                                <?php
                                if ($submenu->num_rows() > 0) { ?>
                                    <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php foreach ($submenu->result() as $sub) : ?>
                                <li class="nav-item">
                                    <a href="<?= base_url($sub->link) ?>" class="nav-link">
                                        <i class="nav-icon <?= $sub->icon ?>"></i>
                                        <p>
                                            <?= $sub->nama_menu ?>
                                        </p>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php } ?>
                    </p>
                    </a>
                    </li>

                <?php endforeach; ?>
                <li class="nav-item">
                    <a href="<?= base_url('Auth/logout') ?>" class="nav-link">
                        <i class="nav-icon fa fa-sign-out-alt"></i>
                        <p>
                            Log Out
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>