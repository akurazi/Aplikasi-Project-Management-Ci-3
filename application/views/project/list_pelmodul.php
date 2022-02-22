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
                <div class="col-md-6">
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
                                <select class="custom-select" id="project" name="project" onchange="loadDataProject()">
                                    <option selected>Silahkan Pilih..</option>
                                    <?php
                                    foreach ($project->result() as $a) {
                                        echo "<option value='" . $a->id . "'>" . $a->nama_project . "</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">

                            <h4>Produk</h4>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Nama</label>
                                </div>
                                <select class="custom-select" id="aplikasi" onchange="loadData()">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <h4>Programmer</h4>
                        </div>
                        <div class="col-md-2">
                            <a href="#" onclick="wak()" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Programmer</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <th>#</th>
                            <th>Nama Modul</th>
                            <th>Nama Programmer</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="tabel">
                        <tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL ADD MODUL -->
<div class="modal fade" id="ModalAddModul" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="id_project" id="id_project">
                            <input name="nama_project2" id="nama_project2" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input name="nama_aplikasi2" id="nama_aplikasi2" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <select name="nama_modul" id="nama_modul" onchange="pro()" class="custom-select">

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <select class="custom-select" id="id_pelaksana" name="id_pelaksana">
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
                <h5 class="modal-title" id="staticBackdropLabel">Hapus Pelaksana Modul </h5>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    //load aplikasi
    function loadDataProject() {
        var id = $("#project").val();
        //console.log(id);
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/aplikasiX',
            data: 'id=' + id,
            success: function(html) {
                $("#aplikasi").html(html);
                loadData();
            }
        })

    }

    //load modul ke tabel sub_modul
    function loadData() {
        var id = $("#aplikasi").val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/pel_modul',
            data: 'id=' + id,
            success: function(html) {
                $("#tabel").html(html);
            }
        })
    }

    function wak() {
        var id = $('#aplikasi').val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Project/get_data_m') ?>",
            dataType: "JSON",
            data: {
                id: id,
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#ModalAddModul').modal('show');
                    $('[name="id"]').val(data.id);
                    $('[name="id_project"]').val(data.id_project);
                    $('[name="nama_project2"]').val(data.nama_project);
                    $('[name="nama_aplikasi2"]').val(data.nama_aplikasi);
                    $('[name="nama_modul"]').val(data.nama_modul);
                    modul(data.id);
                });

            }
        });

    }

    function modul(e) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/tampilModul',
            data: 'id=' + e,
            success: function(html) {
                $("#nama_modul").html(html);
            }
        });

    }

    function pro() {
        var id = $('#id').val();
        var modul = $('#nama_modul').val();
        var id_project = $('#id_project').val();

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/pro',
            data: {
                id: id,
                modul: modul,
                id_project: id_project
            },
            success: function(html) {
                $("#id_pelaksana").html(html);
            }
        });

    }


    //Tambah Modul di aplikasi
    $('#btn_simpan_pel').on('click', function() {
        var idx = $('#nama_modul').val();
        var id_pelaksana = $('#id_pelaksana').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Project/tambahPelaksanaModul') ?>",
            dataType: "JSON",
            data: {
                idx: idx,
                id_pelaksana: id_pelaksana
            },
            success: function(data) {
                $('[name="id_modul"]').val("");
                $('[name="id_pelaksana"]').val("");
                $('#ModalAddModul').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: 'Pelaksana berhasil ditambahkan.'
                });
                loadData();
            }
        });
        return false;
    });

    //get data pelaksana
    function hapus(q) {
        $('#ModalHapus').modal('show');
        $('[name="id"]').val(q);
    }

    //proses hapus modul
    $('#btn_del').on('click', function() {
        var id = $('#id').val();
        console.log(id);

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/hapusPelaksanaModul',
            data: 'id=' + id,
            success: function(data) {
                $('#ModalHapus').modal('hide');
                alert('Berhasil Menghapus Data');
                loadData();
            }
        });
    })
</script>