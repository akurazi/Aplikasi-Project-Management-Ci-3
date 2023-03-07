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
                $hal1 = $this->uri->segment(1);
                $hal2 = $this->uri->segment(2);
                $id = $this->session->userdata("status");
                $q = "SELECT * FROM menu WHERE id_menu in(select id_menu from x_rule where id_level= $id) and is_main=0";
                $menu = $this->db->query($q);
                foreach ($menu->result() as $m) :
                    $this->db->select('a.nama_menu, a.link, a.icon');
                    $this->db->from('menu a');
                    $this->db->join('x_rule b', 'b.id_menu = a.id_menu');
                    $this->db->where('b.id_level', $id);
                    $this->db->where('a.is_main', $m->id_menu);
                    $submenu = $this->db->get();
                    if ($submenu->num_rows() > 0) { ?>
                        <li class="nav-item has-treeview <?= ($hal1 == $m->link) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= ($hal1 == $m->link) ? 'active' : '' ?>">
                                <i class="nav-icon <?= $m->icon ?>"></i>
                                <p>
                                    <?= $m->nama_menu ?> <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php foreach ($submenu->result() as $s) : ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url($m->link . '/' . $s->link) ?>" class="nav-link <?= ($hal2 == $s->link) ? 'active' : '' ?>">
                                            <i class="nav-icon <?= $s->icon ?>"></i>
                                            <p><?= $s->nama_menu ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?= base_url($m->link) ?>" class="nav-link <?= ($hal1 == $m->link) ? 'active' : '' ?>">
                                <i class="nav-icon <?= $m->icon ?>"></i>
                                <p>
                                    <?= $m->nama_menu ?>
                                </p>
                            </a>
                        </li>
                <?php }
                endforeach; ?>
                <!-- batas if -->
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