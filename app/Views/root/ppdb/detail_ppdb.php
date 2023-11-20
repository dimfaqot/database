<?= $this->extend('logged') ?>

<?= $this->section('content') ?>
<div class="container" style="margin-top: 60px;">

    <a href="<?= base_url(menu()['controller']); ?>/<?= url(5); ?>/<?= url(6) ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>/<?= url(12); ?>" class=" btn_main"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
    <div class="btn_main_inactive identitas my-3" style="font-weight: 600;"><?= $data['nama']; ?> [<?= url(13); ?>]</div>

    <?php $sub_menus = [
        ['label' => 'Profile', 'icon' => 'fa-solid fa-user'],
        ['label' => 'Alamat', 'icon' => 'fa-solid fa-location-dot'],
        ['label' => 'Riwayat', 'icon' => "fa-solid fa-clock-rotate-left"],
        ['label' => 'Perwalian', 'icon' => "fa-solid fa-user-group"],
        ['label' => 'Keluarga', 'icon' => "fa-solid fa-people-roof"],
        ['label' => 'Ekonomi', 'icon' => "fa-solid fa-sack-dollar"],
        ['label' => 'Kesehatan', 'icon' => "fa-solid fa-notes-medical"],
        ['label' => 'Karakter', 'icon' => "fa-solid fa-star-and-crescent"],
        ['label' => 'Catatan', 'icon' => "fa-regular fa-note-sticky"],
        ['label' => 'Berkas', 'icon' => "fa-solid fa-file"]
    ];
    ?>

    <div class="d-flex gap-1 mb-4">
        <?php foreach ($sub_menus as $i) : ?>
            <a href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>/<?= url(12); ?>/<?= url(13); ?>/<?= $i['label']; ?>" class="<?= (url(14) == $i['label'] ? 'btn_secondary' : 'btn_main_inactive'); ?>">
                <i class="<?= $i['icon']; ?>"></i> <?= $i['label']; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (url(14) == 'Berkas') : ?>

        <?= view('profile/' . strtolower(url(14)), ['data' => $data, 'cols' => $cols]); ?>

    <?php else : ?>

        <form method="post" action="<?= base_url(menu()['controller']); ?>/update" class="card">
            <input type="hidden" name="id" value="<?= $data['no_id']; ?>">
            <?php if (in_array(url(14), ck_editor())) : ?>
                <input type="hidden" name="cols" value="<?= strtolower(url(14)); ?>">
            <?php else : ?>
                <input type="hidden" name="cols" value="<?= implode(",", $cols); ?>">
            <?php endif; ?>
            <input type="hidden" name="sub_menu" value="<?= url(14); ?>">
            <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>/<?= url(12); ?>">
            <?php if (url(14) == 'Keluarga' || url(14) == 'Ekonomi' || url(14) == 'Kesehatan' || url(14) == 'Karakter' || url(14) == 'Catatan') : ?>
                <div class="card-body">
                    <label class="form-label">Catatan</label>
                    <textarea name="<?= strtolower(url(14)); ?>" class="form-control form-control-sm" id="ck_input" rows="3"><?= $data[strtolower(url(14))]; ?></textarea>
                </div>

                <div class="d-grid p-3">
                    <button type="submit" class="btn-sm btn_check btn_main"><i class="fa-solid fa-file-pen"></i> Update <?= url(14); ?></button>
                </div>

            <?php else : ?>
                <div class="card-body">
                    <?= view('profile/' . strtolower(url(14)), ['data' => $data, 'cols' => $cols]); ?>
                </div>

                <div class="d-grid p-3">
                    <button type="submit" class="btn-sm btn_main btn_check"><i class="fa-solid fa-file-pen"></i> Update <?= url(14); ?></button>
                </div>
            <?php endif; ?>
        </form>

    <?php endif; ?>



</div>

</div>
<?= $this->endSection() ?>