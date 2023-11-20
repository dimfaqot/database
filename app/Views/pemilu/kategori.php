<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container pt-2" style="margin-bottom:100px;margin-top:55px;">

    <button type="button" class="btn-sm btn_main" data-bs-toggle="collapse" data-bs-target="#<?= menu()['controller']; ?>" aria-expanded="false" aria-controls="<?= menu()['controller']; ?>">
        <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
    </button>

    <div class="collapse multi-collapse mt-2" id="<?= menu()['controller']; ?>">
        <div class="card card-body">
            <form action="<?= base_url(); ?><?= menu()['controller']; ?>/add" method="post" enctype="multipart/form-data">
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" name="kategori" placeholder="Kategori" required>
                    <label>Kategori</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="number" class="form-control" name="suara" placeholder="Bobot Suara" required>
                    <label>Bobot Suara</label>
                </div>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn-sm btn_main"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3 g-3">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Kategori</th>
                    <th>Bobot Suara</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <td><?= ($k + 1); ?></td>
                        <td><?= $i['kategori']; ?></td>
                        <td><?= $i['suara']; ?></td>
                        <td>
                            <?php if (settings('pemilu_dimulai') == 1) : ?>
                                <i class="fa-solid fa-ban"></i>
                            <?php else : ?>
                                <a href="" data-bs-toggle="modal" data-bs-target="#update_<?= $i['id']; ?>" type="button" class="main_color" style="font-size: medium;"><i class="fa-solid fa-square-pen"></i></a> <a href="" class="confirm" data-id="<?= $i['id']; ?>" data-order="hapus" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a>

                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>


        </table>
    </div>

    <?php foreach ($data as $i) : ?>
        <div class="modal fade" id="update_<?= $i['id']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-square-pen"></i> Update <?= menu()['menu']; ?></div>
                            <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                        </div>
                        <hr class="dark_color" style="border: 1px solid;">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= base_url(); ?><?= menu()['controller']; ?>/update" method="post">
                                    <input type="hidden" name="id" value="<?= $i['id']; ?>">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" name="kategori" value="<?= $i['kategori']; ?>" placeholder="Kategori" required>
                                        <label>Kategori</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" class="form-control" name="suara" value="<?= $i['suara']; ?>" placeholder="Bobot Suara" required>
                                        <label>Bobot Suara</label>
                                    </div>
                                    <div class="d-grid mt-3">
                                        <button type="submit" class="btn-sm btn_main"><i class="fa-solid fa-square-pen"></i> Update</button>
                                    </div>
                                </form>



                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>