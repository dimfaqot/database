<?php
$exp = explode(" ", $data['nama']);

$size = 70;
if (count($exp) == 3) {
    $size = 65;
}
if (count($exp) == 4) {
    $size = 60;
}
if (count($exp) == 5) {
    $size = 55;
}
if (count($exp) == 6) {
    $size = 50;
}
if (count($exp) == 7) {
    $size = 45;
}
if (count($exp) == 8) {
    $size = 40;
}
if (count($exp) > 8) {
    $size = 35;
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong">
    <link rel="icon" type="image/png" href="<?= base_url(); ?>berkas/menu/karyawan.png" sizes="16x16">

</head>

<body>

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

    <div style="text-align: center; padding-top:10px;">
        <span style="font-size:14px;font-weight:bold;font-style:italic;font-family:Arial, Helvetica, sans-serif;">Nomor: <?= $data['no_surat']; ?></span>
    </div>
    <br>
    <br>
    <br>


    <div style="text-align: center;">
        <span style="font-size:<?= $size; ?>px;border-bottom:1px solid black;text-align:bold;font-family:lobster"><?= $data['nama']; ?></span>
    </div>
    <div style="text-align: center;font-family:Arial, Helvetica, sans-serif;color:#526D82">Atas Prestasinya Menjadi <?= $data['sebagai']; ?> <?= $data['lomba']; ?></div>
    <div style="text-align: center;font-family:Arial, Helvetica, sans-serif;color:#526D82; font-style:italic">Dengan Capaian</div>
    <div style="text-align: center;">
        <span style="font-size:40px;text-align:bold;font-family:lobster">- <?= $data['capaian']; ?> -</span>
    </div>

    <div style="text-align: center;">Mengetahui,</div>


    <table style="width: 100%;">
        <tr>
            <td style="text-align: center; width:50%;"></td>
            <td style="text-align: center; width:50%;">Sragen, <?= date('d', $data['tgl']) . ' ' . bulan(date('m', $data['tgl']))['bulan'] . ' ' . date('Y', $data['tgl']); ?></td>
        </tr>
        <tr>
            <td style="text-align: center; width:50%;">Ketua Yayasan</td>
            <td style="text-align: center; width:50%;">Kepala Sekolah</td>
        </tr>
        <tr>
            <td style="text-align:center;"><?= ($data['is_ttd']  ? $data['ttd_ketua_ypp'] : '<br><br><br><br><br><br>'); ?></td>
            <td style="text-align:center;"><?= ($data['is_ttd']  ? $data['ttd_kepala'] : ''); ?></td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight:bold;"><?= $data['ketua_ypp']; ?></td>
            <td style="text-align: center; font-weight:bold;"><?= $data['kepala']; ?></td>
        </tr>
    </table>

    <div style="position:absolute;bottom:0px;right:0px;z-index:10;">
        <img width="100px;" src="<?= set_qr_code(base_url('public/piagam/') . encode_jwt([$data['id']]), 'karyawan', 'Piagam'); ?>" alt="Piagam <?= $data['nama']; ?>">

    </div>
</body>

</html>