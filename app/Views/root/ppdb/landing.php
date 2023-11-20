<?= $this->extend('guest') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top:55px;margin-bottom:100px;">

    <div class="row g-4">
        <div class="col-md-6">
            <h1 class="mt-4">PENERIMAAN PESERTA DIDIK BARU (PPDB)</h1>
            <p style="font-size: medium;">Telah dibuka pendaftaran santri baru <a class="btn_secondary_inactive" href="<?= base_url(); ?>public/news/label/Pondok">Pondok Pesantren Walisongo Sragen.</a></p>
            <br>
            <a href="#info_ppdb" class="btn_main">Informasi PPDB</a>
            <a href="whatsapp://send/?phone=+6281327380033&text=Assalamualaikum Wr.Wb. Saya mohon informasi PPDB." class="btn_main"><i class="fa-brands fa-whatsapp"></i> Kirim Chat</a>
            <div id="demo" class="carousel slide mt-3" data-bs-ride="carousel">

                <!-- Indicators/dots -->
                <div class="carousel-indicators">
                    <?php foreach (get_files('ppdb/public') as $k => $i) : ?>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $k; ?>" <?= ($k == 0 ? 'class="active"' : ''); ?>></button>
                    <?php endforeach; ?>
                </div>

                <!-- The slideshow/carousel -->
                <div class="carousel-inner">
                    <?php foreach (get_files('ppdb/public') as $k => $i) : ?>
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
        </div>
        <div class="col-md-6 p-0">
            <h1 class="btn_main mt-3" style="border-radius: 3px;border-color:#054552">BERITA PPDB</h1>
            <?php foreach (get_news('Ppdb') as $k => $i) : ?>
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



    <div class="row mt-3">
        <!-- left akun medsos -->
        <div class="col-sm-12 col-md-3 d-none d-md-block">
            <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">SOSMED</h1>
            <?php foreach (sosmed('data') as $i) : ?>
                <div class="d-grid mb-1">
                    <a class="btn_main_inactive" <?= (url() == '' ? 'target="_blank"' : ''); ?> style="border-color: #666666;border-radius:3px;" href="<?= $i['url']; ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['text']; ?></a>
                </div>
            <?php endforeach; ?>

        </div>

        <!-- mid/profile & settings -->
        <div class="col-sm-12 col-md-7">
            <!-- profile -->
            <div id="info_ppdb">
                <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">PENDAFTAR PPDB TAHUN AJARAN <?= tahun_santri('ppdb'); ?>/<?= tahun_santri('ppdb') + 1; ?></h1>
                <div class="d-flex btn_main_inactive gap-2 mb-2" style="border-radius: 2px;">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sub [<?= (url(5) == '' ? $sub : url(5)); ?>]
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach (sub() as $i) : ?>
                            <?php if ($i['singkatan'] == 'SMP' || $i['singkatan'] == 'SMA') : ?>
                                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == '' && $i['singkatan'] == $sub ? 'bg_main' : (url(5) !== '' && $i['singkatan'] == url(5) ? 'bg_main' : '')); ?>" href="<?= base_url('public/ppdb/'); ?><?= $i['singkatan']; ?>/<?= url(6) == '' ? $gender : url(6); ?>"><?= $i['singkatan']; ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url('public/ppdb/'); ?><?= (url(5) == '' ? $sub : url(5)); ?>/All">All</a></li>
                    </ul>

                    <a href="<?= base_url(); ?>public/ppdb/<?= (url(5) == '' ? $sub : url(5)); ?>/L" class="btn_bright_sm"><i class="fa-solid fa-mars"></i> L</a>
                    <a href="<?= base_url(); ?>public/ppdb/<?= (url(5) == '' ? $sub : url(5)); ?>/P" class="btn_bright_sm"><i class="fa-solid fa-venus"></i> P</a>
                    <a href="<?= base_url(); ?>public/ppdb/<?= (url(5) == '' ? $sub : url(5)); ?>/All" class="btn_bright_sm"><i class="fa-solid fa-venus-mars"></i> All</a>
                    <input type="text" class="cari" style="border-radius: 5px; border-color:#f1f1f1;" placeholder="Cari nama...">
                </div>

                <?php if (count($data) == 0) : ?>
                    <div class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Data tidak ditemukan!.</div>
                <?php else : ?>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">P/L</th>
                                <th scope="col">Sub</th>
                                <th scope="col">Alamat</th>
                            </tr>
                        </thead>
                        <tbody class="tabel_search">
                            <?php foreach ($data as $k => $i) : ?>
                                <tr>
                                    <td scope="row"><?= $k + 1; ?></td>
                                    <td><?= $i['nama']; ?></td>
                                    <td><?= $i['gender']; ?></td>
                                    <td><?= $i['sub']; ?></td>
                                    <td><?= $i['kabupaten']; ?></td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>


                <?php endif; ?>


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

    <div class="row p-5 g-3">
        <div class="col-md-3">
            <a href="https://www.youtube.com/channel/UCMq4x3Jkg85t-3JszlX62Pg/" target="_blank" style="text-decoration: none;" class="card">
                <div class="card-body text-center">
                    <i class="fa-brands fa-youtube main_color" style="font-size: 50px;"></i>
                    <p class="dark_color mt-3" style="font-size: medium;">Channel youtube resmi Ponpes Walisongo Sragen. Berisi seluruh kegiatan santri dalam bentuk video.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="https://www.instagram.com/ponpeswalisongosragen/" target="_blank" style="text-decoration: none;" class="card">
                <div class="card-body text-center">
                    <i class="fa-brands fa-instagram main_color" style="font-size: 50px;"></i>
                    <p class="dark_color mt-3" style="font-size: medium;">Akun instagram resmi Ponpes Walisongo Sragen. Berisi seluruh kegiatan santri dalam bentuk photo dan video.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="https://www.facebook.com/ponpeswalisongosragen/" target="_blank" style="text-decoration: none;" class="card">
                <div class="card-body text-center">
                    <i class="fa-brands fa-facebook main_color" style="font-size: 50px;"></i>
                    <p class="dark_color mt-3" style="font-size: medium;">Akun facebook resmi Ponpes Walisongo Sragen. Berisi seluruh kegiatan santri dalam bentuk teks, photo dan video.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="https://www.tiktok.com/@ponpeswalisongosragen" target="_blank" style="text-decoration: none;" class="card">
                <div class="card-body text-center">
                    <i class="fa-brands fa-tiktok main_color" style="font-size: 50px;"></i>
                    <p class="dark_color mt-3" style="font-size: medium;">Akun tiktok resmi Ponpes Walisongo Sragen. Berisi seluruh kegiatan santri dalam bentuk photo dan video.</p>
                </div>
            </a>
        </div>
    </div>
</div>



<?= $this->endSection() ?>