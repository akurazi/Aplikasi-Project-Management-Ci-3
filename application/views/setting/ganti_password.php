<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center ">
                    <h2>Ganti Password</h2>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Password Baru</label>
                                </div>
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-info btn-flat update">Update</button>
                                </div>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    $('.update').on('click', function() {
        var pas = $('#password').val();
        if (pas == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password Tidak Boleh Kosong!',
            })
        } else {
            $.ajax({
                url: "<?= site_url('setting/updatepassword') ?>",
                type: "post",
                data: {
                    password: pas,
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Silahkan Login Kembali!',
                    }).then(function() {
                        window.location.href = "<?= site_url('auth/logout') ?>"
                    })
                }
            });
        }
    })
</script>