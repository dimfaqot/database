<?= $this->extend('guest') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;margin-bottom:100px;">
    <div class="row g-2">
        <div class="col-md-7">
            <div>
                <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">CARI NAMA PENERIMA SERTIFIKAT/PIAGAM</h1>
                <div class="d-flex btn_main_inactive gap-2 mb-2" style="border-radius: 2px;">
                    <div>
                        <?php foreach (options('Sertifikat') as $i) : ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sertifikat" value="<?= $i['value']; ?>" <?= ($i['value'] == 'Piagam' ? 'checked' : ''); ?>>
                                <label class="form-check-label"><?= $i['value']; ?></label>
                            </div>

                        <?php endforeach; ?>

                    </div>

                    <input type="text" class="cari_sertifikat" style="border-radius: 5px; border-color:#f1f1f1;" placeholder="Cari nama...">
                </div>

                <div class="body_sertifikat">

                </div>


            </div>



        </div>
        <div class="col-md-5">
            <h1 class="btn_main" style="border-radius: 3px;border-color:#054552">WALISONGO NEWS</h1>
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
    </div>
    <?= $this->endSection() ?>