<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="header">
                    <div class="row mb-2 mt-2">
                        <div class="col-sm-10">
                            <h4 class="title" style="text-transform:capitalize; margin-top:5px; margin-left:5px;"></h4>
                        </div>
                        <div class="col-sm-1">
                            <a href="<?= base_url('Jobdesk') ?>" class="btn btn-warning btn-fill pull-right" align="right">Kembali</a>
                        </div>
                    </div>

                    <!-- <p class="category">Last Campaign Performance</p> -->
                </div>
                <div class="content">
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped table-borderless">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>NAMA PROJECT</th>
                                    <th>:</th>
                                    <td><?= $cek->nama_project ?></td>
                                </tr>
                                <tr>
                                    <th>Aplikasi</th>
                                    <th>:</th>
                                    <td><?= $cek->nama_aplikasi ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="card ">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Status</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="status" id="implementasi" value="4" checked disabled>
                                    <label for="implementasi" class="custom-control-label">Implementasi</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="status" id="testing" value="5">
                                    <label for="testing" class="custom-control-label">Testing & Integrasi</label>
                                </div>
                            </div>
                            <button class="btn btn-md btn-warning mt-2 status" data-id="<?= $cek->id ?>">Update</button>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card ">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Keterangan</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" rows="5" placeholder="Masukkan Keterangan disini" id="keterangan"><?= $cek->keterangan ?></textarea>
                            <button class="btn btn-md btn-warning mt-2 keterangan" data-id="<?= $cek->id ?>">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($modul->result() as $ke) :
                    $m = $this->db->get_where('durasi', 'id_x_aplikasi =' . $ke->id_x_aplikasi)->row_array(); ?>
                    <div class="card col-md-12 p-3">
                        <div class="row no-gutters">
                            <div class="col-md-3 bg-light">
                                <h4 align="center">
                                    <?php if ($m) {
                                        $awal = new DateTime();
                                        $selesai = new DateTime($m['selesai']);
                                        $days = date_diff($awal, $selesai);
                                        echo '<div class="badge badge-primary" style="width: 160px; height:100px; padding:30px; margin-top:40px; "><h1 style="font-weight:bolder;">' . $days->days . '</h1>Hari</div>';
                                    } else {
                                        echo '<div class="badge badge-danger" style="width: 160px; height:100px; padding:30px; margin-top:40px; "><h1 style="font-weight:bolder;">0</h1>Hari</div>';
                                    } ?></h4>
                                <div style="margin-top: 60px; margin-left:50px;">
                                    Nama Modul :<?= $ke->nama_modul ?><br>
                                    Mulai :
                                    <?php
                                    if ($m) {
                                        echo $m['mulai'];
                                    }  ?>
                                    <br>Selesai :
                                    <?php if ($m) {
                                        echo $m['selesai'];
                                    }  ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="table-responsive" style="position: relative;height: 300px;overflow: auto;">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Sub Modul</th>
                                                    <th>Status</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $cw = $this->db->get_where('sub_modul', 'id_x_aplikasi = ' . $ke->id_x_aplikasi)->result();
                                                foreach ($cw as $t) :
                                                    $status = $t->status;

                                                ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= $t->nama_sub ?></td>
                                                        <td>
                                                            <?php if ($status == 0) {
                                                                echo "
                                                        <input type='radio' onclick='updateStatus(0," . $t->id_sub . ")' checked> <span class='badge badge-danger'>Belum</span>
                                                        <input type='radio' onclick='updateStatus(1," . $t->id_sub . ")'> <span class='badge badge-warning'>Proses</span>
                                                        <input type='radio' onclick='updateStatus(2," . $t->id_sub . ")'> <span class='badge badge-success'>Selesai</span>";
                                                            } else if ($status == 1) {
                                                                echo "
                                                        <input type='radio' onclick='updateStatus(0," . $t->id_sub . ")'> <span class='badge badge-danger'>Belum</span>
                                                        <input type='radio' onclick='updateStatus(1," . $t->id_sub . ")' checked> <span class='badge badge-warning'>Proses</span>
                                                        <input type='radio' onclick='updateStatus(2," . $t->id_sub . ")'> <span class='badge badge-success'>Selesai</span>";
                                                            } else {
                                                                echo "
                                                        <input type='radio' onclick='updateStatus(0," . $t->id_sub . ")'> <span class='badge badge-danger'>Belum</span>
                                                        <input type='radio' onclick='updateStatus(1," . $t->id_sub . ")'> <span class='badge badge-warning'>Proses</span>
                                                        <input type='radio' onclick='updateStatus(2," . $t->id_sub . ")' checked> <span class='badge badge-success'>Selesai</span>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><input type="text" name="keterangan" value="<?= $t->keterangan ?>" class="form-control" id="keterangan" style="width: 300px; display:inline;"><button class="btn btn-sm btn-success ml-3" onclick="updateKeterangan(<?= $t->id_sub ?>)"><i class="fa fa-save"></i></button></td>
                                                    </tr>
                                                <?php $no++;
                                                endforeach;

                                                ?>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


        </div>
    </div>
</div>
</div>
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>

<script>
    function updateStatus(s, d) {
        var id = d;
        var status = s;
        var id_user = <?= $this->session->userdata("id_user"); ?>;
        // console.log(id_user);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Jobdesk/updateStatus') ?>",
            dataType: "JSON",
            data: {
                id: id,
                status: status,
                id_user: id_user
            },
            success: function(data) {
                alert('Sukses Update Status');
                location.reload('#test');
            }
        });
        return false;
    }

    function updateKeterangan(d) {
        var id = d;
        var keterangan = $('#keterangan').val();
        var id_user = <?= $this->session->userdata("id_user"); ?>;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Jobdesk/updateKeterangan') ?>",
            dataType: "JSON",
            data: {
                id: id,
                keterangan: keterangan,
                id_user: id_user
            },
            success: function(data) {
                alert('Berhasil Memberikan Keterangan');
                location.reload();
            }
        });
        return false;
    };

    $('.status').on('click', function() {
        var st = $("input[name='status']:checked").val();
        var id = $(this).data("id");

        $.ajax({
            url: "<?= site_url('project/status') ?>",
            type: "post",
            data: {
                status: st,
                id: id
            },
            success: function(data) {
                alert('Berhasil di update');
            }
        });
    });

    $('.keterangan').on('click', function() {
        var ket = $('#keterangan').val();
        var id = $(this).data("id");

        $.ajax({
            url: "<?= site_url('project/keterangan') ?>",
            type: "post",
            data: {
                keterangan: ket,
                id: id
            },
            success: function(data) {
                alert('Berhasil di update');
            }
        });
    });
</script>