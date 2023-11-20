<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        /* table,
        td,
        th {
            border: 1px solid;
        }

        tr {
            height: 10px;
        } */

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 2px;
            font-size: 12px;
        }
    </style>
    <title>Jadwal Rebana</title>


</head>

<body style="font-size:13px;">
    <?php $exp = explode("_", $data['bl_th']); ?>
    <table style="padding:0px;">
        <tr style="padding:0px;">
            <td rowspan="2" style="width: 70px;padding-bottom:0px;"><?= $data['logo']; ?></td>
            <td style="padding-bottom:2px;font-weight:bold;vertical-align:bottom;">JADWAL SHOLAWAT REBANA WALISONGO SRAGEN</td>
        </tr>
        <tr style="padding:0px;">
            <td style="padding-top:2px;font-weight:bold;vertical-align:top;">BULAN <?= strtoupper($exp[0]); ?> TAHUN <?= $exp[1]; ?></td>
        </tr>
    </table>
    <br>
    <table style="border: 1px solid black;">
        <tr style="border: 1px solid black;">
            <th style="border: 1px solid black;padding:5px;">No.</th>
            <th style="border: 1px solid black;padding:5px;">Hari/Tgl</th>
            <th style="border: 1px solid black;padding:5px;">Alamat</th>
            <th style="border: 1px solid black;padding:5px;">Jam</th>
            <th style="border: 1px solid black;padding:5px;">Acara</th>
            <th style="border: 1px solid black;padding:5px;">Keterangan</th>
        </tr>
        <?php foreach ($data['data'] as $k => $i) : ?>
            <tr style="border: 1px solid black;">
                <td style="text-align: center;border: 1px solid black;padding:5px;"><?= $k + 1; ?></td>
                <td style="border: 1px solid black;padding:5px;"><?= date('d/m/Y', $i['tgl']); ?></td>
                <td style="border: 1px solid black;padding:5px;"><?= $i['alamat']; ?></td>
                <td style="border: 1px solid black;padding:5px;"><?= $i['jam']; ?></td>
                <td style="border: 1px solid black;padding:5px;"><?= $i['acara']; ?></td>
                <td style="border: 1px solid black;padding:5px;"><?= $i['keterangan']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>