<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong">
    <link rel="icon" type="image/png" href="<?= base_url(); ?>berkas/menu/karyawan.png" sizes="16x16">

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #E5E5E5;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #F3F3F3;
        }
    </style>

</head>

<body style="font-size: 12px;">

    <p style="text-align: center;"><?= $logo; ?></p>
    <table style="border: 0px;">
        <tr style="background-color: transparent;border:0px;padding:0px;">
            <td style="border:0px;padding:2px;width:70px;">No. Nota</td>
            <td style="border:0px;padding:2px;width:5px;">:</td>
            <td style="border:0px;padding:2px;"><?= $data['profile']['no_nota']; ?></td>
        </tr>
        <tr style="background-color: transparent;border:0px;padding:2px;">
            <td style="border:0px;padding:2px;width:70px;">Tanggal</td>
            <td style="border:0px;padding:2px;width:5px;">:</td>
            <td style="border:0px;padding:2px;"><?= date('d/m/Y', $data['profile']['tgl']); ?></td>
        </tr>
        <tr style="background-color: transparent;border:0px;padding:2px;">
            <td style="border:0px;padding:2px;width:70px;">Pembeli</td>
            <td style="border:0px;padding:2px;width:5px;">:</td>
            <td style="border:0px;padding:2px;"><?= $data['profile']['pembeli']; ?></td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Barang</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: center;">Harga</th>
            <th style="text-align: center;">Jumlah</th>
        </tr>
        <?php foreach ($data['detail'] as $k => $i) : ?>
            <tr>
                <td><?= ($k + 1); ?></td>
                <td><?= $i['barang']; ?></td>
                <td style="text-align: center;"><?= $i['qty']; ?></td>
                <td style="text-align: right;"><?= rupiah($i['jml'] / $i['qty']); ?></td>
                <td style="text-align: right;"><?= rupiah($i['jml']); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="4" style="text-align:center;">TOTAL</th>
            <th style="text-align: right;"><?= rupiah($data['profile']['total']); ?></th>
        </tr>
    </table>
    <br>
    <br>
    <div style="text-align: right;">Sragen, <?= date('d', $data['profile']['tgl']); ?> <?= bulan(date('m', $data['profile']['tgl']))['bulan']; ?> <?= date('Y', $data['profile']['tgl']); ?></div>
    <table style="border: 0px;">
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;width:50%;"></td>
            <td rowspan="3" style="text-align: center;border:0px;"><img style="text-align: center;" src="<?= set_qr_code(base_url('public/djana/nota/') . $jwt, 'djana', 'Laporan Djana'); ?>" alt="Laporan Djana"></td>
            <td style="text-align: center;border:0px;width:50%;">Petugas</td>
        </tr>
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;"></td>
            <td style="text-align: center;border:0px;"></td>
        </tr>
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;"></td>
            <td style="text-align: center;border:0px;"><?= $data['profile']['teller']; ?></td>
        </tr>
    </table>

</body>

</html>