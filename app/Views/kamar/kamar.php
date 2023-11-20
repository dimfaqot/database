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
                Pondok [<?= (url(4) == '' ? 'L' : url(4)); ?>]
            </a>
            <ul class="dropdown-menu">
                <?php foreach ($genders as $i) : ?>
                    <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == '' && $i == 'L' ? 'bg_main' : (url(4) !== '' && $i == url(4) ? 'bg_main' : '')); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i; ?>"><?= $i; ?></a></li>
                <?php endforeach; ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/All">All</a></li>
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
                                    <input type="hidden" name="pondok" value="<?= (url(4) == '' ? 'L' : url(4)); ?>">
                                    <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'L' : url(4)); ?>">
                                <?php else : ?>
                                    <input type="hidden" name="pondok" value="<?= session('gender'); ?>">
                                    <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>">
                                <?php endif; ?>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" value="" name="kamar" placeholder="Kamar" required>
                                    <label>Kamar</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control cari_nama_db add_wali_kamar_1" data-gender="<?= (session('role') == 'Root' ? (url(4) == '' ? 'L' : url(4)) : session('gender')); ?>" data-order="add" name="wali_kamar_1" data-tabel="santri" placeholder="Wali kamar 1">
                                    <label>Wali Kamar 1</label>
                                    <ul class="p-1 dropdown-menu body_add_wali_kamar_1" style="font-size:small;">

                                    </ul>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control cari_nama_db add_wali_kamar_2" data-gender="<?= (session('role') == 'Root' ? (url(4) == '' ? 'L' : url(4)) : session('gender')); ?>" data-order="add" name="wali_kamar_2" data-tabel="santri" placeholder="Wali kamar 2">
                                    <label>Wali Kamar 2</label>
                                    <ul class="p-1 dropdown-menu body_add_wali_kamar_2" style="font-size:small;">

                                    </ul>
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
                    <td scope="col">#</td>
                    <th>Kamar</th>
                    <th>Wali Kamar 1</th>
                    <th>Wali Kamar 2</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= $i['kamar']; ?></td>
                        <td><?= $i['wali_kamar_1']; ?></td>
                        <td><?= $i['wali_kamar_2']; ?></td>
                        <td><a href="" data-bs-toggle="modal" data-bs-target="#detail_<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen main_color"></i></a> <a href="" class="confirm" data-id="<?= $i['id']; ?>" data-order="hapus" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
                                            <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'L' : url(4)); ?>">
                                            <input type="hidden" name="pondok" value="<?= (url(4) == '' ? 'L' : url(4)); ?>">
                                        <?php else : ?>
                                            <input type="hidden" name="pondok" value="<?= $i['pondok']; ?>">
                                            <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>">
                                        <?php endif; ?>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" value="<?= $i['kamar']; ?>" name="kamar" placeholder="Kamar" required>
                                            <label>Kamar</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" value="<?= $i['wali_kamar_1']; ?>" class="form-control cari_nama_db add_wali_kamar_1_<?= $i['id']; ?>" data-id="<?= $i['id']; ?>" data-gender="<?= (session('role') == 'Root' ? (url(4) == '' ? 'L' : url(4)) : session('gender')); ?>" data-order="update" name="wali_kamar_1" data-tabel="santri" placeholder="Wali kamar 1">
                                            <label>Wali Kamar 1</label>
                                            <ul class="p-1 dropdown-menu body_update_wali_kamar_1_<?= $i['id']; ?>" style="font-size:small;">

                                            </ul>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" value="<?= $i['wali_kamar_2']; ?>" class="form-control cari_nama_db update_wali_kamar_2_<?= $i['id']; ?>" data-id="<?= $i['id']; ?>" data-gender="<?= (session('role') == 'Root' ? (url(4) == '' ? 'L' : url(4)) : session('gender')); ?>" data-order="update" name="wali_kamar_2" data-tabel="santri" placeholder="Wali kamar 2">
                                            <label>Wali Kamar 2</label>
                                            <ul class="p-1 dropdown-menu body_update_wali_kamar_2_<?= $i['id']; ?>" style="font-size:small;">

                                            </ul>
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
    <?php endif; ?>



</div>
<?= $this->endSection() ?>