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
                <div class="col-6">
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
                <div class="col-6">
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
                                    <option>Silahkan Pilih Project Terlebih Dahulu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" id="wek">
                <div class="card-header">
                    <h4>Modul</h4>
                    <button class="btn btn-sm btn-success tambah-modul">Tambah Modul</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Nama Modul</th>
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
                            <input name="nama_project" id="nama_project" class="form-control" type="hidden">
                            <input name="nama_project2" id="nama_project2" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input name="nama_aplikasi" id="nama_aplikasi" class="form-control" type="hidden">
                            <input name="nama_aplikasi2" id="nama_aplikasi2" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <select class="custom-select" id="modul" name="modul">
                                <option selected>Silahkan Pilih..</option>

                                <!-- foreach ($modul->result() as $a) {
                                    echo "<option value='" . $a->id_modul . "'>" . $a->nama_modul . "</option>";
                                }  -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_simpan_sub">Simpan</button>
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
                <h5 class="modal-title" id="staticBackdropLabel">Hapus Modul </h5>
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
<!--END MODAL ADD-->


<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/sweetalert2/sweetalert2.min.js"></script>

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
            url: '<?php echo base_url() ?>Project/modul',
            data: 'id=' + id,
            success: function(html) {
                $("#tabel").html(html);
            }
        })
    }



    //get data modul
    $('.tambah-modul').on('click', function() {
        var id = $('#aplikasi').val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Aplikasi/get_data_m') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#ModalAddModul').modal('show');
                    $('[name="id"]').val(data.id);
                    $('[name="nama_project"]').val(data.nama_project);
                    $('[name="nama_aplikasi"]').val(data.nama_aplikasi);
                    $('[name="nama_project2"]').val(data.nama_project);
                    $('[name="nama_aplikasi2"]').val(data.nama_aplikasi);
                    mod(data.id);
                });
            }
        });
        return false;
    });

    function mod(e) {

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/mod',
            data: 'id=' + e,
            success: function(html) {
                $("#modul").html(html);
            }
        });
    }


    //Tambah Modul di aplikasi
    $('#btn_simpan_sub').on('click', function() {
        var id = $('#id').val();
        var nama_project = $('#nama_project').val();
        var nama_aplikasi = $('#nama_aplikasi').val();
        var id_modul = $('#modul').val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Project/tambahModul') ?>",
            dataType: "JSON",
            data: {
                id: id,
                nama_project: nama_project,
                nama_aplikasi: nama_aplikasi,
                id_modul: id_modul
            },
            success: function(data) {
                $('[name="id_modul"]').val("");
                $('#ModalAddModul').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: 'Modul berhasil ditambahkan.'
                });
                loadData();
            }
        });
        return false;
    });


    //get data modul
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
            url: '<?php echo base_url() ?>Project/hapusModul',
            dataType: 'json',
            data: 'id=' + id,
            success: function(data) {
                $('#ModalHapus').modal('hide');
                Toast.fire({
                    icon: 'warning',
                    title: 'Modul berhasil di hapus.'
                });
                loadData();
            },
            error: function(data) {
                debugger;
                Toast.fire({
                    icon: 'error',
                    title: 'Modul tidak bisa di hapus.'
                });
            }
        });
    })
</script>