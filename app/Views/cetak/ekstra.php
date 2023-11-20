<?php
$exp = explode(" ", $data['profile']['nama']);

$size = 56;
if (count($exp) == 3) {
    $size = 55;
}
if (count($exp) == 4) {
    $size = 50;
}
if (count($exp) == 5) {
    $size = 45;
}
if (count($exp) == 6) {
    $size = 40;
}
if (count($exp) == 7) {
    $size = 35;
}
if (count($exp) == 8) {
    $size = 30;
}
if (count($exp) > 8) {
    $size = 25;
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url(); ?>berkas/menu/ekstra.png" sizes="16x16">
    <style>
        table,
        td,
        th {
            border: 1px solid #033d62;
        }


        tr {
            height: 10px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0px;
        }
    </style>

</head>

<body>

    <?php if ($k % 2 == 0) : ?>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;text-align:center;">
            <span style="border-bottom:1px solid #033d62;color:#033d62">NOMOR: <?= $data['profile']['kode']; ?></span>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div style="font-size:<?= $size; ?>px;font-family:lobster;font-weight:bold;text-align:center;color:#033d62">
            <?= $data['profile']['nama']; ?>
        </div>

        <br>
        <br>

        <div style="font-size:50px;font-family:lobster;text-align:center;color:#033d62">
            <?= $data['profile']['ekstra']; ?>
        </div>
    <?php else : ?>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table style="border: none;color:#033d62;font-family:Arial, Helvetica, sans-serif;">
            <tr style="border: none;">
                <th style="border:none;text-align: left;width:100px;">No. Peserta</th>
                <th style="border:none;text-align: left;width:2px;">:</th>
                <th style="border:none;text-align: left;"><?= $data['profile']['no_id']; ?></th>
            </tr>
            <tr style="border: none;">
                <th style="border:none;text-align: left;width:100px;">Nama</th>
                <th style="border:none;text-align: left;width:2px;">:</th>
                <th style="border:none;text-align: left;"><?= $data['profile']['nama']; ?></th>
            </tr>
            <tr style="border: none;">
                <th style="border:none;text-align: left;width:100px;">Kelas</th>
                <th style="border:none;text-align: left;width:2px;">:</th>
                <th style="border:none;text-align: left;"><?= $data['profile']['kelas']; ?></th>
            </tr>
            <tr style="border: none;">
                <th style="border:none;text-align: left;width:100px;">Jurusan</th>
                <th style="border:none;text-align: left;width:2px;">:</th>
                <th style="border:none;text-align: left;"><?= $data['profile']['ekstra']; ?></th>
            </tr>
        </table>
        <br>
        <table style="color: #033d62;">
            <tr>
                <th>No.</th>
                <th>Mata Pelajaran</th>
                <th>SKS</th>
                <th>Nilai</th>
            </tr>
            <?php foreach ($data['data'] as $k => $i) : ?>
                <tr>
                    <td style="text-align: center;padding:5px;"><?= ($k + 1); ?></td>
                    <td style="padding: 5px;"><?= $i['mapel']; ?></td>
                    <td style="text-align: center;padding:5px;"><?= $i['sks']; ?></td>
                    <td style="text-align: center;padding:5px;"><?= $i['nilai']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <br>
        <div style="font-size:14px; text-align: right;font-family:Arial, Helvetica, sans-serif;color:#033d62;">Sragen, <?= date('d', $data['profile']['tgl']); ?> <?= bulan(date('m', $data['profile']['tgl']))['bulan']; ?> <?= date('Y', $data['profile']['tgl']); ?></div>
        <div style="font-size:14px; text-align: right;font-family:Arial, Helvetica, sans-serif;color:#033d62;">Kepala Jurusan</div>
        <div style="font-size:14px;font-family:Arial, Helvetica, sans-serif;text-align:right;color:#033d62; font-weight:bold;padding-top:70px;">

            <?= $data['profile']['kepala']; ?>
        </div>

    <?php endif; ?>


    <div style="position:absolute;bottom:0px;right:0px;z-index:10;">
        <img width="100px;" src="<?= set_qr_code(base_url('public/ekstra/cetak/pdf/') . encode_jwt([$data['profile']['kode']]), 'ekstra', 'Ekstrakurikuler'); ?>" alt="Ekstrakurikuler <?= $data['profile']['nama']; ?>">

    </div>

</body>

</html>