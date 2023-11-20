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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>


    <div style="font-size:25px;font-family:lobster;font-weight:bold; margin-left:233px; padding-top:-5px;">
        <?= ($data['nama'] == '' ? '-' : $data['nama']); ?>
    </div>

    <div style="font-size:25px;font-family:lobster;font-weight:bold; margin-left:233px;padding-top:-2px;">
        <?= ($data['alamat'] == '' ? '-' : $data['alamat']); ?>
    </div>
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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <div style="font-size:17px;font-family:lobster;font-weight:bold; margin-left:380px; padding-top:-6px;">
        <?= no_pilangsari($data['no']); ?>
    </div>

    <div style="position:absolute;bottom:5px;right:5px;z-index:10;">
        <img width="100px;" src="<?= set_qr_code(base_url('public/pilangsari/') . encode_jwt([$data['no']]), 'karyawan', 'Pilangsari'); ?>" alt="Pilangsari <?= $data['nama']; ?>">
    </div>

</body>

</html>