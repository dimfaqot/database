<?= $this->extend('logged') ?>

<?= $this->section('content') ?>
<div class="container" style="margin-top: 60px;">


    <div class="btn_main_inactive identitas my-3" style="font-weight: 600;"><?= $data['nama']; ?> [<?= $data['no_id']; ?>]</div>

    <?php $sub_menus = [
        ['label' => 'Profile', 'icon' => 'fa-solid fa-user'],
        ['label' => 'Alamat', 'icon' => 'fa-solid fa-location-dot'],
        ['label' => 'Riwayat', 'icon' => "fa-solid fa-clock-rotate-left"],
        ['label' => 'Perwalian', 'icon' => "fa-solid fa-user-group"],
        ['label' => 'Keluarga', 'icon' => "fa-solid fa-people-roof"],
        ['label' => 'Ekonomi', 'icon' => "fa-solid fa-sack-dollar"],
        ['label' => 'Kesehatan', 'icon' => "fa-solid fa-notes-medical"],
        ['label' => 'Karakter', 'icon' => "fa-solid fa-star-and-crescent"],
        ['label' => 'Berkas', 'icon' => "fa-solid fa-file"]
    ];
    ?>

    <div class="d-flex gap-1 mb-4">
        <?php foreach ($sub_menus as $i) : ?>
            <a href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= $i['label']; ?>" class="<?= (url(6) == $i['label'] ? 'btn_secondary' : 'btn_main_inactive'); ?>">
                <i class="<?= $i['icon']; ?>"></i> <?= $i['label']; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (url(6) == 'Berkas') : ?>

        <?= view('profile/' . strtolower(url(6)), ['data' => $data, 'cols' => $cols]); ?>

    <?php else : ?>

        <form method="post" action="<?= base_url(menu()['controller']); ?>/<?= strtolower(session('role')); ?>/<?= strtolower(session('section')); ?>/update" class="card">
            <input type="hidden" name="id" value="<?= $data['no_id']; ?>">
            <?php if (in_array(url(6), ck_editor())) : ?>
                <input type="hidden" name="cols" value="<?= strtolower(url(6)); ?>">
            <?php else : ?>
                <input type="hidden" name="cols" value="<?= implode(",", $cols); ?>">
            <?php endif; ?>
            <input type="hidden" name="sub_menu" value="<?= url(6); ?>">
            <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) ?>">
            <?php if (in_array(url(6), ck_editor())) : ?>
                <div class="card-body">
                    <label class="form-label">Catatan</label>
                    <textarea name="<?= strtolower(url(6)); ?>" class="form-control form-control-sm" id="ck_input" rows="3"><?= $data[strtolower(url(6))]; ?></textarea>
                </div>

                <div class="d-grid p-3">
                    <button type="submit" class="btn-sm btn_check btn_main"><i class="fa-solid fa-file-pen"></i> Update <?= url(6); ?></button>
                </div>

            <?php else : ?>
                <div class="card-body">
                    <?= view('profile/' . strtolower(url(6)), ['data' => $data, 'cols' => $cols]); ?>
                </div>

                <div class="d-grid p-3">
                    <button type="submit" class="btn-sm btn_main btn_check"><i class="fa-solid fa-file-pen"></i> Update <?= url(6); ?></button>
                </div>
            <?php endif; ?>
        </form>

    <?php endif; ?>



</div>

</div>
<?= $this->endSection() ?>