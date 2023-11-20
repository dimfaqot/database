<?= $this->extend('guest') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top:55px;margin-bottom:100px;margin-bottom:100px;">

    <div class="row g-4">
        <div class="col-md-6">
            <img width="70" src="<?= base_url(); ?>berkas/menu/djana.png" alt="Logo">
            <p style="font-size: medium;">Bidang usaha <a class="btn_secondary_inactive" href="<?= base_url(); ?>public/news/label/Pondok">Pondok Pesantren Walisongo Sragen.</a></p>
            <p>- Multimedia-Grafis - Editing - Shooting - Streaming</p>
            <div class="mt-3">
                <div>
                    <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">LAPORAN KEUANGAN <?= (url(6) == 'All' ? 'SEMUA BULAN' : 'BULAN ' . (url(6) == '' ? strtoupper(bulan(date('m'))['bulan']) : strtoupper(bulan(url(6))['bulan']))); ?> <?= (url(5) == 'All' ? 'SEMUA TAHUN' : 'TAHUN ' . strtoupper((url(5) == '' ? date('Y') : url(5)))); ?></h1>
                    <div class="d-flex btn_main_inactive gap-2 mb-2" style="border-radius: 2px;">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tahun [<?= (url(5) == '' ? date('Y') : url(5)); ?>]
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($data['tahun'] as $i) : ?>
                                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == '' && $i == date('Y') ? 'bg_main' : (url(5) !== '' && $i == url(5) ? 'bg_main' : '')); ?>" href="<?= base_url('public/djana/'); ?><?= $i; ?>/<?= (url(6) == '' ? bulan(date('m'))['angka'] : url(6)); ?>"><?= $i; ?></a></li>
                            <?php endforeach; ?>
                            <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url('public/djana/'); ?>All/<?= (url(6) == '' ? bulan(date('m'))['angka'] : url(6)); ?>">All</a></li>
                        </ul>
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bulan [<?= (url(6) == '' ? bulan(date('m'))['angka'] : url(6)); ?>]
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach (bulan() as $i) : ?>
                                <li style="font-size: small;"><a class="dropdown-item <?= (url(6) == '' && $i['angka'] == bulan(date('m'))['angka'] ? 'bg_main' : (url(6) !== '' && $i['angka'] == url(6) ? 'bg_main' : '')); ?>" href="<?= base_url('public/djana/'); ?><?= (url(5) == '' ? date('Y') : url(5)); ?>/<?= $i['angka']; ?>"><?= $i['bulan']; ?></a></li>
                            <?php endforeach; ?>
                            <li style="font-size: small;"><a class="dropdown-item <?= (url(6) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url('public/djana/'); ?><?= (url(5) == '' ? date('Y') : url(5)); ?>/All">All</a></li>
                        </ul>
                    </div>

                    <?php if (count($data['data']) == 0) : ?>
                        <div class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Data tidak ditemukan!.</div>
                    <?php else : ?>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tgl</th>
                                    <th scope="col">Barang</th>
                                    <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['data'] as $k => $i) : ?>
                                    <tr>
                                        <td scope="row"><?= $k + 1; ?></td>
                                        <td><?= $i['tgl']; ?></td>
                                        <td><?= $i['barang']; ?></td>
                                        <td style="text-align: right;"><?= $i['masuk']; ?></td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>


                    <?php endif; ?>
                </div>

            </div>

            <!-- nota -->
            <h1 class="btn_main mt-3" style="border-radius: 3px;border-color:#054552">NOTA <?= (url(6) == 'All' ? 'SEMUA BULAN' : 'BULAN ' . (url(6) == '' ? strtoupper(bulan(date('m'))['bulan']) : strtoupper(bulan(url(6))['bulan']))); ?> <?= (url(5) == 'All' ? 'SEMUA TAHUN' : 'TAHUN ' . strtoupper((url(5) == '' ? date('Y') : url(5)))); ?></h1>
            <div class="input-group btn_main_inactive input-group-sm" style="border-radius: 2px;">
                <input data-bs-toggle="tooltip" data-bs-placement="top" style="border-radius: 6px;font-size:10px;" data-bs-title="Cari daftar data di bawah." type="text" class="cari" placeholder="Cari nota...">
            </div>
            <?php if (count($nota['data']) == 0) : ?>
                <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
            <?php else : ?>
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
                        <?php foreach ($nota['data'] as $k => $i) : ?>
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
                <?php foreach ($nota['data'] as $i) : ?>

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
                                                        <td style="text-align: center;"><?= $d['qty']; ?></td>
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
                                            <a target="_blank" href="<?= base_url('public/djana'); ?>/nota/<?= encode_jwt([$i['profile']['no_nota']]); ?>" class="btn_main"><i class="fa-regular fa-clipboard"></i> Cetak</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>


        </div>
        <div class="col-md-6">
            <div id="demo" class="carousel slide" data-bs-ride="carousel">

                <!-- Indicators/dots -->
                <div class="carousel-indicators">
                    <?php foreach (get_files('djana') as $k => $i) : ?>
                        <?php if ($i !== 'berkas/djana/file_not_found.jpg') : ?>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $k; ?>" <?= ($k == 0 ? 'class="active"' : ''); ?>></button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- The slideshow/carousel -->
                <div class="carousel-inner">
                    <?php foreach (get_files('djana') as $k => $i) : ?>
                        <?php if ($i !== 'berkas/djana/file_not_found.jpg') : ?>
                            <div class="carousel-item <?= ($k == 0 ? 'active' : ''); ?>">
                                <img src="<?= base_url(); ?>/<?= $i; ?>" alt="Los Angeles" class="d-block" style="width:100%">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Left and right controls/icons -->
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

            <h1 class="btn_main mt-3" style="border-radius: 3px;border-color:#054552">STATISTIK KINERJA DJANA <?= (url(6) == 'All' ? 'SEMUA BULAN' : 'BULAN ' . (url(6) == '' ? strtoupper(bulan(date('m'))['bulan']) : strtoupper(bulan(url(6))['bulan']))); ?> <?= (url(5) == 'All' ? 'SEMUA TAHUN' : 'TAHUN ' . strtoupper((url(5) == '' ? date('Y') : url(5)))); ?></h1>
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>


            <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">SOSMED</h1>
            <?php foreach (sosmed('data') as $i) : ?>
                <div class="d-grid mb-1">
                    <a class="btn_main_inactive" <?= (url() == '' ? 'target="_blank"' : ''); ?> style="border-color: #666666;border-radius:3px;" href="<?= $i['url']; ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['text']; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



    <div class="row mt-2">
        <!-- mid/profile & settings -->
        <div class="col-sm-12 col-md-10">
            <!-- profile -->

            <h1 class="btn_main mt-3" style="border-radius: 3px;border-color:#054552">BERITA DJANA</h1>
            <?php foreach (get_news('Djana') as $k => $i) : ?>
                <?php if ($k < 5) : ?>
                    <a href="<?= base_url(); ?>public/news/single/<?= $i['slug']; ?>" class="card mb-2" style="max-width: 100%;text-decoration:none;color:#666666">
                        <div class="row g-0">
                            <div class="col-md-4 p-2">
                                <img src="<?= base_url(); ?>berkas/news/<?= $i['img']; ?>" class="img-fluid rounded-start" alt="<?= $i['judul']; ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title"><?= $i['judul']; ?></h6>
                                    <p class="card-text"><?= get_words($i['artikel']); ?></p>
                                    <p class="card-text"><small class="text-muted"><i class="fa-regular fa-clock"></i></span> <?= date('d/m/Y H:i:s', $i['tgl']); ?></small></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- right/banner -->
        <div class="col-sm-12 col-md-2 d-none d-md-block">
            <div class="row">
                <a href="<?= base_url(); ?>public/ppdb"><img width="200px" src="<?= base_url(); ?>berkas/ppdb/right_side.jpg" alt="BANNER"></a>
            </div>
        </div>
    </div>

    <!-- sm sosmed-->
    <div class="row">
        <div class="d-md-none d-sm-block">
            <div style="margin-bottom:20px;">
                <div class="col-sm-12 d-md-none d-sm-block">
                    <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">SOSMED</h1>
                    <?php foreach (sosmed('data') as $i) : ?>
                        <div class="d-grid mb-1">
                            <a class="btn_main_inactive" <?= (url() == '' ? 'target="_blank"' : ''); ?> style="border-color: #666666;border-radius:3px;" href="<?= $i['url']; ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['text']; ?></a>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>
        </div>
    </div>

    <!-- sm banner-->
    <div class="row">
        <div class="d-md-none d-sm-block">
            <div class="row">
                <a href="<?= base_url(); ?>public/ppdb"><img class="img-fluid" src="<?= base_url(); ?>berkas/ppdb/right_side.jpg" alt="BANNER"></a>

            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>