<?= $this->extend('logged') ?>

<?= $this->section('content') ?>
<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
        </button>
        <?php if (session('role') == 'Root' || session('role') == 'Admin') : ?>
            <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Angkatan [<?= (url(4) == '' ? 'Tujuh' : str_replace("-", " ", url(4))); ?>]
            </a>
            <ul class="dropdown-menu">
                <?php foreach (options('Angkatan') as $i) : ?>
                    <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == '' && $i['value'] == 'Tujuh' ? 'bg_main' : (url(4) !== '' && $i['value'] == str_replace("-", " ", url(4)) ? 'bg_main' : '')); ?>" href="<?= base_url(menu()['controller']); ?>/<?= str_replace(" ", "-", $i['value']); ?>"><?= $i['value']; ?></a></li>
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
                                <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'Tujuh' : url(4)); ?>">
                                <div class="form-floating mb-2">
                                    <select style="font-size: small;" class="form-select" name="angkatan" required>
                                        <?php foreach (options('Angkatan') as $i) : ?>
                                            <option <?= (url(4) == '' && $i['value'] == 'Tujuh' ? 'selected' : (url(4) !== '' && $i['value'] == str_replace("-", " ", url(4)) ? 'selected' : '')); ?> value="<?= $i['value']; ?>"><?= $i['value']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Pilih Angkatan</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="kelas" placeholder="Kelas" required>
                                    <label>Kelas</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control cari_nama_db add_wali_kelas" data-order="add" name="wali_kelas" data-tabel="karyawan" placeholder="Wali kelas">
                                    <label>Wali Kelas</label>
                                    <ul class="p-1 dropdown-menu body_add_wali_kelas" style="font-size:small;">

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
                    <th>Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= $i['kelas']; ?></td>
                        <td><?= $i['wali_kelas']; ?></td>
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
                                        <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'Tujuh' : url(4)); ?>">
                                        <div class="form-floating mb-2">
                                            <select style="font-size: small;" class="form-select" name="angkatan" required>
                                                <?php foreach (options('Angkatan') as $a) : ?>
                                                    <option <?= ($i['angkatan'] == $a['value'] ? 'selected' : ''); ?> value="<?= $a['value']; ?>"><?= $a['value']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Pilih Angkatan</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="kelas" value="<?= $i['kelas']; ?>" placeholder="Kelas" required>
                                            <label>Kelas</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control cari_nama_db add_wali_kelas" data-order="add" value="<?= $i['wali_kelas']; ?>" name="wali_kelas" data-tabel="karyawan" placeholder="Wali kelas">
                                            <label>Wali Kelas</label>
                                            <ul class="p-1 dropdown-menu body_add_wali_kelas" style="font-size:small;">

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