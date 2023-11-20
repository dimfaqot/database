<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url(); ?>berkas/menu/karyawan.png" sizes="16x16">
</head>

<body>
    <?= $data['img_profile']; ?>
    <br>
    <br>
    <table>
        <?php foreach ($cols as $c) : ?>
            <?php if ($c['tipe'] == 'teks') : ?>
                <tr>
                    <th style="text-align: left;"><?= upper_first(str_replace("_", " ", $c['col'])); ?></th>
                    <td>:</td>
                    <td><?= $data[$c['col']]; ?></td>>
                </tr>

            <?php else : ?>
                <tr>
                    <th style="text-align: left;"><?= upper_first(str_replace("_", " ", $c['col'])); ?></th>
                    <td>:</td>
                    <td><a target="_blank" href="<?= base_url(); ?>berkas/<?= menu()['controller']; ?>/<?= $data[$c['col']]; ?>">Klik Link</a></td>>

                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</body>

</html>