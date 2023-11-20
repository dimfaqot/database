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

<body style="font-size:12px;">
    <h4 style="text-align: center;"><?= strtoupper($judul); ?></h4>
    <?php if (count($data) == 1) : ?>
        <table style="border: 0px;">
            <?php foreach ($data as $k => $i) : ?>
                <?php foreach ($cols as $c) : ?>
                    <tr style="border: 0px;">
                        <td style="border: 0px;width:150px;"><?= upper_first(str_replace("_", " ", $c)); ?></td>
                        <td style="border: 0px;width:5px;">:</td>
                        <td style="border: 0px;"><?= $i[$c]; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>

    <?php else : ?>
        <table>
            <tr>
                <th>No.</th>
                <?php foreach ($cols as $c) : ?>
                    <th><?= upper_first(str_replace("_", " ", $c)); ?></th>
                <?php endforeach; ?>
            </tr>

            <?php foreach ($data as $k => $i) : ?>
                <tr>
                    <td style="text-align: center;"><?= $k + 1; ?></td>
                    <?php foreach ($cols as $c) : ?>
                        <td><?= $i[$c]; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php endif; ?>

</body>

</html>