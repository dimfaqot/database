<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
        </button>
    </div>

    <div class="modal fade" id="images" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-images"></i> Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <?php foreach (get_files(menu()['controller']) as $k => $i) : ?>
                            <?php if ($i !== 'berkas/ekstra/sertifikat1.jpg' && $i !== 'berkas/ekstra/sertifikat2.jpg') : ?>

                                <div class="col-md-4">
                                    <div style="position: relative;">
                                        <div class="modal_confirm position-absolute top-50 start-50 d-none translate-middle btn_main_inactive message_confirm_<?= $k; ?>" style="z-index:9999;left:15px;right:15px;">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <span style="font-weight:500;">Delete?</span> <a href="" class="delete_file" data-dir="<?= $i; ?>"><i class="fa-solid fa-circle-check text-success"></i></a> <a href="" class="cancel_delete_file" data-i="<?= $k; ?>"><i class="fa-solid fa-circle-xmark text-danger"></i></a>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body p-1">
                                                <a href="" class="top_right_corner confirm_delete_file" data-i="<?= $k; ?>"><i class="fa-solid fa-circle-xmark"></i></a>
                                                <img class="img-fluid" src="<?= base_url() . $i; ?>" alt="<?= $i; ?>">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <small class="body_warning_img text-danger"></small>
    <form method="post" action="<?= base_url(); ?><?= menu()['controller']; ?>/add_image" class="form-floating mb-2" enctype="multipart/form-data">
        <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>">
        <input type="hidden" name="folder" value="<?= menu()['controller']; ?>">
        <div class="input-group input-group-sm mb-3 line_warning_img">
            <input type="file" class="form-control file" name="file" data-col="img" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pilih gambar.">
            <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Upload gambar." class="btn_main_inactive" type="submit"><i class="fa-solid fa-circle-arrow-up"></i> Upload</button>
            <button data-bs-toggle="modal" data-bs-target="#images" class="btn_main" type="button"><i data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lihat gambar." class="fa-solid fa-images"></i></button>
        </div>
    </form>


    <!-- Modal add-->
    <div class="modal fade" id="<?= menu()['controller']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?></div>
                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                    </div>
                    <hr class="dark_color" style="border: 1px solid;">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?= base_url(); ?><?= menu()['controller']; ?>/add" method="post">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="ekstra" placeholder="Nama Ekstra" required>
                                    <label>Nama Ekstra</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="singkatan" placeholder="Singkatan" required>
                                    <label>Singkatan</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="kepala" placeholder="Kepala" required>
                                    <label>Kepala</label>
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
                    <th scope="col">#</th>
                    <th>Ekstra</th>
                    <th>Singkatan</th>
                    <th>Kepala</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= $i['ekstra']; ?></td>
                        <td><?= $i['singkatan']; ?></td>
                        <td><?= $i['kepala']; ?></td>
                        <td><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Data"><a href="" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>_<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen main_color"></i></a></span> <a href="" class="confirm" data-id="<?= $i['id']; ?>" data-order="hapus" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
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
                                        <input type="text" class="form-control" value="<?= $i['ekstra']; ?>" name="ekstra" placeholder="Nama Ekstra" required>
                                        <label>Nama Ekstra</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['singkatan']; ?>" name="singkatan" placeholder="Singkatan">
                                        <label>Singkatan</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['kepala']; ?>" name="kepala" placeholder="Kepala">
                                        <label>Kepala</label>
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