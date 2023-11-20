<?= $this->extend('logged') ?>

<?= $this->section('content') ?>
<div class="container" style="margin-top: 60px;">
    <a href="<?= base_url(menu()['controller']); ?>/<?= url(5); ?>/<?= url(6) ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>"" class=" btn_main"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
    <div class="btn_main_inactive identitas my-3" style="font-weight: 600;"><?= $data['nama']; ?> [<?= url(12); ?>]</div>

    <?php $sub_menus = [
        ['label' => 'Profile', 'icon' => 'fa-solid fa-user'],
        ['label' => 'Alamat', 'icon' => 'fa-solid fa-location-dot'],
        ['label' => 'Pendidikan', 'icon' => 'fa-solid fa-graduation-cap'],
        ['label' => 'Riwayat', 'icon' => "fa-solid fa-clock-rotate-left"],
        ['label' => 'Catatan', 'icon' => "fa-regular fa-note-sticky"],
        ['label' => 'Berkas', 'icon' => "fa-solid fa-file"]
    ];
    ?>
    <div class="d-flex gap-1 mb-4">
        <?php foreach ($sub_menus as $i) : ?>
            <a href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>/<?= url(12); ?>/<?= $i['label']; ?>" class="<?= (url(13) == $i['label'] ? 'btn_secondary' : 'btn_main_inactive'); ?>">
                <i class="<?= $i['icon']; ?>"></i> <?= $i['label']; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (url(13) == 'Berkas') : ?>

        <?= view('profile/' . strtolower(url(13)), ['data' => $data, 'cols' => $cols]); ?>

    <?php else : ?>

        <form method="post" action="<?= base_url(menu()['controller']); ?>/update" class="card">
            <input type="hidden" name="id" value="<?= $data['no_id']; ?>">
            <?php if (in_array(url(13), ck_editor())) : ?>
                <input type="hidden" name="cols" value="catatan">
            <?php else : ?>
                <input type="hidden" name="cols" value="<?= implode(",", $cols); ?>">
            <?php endif; ?>
            <input type="hidden" name="sub_menu" value="<?= url(13); ?>">
            <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>">
            <?php if (url('13') == 'Catatan') : ?>
                <div class="card-body">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control form-control-sm" id="ck_input" rows="3"><?= $data['catatan']; ?></textarea>
                </div>

                <div class="d-grid p-3">
                    <button type="submit" class="btn-sm btn_check btn_main"><i class="fa-solid fa-file-pen"></i> Update <?= url(13); ?></button>
                </div>

            <?php else : ?>
                <div class="card-body">
                    <?= view('profile/' . strtolower(url(13)), ['data' => $data, 'cols' => $cols]); ?>
                </div>

                <div class="d-grid p-3">
                    <button type="submit" class="btn-sm btn_main btn_check"><i class="fa-solid fa-file-pen"></i> Update <?= url(13); ?></button>
                </div>
            <?php endif; ?>
        </form>

    <?php endif; ?>



</div>

</div>
<?= $this->endSection() ?>