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
                            <a href="<?= base_url('Project/listproject') ?>" class="btn btn-warning btn-fill ml-2" align="right">Kembali</a>
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
                                    <th>JENIS PROJECT</th>
                                    <th>:</th>
                                    <td><?= $cek->jenis_project ?></td>
                                </tr>
                                <tr>
                                    <th>KONTRAK</th>
                                    <th>:</th>
                                    <td>
                                        <?php
                                        $this->db->join('base_kontrak', 'base_kontrak.id_bKontrak = kontrak.nama_kontrak');
                                        $k = $this->db->get_where('kontrak', 'id_project = ' . $cek->id)->row_array();
                                        if ($k) {
                                            echo $k['lama'] . " " . $k['satuan'];
                                        } else {
                                            echo "";
                                        } ?></td>
                                </tr>
                                <tr>
                                    <th>MARKETING</th>
                                    <th>:</th>
                                    <td><?= $cek->marketing ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
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
                                <?php foreach ($status->result() as $st) {
                                    if ($st->id_status == $cek->status) {
                                        echo ' <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="status" id="' . $st->nama . '" value="' . $st->id_status . '" checked>
                                    <label for="' . $st->nama . '" class="custom-control-label">' . $st->nama . '</label>
                                </div>';
                                    } else {
                                        echo ' <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="status" id="' . $st->nama . '" value="' . $st->id_status . '">
                                        <label for="' . $st->nama . '" class="custom-control-label">' . $st->nama . '</label>
                                    </div>';
                                    }
                                } ?>

                            </div>
                            <button class="btn btn-md btn-warning mt-2 status" data-id="<?= $cek->id ?>">Update</button>

                        </div>
                    </div>
                </div>
                <div class="col-md-8">
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
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Requirement</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="content">
                            <?php
                            $id_pro = $this->uri->segment(3);
                            $no = 1;
                            foreach ($aplikasi->result() as $d) :
                            ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Nama Aplikasi</td>
                                                <td>:</td>
                                                <td>
                                                    <?= $d->nama_aplikasi ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nama Modul</td>
                                                <td>:</td>
                                                <td>
                                                    <?php
                                                    $m = array();
                                                    $modul = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $d->id_aplikasi);
                                                    foreach ($modul->result() as $mod) {
                                                        echo $mod->nama_modul . "<br>";
                                                        array_push($m, $mod->id_x_aplikasi);
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sub Modul</td>
                                                <td>:</td>
                                                <td><?php
                                                    for ($i = 0; $i < count($m); $i++) {
                                                        $cw = $this->db->get_where('sub_modul', 'id_x_aplikasi = ' . $m[$i])->result();
                                                        foreach ($cw as $t) {
                                                            echo $t->nama_sub . "<br>";
                                                        }
                                                    }

                                                    ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Pelaksana</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="content">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Nama Penanggung Jawab</td>
                                            <td>:</td>
                                            <td><?php
                                                $this->db->join('user', 'user.id = x_pelaksana.id_pelaksana');
                                                $this->db->join('level_user', 'level_user.id_level = user.status');
                                                $this->db->where('user.status=2');
                                                $pen = $this->db->get_where('x_pelaksana', 'id_project =' . $cek->id)->result_array();
                                                $no = 1;
                                                foreach ($pen as $t) {
                                                    echo $no . ". " . $t['nama'] . "<br>";
                                                    $no++;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama PIC</td>
                                            <td>:</td>
                                            <td><?php
                                                $this->db->join('user', 'user.id = x_pelaksana.id_pelaksana');
                                                $this->db->join('level_user', 'level_user.id_level = user.status');
                                                $this->db->where('user.status=3');
                                                $pen = $this->db->get_where('x_pelaksana', 'id_project =' . $cek->id)->result_array();
                                                $no = 1;
                                                foreach ($pen as $t) {
                                                    echo $no . ". " . $t['nama'] . "<br>";
                                                    $no++;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Programmer</td>
                                            <td>:</td>
                                            <td>
                                                <?php
                                                $this->db->join('user', 'user.id = x_pelaksana.id_pelaksana');
                                                $this->db->join('level_user', 'level_user.id_level = user.status');
                                                $this->db->where('user.status=4');
                                                $pen = $this->db->get_where('x_pelaksana', 'id_project =' . $cek->id)->result_array();
                                                $no = 1;
                                                foreach ($pen as $t) {
                                                    echo $no . ". " . $t['nama'] . "<br>";
                                                    $no++;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">

                <div class="col-md-8">
                    <div class="card text-center">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Status Pengerjaan</h3>
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
                            <div class="table-responsive" style="position: relative;height: 240px;overflow: auto;">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Modul</th>
                                            <th>Status</th>
                                            <th>Sub Modul</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $total_sudah = array();
                                        $total_persen = array();
                                        $modul = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $d->id_aplikasi);
                                        foreach ($modul->result() as $mod) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $mod->nama_modul ?></td>
                                                <td>
                                                    <?php
                                                    $sudah = $this->db->get_where('sub_modul', array(
                                                        'id_x_aplikasi' =>  $mod->id_x_aplikasi,
                                                        'status' => 2
                                                    ))->num_rows();

                                                    $total = $this->db->get_where('sub_modul', 'id_x_aplikasi =' . $mod->id_x_aplikasi)->num_rows();
                                                    if ($sudah ==  0) {
                                                        $badge =  " <span class='badge badge-danger'>0 %</span>";
                                                    } else if ($sudah > 0) {
                                                        $persen = round($sudah / $total * 100);
                                                        $badge =  " <span class='badge badge-warning'>" . $persen . " %</span>";
                                                    } else if ($sudah == $total) {
                                                        $badge =  " <span class='badge badge-success'>100%</span>";
                                                    }

                                                    echo $badge;
                                                    array_push($total_sudah, $sudah);
                                                    array_push($total_persen, $total);

                                                    ?>
                                                </td>
                                                <td><?= $sudah . "/" . $total ?></td>
                                            </tr>

                                        <?php endforeach;

                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div>
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Progress</h3>

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
                            <input type="hidden" id="sudah" value="<?= array_sum($total_sudah) ?>">
                            <input type="hidden" id="total" value="<?= array_sum($total_persen) ?>"> <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<!-- jQuery -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/chart.js/Chart.min.js"></script>

<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    const coba = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $('.swalDefaultSuccess').click(function() {
        Toast.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            //icon: 'success',
            //title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        )
    });
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var sudah = $('#sudah').val();
    var total = $('#total').val();
    var pieData = {
        labels: [
            'Selesai',
            'Progres',

        ],
        datasets: [{
            data: [sudah, total],
            backgroundColor: ['#1fc716', '#dfe3de'],
        }]
    }
    var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    })

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
                Toast.fire({
                    icon: 'success',
                    title: 'Status berhasil di Update.'
                });
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
                Toast.fire({
                    icon: 'success',
                    title: 'Keterangan berhasil di Update.'
                });
            }
        });
    });
</script>