<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <div class="new_active mb-2">
        <?= menu()['menu']; ?>
    </div>

    <form action="<?= base_url(); ?><?= menu()['controller']; ?>/update" method="post">
        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <div class="form-floating mb-2">
            <input type="text" class="form-control" name="default_password" value="<?= $data['default_password']; ?>" placeholder="Default Password" required>
            <label>Default Password</label>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control" name="key_jwt" value="<?= $data['key_jwt']; ?>" placeholder="Key Jwt" required>
            <label>Key Jwt</label>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control" name="hasil_pemilu" value="<?= $data['hasil_pemilu']; ?>" placeholder="Hasil Pemilu" required>
            <label>Hasil Pemilu</label>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control" name="pemilu_dimulai" value="<?= $data['pemilu_dimulai']; ?>" placeholder="Pemilu Dimulai" required>
            <label>Pemilu Dimulai</label>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control" name="is_sertifikat" value="<?= $data['is_sertifikat']; ?>" placeholder="Is Sertifikat" required>
            <label>Is Srtifikat</label>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control" name="db" value="<?= $data['db']; ?>" placeholder="Db" required>
            <label>Db</label>
        </div>


        <div class="d-grid mt-3">
            <button type="submit" class="btn-sm btn_main"><i class="fa-solid fa-file-pen"></i> Update</button>

        </div>
    </form>

</div>
<?= $this->endSection() ?>