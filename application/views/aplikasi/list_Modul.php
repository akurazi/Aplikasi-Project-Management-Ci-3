<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Modul</h4>
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalaAdd">Tambah Modul</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <th>#</th>
                                    <th>Nama Modul</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($modul->result() as $a) : ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $a->nama_modul ?></td>
                                            <td><a href="javascript:;" data="<?= $a->id_modul ?>" class="btn btn-sm btn-warning item-edit"><i class="fa fa-edit"></i></a> <a href="<?= base_url('Aplikasi/deleteModul/') . $a->id_modul ?>" onclick="return confirm('Apakah Data Ingin Dihapus...?')" class="btn btn-sm btn-danger item-hapus"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    <?php $no++;
                                    endforeach; ?>
                                <tbody>
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
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Modul </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input name="nama" id="nama" class="form-control" type="text" placeholder="Nama Modul" required>
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
                <h3 class="modal-title" id="myModalLabel">Edit Modul</h3>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Modul</label>
                        <div class="col-xs-9">
                            <input type="hidden" name="id_edit" id="id_edit">
                            <input name="nama_edit" id="nama_edit" class="form-control" type="text">
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

<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
    //Tambah
    $('#btn_simpan').on('click', function() {
        var nama = $('#nama').val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Aplikasi/addModul') ?>",
            dataType: "JSON",
            data: {
                nama: nama,
            },
            success: function(data) {
                $('[name="nama"]').val("");
                $('#ModalaAdd').modal('hide');
                location.reload();
            }
        });
        return false;
    });


    //GET data  modul untuk di edit
    $('.item-edit').on('click', function() {
        var id = $(this).attr('data');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Aplikasi/get_dataModul') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#ModalaEdit').modal('show');
                    $('[name="id_edit"]').val(data.id);
                    $('[name="nama_edit"]').val(data.nama);
                });
            }
        });
        return false;
    });

    //update data modul 
    $('#btn_update').on('click', function() {
        var id = $('#id_edit').val();
        var nama = $('#nama_edit').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Aplikasi/updateModul') ?>",
            dataType: "JSON",
            data: {
                id: id,
                nama: nama
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
</script>