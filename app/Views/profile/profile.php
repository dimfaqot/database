<?php foreach ($cols as $i) : ?>
    <?php

    if ($i == 'bidang_pekerjaan') {
        continue;
    }

    $type = 'text';
    if ($i == 'hp' || $i == 'nik' || $i == 'no_kk') {
        $type = 'number';
    }
    if ($i == 'email') {
        $type = 'email';
    }
    if ($i == 'tgl_lahir') {
        $type = 'date';
    }
    ?>
    <?php if ($i == 'gender') : ?>
        <div class="form-floating mb-3">
            <select class="form-select check_<?= $i; ?>" name="<?= $i; ?>" style="font-size: medium;" required>
                <option <?= ($data[$i] == 'L' ? 'selected' : ''); ?> value="L">L</option>
                <option <?= ($data[$i] == 'P' ? 'selected' : ''); ?> value="P">P</option>
            </select>
            <label>Gender</label>
        </div>
    <?php elseif ($i == 'ikut_bpjs_ket' || $i == 'ikut_bpjs_kes') : ?>
        <div class="input-group mb-3">
            <input type="text" class="form-control" value="<?= upper_first(str_replace("_", " ", $i)); ?>" aria-label="Text input with checkbox" readonly>
            <div class="input-group-text">
                <input class="form-check-input mt-0 update_checkbox" data-id="<?= $data['no_id']; ?>" data-col="<?= $i; ?>" data-tabel="<?= menu()['tabel']; ?>" data-db="karyawan" type="checkbox" <?= ($data[$i] == 1 ? 'checked' : ''); ?>>
            </div>
        </div>

    <?php else : ?>
        <div class="form-floating mb-3">
            <?php if ($i == 'hp' || $i == 'hp_ayah' || $i == 'hp_ibu' || $i == 'hp_wali') : ?>
                <span class="d-flex justify-content-end body_wa_<?= $i; ?>"></span>
            <?php endif; ?>
            <input name="<?= $i; ?>" data-id="<?= $data['no_id']; ?>" data-tabel="<?= url(); ?>" type="<?= $type; ?>" class="form-control check_<?= $i; ?> <?= ($i == 'hp' || $i == 'hp_ayah' || $i == 'hp_ayah' || $i == 'hp_ibu' || $i == 'hp_wali' ? 'wa_' . $i : ''); ?>" <?= ($i == 'hp' || $i == 'hp_ayah' || $i == 'hp_ayah' || $i == 'hp_ibu' || $i == 'hp_wali' ? 'data-nama="' . $data['nama'] . '" data-no="' . $data[$i] . '"' : ''); ?> value="<?= $data[$i]; ?>" placeholder="<?= upper_first(str_replace("_", " ", $i)); ?><?= ($i == 'hp' && url() == 'santri' || url() == 'ppdb' ? ' Anak' : ''); ?>" <?= (url() == 'recruitment' && $i == 'no_id' ? 'disabled' : (url() == 'ppdb' && $i == 'no_id' ? 'disabled' : (url() == 'identitas' && $i == 'no_id' ? 'disabled' : ''))); ?>>
            <label><?= upper_first(str_replace("_", " ", $i)); ?><?= ($i == 'hp' && url() == 'santri' || url() == 'ppdb' ? ' Anak' : ''); ?></label>
            <?php if ($i == 'kota_lahir') : ?>
                <ul class="p-1 dropdown-menu body_list_<?= $i; ?>" style="font-size:small;">

                </ul>
            <?php endif; ?>


            <div class="body_feedback_<?= $i; ?> invalid-feedback">

            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>