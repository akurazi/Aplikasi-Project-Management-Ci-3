<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10">
                    <h2>Rule User</h2>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Level User</h4>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Level</label>
                                </div>
                                <select class="custom-select" id="level" name="level" onchange="loadData()">
                                    <option selected>Silahkan Pilih..</option>
                                    <?php foreach ($level->result() as $lev) {
                                        echo "<option value='" . $lev->id_level . "'>" . $lev->nama_level . "</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Hak Akses</h4>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>

                                        <th scope="col">Nama Menu</th>
                                        <th scope="col">Link</th>
                                        <th scope="col">Akses</th>
                                    </tr>
                                </thead>
                                <tbody id="isi"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
<script>
    function loadData() {
        var id = $("#level").val();
        console.log(id);
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Setting/get_rule',
            data: 'id=' + id,
            success: function(html) {
                $("#isi").html(html);
            }
        })
    }

    function addRule(id_menu) {
        var level_user = $("#level").val();
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Setting/addrule',
            data: 'level_user=' + level_user + '& id_menu=' + id_menu,
            success: function(html) {

                alert('suksess memberikan akses');
            }
        })
    }

    function addMenu(id_menu) {
        var level_user = $('#level').val();
        console.log(level_user, id_menu);

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Setting/addmenu',
            data: 'level_user=' + level_user + '& id_menu=' + id_menu,
            success: function(html) {
                alert('suksess memberikan akses');
                loadData();
            }
        })
    }
</script>