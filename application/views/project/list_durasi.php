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
                                <select class="form-control selectpicker" onchange="loadDataProject()" name="project" id="project" data-live-search="true" required>
                                    <option value="Select Part" disabled selected>Select Part</option>
                                    <?php foreach ($project->result() as $proj) {
                                        echo "<option value='" . $proj->id . "'>" . $proj->nama_project . "</option>";
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
            <div class="card">
                <div class="card-header">
                    <h4>Durasi Pengerjaan</h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered" style="width: 100%;">
                        <thead style="width: 100%;">
                            <th>#</th>
                            <th>Nama Modul</th>
                            <th>Durasi</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
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

<!-- MODAL ADD Durasi -->
<div class="modal fade" id="ModalAddModul" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Durasi </h5>
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
                            <input name="durasi" id="durasi" class="form-control" type="number" placeholder="Masukkan dalam hitungan hari">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input name="mulai" id="mulai" class="form-control" type="date" placeholder="Masukkan tanggal mulai">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_simpan_dur">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL ADD-->

<!-- MODAL EDIT Durasi -->
<div class="modal fade" id="modalEditDurasi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Durasi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input type="hidden" name="id_edit" id="id_edit">
                            <input name="modul_edit" id="modul_edit" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input name="durasi_edit" id="durasi_edit" class="form-control" type="number" placeholder="Masukkan dalam hitungan hari">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input name="mulai_edit" id="mulai_edit" class="form-control" type="date">
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
<!--END MODAL ADD-->


<!-- MODAL HAPUS -->
<div class="modal fade" id="ModalHapus" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Hapus Durasi</h5>
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

<script type="text/javascript">
    //load aplikasi
    function loadDataProject() {
        var id = $("#project").val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Aplikasi/aplikasiX',
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
        console.log(id);
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/durasi',
            data: 'id=' + id,
            success: function(html) {
                $("#tabel").html(html);
            }
        })
    }

    //get data modul
    function tambah(e) {
        var id = e;
        console.log(id);
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Project/get_durasi') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#ModalAddModul').modal('show');
                    $('[name="id"]').val(data.id);
                    $('[name="nama_aplikasi"]').val(data.nama_aplikasi);
                    $('[name="nama_modul"]').val(data.nama_modul);
                });
            }
        });
        return false;
    };

    //Tambah durasi di modul
    $('#btn_simpan_dur').on('click', function() {
        var id = $('#id').val();
        var durasi = $('#durasi').val();
        var mulai = $('#mulai').val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Project/tambahDurasi') ?>",
            dataType: "JSON",
            data: {
                id: id,
                durasi: durasi,
                mulai: mulai
            },
            success: function(data) {
                $('[name="id_modul"]').val("");
                $('#ModalAddModul').modal('hide');
                alert('Sukses Menambahkan!');
                loadData();
            }
        });
        return false;
    });

    function edit(w) {
        $.ajax({
            type: "GET",
            url: "<?= base_url('Project/get_durasi1') ?>",
            dataType: "JSON",
            data: {
                id: w
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#modalEditDurasi').modal('show');
                    $('[name="id_edit"]').val(data.id);
                    $('[name="modul_edit"]').val(data.modul);
                    $('[name="durasi_edit"]').val(data.durasi);
                    $('[name="mulai_edit"]').val(data.mulai);
                });
            }
        });
        return false;
    };

    //update data modul 
    $('#btn_update').on('click', function() {
        var id = $('#id_edit').val();
        var durasi = $('#durasi_edit').val();
        var mulai = $('#mulai_edit').val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Project/updateDurasi') ?>",
            dataType: "JSON",
            data: {
                id: id,
                durasi: durasi,
                mulai: mulai
            },
            success: function(data) {
                $('[name="id_edit"]').val("");
                $('[name="modul_edit"]').val("");
                $('#modalEditDurasi').modal('hide');
                alert('Perubahan Data berhasil');
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
            url: '<?php echo base_url() ?>Project/hapusDurasi',
            data: 'id=' + id,
            success: function(data) {
                $('#ModalHapus').modal('hide');
                alert('Berhasil Menghapus Data');
                loadData();
            }
        });
    })
</script>