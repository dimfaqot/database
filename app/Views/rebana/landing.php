<?= $this->extend('guest') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top:55px;margin-bottom:100px;margin-bottom:100px;">

    <div class="row g-4">
        <div class="col-md-6">
            <img width="70" src="<?= base_url(); ?>berkas/menu/rebana.png" alt="Logo">
            <h1 class="mt-4">Rebana Walisongo Sragen</h1>
            <p style="font-size: medium;">Media dakwah Islam kesenian sholawat rebana di bawah pimpinan K.H. Ma'ruf Islamuddin. Beliau juga Pengasuh <a class="btn_secondary_inactive" href="<?= base_url(); ?>public/news/label/Pondok">Pondok Pesantren Walisongo Sragen.</a></p>
            <br>
            <a href="#jadwal_rebana" class="btn_main">Jadwal Rebana Walisongo Sragen</a>
            <a href="whatsapp://send/?phone=+6285647275725&text=Assalamualaikum Wr.Wb. Saya mau pesan jadwal rebana." class="btn_main"><i class="fa-brands fa-whatsapp"></i> Pemesanan Jadwal</a>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <a href="https://www.youtube.com/@RebanaWalisongoSragen" target="_blank" style="text-decoration: none;" class="card">
                        <div class="card-body text-center">
                            <i class="fa-brands fa-youtube main_color" style="font-size: 50px;"></i>
                            <p class="dark_color mt-3" style="font-size: medium;">Channel youtube resmi Rebana Walisongo Sragen. Berisi seluruh karya dalam bentuk video.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="https://www.instagram.com/rebanawalisongosragen9/" target="_blank" style="text-decoration: none;" class="card">
                        <div class="card-body text-center">
                            <i class="fa-brands fa-instagram main_color" style="font-size: 50px;"></i>
                            <p class="dark_color mt-3" style="font-size: medium;">Akun instagram resmi Rebana Walisongo Sragen. Berisi seluruh karya dalam bentuk video.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="https://www.facebook.com/RebanaWalisongoSragen1995/" target="_blank" style="text-decoration: none;" class="card">
                        <div class="card-body text-center">
                            <i class="fa-brands fa-facebook main_color" style="font-size: 50px;"></i>
                            <p class="dark_color mt-3" style="font-size: medium;">Akun facebook resmi Rebana Walisongo Sragen. Berisi seluruh karya dalam bentuk video.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="https://www.tiktok.com/@rebanawalisongosragen" target="_blank" style="text-decoration: none;" class="card">
                        <div class="card-body text-center">
                            <i class="fa-brands fa-tiktok main_color" style="font-size: 50px;"></i>
                            <p class="dark_color mt-3" style="font-size: medium;">Akun tiktok resmi Rebana Walisongo Sragen. Berisi seluruh karya dalam bentuk video.</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="mt-3">
                <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">SOSMED</h1>
                <?php foreach (sosmed('data') as $i) : ?>
                    <div class="d-grid mb-1">
                        <a class="btn_main_inactive" <?= (url() == '' ? 'target="_blank"' : ''); ?> style="border-color: #666666;border-radius:3px;" href="<?= $i['url']; ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['text']; ?></a>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <div class="col-md-6">
            <div id="demo" class="carousel slide" data-bs-ride="carousel">

                <!-- Indicators/dots -->
                <div class="carousel-indicators">
                    <?php foreach (get_files('rebana') as $k => $i) : ?>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $k; ?>" <?= ($k == 0 ? 'class="active"' : ''); ?>></button>
                    <?php endforeach; ?>
                </div>

                <!-- The slideshow/carousel -->
                <div class="carousel-inner">
                    <?php foreach (get_files('rebana') as $k => $i) : ?>
                        <div class="carousel-item <?= ($k == 0 ? 'active' : ''); ?>">
                            <img src="<?= base_url(); ?>/<?= $i; ?>" alt="Los Angeles" class="d-block" style="width:100%">
                        </div>

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

            <h1 class="btn_main mt-3" style="border-radius: 3px;border-color:#054552">BERITA REBANA</h1>
            <?php foreach (get_news('Rebana') as $k => $i) : ?>
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
    </div>



    <div class="row mt-2">
        <!-- mid/profile & settings -->
        <div class="col-sm-12 col-md-10">
            <!-- profile -->
            <div id="jadwal_rebana">
                <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">JADWAL REBANA <?= ($bulan == 'All' ? 'SEMUA BULAN' : 'BULAN ' . strtoupper($bulan)); ?> <?= ($tahun == 'All' ? 'SEMUA TAHUN' : 'TAHUN ' . strtoupper($tahun)); ?></h1>
                <div class="d-flex btn_main_inactive gap-2 mb-2" style="border-radius: 2px;">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tahun [<?= (url(5) == '' ? $tahun : url(5)); ?>]
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($tahuns as $i) : ?>
                            <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == '' && $i == $tahun ? 'bg_main' : (url(5) !== '' && $i == url(5) ? 'bg_main' : '')); ?>" href="<?= base_url('public/rebana/'); ?><?= $i; ?>/<?= (url(6) == '' ? bulan($bulan)['angka'] : url(6)); ?>"><?= $i; ?></a></li>
                        <?php endforeach; ?>
                        <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url('public/rebana/'); ?>All/<?= (url(6) == '' ? bulan($bulan)['angka'] : url(6)); ?>">All</a></li>
                    </ul>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Bulan [<?= (url(6) == '' ? bulan($bulan)['angka'] : url(6)); ?>]
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach (bulan() as $i) : ?>
                            <li style="font-size: small;"><a class="dropdown-item <?= (url(6) == '' && $i['angka'] == bulan($bulan)['angka'] ? 'bg_main' : (url(6) !== '' && $i['angka'] == url(6) ? 'bg_main' : '')); ?>" href="<?= base_url('public/rebana/'); ?><?= (url(5) == '' ? $tahun : url(5)); ?>/<?= $i['angka']; ?>"><?= $i['bulan']; ?></a></li>
                        <?php endforeach; ?>
                        <li style="font-size: small;"><a class="dropdown-item <?= (url(6) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url('public/rebana/'); ?><?= (url(5) == '' ? $tahun : url(5)); ?>/All">All</a></li>
                    </ul>
                    <a target="_blank" href="<?= base_url(); ?>public/rebana/cetak/<?= (url(5) == '' ? $tahun : url(5)); ?>/<?= (url(6) == '' ? bulan($bulan)['angka'] : url(6)); ?>/excel" class="btn_bright_sm"><i class="fa-regular fa-file-excel"></i></a>
                    <a target="_blank" href="<?= base_url(); ?>public/rebana/cetak/<?= (url(5) == '' ? $tahun : url(5)); ?>/<?= (url(6) == '' ? bulan($bulan)['angka'] : url(6)); ?>/pdf" class="btn_bright_sm"><i class="fa-regular fa-file-pdf"></i></a>
                </div>

                <?php if (count($data) == 0) : ?>
                    <div class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Data tidak ditemukan!.</div>
                <?php else : ?>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Ket.</th>
                                <th scope="col">Lagu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $k => $i) : ?>
                                <tr>
                                    <th scope="row"><?= $k + 1; ?></th>
                                    <td><?= date('d/m/Y', $i['tgl']); ?></td>
                                    <td><?= $i['alamat']; ?></td>
                                    <td><?= $i['keterangan']; ?></td>
                                    <td><a data-bs-toggle="modal" data-bs-target="#daftar_lagu_<?= $i['id']; ?>" type="button" class="dark_color" href=""><i class="fa-solid fa-music"></i></a></td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>


                <?php endif; ?>


                <?php foreach ($data as $i) : ?>
                    <div class="modal fade" id="daftar_lagu_<?= $i['id']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-music"></i> Daftar Lagu</div>
                                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                                    </div>
                                    <hr class="dark_color" style="border: 1px solid;">
                                    <div class="card">
                                        <div class="card-body">
                                            <?php
                                            $songs = $i['lagu'];
                                            $exp = explode(",", $songs);
                                            ?>
                                            <table class="table table-bordered">
                                                <?php if ($songs !== '') : ?>
                                                    <?php foreach ($exp as $k => $e) : ?>
                                                        <tr>
                                                            <th scope="row" style="width: 40px;"><?= ($k + 1); ?></th>
                                                            <td><?= $e; ?></td>
                                                        </tr>


                                                    <?php endforeach; ?>

                                                <?php endif; ?>
                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


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