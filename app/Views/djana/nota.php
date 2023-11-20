<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <!-- Button trigger modal -->
    <div class="input-group input-group-sm mb-3">
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> Tambah <?= menu()['menu']; ?>
        </button>
        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tahun [<?= url(4); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($tahun as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == $i ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i; ?>/<?= url(5); ?>/<?= url(6); ?>"><?= $i; ?></a></li>
            <?php endforeach; ?>
            <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/All/<?= url(5); ?>">All</a></li>
        </ul>
        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Bulan [<?= url(5); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach (bulan() as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == $i['angka'] ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= $i['angka']; ?>/<?= url(5); ?>/<?= url(6); ?>"><?= $i['bulan']; ?></a></li>
            <?php endforeach; ?>
            <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/All">All</a></li>
        </ul>

    </div>

    <?php if (count($data) == 0) : ?>
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
                    <th>No. Nota</th>
                    <th>Pembeli</th>
                    <th class="d-none d-md-table-cell">Teller</th>
                    <th>Total</th>
                    <th>Ket</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row" style="width: 35px;"><?= ((int)$k + 1); ?></th>
                        <td class="d-none d-md-table-cell"><?= date('d/m/Y', $i['profile']['tgl']); ?></td>
                        <td><?= $i['profile']['no_nota']; ?></td>
                        <td><?= $i['profile']['pembeli']; ?></td>
                        <td class="d-none d-md-table-cell"><?= $i['profile']['teller']; ?></td>
                        <td style="text-align: right;"><?= rupiah($i['profile']['total']); ?></td>
                        <td><a class="main_color" href="" data-bs-toggle="modal" data-bs-target="#detail_<?= $i['profile']['no_nota']; ?>" role="button"><i class="fa-solid fa-circle-info"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal detail-->
        <?php foreach ($data as $i) : ?>

            <div class="modal fade" id="detail_<?= $i['profile']['no_nota']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="d-flex justify-content-between btn_main_inactive py-2 px-3" style="border-radius:0px;">
                            <div>
                                <div class="main_color"><i class="fa-regular fa-clipboard"></i> <?= $i['profile']['pembeli']; ?> <?= $i['profile']['no_nota']; ?></div>

                            </div>
                            <a href="" data-bs-dismiss="modal" class="danger_color">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        </div>
                        <div class="modal-body py-2">

                            <div class="card">
                                <div class="row g-3 mb-2">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Tanggal</span>
                                            <input type="text" class="form-control" readonly value="<?= date('d/m/Y', $i['profile']['tgl']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Pembeli</span>
                                            <input type="text" class="form-control" readonly value="<?= $i['profile']['pembeli']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">No. Nota</span>
                                            <input type="text" class="form-control" readonly value="<?= $i['profile']['no_nota']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Barang</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($i['detail'] as $k => $d) : ?>
                                            <tr>
                                                <th><?= ($k + 1); ?></th>
                                                <td><?= $d['barang']; ?></td>
                                                <td style="text-align: center;" contenteditable="true" class="qty" data-id="<?= $d['id']; ?>" data-harga="<?= $d['harga']; ?>"><?= $d['qty']; ?></td>
                                                <td style="text-align: right;" class="harga_<?= $d['id']; ?>"><?= rupiah($d['harga']); ?></td>
                                                <td style="text-align: right;"><?= rupiah($d['jml']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <th style="text-align: center;" colspan="4">Total</th>
                                            <th style="text-align: right;"><?= rupiah($i['profile']['total']); ?></th>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="d-grid text-center">
                                    <a target="_blank" href="<?= base_url(menu()['controller']); ?>/cetak/<?= encode_jwt([$i['profile']['no_nota']]); ?>" class="btn_main"><i class="fa-regular fa-clipboard"></i> Cetak</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>


    <!-- Modal add-->
    <div class="modal fade" id="<?= menu()['controller']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div class="main_color" style="font-weight: bold;"><i class="<?= menu()['icon']; ?>"></i> Tambah <?= menu()['menu']; ?></div>
                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                    </div>
                    <hr class="dark_color" style="border: 1px solid;">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>">
                            <div class="input-group input-group-sm">
                                <span style="width: 120px;" class="input-group-text">Cari Barang</span>
                                <input type="text" value="" class="form-control cari_barang" placeholder="Cari Barang">
                                <div class="bg-light body_cari_barang" style="z-index: 999px;position:absolute;left:0px;right:0px;top:25px;">

                                </div>
                            </div>
                            <table id="tabel_nota" class="table table-sm table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tgl</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Act</th>
                                    </tr>
                                </thead>
                                <tbody class="body_insert_nota">
                                    <tr class="remove_tr"></tr>
                                </tbody>

                            </table>
                            <div class="d-grid mt-3">
                                <button type="button" class="btn-sm btn_main create_nota"><i class="fa-regular fa-floppy-disk"></i> Create</button>
                            </div>



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>