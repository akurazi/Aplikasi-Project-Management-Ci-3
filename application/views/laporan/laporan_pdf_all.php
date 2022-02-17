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
    <?php foreach ($project as $p) : ?>
        <div style="text-align:center">

            <h3> <?= strtoupper($p->nama_project) ?> </h3>
        </div>
        <table id="table">
            <tbody>
                <tr>
                    <td colspan="2" style="background-color: #9c9797; text-align:center;"><b>Detail</b></td>
                </tr>
                <tr>
                    <td width="150">Nama Project</td>
                    <td><?= strtoupper($p->nama_project) ?></td>
                </tr>
                <tr>
                    <td>Jenis Project</td>
                    <td><?= $p->jenis_project ?></td>
                </tr>
                <tr>
                    <td>Kontrak</td>
                    <td><?php
                        $this->db->join('base_kontrak', 'base_kontrak.id_bKontrak = kontrak.nama_kontrak');
                        $cek = $this->db->get_where('kontrak', 'id_project =' . $p->id);
                        if ($cek->num_rows() > 0) {
                            echo $cek->row()->lama . " " . $cek->row()->satuan;
                        } ?></td>
                </tr>
                <tr>
                    <td>Marketing</td>
                    <td><?= $p->marketing ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #9c9797; text-align:center;"><b>Requirements</b></td>
                </tr>
                <tr>
                    <td width="150">Nama Produk</td>
                    <td><?php
                        $a = $this->db->get_where('aplikasi', 'id_project = ' . $p->id)->row();
                        echo $a->nama_aplikasi;
                        $modul = $this->db->get_where('x_aplikasi', 'id_aplikasi = ' . $a->id_aplikasi); ?></td>
                </tr>
                <tr>
                    <td>Nama Modul</td>
                    <td>
                        <ul>
                            <?php foreach ($modul->result() as  $m) : ?>
                                <li><?= $m->nama_modul ?> </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Nama Sub Modul</td>
                    <td>
                        <ul>
                            <?php foreach ($modul->result() as $m) :
                                $d = $m->id_x_aplikasi;
                                $hsl = $this->db->get_where('sub_modul', 'id_x_aplikasi = ' . $d);
                                foreach ($hsl->result() as $kk) {
                                    echo "<li>" . $kk->nama_sub . "</li>";
                                } ?>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #9c9797; text-align:center;"><b>Pelaksana</b></td>
                </tr>
                <tr>
                    <td width="150">Penanggung Jawab</td>
                    <td>
                        <ul>
                            <?php
                            $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                            $this->db->where('pelaksana.jabatan = "penjab"');
                            $penjab = $this->db->get_where('x_pelaksana', 'id_project =' . $p->id);
                            foreach ($penjab->result_array() as $pp) {
                                echo "<li>" . $pp['nama'] . "</li>";
                            } ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>PIC</td>
                    <td>
                        <ul>
                            <?php
                            $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                            $this->db->where('pelaksana.jabatan = "pic"');
                            $pic = $this->db->get_where('x_pelaksana', 'id_project =' . $p->id);
                            foreach ($pic->result_array() as $pp) {
                                echo "<li>" . $pp['nama'] . "</li>";
                            } ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Programmer</td>
                    <td>
                        <ul>
                            <?php
                            $this->db->join('pelaksana', 'pelaksana.id_pelaksana = x_pelaksana.id_pelaksana');
                            $this->db->where('pelaksana.jabatan = "programmer"');
                            $programmer = $this->db->get_where('x_pelaksana', 'id_project =' . $p->id);
                            foreach ($programmer->result_array() as $pp) {
                                echo "<li>" . $pp['nama'] . "</li>";
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