<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <h2>Menu Management</h2>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-md btn-success" data-toggle="modal" data-target="#ModalaAdd">Tambah Menu</button>

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
                                        <th>Nama Menu</th>
                                        <th>Link</th>
                                        <th>Icon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($menu->result() as $p) :
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $p->nama_menu ?></td>
                                            <td><?= $p->link ?></td>
                                            <td><?= $p->icon ?></td>
                                            <td>
                                                <a href="javascript:;" data="<?= $p->id_menu ?>" class="btn btn-sm btn-warning item-edit"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="<?= base_url('Setting/hapusMenu' . $p->id_menu) ?>" class="btn btn-sm btn-danger" onclick="return confirm(' Anda Yakin ingin Menghapus Data ini?')"><i class="fa fa-trash"></i> Hapus</a>
                                            </td>
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
<!-- Modal Add -->
<div class="modal fade" id="ModalaAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Menu </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-tag"></i></div>
                        </div>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Menu">
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-link"></i></div>
                        </div>
                        <input type="text" class="form-control" id="link" name="link" placeholder="Nama Link">
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-circle"></i></div>
                        </div>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="icon Menu">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal add -->

<!-- MODAL EDIT -->
<div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">Edit Menu</h3>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-tag"></i></div>
                        </div>
                        <input type="text" class="form-control" id="nama_edit" name="nama_edit" placeholder="Nama Menu">
                        <input type="hidden" name="id_edit" id="id_edit">
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-link"></i></div>
                        </div>
                        <input type="text" class="form-control" id="link_edit" name="link_edit" placeholder="Nama Link">
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-circle"></i></div>
                        </div>
                        <input type="text" class="form-control" id="icon_edit" name="icon_edit" placeholder="icon Menu">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->


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
            "aoColumns": [{
                    sWidth: '2%'
                },
                {
                    sWidth: '25%'
                },
                {
                    sWidth: '5%'
                },
                {
                    sWidth: '15%'
                },
                {
                    sWidth: '15%'
                }
            ]
        });
        tutup();
    });

    $('#btn_simpan').on('click', function() {
        var nama = $('#nama').val();
        var link = $('#link').val();
        var icon = $('#icon').val();
        var sub = $('#menuu').val();


        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Setting/tambah') ?>",
            dataType: "JSON",
            data: {
                nama: nama,
                link: link,
                icon: icon,
                sub: sub
            },
            success: function(data) {
                $('[name="nama"]').val("");
                $('#ModalaAdd').modal('hide');
                location.reload();
            }
        });
        return false;
    });

    $('.item-edit').on('click', function() {
        var id = $(this).attr('data');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Setting/get_menu') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#ModalaEdit').modal('show');
                    $('[name="id_edit"]').val(data.id);
                    $('[name="nama_edit"]').val(data.nama);
                    $('[name="link_edit"]').val(data.link);
                    $('[name="icon_edit"]').val(data.icon);
                });
            }
        });
        return false;
    });

    //update data modul 
    $('#btn_update').on('click', function() {
        var id = $('#id_edit').val();
        var nama = $('#nama_edit').val();
        var link = $('#link_edit').val();
        var icon = $('#icon_edit').val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Setting/updateMenu') ?>",
            dataType: "JSON",
            data: {
                id: id,
                nama: nama,
                link: link,
                icon: icon
            },
            success: function(data) {
                $('[name="id_edit"]').val("");
                $('[name="nama_edit"]').val("");
                $('#ModalaEdit').modal('hide');
                alert('Perubahan Data berhasil');
                location.reload();
            }
        });
        return false;

    });
</script>