<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10">
                    <h2>Pelaksana</h2>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Project</h4>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Nama</label>
                                </div>
                                <select class="custom-select" id="project" name="project" onchange="loadDataa()">
                                    <option selected>Silahkan Pilih..</option>
                                    <?php
                                    foreach ($project->result() as $a) {
                                        echo "<option value='" . $a->id . "'>" . $a->nama_project . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pelaksana</h4>
                            <button class="btn btn-sm btn-success tambah">Tambah Pelaksana</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-borderless">
                                <tr>
                                    <td>Penanggung Jawab</td>
                                    <td id="penjab">
                                        <!-- .  <table id="penjab" border="0"></table> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>PIC</td>
                                    <td id="pic"></td>
                                </tr>
                                <tr>
                                    <td>Programmer</td>
                                    <td id="programmer"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
<!-- MODAL ADD Pelaksana -->
<div class="modal fade" id="ModalAddModul" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Pelaksana </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input type="hidden" name="id" id="id">
                            <input name="nama_project" id="nama_project" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <select class="custom-select jabatan" id="jabatan" name="jabatan">
                                <option selected>Silahkan Pilih..</option>
                                <?php foreach ($level->result() as $lev) {
                                    echo "<option value='" . $lev->id_level . "'>" . $lev->nama_level . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <select class="custom-select" id="nama" name="nama">
                                <option selected>Silahkan Pilih..</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_simpan_pel">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL ADD-->

<!-- MODAL HAPUS -->
<div class="modal fade" id="ModalHapus" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Hapus Pelaksana </h5>
                <input type="hidden" name="id" id="id">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tidak</button>
                <button class="btn btn-info" id="btn_del">Yakin</button>
            </div>
        </div>
    </div>
</div>
<!--END MODAL HAPUS-->

<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    //load pelaksana 
    function loadDataa() {
        var id = $("#project").val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/penjab',
            data: 'id=' + id,
            success: function(html) {
                $("#penjab").html(html);
            }
        });

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/pic',
            data: 'id=' + id,
            success: function(html) {
                $("#pic").html(html);
            }
        });

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/programmer',
            data: 'id=' + id,
            success: function(html) {
                $("#programmer").html(html);
            }
        });
    }

    $('.jabatan').on('change', function() {
        var id = $('#id').val();
        var jab = $('#jabatan').val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/pelaksana',
            data: {
                jabatan: jab,
                id: id
            },
            success: function(html) {
                $("#nama").html(html);
            }
        });
    })

    //get data pelaksana
    $('.tambah').on('click', function() {
        var id = $('#project').val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Project/get_data_p') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#ModalAddModul').modal('show');
                    $('[name="id"]').val(data.id);
                    $('[name="nama_project"]').val(data.nama);
                });
            }
        });
        return false;
    });

    //Tambah pelaksana di project
    $('#btn_simpan_pel').on('click', function() {
        var id_project = $('#id').val();
        var nama = $('#nama').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Project/tambahPelaksana') ?>",
            dataType: "JSON",
            data: {
                id_project: id_project,
                nama: nama,
            },
            success: function() {
                document.getElementById('jabatan').value = "";
                document.getElementById('nama').value = "";
                $('#ModalAddModul').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: 'Pelaksana berhasil ditambahkan.'
                });
                loadDataa();
            }
        });
        return false;
    });

    //get data pelaksana
    function hapus(q) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Menghapus pelaksana ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() ?>Project/hapusPelaksana',
                    data: 'id=' + q,
                    success: function(data) {
                        Swal.fire(
                            'Dihapus!',
                            'Pelaksana sudah di hapus.',
                            'success'
                        )
                    }
                })
                loadDataa();
            }
        });


    }

    //proses hapus modul
    $('#btn_del').on('click', function() {
        var id = $('#id').val();
        console.log(id);

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/hapusPelaksana',
            data: 'id=' + id,
            success: function(data) {
                $('#ModalHapus').modal('hide');

                loadDataa();
            }
        });
    })
</script>