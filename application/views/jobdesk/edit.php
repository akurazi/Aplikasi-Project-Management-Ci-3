<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Edit Project</h3>
                        </div>


                        <div class="card-body">
                            <?php
                            echo $this->session->flashdata('error');
                            ?>
                            <form action="<?= base_url('Project/edit/' . $cek['id']) ?>" class="form-horizontal" method="POST">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?= $cek['id'] ?>">
                                    <label for="nama">Nama Project</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Project" value="<?= $cek['nama_project'] ?>">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="jenis">Jenis Project</label>
                                            <select class="custom-select" id="jenis" name="jenis">
                                                <?php
                                                $bulan = array("", "Pendidikan", "Pemasaran", "Perkebunan");
                                                for ($a = 1; $a <= 3; $a++) {
                                                    if ($bulan[$a] == $cek['jenis_project']) {
                                                        $pilih = "selected";
                                                        echo ("<option value='$bulan[$a]' $pilih>$bulan[$a]</option>" . "\n");
                                                    } else {
                                                        $pilih = "";
                                                        echo ("<option value='$bulan[$a]' $pilih>$bulan[$a]</option>" . "\n");
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nama">Aplikasi</label>
                                            <select class="custom-select" name="aplikasi">
                                                <?php foreach ($aplikasi->result_array() as $k) {
                                                    if ($k['nama_aplikasi'] == $cek['nama_aplikasi']) {
                                                        echo "<option value='" . $k['id_bAplikasi'] . "' selected>" . $k['nama_aplikasi'] . "</option>";
                                                    } else {
                                                        echo "<option value=" . $k['id_bAplikasi'] . ">" . $k['nama_aplikasi'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="nama">Durasi Pengerjaan</label>
                                            <input type="number" class="form-control" id="durasi" name="durasi" placeholder="Masukkan Durasi dalam Hari" value="<?= $cek['lama'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <label for="nama">Marketing</label>
                                            <input type="text" class="form-control" id="marketing" name="marketing" placeholder="Masukkan Marketing" value="<?= $cek['marketing'] ?>">
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="nama">Kontrak<?= $cek['id_x_kontrak']?></label>
                                            <select name="kontrak" class="form-control">
                                                <?php
                                                foreach ($kontrak->result_array() as $u) {
                                                    if ($u['id_kontrak'] == $cek['id_kontrak']) {
                                                        $pilih = "selected";
                                                        echo "<option value=" . $u['id_kontrak'] . " selected>" . $u['nama_kontrak'] . "</option>" . "\n";
                                                    } else {
                                                        $pilih = "";
                                                        echo "<option value=" . $u['id_kontrak'] . ">" . $u['nama_kontrak'] . "</option>" . "\n";
                                                    }
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="nama">Detail Kontrak</label>
                                            <textarea class="form-control" name="detail"><?= $cek['detail_kontrak'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2 mt-2">
                                            <?php echo anchor('Project', 'KEMBALI', array('class' => 'btn btn-info btn-sm')); ?>
                                        </div>
                                        <div class="col-sm-1 mt-2">
                                            <button type="submit" name="submit" class="btn btn-danger  btn-sm">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>