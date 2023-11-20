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
    <table style="width: 100%;">
        <tr>
            <th>No.</th>
            <?php foreach ($cols as $i) : ?>
                <th><?= upper_first(str_replace("_", " ", ($i == 'tgl_lunas' ? 'tgl' : $i))); ?></th>
            <?php endforeach; ?>

        </tr>
        <?php foreach ($data as $k => $i) : ?>
            <?php $i['tgl_lunas'] = date('d/m/Y', $i['tgl_lunas']); ?>
            <tr>
                <td><?= ($k + 1); ?></td>
                <?php foreach ($cols as $c) : ?>
                    <td <?= ($c == 'harga' ? 'style="text-align: right;"' : ''); ?>><?= ($c == 'harga' ? rupiah($i['jml_lunas']) : $i[$c]); ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="4" style="text-align:center;">TOTAL</th>
            <th style="text-align: right;"><?= $total; ?></th>
        </tr>
    </table>
    <br>
    <br>
    <div style="text-align: right;">Sragen, <?= date('d'); ?> <?= bulan(date('m'))['bulan']; ?> <?= date('Y'); ?></div>
    <table style="border: 0px;">
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;width:50%;">Kepala</td>
            <td rowspan="3" style="text-align: center;border:0px;"><img style="text-align: center;" src="<?= set_qr_code(base_url('public/djana/inventaris/') . $jwt, 'djana', 'Laporan Djana'); ?>" alt="Laporan Djana"></td>
            <td style="text-align: center;border:0px;width:50%;">Bagian Inventaris</td>
        </tr>
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;"></td>
            <td style="text-align: center;border:0px;"></td>
        </tr>
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;">M. Dimyati</td>
            <td style="text-align: center;border:0px;">Ibnu Sulaiman</td>
        </tr>
    </table>

</body>

</html>