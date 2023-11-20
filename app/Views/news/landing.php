<?= $this->extend('guest') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;margin-bottom:100px;">
    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <div class="mb-3" style="font-size: medium;">
                <a href="<?= base_url(); ?>" style="text-decoration:none;color:#054552"><i class="fa-solid fa-rss" style="color: #116A7B;"></i> <span style="font-weight: normal;color:#054552;">Walisongo</span> <b class="me-3 main_color">News</b></a> <a <?= (url() == '' ? 'target="_blank"' : ''); ?> href="https://www.youtube.com/channel/UCMq4x3Jkg85t-3JszlX62Pg"><i class="fa-brands fa-youtube main_color"></i></a> <a <?= (url() == '' ? 'target="_blank"' : ''); ?> href="https://www.instagram.com/ponpeswalisongosragen"><i class="fa-brands fa-instagram main_color"></i></a> <a <?= (url() == '' ? 'target="_blank"' : ''); ?> href="https://www.facebook.com/ponpeswalisongosragen"><i class="fa-brands fa-facebook main_color"></i></a> <a <?= (url() == '' ? 'target="_blank"' : ''); ?> href="https://www.tiktok.com/@ponpeswalisongosragen"><i class="fa-brands fa-tiktok main_color"></i></a>
            </div>
            <h6 style="font-size: small; margin-bottom:-1px;color:#054552;"><?= date('M d, Y'); ?></h6>
            <small style="color: #054552;"><?= date('H:m a'); ?></small>

        </div>

        <div class="col-md-9">
            <?php if (info_pemilu() == 0) : ?>
                <a href="<?= base_url(); ?>public/ppdb">
                    <img src="<?= base_url(); ?>berkas/ppdb/banner_ppdb.jpg" style="max-width: 100%;" class="img-fluid" alt="BANNER PPDB">
                </a>
            <?php else : ?>
                <?php foreach (hasil_pemilu(date('Y')) as $i) : ?>
                    <a href="<?= base_url(); ?>pemilu" <?= (url() == '' ? 'target="_blank"' : ''); ?> style="text-decoration: none;">
                        <h6 class="btn_main_inactive" style="border-radius: 4px;padding:3px;text-align:center;">HASIL PEMILU ISWA TAHUN <?= $i['tahun']; ?></h6>

                        <?php foreach ($i['detail'] as $d) : ?>
                            <h6 style="border-radius: 4px;padding:3px;" class="btn_main_inactive"><?= $d['pondok']; ?></h6>
                            <div class="d-flex justify-content-between mb-1">
                                <?php foreach ($d['data'] as $t) : ?>

                                    <img class="img-fluid" style="max-width: 10%;" src="<?= base_url(); ?>berkas/pemilu/<?= $t['flyer']; ?>" alt="PemILU ISWA">


                                <?php endforeach; ?>

                            </div>
                        <?php endforeach; ?>
                    </a>
                <?php endforeach; ?>


            <?php endif; ?>
        </div>

    </div>

    <div class="row g-2 mb-3">
        <div class="col-md-8">
            <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">HEADLINES</h1>
            <?= view('news/top_center'); ?>
        </div>
        <div class="col-md-4">
            <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">SOSMED</h1>
            <?php foreach (sosmed('data') as $i) : ?>
                <div class="d-grid mb-1">
                    <a class="btn_main_inactive" <?= (url() == '' ? 'target="_blank"' : ''); ?> style="border-color: #666666;border-radius:3px;" href="<?= $i['url']; ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['text']; ?></a>
                </div>
            <?php endforeach; ?>
        </div>


    </div>

    <div class="row g-2">
        <div class="col-md-3">
            <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">KATEGORI</h1>
            <?php foreach (labels_news() as $i) : ?>
                <div class="mb-2">
                    <div class="d-grid mb-1">
                        <a class="btn_secondary" style="border-color: #666666;border-radius:3px;" href="<?= base_url(); ?>public/news/label/<?= $i['label']; ?>"><?= $i['label']; ?></a>
                    </div>
                    <?php foreach (get_news($i['label']) as $n) : ?>

                        <div class="d-grid mb-1">
                            <a class="btn_main_inactive" style="border-bottom: 1px solid #666666; border-radius:0px;;" href="<?= base_url(); ?>public/news/single/<?= $n['slug']; ?>"><?= $n['judul']; ?></a>
                        </div>
                    <?php endforeach; ?>

                </div>

            <?php endforeach; ?>
        </div>
        <div class="col-md-6">
            <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">TRENDING</h1>
            <?php foreach (get_news('Trending') as $k => $i) : ?>
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
        <div class="col-md-3" style="max-width: 100%;">
            <a href="<?= base_url(); ?>public/ppdb">
                <img src="<?= base_url(); ?>berkas/ppdb/right_side.jpg" class="img-fluid" alt="PPDB">
            </a>
        </div>
    </div>


</div>
<?= $this->endSection() ?>