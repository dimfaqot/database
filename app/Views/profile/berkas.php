<?php
$url = base_url() . 'berkas/' . url();
if (url() == 'identitas') {
    $url = base_url() . 'berkas/' . strtolower(session('section'));
}
?>
<div class="container text-center">
    <div class="row g-3">
        <?php foreach ($cols as $i) : ?>
            <?php
            if ($i == 'nama' || $i == 'no_id' || $i == 'bidang_pekerjaan' || $i == 'ijazah_pendidikan_terakhir' || $i == 'nilai_pendidikan_terakhir') {
                continue;
            }
            ?>
            <div class="card mb-3 shadow shadow-sm line_warning_<?= $i; ?>">
                <div class="row g-0">
                    <div class="col-md-4 p-2">
                        <?php if ($i == 'cv' || $i == 'sp' || $i == 'kontrak') : ?>
                            <div style="padding-top: 30px;">
                                <a class="<?= ($data[$i] == 'file_not_found.jpg' ? 'new_inactive' : 'new_active'); ?>" target="_blank" href="<?= $url . '/' . $data[$i]; ?>"><span class="btn_main">Klik Untuk Cek <?= upper_first(str_replace("_", " ", $i)); ?></span> <span><?= ($data[$i] == 'file_not_found.jpg' ? '<i class="fa-solid fa-circle-xmark text-danger"></i>' : '<i class="fa-solid fa-circle-check text-success"></i>'); ?></span></a>
                            </div>
                        <?php else : ?>
                            <a href="" class="zoom" data-url="<?= $url; ?>/<?= $data[$i]; ?>" data-col="<?= upper_first(str_replace("_", " ", $i)); ?>">
                                <img width="80px" class="img-fluid rounded" src="<?= $url; ?>/<?= $data[$i]; ?>" alt="<?= upper_first(str_replace("_", " ", $i)); ?>">
                            </a>

                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h6 class="card-title"><?= upper_first(str_replace("_", " ", $i)); ?></h6>
                            <?php if (url() == 'identitas') : ?>
                                <form method="post" action="<?= base_url(menu()['controller']); ?>/<?= strtolower(session('role')); ?>/<?= strtolower(session('section')); ?>/update" class="form-floating mb-2" enctype="multipart/form-data">

                                <?php else : ?>
                                    <form method="post" action="<?= base_url(); ?><?= menu()['controller']; ?>/update" class="form-floating mb-2" enctype="multipart/form-data">

                                    <?php endif; ?>
                                    <div class="input-group input-group-sm">
                                        <input type="hidden" name="id" value="<?= $data['no_id']; ?>">
                                        <?php if (url() == 'identitas') : ?>
                                            <input type="hidden" name="sub_menu" value="<?= (url(6)); ?>">
                                            <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) ?>">

                                        <?php else : ?>
                                            <input type="hidden" name="sub_menu" value="<?= (get_db(menu()['tabel']) == 'karyawan' ? url(13) : url(14)); ?>">
                                            <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?><?= (get_db(menu()['tabel']) == 'santri' ? '/' . url(12) : ''); ?>">

                                        <?php endif; ?>
                                        <input type="hidden" name="cols" value="<?= $i; ?>">
                                        <input type="file" name="file" data-col="<?= $i; ?>" class="form-control file">
                                        <button class="btn_main btn_<?= $i; ?>" type="submit"><i class="fa-solid fa-circle-arrow-up"></i></button>
                                    </div>
                                    </form>
                                    <small class="body_warning_<?= $i; ?> text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
        <?php if (get_db(menu()['tabel']) == 'karyawan') : ?>
            <h6 class="btn_main_inactive">KHUSUS LULUSAN DI BAWAH SARJANA (SD/SMP/SMA)</h6>

        <?php endif; ?>
        <?php foreach ($cols as $i) : ?>
            <?php
            if ($i == 'ijazah_pendidikan_terakhir' || $i == 'nilai_pendidikan_terakhir') : ?>
                <div class="card mb-3 shadow shadow-sm line_warning_<?= $i; ?>">
                    <div class="row g-0">
                        <div class="col-md-4 p-2">
                            <a href="" class="zoom" data-url="<?= $url; ?>/<?= $data[$i]; ?>" data-col="<?= upper_first(str_replace("_", " ", $i)); ?>">
                                <img width="80px" class="img-fluid rounded" src="<?= $url; ?>/<?= $data[$i]; ?>" alt="<?= upper_first(str_replace("_", " ", $i)); ?>">
                            </a>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h6 class="card-title"><?= upper_first(str_replace("_", " ", $i)); ?></h6>
                                <?php if (url() == 'identitas') : ?>
                                    <form method="post" action="<?= base_url(menu()['controller']); ?>/<?= strtolower(session('role')); ?>/<?= strtolower(session('section')); ?>/update" class="form-floating mb-2" enctype="multipart/form-data">

                                    <?php else : ?>
                                        <form method="post" action="<?= base_url(); ?><?= menu()['controller']; ?>/update" class="form-floating mb-2" enctype="multipart/form-data">

                                        <?php endif; ?>
                                        <div class="input-group input-group-sm">
                                            <input type="hidden" name="id" value="<?= $data['no_id']; ?>">
                                            <input type="hidden" name="sub_menu" value="<?= url(6); ?>">
                                            <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) ?>">
                                            <input type="hidden" name="cols" value="<?= $i; ?>">
                                            <input type="file" name="file" data-col="<?= $i; ?>" class="form-control file">
                                            <button class="btn_main" type="submit"><i class="fa-solid fa-circle-arrow-up"></i></button>
                                        </div>
                                        </form>
                                        <small class="body_warning_<?= $i; ?> text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>

    </div>
</div>