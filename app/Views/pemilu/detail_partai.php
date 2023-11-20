<?= $this->extend('logged') ?>

<?= $this->section('content') ?>


<div class="container pt-2" style="margin-bottom:100px;margin-top:55px;">

    <a href="<?= base_url(); ?><?= menu()['controller']; ?>" type="button" class="btn-sm btn_main mb-3">
        <i class="fa-solid fa-angles-left"></i> Back to <?= menu()['menu']; ?>
    </a>


    <div class="card card-body">
        <form action="<?= base_url(); ?><?= menu()['controller']; ?>/update" method="post" enctype="multipart/form-data">
            <input type="hidden" name="col" value="logo_partai">
            <input type="hidden" name="id" value="<?= $data['id']; ?>">
            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="partai" value="<?= $data['partai']; ?>" placeholder="Partai" required>
                <label>Partai</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="singkatan_partai" value="<?= $data['singkatan_partai']; ?>" placeholder="Singkatan Partai" required>
                <label>Singkatan Partai</label>
            </div>
            <label class="form-label">Logo Partai</label>
            <div class="mb-2">
                <img width="250" src="<?= base_url(); ?>berkas/pemilu/<?= $data['logo_partai']; ?>" class="img-fluid rounded mb-2" alt="Gambar Galleries">
                <input class="form-control form-control-sm" name="file" type="file">
            </div>
            <div class="d-grid mt-3">
                <button type="submit" class="btn-sm btn_main"><i class="fa-solid fa-square-pen"></i> Update</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>