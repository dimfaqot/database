<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= base_url(); ?>berkas/menu/karyawan.png" sizes="16x16">
    <style>
        /* table,
        td,
        th {
            border: 1px solid;
        } */

        tr {
            height: 10px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 2px;
        }
    </style>
    <title><?= $judul; ?></title>


</head>

<body style="font-size:13px;">

    <?= $data['kop']; ?>
    <div style="margin-top:20px; font-size:14px;">
        <div style="text-align: center;"><b>SURAT KEPUTUSAN</b></div>
        <div style="text-align: center;"><b>YAYASAN PONDOK PESANTREN WALISONGO SRAGEN</b></div>
        <div style="text-align: center;"><b>Nomor: <?= $data['no_sk']; ?></b></div>
        <br>
        <div style="text-align: center;"><b>TENTANG</b></div>
        <div style="text-align: center;"><b>PENGANGKATAN <?= strtoupper($data['jenis']); ?></b></div>

    </div>
    <br>
    <br>
    <table>
        <tr>
            <td style="width: 18%; vertical-align:top"><b>Menimbang</b></td>
            <td style="width: 2%; vertical-align:top"><b>:</b></td>
            <td style="width: 3%; vertical-align:top">1.</td>
            <td style="width: 77%; text-align:justify;">Bahwa dalam rangka pemenuhan tenaga guru dan atau tenaga lainnya untuk mendukung proses belajar mengajar dan atau kegiatan di sekolah lainnya, maka dipandang perlu segera diambil keputusan.</td>
        </tr>
        <tr>
            <td style="width: 18%;"></td>
            <td style="width: 2%;"></td>
            <td style="width: 3%; vertical-align:top">2.</td>
            <td style="width: 77%; text-align:justify;">Bahwa yang tercatat namanya dalam keputusan ini dipandang cakap dan mampu melaksanakan tugas yang diberikan kepadanya.</td>
        </tr>
        <tr>
            <td style="width: 18%;"></td>
            <td style="width: 2%;"></td>
            <td style="width: 3%;">3.</td>
            <td style="width: 77%; text-align:justify;">Untuk maksud di atas, dipandang perlu menerbitkan surat keputusan.</td>
        </tr>
        <br>
        <tr>
            <td style="width: 18%;"><b>Mengingat</b></td>
            <td style="width: 2%;"><b>:</b></td>
            <td style="width: 3%;">1.</td>
            <td style="width: 77%; text-align:justify;">AD dan ART Yayasan Pondok Pesantren Walisongo Sragen.</td>
        </tr>
        <tr>
            <td style="width: 18%;"></td>
            <td style="width: 2%;"></td>
            <td style="width: 3%;">2.</td>
            <td style="width: 77%; text-align:justify;">Peraturan Kepegawaian Yayasan Pondok Pesantren Walisongo Sragen.</td>
        </tr>
        <br>
        <tr>
            <td style="width: 18%;vertical-align:top"><b>Memperhatikan</b></td>
            <td style="width: 2%;vertical-align:top"><b>:</b></td>
            <td style="width: 3%;vertical-align:top">1.</td>
            <td style="width: 77%; text-align:justify;">Hasil musyawarah Pengurus Yayasan Pondok Pesantren Walisongo Sragen pada tanggal <?= $data['rapat']; ?></td>
        </tr>
    </table>
    <br>
    <br>
    <div style="text-align: center;"><b>MEMUTUSKAN</b></div>
    <br>
    <table>
        <tr>
            <td style="width: 18%;"><b>Menetapkan</b></td>
            <td style="width: 2%;"><b>:</b></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 18%;"><b>Pertama</b></td>
            <td style="width: 2%;"><b>:</b></td>
            <td style="width: 40%;">Pegawai di bawah ini:</td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width: 20%;"></td>
            <td style="width: 20%;">Nama</td>
            <td style="width: 2%;">:</td>
            <td style="width: 53%;"><?= $data['nama']; ?></td>
        </tr>
        <tr>
            <td style="width: 20%;"></td>
            <td style="width: 20%;">Tempat, Tanggal Lahir</td>
            <td style="width: 2%;">:</td>
            <td style="width: 53%;"><?= $data['ttl']; ?></td>
        </tr>
        <tr>
            <td style="width: 20%;"></td>
            <td style="width: 20%;">NIY</td>
            <td style="width: 2%;">:</td>
            <td style="width: 53%;"><?= $data['no_id']; ?></td>
        </tr>
        <tr>
            <td style="width: 20%;"></td>
            <td style="width: 20%;">Pendidikan Terakhir</td>
            <td style="width: 2%;">:</td>
            <td style="width: 53%;"><?= $data['pendidikan']; ?></td>
        </tr>
        <tr>
            <td style="width: 20%;"></td>
            <td style="width: 20%;">Jabatan</td>
            <td style="width: 2%;">:</td>
            <td style="width: 53%;"><?= $data['jabatan']; ?></td>
        </tr>
        <tr>
            <td style="width: 20%;"></td>
            <td style="width: 20%;">Unit Kerja</td>
            <td style="width: 2%;">:</td>
            <td style="width: 53%;"><?= $data['sub']; ?></td>
        </tr>
        <?php if ($data['tugas'] !== "" && $data['tugas'] !== "-") : ?>
            <tr>
                <td style="width: 20%;"></td>
                <td style="width: 20%;">Tugas Tambahan</td>
                <td style="width: 2%;">:</td>
                <td style="width: 53%;"><?= $data['tugas']; ?></td>
            </tr>
        <?php endif; ?>
        <br>

    </table>
    <br>
    <table>
        <tr>
            <td style="width: 20%;"></td>
            <td style="width: 80%; text-align:justify; font-size:14px;"><b>Terhitung mulai tanggal <?= $data['diangkat']; ?> diangkat menjadi <?= $data['jenis']; ?> unit kerja <?= $data['sub']; ?>.</b></td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td style="width: 18%;vertical-align: top;"><b>Kedua</b></td>
            <td style="width: 2%;vertical-align: top;"><b>:</b></td>
            <td style="width: 80%; text-align:justify;">Apabila di kemudian hari ternyata terdapat kekeliruan dalam keputusan ini, akan diadakan perbaikan dan penghitungan kembali sebagaimana mestinya.</td>
        </tr>
        <tr>
            <td style="width: 18%;vertical-align: top;"><b>Ketiga</b></td>
            <td style="width: 2%;vertical-align: top;"><b>:</b></td>
            <td style="width: 80%; text-align:justify;">Keputusan ini diberikan kepada yang bersangkutan dan yang berkepentingan untuk diketahui serta dipergunakan sebagaimana mestinya.</td>
        </tr>

    </table>
    <br>
    <br>
    <br>
    <table>
        <tr>
            <td style="width:63%;"></td>
            <td style="width: 13%;">Ditetapkan di</td>
            <td style="width: 2%;"><b>:</b></td>
            <td style="width: 25%;">Sragen</td>
        </tr>
        <tr>
            <td style="width:63%;"></td>
            <td style="width: 13%;">Pada Tanggal</td>
            <td style="width: 2%;"><b>:</b></td>
            <td style="width: 25%;"><?= $data['penetapan']; ?></td>
        </tr>

    </table>
    <br>
    <table>
        <tr>
            <td style="width:63%;"></td>
            <td style="width: 37%; text-align:center;">Ketua Yayasan</td>
        </tr>

    </table>
    <?php if ($data['is_ttd'] === false) : ?>
        <br>
        <br>
        <br>
        <br>
        <table>
            <tr>
                <td style="width:63%;"></td>
                <td style="width: 37%; text-align:center;"><?= $data['ketua_ypp']; ?></td>
            </tr>
        </table>
    <?php else : ?>
        <table>
            <tr>
                <td style="width:63%;"></td>
                <td style="width: 37%; text-align:center;"><?= $data['ttd']; ?></td>
            </tr>
            <tr>
                <td style="width:63%;"></td>
                <td style="width: 37%; text-align:center;"><?= $data['ketua_ypp']; ?></td>
            </tr>
        </table>
    <?php endif; ?>
</body>

</html>