<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <h2>Project Management</h2>
                </div>
                <div class="col-md-2">
                    <a href="<?= base_url() ?>Project/add" class="btn btn-primary">New Project</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered" id="example1">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Project</th>
                                        <th>Jenis Project</th>
                                        <th>Produk</th>

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($project->result() as $p) :
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $p->nama_project ?></td>
                                            <td><?= $p->jenis_project ?></td>
                                            <td><?= $p->nama_aplikasi ?></td>
                                            <td align="center">
                                                <?php
                                                if ($p->status == 1 || $p->status == 2) {
                                                    echo '<div class="badge badge-danger text-wrap text-center" style="width: 6rem; height:2rem; ">
                                                    ' . $p->nama . '</div>';
                                                } else  if ($p->status == 3 || $p->status == 4) {
                                                    echo '<div class="badge badge-warning text-wrap text-center" style="width: 6rem; height:2rem;">
                                                    ' . $p->nama . '</div>';
                                                } else  if ($p->status == 5 || $p->status == 6) {
                                                    echo '<div class="badge badge-success text-wrap text-center" style="width: 6rem; height:2rem;">
                                                    ' . $p->nama . '</div>';
                                                } ?>

                                            </td>
                                            <td><a href="<?= base_url('Project/detail/' . $p->id) ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a> <a href="<?= base_url('Project/edit/' . $p->id) ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a> <a href="<?= base_url('Project/delete/' . $p->id) ?>" onclick="return confirm('Apakah Data Ingin Dihapus...?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    <?php $no++;
                                    endforeach; ?>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example1').DataTable({
            "responsive": true,
            "autoWidth": false,
            "columnDefs": [{
                    "targets": [1, 2, 3, 4, -1],
                    "classname": 'text-center'
                },
                {
                    "targets": [4, -1],
                    "orderable": false
                }
            ]
        });
    });
</script>