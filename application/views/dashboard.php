<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $project ?></h3>
              <p>Project</p>
            </div>
            <div class="icon">
              <i class="ion ion-folder"></i>
            </div>
          </div>
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $modul ?></h3>
              <p>Modul</p>
            </div>
            <div class="icon">
              <i class="fa fa-th-list"></i>
            </div>
          </div>
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $sub ?></h3>
              <p>Sub Modul</p>
            </div>
            <div class="icon">
              <i class="fa fa-list-alt"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <!-- PRODUCT LIST -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Aktivitas Terakhir </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <?php foreach ($history->result() as $his) : ?><li class="item">
                    <div class="product-img">
                      <img src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">
                        <?php
                        $id = $his->id_user;
                        $q = $this->db->get_where('user', 'id =' . $id)->row_array();
                        echo $q['nama'];
                        ?>
                        <span class="badge badge-info float-right">
                          <?php
                          $sekarang = date_create();
                          $last = date_create($his->update_at);
                          $diff = date_diff($last, $sekarang);
                          if ($diff->d >= 1) {
                            echo $diff->d . " Hari";
                          } else if ($diff->d < 1 && $diff->h >= 1) {
                            echo $diff->h . " Jam";
                          } else if ($diff->h < 1 && $diff->i >= 1) {
                            echo $diff->i . " Menit";
                          } else if ($diff->i < 1 && $diff->s >= 1) {
                            echo $diff->s . " Detik";
                          }
                          ?></span></a>

                      <span class="product-description">
                        <?= $his->history ?> pada
                        <?php $ket = $this->db->get_where('sub_modul', 'id_sub = ' . $his->id_sub)->row_array();
                        echo $ket['nama_sub']; ?>
                      </span>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase"></a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-lg-4">
          <div class="card bg-gradient-success">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="far fa-calendar-alt"></i>
                Calendar
              </h3>

              <div class="card-tools">


                <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>

            </div>

            <div class="card-body pt-0">

              <div id="calendar" style="width: 100%"></div>
            </div>

          </div>
          <div class="card bg-gradient-primary" id="map">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-map-marker-alt mr-1"></i>
                Visitors
              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                  <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>

            </div>
            <div class="card-body">
              <div id="world-map" style="height: 100px; width: 100%;"></div>
            </div>

            <div class="card-footer bg-transparent">
              <div class="row">
                <div class="col-4 text-center">
                  <div id="sparkline-1"></div>
                  <div class="text-white">Visitors</div>
                </div>

                <div class="col-4 text-center">
                  <div id="sparkline-2"></div>
                  <div class="text-white">Online</div>
                </div>

                <div class="col-4 text-center">
                  <div id="sparkline-3"></div>
                  <div class="text-white">Sales</div>
                </div>

              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-4">
          <div class="card">
            <div class="card-header bg-info">
              <h3 class="card-title">Akan Dikerjakan</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <?php foreach ($akan as $aku) : ?>
                  <li class="item">
                    <div class="product-img">
                      <img src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><?= $aku->nama_project ?>
                        <span class="badge badge-info float-right"><?= $aku->update_at ?></span>
                      </a>
                      <span class="product-description">
                        Deskripsi
                      </span>
                      <span class="float-right text-muted">Diposting Oleh <?= $aku->nama ?> </span>
                    </div>

                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase"></a>
            </div>
            <!-- /.card-footer -->
          </div>
        </div>
        <div class="col-lg-4 col-4">
          <div class="card">
            <div class="card-header bg-warning">
              <h3 class="card-title">Sedang Dikerjakan</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <?php foreach ($sedang as $sed) : ?>
                  <li class="item">
                    <div class="product-img">
                      <img src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><?= $sed->nama_project ?>
                        <span class="badge badge-warning float-right"><?= $sed->update_at ?></span>
                      </a>
                      <span class="product-description">
                        Deskripsi
                      </span>
                      <span class="float-right text-muted">Diposting Oleh <?= $sed->nama ?> </span>
                    </div>

                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase"></a>
            </div>
            <!-- /.card-footer -->
          </div>
        </div>
        <div class="col-lg-4 col-4">
          <div class="card">
            <div class="card-header bg-success">
              <h3 class="card-title">Selesai</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <?php foreach ($selesai as $sel) : ?>
                  <li class="item">
                    <div class="product-img">
                      <img src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><?= $sel->nama_project ?>
                        <span class="badge badge-info float-right"><?= $sel->update_at ?></span>
                      </a>
                      <span class="product-description">
                        Deskripsi
                      </span>
                      <span class="float-right text-muted">Diposting Oleh <?= $sel->nama ?> </span>
                    </div>

                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase"></a>
            </div>
            <!-- /.card-footer -->
          </div>
        </div>
      </div>

    </div>

  </section>

</div>
<!-- jQuery -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  document.getElementById("map").style.visibility = "hidden";
</script>