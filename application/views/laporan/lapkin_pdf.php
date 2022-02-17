<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin: auto;
            border: 1px solid #ddd;

        }

        #table thead {
            border: 2px solid #ddd;
            background-color: #aeb0af;
        }

        #table td {
            border: 1px solid #ddd;
            padding: 8px;
        }



        #table ul {
            padding-left: 10;
        }
    </style>
</head>

<body>
    <div style="text-align:center">
        <h3> LAPORAN KINERJA </h3>
    </div>

    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?= $pelaksana['nama'] ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Programmer</td>
        </tr>
    </table><br>
    <?php foreach ($project as $pe) : ?>
        <table id="table">
            <thead>
                <tr>
                    <th colspan="3"><?= $pe->nama_project . " | " . $pe->nama_aplikasi ?></th>
                </tr>
                <tr>
                    <th>Modul</th>
                    <th>Sub Modul</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $this->db->join('x_pelmodul', 'x_pelmodul.id_x_aplikasi = x_aplikasi.id_x_aplikasi');
                $mod = $this->db->get_where('x_aplikasi', ['id_aplikasi  ' => $pe->id_aplikasi, 'id_pelaksana' => $pelaksana['id_pelaksana']]);
                foreach ($mod->result() as $m) :
                    $sub = $this->db->get_where('sub_modul', 'id_x_aplikasi = ' . $m->id_x_aplikasi);
                    $jml = $sub->num_rows();

                    if ($jml > 0) {
                        echo "<tr>
                                <td rowspan='" . $jml . "'>" . $m->nama_modul . "</td>";
                        foreach ($sub->result() as $s) {
                            if ($s->status == 0) {
                                $status = "Belum Selesai";
                            } else if ($s->status == 1) {
                                $status = "Proses";
                            } else {
                                $status = "Selesai";
                            }
                            echo "<td>" . $s->nama_sub . "</td>
                                  <td>" . $status . "</td></tr><tr>";
                        }
                        echo "<td style='padding:0px;'></td>
                        <td style='padding:0px;'></td>
                        <td style='padding:0px;'></td></tr>";
                    } else {
                        echo "<tr>
                                <td>" . $m->nama_modul . "</td>
                                <td></td>
                                <td></td>
                                </tr>";
                    }



                endforeach; ?>

            </tbody>
        </table><br>
    <?php endforeach; ?>
</body>

</html>