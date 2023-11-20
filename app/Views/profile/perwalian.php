<?php foreach ($cols as $i) : ?>
    <?php

    if ($i == 'bidang_pekerjaan' || $i == 'nama' || $i == 'no_id') {
        continue;
    }

    $type = 'text';
    if ($i == 'hp' || $i == 'hp_ayah' || $i == 'ibu' || $i == 'hp_wali' || $i == 'nik_ayah' || $i == 'nik_ibu' || $i == 'no_kk') {
        $type = 'number';
    }
    if ($i == 'email') {
        $type = 'email';
    }
    if ($i == 'tgl_lahir') {
        $type = 'date';
    }
    ?>
    <?php if ($i == 'pendapatan') : ?>
        <div class="form-floating mb-3">
            <select class="form-select check_<?= $i; ?>" name="<?= $i; ?>" style="font-size: medium;" required>
                <?php foreach (options('Pendapatan') as $s) : ?>
                    <option <?= ($data[$i] == $s['value'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
        </div>
    <?php elseif ($i == 'infaq') : ?>
        <div class="form-floating mb-3">
            <select class="form-select check_<?= $i; ?>" name="<?= $i; ?>" style="font-size: medium;" required>
                <?php foreach (options('Infaq') as $s) : ?>
                    <option <?= ($data[$i] == $s['value'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= rupiah($s['value']); ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
        </div>
    <?php elseif ($i == 'alamat_wali') : ?>
        <div class="form-floating">
            <textarea name="<?= $i; ?>" class="form-control check_<?= $i; ?>" placeholder="<?= upper_first(str_replace("_", " ", $i)); ?>" style="height: 100px"><?= $data[$i]; ?></textarea>
            <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
        </div>
    <?php else : ?>
        <div class="form-floating mb-3">
            <?php if ($i == 'hp' || $i == 'hp_ayah' || $i == 'hp_ibu' || $i == 'hp_wali') : ?>
                <span class="d-flex justify-content-end body_wa_<?= $i; ?>"></span>
            <?php endif; ?>
            <input name="<?= $i; ?>" data-id="<?= $data['no_id']; ?>" <?= ($i == 'hp_ayah' || $i == 'hp_ayah' || $i == 'hp_ibu' || $i == 'hp_wali' ? 'data-nama="' . $data['nama'] . '" data-no="' . $data[$i] . '"' : ''); ?> data-tabel="<?= url(); ?>" type="<?= $type; ?>" class="form-control check_<?= $i; ?> <?= ($i == 'hp' || $i == 'hp_ayah' || $i == 'hp_ibu' || $i == 'hp_wali' ? 'wa_' . $i : ''); ?>" value="<?= $data[$i]; ?>" placeholder="<?= upper_first(str_replace("_", " ", $i)); ?><?= ($i == 'hp' && url() == 'santri' || url() == 'ppdb' ? ' Anak' : ''); ?>" <?= (url() == 'recruitment' && $i == 'no_id' ? 'disabled' : ''); ?>>
            <label><?= upper_first(str_replace("_", " ", $i)); ?><?= ($i == 'hp' && url() == 'santri' || url() == 'ppdb' ? ' Anak' : ''); ?></label>

            <?php if ($i == 'kota_lahir') : ?>
                <ul class="p-1 dropdown-menu body_list_<?= $i; ?>" style="font-size:small;">

                </ul>
            <?php endif; ?>

            <div class="body_feedback_<?= $i; ?> invalid-feedback"></div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>