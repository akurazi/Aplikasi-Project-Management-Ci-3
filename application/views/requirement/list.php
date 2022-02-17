<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10">
                    <h2>Requirement</h2>
                </div>
                <div class="col-2">
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus"></span> Requirement</a>
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
                                        <th>Requirement</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($project->result() as $p) :
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $p->nama_requirement ?></td>
                                            <td><a href="<?= base_url('Project/detail/' . $p->id_requirement) ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a> <a href="javascript:;" data="<?= $p->id_requirement ?>" class="btn btn-sm btn-warning item-edit"><i class="fa fa-edit"></i></a> <a href="<?= base_url('Requirement/delete/' . $p->id_requirement) ?>" onclick="return confirm('Apakah Data Ingin Dihapus...?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
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
<!-- MODAL ADD -->
<div class="modal fade" id="ModalaAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Requirement </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Requirement</label>
                        <div class="col-xs-9">
                            <input name="nama" id="nama" class="form-control" type="text" placeholder="Kode Barang" style="width:335px;" required>
                        </div>
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
<!--END MODAL ADD-->


<!-- MODAL EDIT -->
<div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">Edit Requirement</h3>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama</label>
                        <div class="col-xs-9">
                            <input type="hidden" name="id_edit" id="id_edit">
                            <input name="nama_edit" id="nama_edit" class="form-control" type="text" placeholder="Nama">
                        </div>
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

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Hapus Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin mau memhapus pelaksana ini?</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL HAPUS-->

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
        });
    });
</script>
<script type="text/javascript">
    //Tambah
    $('#btn_simpan').on('click', function() {
        var nama = $('#nama').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Requirement/tambah') ?>",
            dataType: "JSON",
            data: {
                nama: nama,

            },
            success: function(data) {
                console.log('berhasil');
                $('[name="nama"]').val("");
                $('#ModalaAdd').modal('hide');
                location.reload();
            }
        });
        return false;
    });

    //update
    $('#btn_update').on('click', function() {
        var id = $('#id_edit').val();
        var nama = $('#nama_edit').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Requirement/update') ?>",
            dataType: "JSON",
            data: {
                id: id,
                nama: nama,
            },
            success: function(data) {
                $('[name="id_edit"]').val("");
                $('[name="nama_edit"]').val("");
                $('#ModalaEdit').modal('hide');
                location.reload();
            }
        });
        return false;
    });

    //GET UPDATE
    $('.item-edit').on('click', function() {
        var id = $(this).attr('data');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Requirement/get_data') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama) {
                    $('#ModalaEdit').modal('show');
                    $('[name="id_edit"]').val(data.id);
                    $('[name="nama_edit"]').val(data.nama_requirement);
                });
            }
        });
        return false;
    });

    //GET HAPUS
    $('.item-hapus').on('click', function() {
        var id = $(this).attr('data');
        $('#ModalHapus').modal('show');
        $('[name="kode"]').val(id);
    });

    //Hapus Barang
    $('#btn_hapus').on('click', function() {
        var kode = $('#textkode').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Pelaksana/hapus') ?>",
            dataType: "JSON",
            data: {
                kode: kode
            },
            success: function(data) {
                $('#ModalHapus').modal('hide');
                location.reload();
            }
        });
        return false;
    });
</script>