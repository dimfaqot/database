<?php foreach ($cols as $i) : ?>
    <?php
    if ($i == 'nama' || $i == 'bidang_pekerjaan' || $i == 'no_id') {
        continue;
    }
    $type = 'text';
    if ($i == 'kode_pos') {
        $type = 'number';
    }
    ?>
    <div class="form-floating mb-3">
        <input name="<?= $i; ?>" data-id="<?= $data['no_id']; ?>" data-tabel="<?= url(); ?>" type="<?= $type; ?>" class="form-control check_<?= $i; ?>" value="<?= $data[$i]; ?>" placeholder="<?= upper_first(str_replace("_", " ", $i)); ?>" required>
        <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
        <ul class="p-1 dropdown-menu body_search_<?= $i; ?>" style="font-size:small;">

        </ul>


        <div class="body_feedback_<?= $i; ?> invalid-feedback"></div>

    </div>

<?php endforeach; ?>