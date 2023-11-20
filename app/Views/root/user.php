<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
        </button>
        <button type="button" class="btn-sm btn_secondary modal_cari_db"><i class="fa-solid fa-user-plus"></i> Database</button>
        <select class="form-select filter_by" aria-label="Example select with button addon">
            <?php foreach ($sections as $i) : ?>
                <option <?= ($i['section'] == url(4) ? 'selected' : ''); ?> value="<?= $i['section']; ?>"><?= $i['section']; ?></option>
            <?php endforeach; ?>
            <option <?= (url(4) == 'All' ? 'selected' : ''); ?> value="All">All</option>
        </select>
    </div>
    <!-- Modal add-->
    <div class="modal fade" id="<?= menu()['controller']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div class="main_color" style="font-weight:bold;"><i class="<?= menu()['icon']; ?>"></i> Tambah <?= menu()['menu']; ?></div>
                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                    </div>
                    <hr class="dark_color" style="border: 1px solid;">
                    <div class="card">
                        <div class="card-body">

                            <form action="<?= base_url(); ?><?= menu()['controller']; ?>/add" method="post">
                                <input type="hidden" name="section" value="<?= url(4); ?>">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="nama" placeholder="Nama" required>
                                    <label>Nama</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                                    <label>Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="role" required>
                                        <?php foreach (options('Role') as $i) : ?>
                                            <option <?= ($i['value'] == 'Member' ? 'selected' : ''); ?> value="<?= $i['value']; ?>"><?= $i['value']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Pilih Role</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="gender">
                                        <option value="L">L</option>
                                        <option value="P">P</option>
                                    </select>
                                    <label>Pilih Gender</label>
                                </div>

                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn_main btn-sm"><i class="fa-regular fa-floppy-disk"></i> Save</button>

                                </div>
                            </form>



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php if (count($data) == 0) : ?>
        <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
    <?php else : ?>
        <div class="input-group input-group-sm">
            <span class="input-group-text">Cari <?= menu()['menu']; ?></span>
            <input type="text" class="form-control cari" placeholder="...">
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Nama</th>
                    <th>Section</th>
                    <th>Username</th>
                    <th>No Id</th>
                    <th>Role</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= $i['nama']; ?></td>
                        <td><?= $i['section']; ?></td>
                        <td><?= $i['username']; ?></td>
                        <td><?= $i['no_id']; ?></td>
                        <td><?= $i['role']; ?></td>
                        <td><a href="" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>_<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen main_color"></i></a> <a class="confirm" data-order="reset password" data-id="<?= $i['id']; ?>" data-method="reset_password" href="" style="font-size: medium;"><i class="fa-solid fa-rotate-left"></i></a> <a href="" data-method="delete" class="confirm" data-id="<?= $i['id']; ?>" data-controller="<?= menu()['controller']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>


    <?php foreach ($data as $i) : ?>
        <!-- Modal update-->
        <div class="modal fade" id="<?= menu()['controller']; ?>_<?= $i['id']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="main_color" style="font-weight: bold;"><i class="<?= menu()['icon']; ?>"></i> Update <?= menu()['menu']; ?></div>
                            <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                        </div>
                        <hr class="dark_color" style="border: 1px solid;">
                        <div class="card">
                            <div class="card-body">

                                <form action="<?= base_url(); ?><?= menu()['controller']; ?>/update" method="post">
                                    <input type="hidden" name="id" value="<?= $i['id']; ?>">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['nama']; ?>" name="nama" placeholder="Nama" required>
                                        <label>Nama</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['username']; ?>" name="username" placeholder="Username">
                                        <label>Username</label>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <select class="form-select" name="section" required>
                                            <?php foreach (options('Section') as $r) : ?>
                                                <option <?= ($i['section'] == $r['value'] ? 'selected' : ''); ?> value="<?= $r['value']; ?>"><?= $r['value']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Pilih Section</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="role" required>
                                            <?php foreach (options('Role') as $b) : ?>
                                                <option <?= ($i['role'] == $b['value'] ? 'selected' : ''); ?> value="<?= $b['value']; ?>"><?= $b['value']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Pilih Role</label>
                                    </div>

                                    <div class="form-floating">
                                        <select class="form-select" name="gender">
                                            <option <?= ($i['gender'] == 'L' ? 'selected' : ''); ?> value="L">L</option>
                                            <option <?= ($i['gender'] == 'P' ? 'selected' : ''); ?> value="P">P</option>
                                        </select>
                                        <label>Pilih Gender</label>
                                    </div>

                                    <div class="d-grid mt-3">
                                        <button type="submit" class="btn-sm btn_main"><i class="fa-solid fa-file-pen"></i> Update <?= menu()['menu']; ?></button>

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