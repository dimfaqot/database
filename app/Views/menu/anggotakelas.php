<?php
$url = url(4);
if (url(4) == '') {
    $url = 'tujuh';
}

?>
<div class="list-group list-group-flush shadow shadow-sm">
    <div href="#" class="list-group-item list-group-item-action">
        ANGGOTA KELAS
    </div>

    <?php foreach (menu_anggota_kelas() as $i) : ?>
        <a href="#" class="list-group-item list-group-item-action <?= ($url == $i['controller'] ? 'btn_main' : ''); ?>" <?= ($url == $i['controller'] ? 'style="border-radius: 3px;"' : ''); ?>><i class="<?= $i['icon']; ?>"></i> <?= $i['menu']; ?></a>
    <?php endforeach; ?>
</div>