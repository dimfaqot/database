<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
        </button>
        <select class="form-select filter_by" aria-label="Example select with button addon">
            <?php foreach ($menu_roles as $i) : ?>
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
                        <div class="main_color" style="font-weight: bold;"><i class="<?= menu()['icon']; ?>"></i> Tambah <?= menu()['menu']; ?></div>
                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                    </div>
                    <hr class="dark_color" style="border: 1px solid;">
                    <div class="card">
                        <div class="card-body">

                            <form action="<?= base_url(); ?><?= menu()['controller']; ?>/add" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="section" value="<?= url(4); ?>">
                                <div class="form-floating mb-2">
                                    <select style="font-size: small;" class="form-select" name="role" required>
                                        <option>Click to select</option>
                                        <?php foreach (options('Role') as $i) : ?>
                                            <option value="<?= $i['value']; ?>"><?= $i['value']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Pilih Role</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="menu" placeholder="Menu" required>
                                    <label>Menu</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="tabel" placeholder="Tabel" required>
                                    <label>Tabel</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="controller" placeholder="Controller" required>
                                    <label>Controller</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="icon" placeholder="Icon" required>
                                    <label>Icon</label>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Logo</label>
                                    <input class="form-control form-control-sm" name="logo" type="file">
                                </div>

                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn-sm btn_main"><i class="fa-regular fa-floppy-disk"></i> Save</button>

                                </div>
                            </form>



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal copy-->
    <div class="modal fade" id="copy_menu" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body body_modal_copy_menu">

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
                    <th>Section</th>
                    <th>Role</th>
                    <th>Menu</th>
                    <th>Tabel</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= $i['section']; ?></td>
                        <td><?= $i['role']; ?></td>
                        <td><?= $i['menu']; ?></td>
                        <td><?= $i['tabel']; ?></td>
                        <td><span class="px-2 bg-secondary text-light rounded" style="font-size: 10px;"><?= $i['no_urut']; ?></span> <a href="" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>_<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen main_color"></i></a> <a href="" class="copy_menu dark_color" data-id="<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-copy"></i></a> <a href="" class="confirm" data-id="<?= $i['id']; ?>" data-order="hapus" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
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

                                <form action="<?= base_url(); ?><?= menu()['controller']; ?>/update" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $i['id']; ?>">
                                    <div class="form-floating mb-2">
                                        <select class="form-select" name="section" required>
                                            <?php foreach (options('Section') as $r) : ?>
                                                <option <?= ($i['section'] == $r['value'] ? 'selected' : ''); ?> value="<?= $r['value']; ?>"><?= $r['value']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Section</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <select class="form-select" name="role" required>
                                            <?php foreach (options('role') as $b) : ?>
                                                <option <?= ($i['role'] == $b['value'] ? 'selected' : ''); ?> value="<?= $b['value']; ?>"><?= $b['value']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Role</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['menu']; ?>" name="menu" placeholder="Menu" required>
                                        <label>Menu</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['tabel']; ?>" name="tabel" placeholder="Tabel" required>
                                        <label>Tabel</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['controller']; ?>" name="controller" placeholder="Controller" required>
                                        <label>Controller</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['icon']; ?>" name="icon" placeholder="Icon" required>
                                        <label>Icon</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" class="form-control" value="<?= $i['no_urut']; ?>" name="no_urut" placeholder="No. Urut" required>
                                        <label>No. Urut</label>
                                    </div>

                                    <div class="card" style="width: 18rem;">
                                        <img src="<?= base_url(); ?>berkas/<?= menu()['controller']; ?>/<?= $i['logo']; ?>" class="card-img-top" alt="Logo">
                                        <div class="card-body">
                                            <h6 style="font-size: small;" class="card-title">Logo</h6>
                                            <input class="form-control form-control-sm" name="logo" type="file">
                                        </div>
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