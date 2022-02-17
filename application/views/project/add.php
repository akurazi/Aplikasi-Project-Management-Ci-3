<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Project</h3>
                        </div>


                        <div class="card-body">
                            <?php
                            echo $this->session->flashdata('error');
                            ?>
                            <form action="add" class="form-horizontal" method="POST">
                                <div class="form-group">
                                    <label for="nama">Nama Project</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Project">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="jenis">Jenis Project</label>
                                            <select class="custom-select" id="jenis" name="jenis">
                                                <option selected>Jenis Project</option>
                                                <option value="pendidikan">Pendidikan</option>
                                                <option value="perkebunan">Perkebunan</option>
                                                <option value="pemasaran">Pemasaran</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nama">Produk</label>
                                            <select class="custom-select" name="aplikasi">
                                                <option selected>--Silahkan Pilih Produk--</option>
                                                <?php foreach ($aplikasi->result_array() as $k) {
                                                    echo "<option value=" . $k['id_bAplikasi'] . ">" . $k['nama_aplikasi'] . "</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="marketing">Marketing</label>
                                        <input type="text" class="form-control" id="marketing" name="marketing" placeholder="Masukkan Nama Marketing">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2 mt-2">
                                            <?php echo anchor('Project', 'KEMBALI', array('class' => 'btn btn-info btn-sm')); ?>
                                        </div>
                                        <div class="col-sm-1 mt-2">
                                            <button type="submit" name="submit" class="btn btn-danger  btn-sm">SIMPAN</button>
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