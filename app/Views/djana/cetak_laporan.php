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

    <p style="text-align: center;margin-top:-100px;"><?= $logo; ?></p>
    <div style="text-align: center;font-weight:bold;"><?= $judul; ?></div>
    <br>
    <br>
    <h3>A. Pemasukan</h3>
    <table>
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Sumber Anggaran</th>
            <th style="text-align: center;">Saldo</th>
        </tr>
        <tr>
            <td style="text-align: center;">1.</td>
            <td><?= $saldo_bulan_lalu['text']; ?></td>
            <td style="text-align: right;"><?= rupiah($saldo_bulan_lalu['saldo']); ?></td>
        </tr>
        <tr>
            <td style="text-align: center;">2.</td>
            <td>Pemasukan Lain</td>
            <td style="text-align: right;">Rp. 0</td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;text-align:center;">TOTAL</td>
            <td style="font-weight: bold;text-align:right"><?= rupiah($saldo_bulan_lalu['saldo']); ?></td>
        </tr>
    </table>
    <br>
    <h3>B. Rincian Keuangan</h3>
    <table style="width: 100%;">
        <tr>
            <th>No.</th>
            <?php foreach ($cols as $i) : ?>
                <th><?= upper_first(str_replace("_", " ", $i)); ?></th>
            <?php endforeach; ?>

        </tr>
        <?php foreach ($data['data'] as $k => $i) : ?>
            <tr>
                <td><?= ($k + 1); ?></td>
                <?php foreach ($cols as $c) : ?>
                    <td <?= ($c == 'keluar' || $c == 'masuk' || $c == 'laba' ? 'style="text-align: right;"' : ''); ?>><?= $i[$c]; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="font-weight:bold;text-align:center;">TOTAL</td>
            <td style="text-align: right;font-weight:bold;"><?= $data['totalKeluar']; ?></td>
            <td style="text-align: right;font-weight:bold;"><?= $data['totalMasuk']; ?></td>
            <td style="text-align: right;font-weight:bold;"><?= $data['totalLaba']; ?></td>
        </tr>
    </table>
    <br>
    <br>
    <div style="text-align: right;">Sragen, <?= date('d'); ?> <?= bulan(date('m'))['bulan']; ?> <?= date('Y'); ?></div>
    <table style="border: 0px;">
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;width:50%;">Kepala</td>
            <td rowspan="3" style="text-align: center;border:0px;"><img src="<?= set_qr_code(base_url('public/djana/laporan/') . $jwt, 'djana', 'Laporan Djana'); ?>" alt="Laporan Djana"></td>
            <td style="text-align: center;border:0px;width:50%;">Bendahara</td>
        </tr>
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;"></td>
            <td style="text-align: center;border:0px;"></td>
        </tr>
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;">M. Dimyati</td>
            <td style="text-align: center;border:0px;">Fajar Zulfikar</td>
        </tr>
    </table>

</body>

</html>