<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pilih database." class="card mb-1">
        <div class="card-body">
            <h5 class="btn_main_inactive" style="border-radius: 3px;"><i class="fa-solid fa-server"></i> DATABASES</h5>

            <div class="row g-2">
                <?php foreach ($data as $i) : ?>
                    <div class="col-6 col-md-2">
                        <div class="form-check form-check-inline form-switch">
                            <input class="form-check-input get_db" type="radio" name="database" value="<?= $i; ?>" role="switch" <?= ($i == 'karyawan' ? 'checked' : ''); ?>>
                            <label class="form-check-label"><?= upper_first(str_replace("_", " ", $i)); ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <div class="card body_tables mb-1">

    </div>

    <div class="card body_columns mb-1">

    </div>

    <div class="card body_filter">

    </div>

    <div class="d-grid mt-3">
        <button type="button" class="btn-sm btn_main get_data"><i class="fa-solid fa-square-arrow-up-right"></i> Get Data</button>

    </div>


    <div class="modal fade" id="cetak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cetakLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content body_data">

            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>