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
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header bg-primary">Laporan Kinerja</h5>
                        <div class="card-body">
                            <h5 class="card-title">Pilih Programmer :</h5><br>
                            <form action="<?= site_url('Laporan/orang') ?>" method="post" target="_blank">
                                <div class="input-group mb-4 mt-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                    </div>
                                    <select class="custom-select" name="orang" id="orang">
                                        <option selected disabled>Choose. . .</option>
                                        <?php foreach ($programmer->result() as $p) {
                                            echo "<option value='" . $p->id_pelaksana . "'>" . $p->nama . "</option>";
                                        } ?>
                                        <option value="all">-All-</option>
                                    </select>
                                </div>
                                <button type="submit" name="excel" class="btn btn-success float-right ml-3" id="pdf"><i class="fa fa-file-excel"></i> Export</button>
                                <button type="submit" name="pdf" class="btn btn-danger float-right" id="pdf"><i class="fa fa-file-pdf"></i> Export</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>