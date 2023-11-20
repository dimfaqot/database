<?= $this->extend('guest') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;margin-bottom:100px;">
    <div class="row g-2">
        <div class="col-md-7">
            <div>
                <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">DATA PENERIMA SERTIFIKAT EKSTRAKURIKULER</h1>
                <div class="d-flex btn_main_inactive gap-2 mb-2" style="border-radius: 2px;">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Ekstra [<?= (url(5) == '' ? 'Multimedia' : str_replace("-", " ", url(5))); ?>]
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($ekstras as $i) : ?>
                            <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == '' && $i['ekstra'] == 'Multimedia' ? 'bg_main' : (url(5) !== '' && $i['ekstra'] == str_replace("-", " ", url(5) ? 'bg_main' : ''))); ?>" href="<?= base_url('public/ekstra/'); ?><?= str_replace(" ", "-", $i['ekstra']); ?>"><?= $i['ekstra']; ?></a></li>

                        <?php endforeach; ?>
                        <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url('public/ekstra/'); ?>All">All</a></li>
                    </ul>


                    <input type="text" class="cari" style="border-radius: 5px; border-color:#f1f1f1;" placeholder="Cari nama...">
                </div>


                <?php if (count($data) == 0) : ?>
                    <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
                <?php else : ?>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>No. Serifikat</th>
                                <th>No. Id</th>
                                <th>Nama</th>
                                <th>Print</th>
                            </tr>
                        </thead>
                        <tbody class="tabel_search">
                            <?php foreach ($data as $k => $i) : ?>
                                <?php $d = [$i['kode']];
                                $data_cetak = encode_jwt($d); ?>
                                <tr>
                                    <td><?= $k + 1; ?></td>
                                    <td><?= $i['kode']; ?></td>
                                    <td><?= $i['no_id']; ?></td>
                                    <td><?= $i['nama']; ?></td>
                                    <td><a target="_blank" class="main_color" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cetak pdf." href="<?= base_url('public/ekstra/cetak/pdf/'); ?><?= $data_cetak; ?>" style="font-size: medium;"><i class="fa-solid fa-file-pdf"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>


            </div>

        </div>
        <div class="col-md-5">
            <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">BERITA EKSTRAKURIKULER</h1>
            <?php foreach (get_news('Ekstrakurikuler') as $k => $i) : ?>
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