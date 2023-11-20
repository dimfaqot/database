<?= $this->extend('logged') ?>

<?= $this->section('content') ?>


<div class="container pt-2" style="margin-bottom:100px;margin-top:55px;">

    <button type="button" class="btn-sm btn_main mb-2" data-bs-toggle="collapse" data-bs-target="#<?= menu()['controller']; ?>" aria-expanded="false" aria-controls="<?= menu()['controller']; ?>">
        <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
    </button>

    <div class="collapse multi-collapse" id="<?= menu()['controller']; ?>">
        <div class="card card-body">
            <form action="<?= base_url(); ?><?= menu()['controller']; ?>/add" method="post" enctype="multipart/form-data">
                <input type="hidden" name="col" value="logo_partai">
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" name="partai" placeholder="Partai" required>
                    <label>Partai</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" name="singkatan_partai" placeholder="Singkatan Partai" required>
                    <label>Singkatan Partai</label>
                </div>
                <div class="mb-2">
                    <label class="form-label">Logo Partai</label>
                    <input class="form-control form-control-sm" name="file" type="file" required>
                </div>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn-sm btn_main"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3 g-3">
        <?php foreach ($data as $i) : ?>
            <div class="col-sm-4">
                <div class="card" style="width: 18rem;">
                    <a href="<?= base_url(); ?><?= menu()['controller']; ?>/dtl/<?= $i['id']; ?>"><img src="<?= base_url(); ?>berkas/<?= get_db(menu()['controller']); ?>/<?= $i['logo_partai']; ?>" class="card-img-top" alt="Logo partai"></a>
                    <div class="card-body">
                        <h6><?= $i['partai']; ?></h6>
                        <small><?= $i['singkatan_partai']; ?></small>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>