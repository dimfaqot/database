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

    <table>
        <tr>
            <th>No.</th>
            <?php foreach ($cols as $c) : ?>
                <th><?= upper_first(str_replace("_", " ", $c)); ?></th>
            <?php endforeach; ?>
            <?php if ($headers['custome_header']) : ?>
                <?php foreach ($headers['headers'] as $i) : ?>
                    <th><?= $i; ?></th>
                <?php endforeach; ?>
            <?php else : ?>
                <?php for ($i = 1; $i <= $headers['jml_kolom']; $i++) : ?>
                    <th><?= $i; ?></th>
                <?php endfor; ?>
            <?php endif; ?>
        </tr>

        <?php foreach ($data as $k => $i) : ?>
            <tr>
                <td style="text-align: center;"><?= $k + 1; ?></td>
                <?php foreach ($cols as $c) : ?>
                    <td><?= $i[$c]; ?></td>
                <?php endforeach; ?>
                <?php for ($i = 1; $i <= $headers['jml_kolom']; $i++) : ?>
                    <td></td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    $left = str_replace(".", '<br>', $headers['lower_kiri']);
    $center = str_replace(".", '<br>', $headers['lower_tengah']);
    $right = str_replace(".", '<br>', $headers['lower_kanan']);


    ?>

    <br><br>
    <table style="border: 0px;">
        <?php if ($headers['lower_tengah'] !== '') : ?>
            <tr style="border: 0px;">
                <td colspan="2" style="text-align:center;border: 0px;"><?= $center; ?></td>
            </tr>
        <?php endif; ?>
        <tr style="border: 0px;">
            <td style="width: 50%; text-align:center;border: 0px;"><?= $left; ?></td>
            <td style="width: 50%;text-align:center;border: 0px;"><?= $right; ?></td>
        </tr>
        <tr style="border: 0px;">
            <td style="border: 0px;"><br><br><br><br></td>
        </tr>
        <tr style="border: 0px;">

            <td style="width: 50%; text-align:center;border: 0px;"><?= ($headers['lower_kiri'] == '' ? '' : '(_______________________)'); ?></td>
            <td style="width: 50%; text-align:center;border: 0px;"><?= ($headers['lower_kanan'] == '' ? '' : '(_______________________)'); ?></td>

        </tr>
    </table>

</body>

</html>