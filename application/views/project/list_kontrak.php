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
                            <div id="success" class="alert alert-success" style="display: none"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button><span id="msg"></span></div>

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
                                    <option>Silahkan Pilih Project Dahulu.</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="kontrak"></table>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-10">
                                    <h4 align="center">Dokumen </h4>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-sm btn-success tambah-dokumen">Tambah Dokumen</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th>#</th>
                                    <th>Nama Dokumen</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="tabel">
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- MODAL ADD Dokumen -->
<div class="modal fade" id="modalAddDok" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Dokumen </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" id="upload" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-xs-9">
                            <div id="error" class="alert alert-danger" style="display: none">
                                <span id="msgerror"></span>
                            </div>
                            <input type="hidden" name="id" id="id">
                            <input name="nama_project" id="nama_project" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input type="text" name="nama_dokumen" id="nama_dokumen" placeholder="Masukkan Nama Dokumen" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-9">
                            <select name="jenis" class="form-control" id="jenis">
                                <option>--Pilih Jenis Dokumen</option>
                                <option value="Kontrak">Kontrak</option>
                                <option value="Adendum">Adendum</option>
                                <option value="Flowchart">Flowchart</option>
                                <option value="DFD">Data Flow Diagram(DFD)</option>
                                <option value="UCD">Use Case Diagram (UCD)</option>
                                <option value="Layout Tampilan">Layout Tampilan</option>
                                <option value="Layout Database">Layout Database</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input type="file" class="form-control" name="file" id="file">
                        </div>
                    </div>
                </div>

                <div class=" modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" type="submit">Simpan</button>
                </div>
                <!-- </form> -->
        </div>
    </div>
</div>
<!--END MODAL ADD-->

<!-- MODAL ADD kontrak -->
<div class="modal fade" id="modalAddKontrak" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Kontrak </h5>
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
                            <select name="pilKontrak" id="pilKontrak" class="form-control">
                                <option>-- Pilih Kontrak --</option>
                                <?php foreach ($kontrak->result() as $k) {
                                    echo "<option value=" . $k->id_bKontrak . ">" . $k->lama . " " . $k->satuan . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input type="date" class="form-control" name="mulai" id="mulai">
                        </div>
                    </div>

                </div>

                <div class=" modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL ADD Kontrak-->

<!-- MODAL EDIT Kontrak -->
<div class="modal fade" id="modalEditKontrak" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Kontrak </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input type="hidden" name="id_edit" id="id_edit">
                            <input name="nama_project_edit" id="nama_project_edit" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <select name="pilKontrak_edit" id="pilKontrak_edit" class="form-control">
                                <?php foreach ($kontrak->result() as $k) {
                                    echo "<option value=" . $k->id_bKontrak . ">" . $k->lama . " " . $k->satuan . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                            <input type="date" class="form-control" name="mulai_edit" id="mulai_edit">
                        </div>
                    </div>

                </div>

                <div class=" modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--END MODAL EDIT Kontrak-->

<!-- MODAL HAPUS Dokumen -->
<div class="modal fade" id="ModalHapus" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Hapus Dokumen </h5>
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
<!--END MODAL hapus dokumen-->


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
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Aplikasi/aplikasiX',
            data: 'id=' + id,
            success: function(html) {
                $("#aplikasi").html(html);
                loadData();
            }
        });
    }

    //load produk ke tabel dokumen
    function loadData() {
        var id = $("#project").val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/tampilDokumen',
            data: 'id=' + id,
            success: function(html) {
                $("#tabel").html(html);
            }
        });

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/tampilKontrak',
            data: 'id=' + id,
            success: function(html) {
                $("#kontrak").html(html);
            }
        });
    }

    //get data project
    $('.tambah-dokumen').on('click', function() {
        var id = $('#project').val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Project/get_project') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#modalAddDok').modal('show');
                    $('[name="id"]').val(data.id);
                    $('[name="nama_project"]').val(data.nama);
                    //$('[name="nama_dokumen"]').val(data.nama);
                });
            }
        });
        return false;
    });

    $('#upload').submit(function(e) {
        e.preventDefault();
        //console.log("bARU");
        if ($('#file').val() == '') {
            alert("Please Select the File");
        } else {
            $.ajax({
                url: "<?= site_url('Project/save') ?>",
                type: "post",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                dataType: "json",
                success: function(res) {

                    if (res.success == true) {
                        $('#id').val();
                        document.getElementById('nama_dokumen').value = "";
                        document.getElementById('jenis').value = "";
                        document.getElementById('file').value = "";
                        $('#modalAddDok').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Dokumen Berhasil di Upload.'
                        });
                    } else if (res.success == false) {
                        $('#msgerror').html(res.msg);
                        $('#error').show();
                    }

                    setTimeout(function() {
                        $('#msgerror').html('');
                        $('#error').hide();
                        $('#msg').html('');
                        $('#success').hide();
                    }, 3000);
                    loadData();
                }
            });
        }
        return false;
    });

    //tampilkan modal add kontrak
    function tambahKontrak() {
        var id = $('#project').val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Project/get_project') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#modalAddKontrak').modal('show');
                    $('[name="id"]').val(data.id);
                    $('[name="nama_project"]').val(data.nama);
                    $('[name="nama_project2"]').val(data.nama);
                });
            }
        });
    }

    //Tambah kontrak
    $('#btn-simpan').on('click', function() {
        $('#ModalAddKontrak').modal('hide');
        var id = $('#id').val();
        var kontrak = $('#pilKontrak').val();
        var mulai = $('#mulai').val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Project/tambahKontrak') ?>",
            dataType: "JSON",
            data: {
                id: id,
                kontrak: kontrak,
                mulai: mulai
            },
            success: function(data) {
                $('[name="nama_project"]').val("");
                $('#modalAddKontrak').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: 'Kontrak berhasil ditambahkan.'
                });
                loadData();
            }
        });
        return false;
    });

    function editKontrak(w) {
        var id = w;
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Project/get_kontrak') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function(nama, jabatan) {
                    $('#modalEditKontrak').modal('show');
                    $('[name="id_edit"]').val(data.id);
                    $('[name="nama_project_edit"]').val(data.project);
                    $('[name="pilKontrak_edit"]').val(data.nama);
                    $('[name="mulai_edit"]').val(data.mulai);
                });
            }
        });
        return false;
    }

    //update data modul 
    $('#btn_update').on('click', function() {
        var id = $('#id_edit').val();
        var kontrak = $('#pilKontrak_edit').val();
        var mulai = $('#mulai_edit').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Project/updateKontrak') ?>",
            dataType: "JSON",
            data: {
                id: id,
                kontrak: kontrak,
                mulai: mulai
            },
            success: function(data) {
                $('[name="id_edit"]').val("");
                $('[name="pilKontrak_edit"]').val("");
                $('#modalEditKontrak').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: 'Kontrak Berhasil di ubah.'
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

    //proses hapus dokumen
    $('#btn_del').on('click', function() {
        var id = $('#id').val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Project/deleteDokumen',
            data: 'id=' + id,
            success: function(data) {
                $('#ModalHapus').modal('hide');
                Toast.fire({
                    icon: 'warning',
                    title: 'Dokumen Berhasil di hapus.'
                });
                loadData();
            }
        });
    })


    function hapusKontrak(w) {

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Untuk menghapus kontrak ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() ?>Project/deleteKontrak',
                    data: 'id=' + w,
                    success: function(data) {
                        Swal.fire(
                            'Di hapus!',
                            'Kontrak sudah di hapus.',
                            'success'
                        )
                    }
                })
                loadData();
            }
        });

    }
</script>