<?php foreach ($cols as $i) : ?>
    <?php
    if ($i == 'nama' || $i == 'no_id') {
        continue;
    }
    $type = 'text';
    if ($i == 'tahun_masuk' || $i == 'tahun_keluar') {
        $type = 'number';
    }
    ?>
    <?php if ($i == 'sub') : ?>
        <div class="form-floating mb-3">
            <select class="form-select check_<?= $i; ?>" name="<?= $i; ?>" style="font-size: small;" required <?= (url() == 'identitas' ? 'disabled' : ''); ?>>
                <?php foreach (sub() as $s) : ?>
                    <option <?= ($data[$i] == $s['singkatan'] ? 'selected' : ''); ?> value="<?= $s['singkatan']; ?>"><?= $s['singkatan']; ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
            <div class="body_feedback_<?= $i; ?> invalid-feedback"> </div>
        </div>
    <?php elseif ($i == 'bidang_pekerjaan') : ?>
        <?php if (url() == 'recruitment' || url() == 'karyawan') : ?>
            <div class="form-floating mb-3">
                <select class="form-select check_<?= $i; ?>" name="<?= $i; ?>" style="font-size: small;" required>
                    <?php foreach (options('Pekerjaan') as $s) : ?>
                        <option <?= ($data[$i] == $s['value'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
                <div class="body_feedback_<?= $i; ?> invalid-feedback"> </div>
            </div>
        <?php endif; ?>
    <?php elseif ($i == 'pondok') : ?>
        <?php if (url() == 'identitas' || url() == 'ppdb' || url() == 'santri') : ?>
            <div class="form-floating mb-3">
                <select class="form-select" style="font-size: small;" required <?= (url() == 'identitas' ? 'disabled' : ''); ?>>
                    <?php foreach (options('Pondok') as $s) : ?>
                        <option <?= ($data[$i] == $s['value'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
            </div>
        <?php endif; ?>
    <?php elseif ($i == 'status') : ?>
        <?php $status = (url() == 'karyawan' || url() == 'santri' ? 'Status' : menu()['menu']); ?>
        <div class="form-floating mb-3">
            <select class="form-select check_<?= $i; ?>" name="<?= $i; ?>" style="font-size: small;" required <?= (url() == 'identitas' ? 'disabled' : ''); ?>>
                <?php foreach (options($status) as $s) : ?>
                    <option <?= ($data[$i] == $s['value'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
            <div class="body_feedback_<?= $i; ?> invalid-feedback"> </div>
        </div>
    <?php elseif ($i == 'tempat_pendaftaran') : ?>
        <div class="form-floating mb-3">
            <select class="form-select check_<?= $i; ?>" name="<?= $i; ?>" style="font-size: small;" required>
                <?php foreach (options('Pendaftaran') as $s) : ?>
                    <option <?= ($data[$i] == $s['value'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
            <div class="body_feedback_<?= $i; ?> invalid-feedback"> </div>
        </div>
    <?php elseif ($i == 'ket_pendaftaran') : ?>
        <div class="form-floating mb-3">
            <select class="form-select check_<?= $i; ?>" name="<?= $i; ?>" style="font-size: small;" required>
                <?php foreach (options('Biaya') as $s) : ?>
                    <option <?= ($data[$i] == $s['value'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                <?php endforeach; ?>
            </select>
            <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
            <div class="body_feedback_<?= $i; ?> invalid-feedback"> </div>
        </div>
    <?php else : ?>

        <div class="form-floating mb-3">
            <input name="<?= $i; ?>" data-id="<?= $data['no_id']; ?>" data-tabel="<?= url(); ?>" type="<?= $type; ?>" class="form-control check_<?= $i; ?>" value="<?= $data[$i]; ?>" placeholder="<?= upper_first(str_replace("_", " ", $i)); ?>" <?= (url() == 'identitas' && $i == 'tahun_masuk' ? 'disabled' : ''); ?>>
            <label><?= upper_first(str_replace("_", " ", $i)); ?></label>
            <ul class="p-1 dropdown-menu body_search_<?= $i; ?>" style="font-size:small;">

            </ul>


            <div class="body_feedback_<?= $i; ?> invalid-feedback"></div>

        </div>

    <?php endif; ?>

<?php endforeach; ?>