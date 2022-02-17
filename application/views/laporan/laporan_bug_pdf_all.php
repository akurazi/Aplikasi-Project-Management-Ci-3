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
            width: 80%;
            margin: auto;
        }

        #table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table ul {
            padding-left: 10;
        }

        .page_break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <?php foreach ($project as $pro) : ?>
        <div style="text-align:center">
            <h3> <?= strtoupper($pro->nama_project) ?> </h3>
        </div>
        <table id="table">
            <tbody>
                <tr>
                    <td colspan="3" style="background-color: #9c9797; text-align:center;"><b>Detail</b></td>
                </tr>
                <tr>
                    <td width="150">Nama Project</td>
                    <td colspan="2"><?= strtoupper($pro->nama_project) ?></td>
                </tr>
                <tr>
                    <td>Jenis Project</td>
                    <td colspan="2"><?= $pro->jenis_project ?></td>
                </tr>
                <tr>
                    <td>Kontrak</td>
                    <td colspan="2"><?php
                                    $this->db->join('base_kontrak', 'base_kontrak.id_bKontrak = kontrak.nama_kontrak');
                                    $cek = $this->db->get_where('kontrak', 'id_project =' . $pro->id);
                                    if ($cek->num_rows() > 0) {
                                        echo $cek->row()->lama . " " . $cek->row()->satuan;
                                    } ?></td>
                </tr>
                <tr>
                    <td>Marketing</td>
                    <td colspan="2"><?= $pro->marketing ?></td>
                </tr>
                <tr>
                    <td width="150">Nama Produk</td>
                    <td colspan="2"><?php $aplikasi = $this->db->get_where('aplikasi', 'id_project = ' . $pro->id)->row();
                                    $aplikasi->nama_aplikasi ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="background-color: #9c9797; text-align:center;"><b>Daftar Bugs</b></td>
                </tr>
                <tr style="background-color: #9c9797; text-align:center;">
                    <td>Modul</td>
                    <td>Sub Modul</td>
                    <td>Keterangan</td>
                </tr>
                <?php
                $modul = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $aplikasi->id_aplikasi);
                foreach ($modul->result() as  $m) :

                    $hsl = $this->db->get_where('sub_modul', ['id_x_aplikasi  ' => $m->id_x_aplikasi, 'keterangan !=' => '']);
                    $jml = $hsl->num_rows();

                    if ($jml > 0) {
                        echo "<tr>
                            <td rowspan='" . $jml . "'>" . $m->nama_modul . "</td>";
                        foreach ($hsl->result() as $sub) {
                            echo "<td>" . $sub->nama_sub . "</td>
                                    <td>" . $sub->keterangan . "</td></tr><tr>";
                        }
                        echo "<td style='padding:0px;'></td>
                        <td style='padding:0px;'></td>
                        <td style='padding:0px;'></td></tr>";
                    }
                endforeach; ?>
                <tr>
                    <td colspan="3" style="background-color: #9c9797; text-align:center;"><b>Pelaksana</b></td>
                </tr>
                <tr>
                    <td width="150">Penanggung Jawab</td>
                    <td colspan="2">
                        <ul>
                            <?php
                            $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                            $this->db->where('pelaksana.jabatan = "penjab"');
                            $penjab = $this->db->get_where('x_pelaksana', 'id_project =' . $pro->id);
                            foreach ($penjab->result() as $pp) {
                                echo "<li>" . $pp->nama . "</li>";
                            } ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>PIC</td>
                    <td colspan="2">
                        <ul>
                            <?php
                            $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                            $this->db->where('pelaksana.jabatan = "pic"');
                            $pic = $this->db->get_where('x_pelaksana', 'id_project =' . $pro->id);
                            foreach ($pic->result() as $pp) {
                                echo "<li>" . $pp->nama . "</li>";
                            } ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Programmer</td>
                    <td colspan="2">
                        <ul>
                            <?php
                            $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                            $this->db->where('pelaksana.jabatan = "penjab"');
                            $programmer = $this->db->get_where('x_pelaksana', 'id_project =' . $pro->id);
                            foreach ($programmer->result() as $pp) {
                                echo "<li>" . $pp->nama . "</li>";
                            } ?>
                        </ul>
                    </td>
                </tr>

            </tbody>
        </table>
        <div class="page_break"></div>
    <?php endforeach; ?>
</body>

</html>