<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <!-- Button trigger modal -->
    <div class="input-group input-group-sm mb-3">

        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tahun [<?= url(4); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($data['tahun'] as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == $i ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i; ?>/<?= url(5); ?>"><?= $i; ?></a></li>
            <?php endforeach; ?>
            <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/All/<?= url(5); ?>">All</a></li>
        </ul>
        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Bulan [<?= url(5); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach (bulan() as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == $i['angka'] ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= $i['angka']; ?>"><?= $i['bulan']; ?></a></li>
            <?php endforeach; ?>
            <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/All">All</a></li>
        </ul>

    </div>



    <?php if (count($data['data']) == 0) : ?>
        <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
    <?php else : ?>
        <div class="input-group input-group-sm">
            <span style="width: 92px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." class="input-group-text">Cari <?= menu()['menu']; ?></span>
            <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." type="text" class="form-control cari" placeholder="...">
        </div>
        <div class="check_all_pesanan d-none mt-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Check All" href="" class="btn_bright_sm btn_check_all_pesanan" style="font-style:italic;"><i class="fa-solid fa-list-check"></i> Check All</a>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th class="d-none d-md-table-cell">Tgl</th>
                    <th>Barang</th>
                    <th class="d-none d-md-table-cell">Keluar</th>
                    <th class="d-none d-md-table-cell">Masuk</th>
                    <th>Laba</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data['data'] as $k => $i) : ?>
                    <tr>
                        <th scope="row" style="width: 35px;"><?= ($k + 1); ?></th>
                        <td class="d-none d-md-table-cell"><?= $i['tgl']; ?></td>
                        <td><?= $i['barang']; ?></td>
                        <td class="d-none d-md-table-cell" style="text-align: right;"><?= $i['keluar']; ?></td>
                        <td class="d-none d-md-table-cell" style="text-align: right;"><?= $i['masuk']; ?></td>
                        <td style="text-align: right;"><?= $i['laba']; ?></td>
                        <td style="text-align: center;"><a href="" class="main_color detail_djana" data-id="<?= $i['barang_id']; ?>" data-tabel="pesanan"><i class="fa-solid fa-circle-info"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="d-none d-md-table-cell" colspan="3" style="font-weight:500;text-align:center;">TOTAL</td>
                    <td class="d-md-none d-sm-table-cell" colspan="2" style="font-weight:500;text-align:center;">TOTAL</td>
                    <td class="d-none d-md-table-cell" style="text-align: right;"><?= $data['totalKeluar']; ?></td>
                    <td class="d-none d-md-table-cell" style="text-align: right;"><?= $data['totalMasuk']; ?></td>
                    <td style="text-align: right;"><?= $data['totalLaba']; ?></td>
                    <td style="text-align: center;"><a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cetak excel." href="<?= base_url(menu()['controller']); ?>/cetak/excel/<?= encode_jwt(['tahun' => url(4), 'bulan' => url(5)]); ?>" class="success_color" style="font-size: medium;"><i class="fa-regular fa-file-excel"></i></a> <a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cetak pdf." href="<?= base_url(menu()['controller']); ?>/cetak/pdf/<?= encode_jwt(['tahun' => url(4), 'bulan' => url(5)]); ?>" class="text_grey_mid" style="font-size: medium;"><i class="fa-solid fa-file-pdf"></i></a></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- modal detail -->
    <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content body_detail">

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>