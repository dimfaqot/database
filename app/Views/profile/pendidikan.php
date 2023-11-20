<?php foreach ($cols as $i) : ?>
    <?php
    if ($i == 'nama' || $i == 'bidang_pekerjaan' || $i == 'no_id') {
        continue;
    }
    $type = 'text';
    if ($i == 'ipk_s1' || $i == 'ipk_s2' || $i == 'ipk_s3') {
        $type = 'number';
    }
    ?>
    <?php if ($i == 'pendidikan_terakhir') : ?>

        <small class="text-danger" style="font-style: italic;"><i class="fa-solid fa-circle-exclamation"></i> Khusus lulusan di bawah Sarjana!.</small>
        <div class="form-floating">
            <select class="form-select check_<?= $i; ?>" name="<?= $i; ?>" style="font-size: small;" required>
                <option>-Pilih Pendidikan Terakhir-</option>
                <option <?= ($data[$i] == 'SD' ? 'selected' : ''); ?> value="SD">SD</option>
                <option <?= ($data[$i] == 'SMP' ? 'selected' : ''); ?> value="SMP">SMP</option>
                <option <?= ($data[$i] == 'SMA' ? 'selected' : ''); ?> value="SMA">SMA</option>
            </select>
            <label>Ijazah terakhir</label>
            <div class="body_feedback_<?= $i; ?> invalid-feedback"></div>
        </div>
    <?php else : ?>
        <?php if ($i == 'kampus_s1' || $i == 'kampus_s2' || $i == 'kampus_s3') : ?>
            <div class="btn_main_inactive mb-1" style="border-radius: 4px; font-weight:bold;">Jenjang <?= upper_first(explode("_", $i)[1]); ?></div>
        <?php endif; ?>
        <div class="form-floating mb-3">
            <input type="<?= $type; ?>" name="<?= $i; ?>" class="form-control check_<?= $i; ?>" value="<?= $data[$i]; ?>" placeholder="<?= upper_first(str_replace("_", " ", $i)); ?>">
            <label><?= upper_first(str_replace("_", " ", $i)); ?></label>

            <ul class="p-1 dropdown-menu body_search_<?= $i; ?>" style="font-size:small;">

            </ul>

            <div class="body_feedback_<?= $i; ?> invalid-feedback"></div>
        </div>
    <?php endif; ?>

<?php endforeach; ?>