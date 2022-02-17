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
            border: 1px solid #ddd;

        }

        #table thead {
            border: 2px solid #ddd;
            background-color: aqua;
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
    <table id="table">
        <thead>
            <tr>
                <th colspan="3">JUDUL GEDEK</th>
            </tr>
            <tr>
                <th>Judul 1</th>
                <th>Judul 2 </th>
                <th>Judul 3</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2">Makanan</td>
                <td>Nasi Goreng</td>
                <td>Ada</td>
            </tr>
            <tr>
                <td>Nasi Uduk</td>
                <td>Ada</td>
            </tr>
            <tr>
                <td>Minuman</td>
                <td>Kelapa Muda</td>
                <td>Kosong</td>
            </tr>
        </tbody>
    </table>
</body>

</html>