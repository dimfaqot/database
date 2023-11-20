<?= $this->extend('logged') ?>

<?= $this->section('content') ?>
<?php $genders = ['L', 'P']; ?>
<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
        </button>
        <?php if (session('role') == 'Root') : ?>
            <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Section [<?= (url(4) == '' ? 'Root' : url(4)); ?>]
            </a>
            <ul class="dropdown-menu">
                <?php foreach (options('Section') as $i) : ?>
                    <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == '' && $i['value'] == 'Root' ? 'bg_main' : (url(4) !== '' && $i['value'] == url(4) ? 'bg_main' : '')); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i['value']; ?>/<?= (url(5) == '' ? 'Root' : url(5)); ?>"><?= $i['value']; ?></a></li>
                <?php endforeach; ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/All/<?= (url(5) == '' ? 'Root' : url(5)); ?>">All</a></li>
            </ul>
            <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Role [<?= (url(5) == '' ? 'Root' : url(5)); ?>]
            </a>
            <ul class="dropdown-menu">
                <?php foreach (options('Role') as $i) : ?>
                    <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == '' && $i['value'] == 'Root' ? 'bg_main' : (url(5) !== '' && $i['value'] == url(5) ? 'bg_main' : '')); ?>" href="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'Root' : url(4)); ?>/<?= $i['value']; ?>"><?= $i['value']; ?></a></li>
                <?php endforeach; ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'Root' : url(4)); ?>/All">All</a></li>
            </ul>
        <?php endif; ?>
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
                                <?php if (session('role') == 'Root') : ?>
                                    <input type="hidden" name="section" value="<?= (url(4) == '' ? 'Root' : url(4)); ?>">
                                    <input type="hidden" name="role" value="<?= (url(5) == '' ? 'Root' : url(5)); ?>">
                                    <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'Root' : url(4)); ?>/<?= (url(5) == '' ? 'Root' : url(5)); ?>">
                                <?php else : ?>
                                    <input type="hidden" name="section" value="<?= session('section'); ?>">
                                    <input type="hidden" name="role" value="Member">
                                    <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>">
                                <?php endif; ?>
                                <div class="form-floating mb-2">
                                    <select style="font-size: small;" class="form-select" name="gender" required>
                                        <?php foreach ($genders as $i) : ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Pilih Gender</label>
                                </div>
                                <label class="form-label">Informasi</label>
                                <textarea name="informasi" class="form-control form-control-sm" id="ck_input_add" rows="3"></textarea>
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
                    <th>Gender</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= $i['section']; ?></td>
                        <td><?= $i['role']; ?></td>
                        <td><?= $i['gender']; ?></td>
                        <td><a href="" class="dark_color" data-bs-toggle="modal" data-bs-target="#copy_<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-copy"></i></a> <a href="" data-bs-toggle="modal" data-bs-target="#detail_<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen main_color"></i></a> <a href="" class="confirm" data-id="<?= $i['id']; ?>" data-order="hapus" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php foreach ($data as $k => $i) : ?>
        <!-- Modal update-->
        <div class="modal fade" id="detail_<?= $i['id']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
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
                                    <?php if (session('role') == 'Root') : ?>
                                        <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'Root' : url(4)); ?>/<?= (url(5) == '' ? 'Root' : url(5)); ?>">
                                        <div class="form-floating mb-2">
                                            <select style="font-size: small;" class="form-select" name="section" required>
                                                <?php foreach (options('Section') as $g) : ?>
                                                    <option <?= ($g['value'] == $i['section'] ? 'selected' : ''); ?> value="<?= $g['value']; ?>"><?= $g['value']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Pilih Section</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <select style="font-size: small;" class="form-select" name="role" required>
                                                <?php foreach (options('Role') as $g) : ?>
                                                    <option <?= ($g['value'] == $i['role'] ? 'selected' : ''); ?> value="<?= $g['value']; ?>"><?= $g['value']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Pilih Role</label>
                                        </div>
                                    <?php else : ?>
                                        <input type="hidden" name="section" value="<?= $i['section']; ?>">
                                        <input type="hidden" name="role" value="<?= $i['role']; ?>">
                                        <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>">
                                    <?php endif; ?>
                                    <div class="form-floating mb-2">
                                        <select style="font-size: small;" class="form-select" name="gender" required>
                                            <?php foreach ($genders as $g) : ?>
                                                <option <?= ($g == $i['gender'] ? 'selected' : ''); ?> value="<?= $g; ?>"><?= $g; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Pilih Gender</label>
                                    </div>
                                    <label class="form-label">Informasi</label>
                                    <textarea name="informasi" class="form-control form-control-sm" id="ck_input_update_<?= $k; ?>" rows="3"><?= $i['informasi']; ?></textarea>

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


        <!-- Modal copy-->
        <div class="modal fade" id="copy_<?= $i['id']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="<?= base_url(menu()['controller']); ?>/copy" method="post">
                            <input type="hidden" name="id" value="<?= $i['id']; ?>">
                            <div class="d-flex gap-2">
                                <?php if (session('role') == 'Root') : ?>
                                    <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'Root' : url(4)); ?>/<?= (url(5) == '' ? 'Root' : url(5)); ?>">
                                    <select name="section" class="form-select form-select-sm">
                                        <?php foreach (options('Section') as $s) : ?>
                                            <option <?= ($s['value'] == $i['section'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select name="role" class="form-select form-select-sm">
                                        <?php foreach (options('Role') as $s) : ?>
                                            <option <?= ($s['value'] == $i['role'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select name="gender" class="form-select form-select-sm">
                                        <?php foreach ($genders as $s) : ?>
                                            <option <?= ($s !== $i['gender'] ? 'selected' : ''); ?> value="<?= $s; ?>"><?= $s; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else : ?>
                                    <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>">
                                    <input type="hidden" name="section" value="<?= $i['section']; ?>">
                                    <input type="hidden" name="role" value="<?= $i['role']; ?>">
                                    <div class="mb-1">
                                        <label class="form-label">Copy Info ke <?= ($i['gender'] == 'P' ? 'Laki-laki' : 'Perempuan'); ?></label>
                                        <input type="hidden" name="gender" value="<?= ($i['gender'] == 'P' ? 'L' : 'P'); ?>" class="form-control form-control-sm" readonly>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <div class="d-grid mt-3">
                                <button type="submit" class="btn-sm btn_main"><i class="fa-solid fa-copy"></i> Copy <?= menu()['menu']; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>


</div>
<?= $this->endSection() ?>