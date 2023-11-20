<?= $this->extend('guest') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px; margin-bottom:100px;">
    <div id="demo" class="carousel slide" data-bs-ride="carousel">

        <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <?php foreach (get_files('rental') as $k => $i) : ?>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $k; ?>" <?= ($k == 0 ? 'class="active"' : ''); ?>></button>
            <?php endforeach; ?>
        </div>

        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <?php foreach (get_files('rental') as $k => $i) : ?>
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

    <div class="row g-3 text-center mt-3">
        <div class="col-md-4">
            <a href="whatsapp://send/?phone=+6287730795571&text=Assalamualaikum Wr.Wb. Saya mau sewa bus." class="btn_main"><i class="fa-brands fa-whatsapp"></i> Pemesanan Bus</a>
        </div>
        <div class="col-md-4">
            <a href="whatsapp://send/?phone=+62895613460375&text=Assalamualaikum Wr.Wb. Saya mau sewa l300." class="btn_main"><i class="fa-brands fa-whatsapp"></i> Pemesanan L300</a>
        </div>
        <div class="col-md-4">
            <a href="whatsapp://send/?phone=+6285647567450&text=Assalamualaikum Wr.Wb. Saya mau sewa elf." class="btn_main"><i class="fa-brands fa-whatsapp"></i> Pemesanan Elf</a>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-md-7">
            <div>
                <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">JADWAL PERSEWAAN <?= (url(7) == '' ? 'BUS' : strtoupper(url(7))); ?> BULAN <?= (url(6) == '' ? strtoupper(bulan(date('m'))['bulan']) :  url(6)); ?> TAHUN <?= (url(5) == '' ? date('Y') : url(5)); ?></h1>

                <div class="d-flex btn_main_inactive gap-2 mb-2" style="border-radius: 2px;">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tahun [<?= (url(5) == '' ? date('Y') : url(5)); ?>]
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($tahuns as $i) : ?>
                            <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == '' && $i == date('Y') ? 'bg_main' : (url(5) !== '' && $i == url(5) ? 'bg_main' : '')); ?>" href="<?= base_url('public/rental/'); ?><?= $i; ?>/<?= (url(6) == '' ? bulan(date('m'))['angka'] : url(6)); ?>/<?= (url(7) == '' ? 'Bus' : url(7)); ?>"><?= $i; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Bulan [<?= (url(6) == '' ? bulan(date('m'))['angka'] : url(6)); ?>]
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach (bulan() as $i) : ?>
                            <li style="font-size: small;"><a class="dropdown-item <?= (url(6) == '' && $i['angka'] == bulan(date('m'))['angka'] ? 'bg_main' : (url(6) !== '' && $i['angka'] == url(6) ? 'bg_main' : '')); ?>" href="<?= base_url('public/rental/'); ?><?= (url(5) == '' ? date('Y') : url(5)); ?>/<?= $i['angka']; ?>/<?= (url(7) == '' ? 'Bus' : url(7)); ?>"><?= $i['bulan']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori [<?= (url(7) == '' ? 'Bus' : url(7)); ?>]
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach (options('Rental') as $i) : ?>
                            <li style="font-size: small;"><a class="dropdown-item <?= (url(7) == '' && $i['value'] == 'Bus' ? 'bg_main' : (url(7) !== '' && $i['value'] == url(7) ? 'bg_main' : '')); ?>" href="<?= base_url('public/rental/'); ?><?= (url(5) == '' ? date('Y') : url(5)); ?>/<?= (url(6) == '' ? bulan(date('m'))['angka'] : url(6)); ?>/<?= $i['value']; ?>"><?= $i['value']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>

                </div>

                <?php if (count($data) == 0) : ?>
                    <div class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Data tidak ditemukan!.</div>
                <?php else : ?>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Penyewa</th>
                                <th scope="col">Pj</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $k => $i) : ?>
                                <tr>
                                    <th scope="row"><?= $k + 1; ?></th>
                                    <td><?= date('d/m/Y', $i['tgl']); ?></td>
                                    <td><?= $i['waktu']; ?></td>
                                    <td><?= $i['pemakai']; ?></td>
                                    <td><?= $i['pj']; ?></td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>


                <?php endif; ?>

            </div>
        </div>
        <div class="col-md-5">
            <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">Tour and Travel</h1>
            <?php foreach (get_news('Rental') as $k => $i) : ?>
                <?php if ($k < 8) : ?>
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
    <?= $this->endSection() ?>