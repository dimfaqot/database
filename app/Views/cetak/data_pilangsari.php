<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= base_url(); ?>berkas/menu/karyawan.png" sizes="16x16">
    <style>
        table,
        td,
        th {
            border: 1px solid;

        }

        th,
        td {
            padding: 5px;
        }

        /* tr {
            height: 10px;
        } */

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 2px;
        }
    </style>
    <title><?= $judul; ?></title>


</head>

<body style="font-size:13px;">
    <h4 style="text-align: center;"><?= strtoupper($judul); ?></h4>
    <table>
        <tr>
            <?php foreach ($cols as $c) : ?>
                <?php if ($order == 'non') : ?>
                    <?php if ($c !== 'created_at' && $c !== 'updated_at' && $c !== 'petugas' && $c !== 'qr_code' && $c !== 'jenis' && $c !== 'ket') : ?>
                        <th><?= upper_first(str_replace("_", " ", $c)); ?></th>
                    <?php endif; ?>

                <?php else : ?>
                    <?php if ($c !== 'created_at' && $c !== 'updated_at' && $c !== 'petugas' && $c !== 'qr_code' && $c !== 'jenis' && $c !== 'jml_uang') : ?>
                        <th><?= upper_first(str_replace("_", " ", $c)); ?></th>
                    <?php endif; ?>

                <?php endif; ?>
            <?php endforeach; ?>
        </tr>

        <?php foreach ($data as $k => $i) : ?>
            <tr>
                <?php foreach ($cols as $c) : ?>
                    <?php if ($order == 'non') : ?>
                        <?php if ($c !== 'created_at' && $c !== 'updated_at' && $c !== 'petugas' && $c !== 'qr_code' && $c !== 'jenis' && $c !== 'ket') : ?>
                            <td><?= ($c == 'jml_uang' ? rupiah($i[$c]) : $i[$c]); ?></td>
                        <?php endif; ?>

                    <?php else : ?>
                        <?php if ($c !== 'created_at' && $c !== 'updated_at' && $c !== 'petugas' && $c !== 'qr_code' && $c !== 'jenis' && $c !== 'jml_uang') : ?>
                            <td><?= ($c == 'ket' ? ($i[$c] == 1 ? 'Lunas' : 'Belum') : $i[$c]); ?></td>
                        <?php endif; ?>

                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>