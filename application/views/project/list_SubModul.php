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
                            <h4>Produk</h4>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Nama</label>
                                </div>
                                <select class="custom-select" id="aplikasi" name="aplikasi" onchange="loadDataAplikasi()">
                                    <option selected>Silahkan Pilih..</option>
                                    <?php
                                    foreach ($aplikasi->result() as $a) {
                                        echo "<option value='" . $a->id_aplikasi . "'>" . $a->nama_project . " - " . $a->nama_aplikasi . "</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Modul</h4>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Nama</label>
                                </div>
                                <select class="custom-select" id="modul" onchange="loadData()">
                                    <option>Silahkan Pilih Produk Terlebih Dahulu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Sub Modul</h4>
                    <button class="btn btn-sm btn-success tambah-submodul">Tambah Sub-Modul</button>
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

<!-- MODAL ADD SUB-MODUL -->
<div class="modal fade" id="ModalAddModul" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Sub-Modul </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input type="hidden" name="id" id="id">
                            <input name="nama_aplikasi" id="nama_aplikasi" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input name="nama_modul" id="nama_modul" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <select class="custom-select" name="nama_sub" id="nama_sub">

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
                <h5 class="modal-title" id="staticBackdropLabel">Hapus Sub Modul </h5>
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
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/sweetalert2/sweetalert2.min.js"></script>
<script type="text/javascript">
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    //load aplikasi
    function loadDataAplikasi() {
        var id = $("#aplikasi").val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/modulX',
            data: 'id=' + id,
            success: function(html) {
                $("#modul").html(html);
                loadData();
            }
        })

    }

    //load modul ke tabel sub_modul
    function loadData() {
        var id = $("#modul").val();
        //console.log(id);
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/sub_modul',
            data: 'id=' + id,
            success: function(html) {
                $("#tabel").html(html);
            }
        })
    }


    //get data submodul
    $('.tambah-submodul').on('click', function() {
        var id = $('#modul').val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Project/get_data_modul') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#ModalAddModul').modal('show');
                    $('[name="id"]').val(data.id);
                    $('[name="nama_aplikasi"]').val(data.nama);
                    $('[name="nama_modul"]').val(data.nama_modul);
                    sub(data.id);
                });
            }
        });
        return false;
    });

    function sub(e) {

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/sub',
            data: 'id=' + e,
            success: function(html) {
                $("#nama_sub").html(html);
            }
        });
    }

    //Tambah SubModul
    $('#btn_simpan_sub').on('click', function() {
        var id = $('#id').val();
        var nama = $('#nama_sub').val();
        console.log(nama);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Project/tambahSubModul') ?>",
            dataType: "JSON",
            data: {
                id: id,
                nama: nama
            },
            success: function(data) {
                $('[name="id_modul"]').val("");
                $('#ModalAddModul').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: 'Sub Modul berhasil ditambahkan.'
                });
                loadData();
            }
        });
        return false;
    });

    //get data submodul
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
            url: '<?php echo base_url() ?>Project/hapusSub',
            data: 'id=' + id,
            success: function(data) {
                $('#ModalHapus').modal('hide');
                Toast.fire({
                    icon: 'warning',
                    title: 'Sub Modul berhasil di hapus.'
                });
                loadData();
            }
        });
    })
</script>