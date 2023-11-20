<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?> <?= url(4); ?>
        </button>

        <button type="button" class="btn-sm btn_secondary" data-bs-toggle="modal" data-bs-target="#daftar_ekstra">
            <i class="fa-solid fa-list"></i> Daftar Ekstra [<?= url(4); ?>]
        </button>


    </div>


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
                                <input type="hidden" name="ekstra" value="<?= url(4); ?>">
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control" name="no_urut" placeholder="Mapel Ke" required>
                                    <label>Mapel Ke</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="mapel" placeholder="Mapel" required>
                                    <label>Mapel</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control" name="sks" placeholder="Sks" required>
                                    <label>Sks</label>
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
    <!-- Modal ekstra-->
    <div class="modal fade" id="daftar_ekstra" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
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
                            <div class="list-group">
                                <?php foreach ($ekstra as $i) : ?>
                                    <a href="<?= base_url(menu()['controller']); ?>/<?= $i['singkatan']; ?>" class="list-group-item list-group-item-action <?= (url(4) == $i['singkatan'] ? 'btn_main' : ''); ?>"><?= $i['ekstra']; ?></a>
                                <?php endforeach; ?>
                            </div>


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
                    <th>Mapel Ke</th>
                    <th>Mapel</th>
                    <th>Sks</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= $i['no_urut']; ?></td>
                        <td><?= $i['mapel']; ?></td>
                        <td><?= $i['sks']; ?></td>
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
                                    <input type="hidden" name="ekstra" value="<?= url(4); ?>">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['ekstra']; ?>" name="ekstra" placeholder="Ekstra" disabled>
                                        <label>Ekstra</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['singkatan']; ?>" name="singkatan" placeholder="Singkatan" disabled>
                                        <label>Singkatan</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['kepala']; ?>" name="kepala" placeholder="Kepala" disabled>
                                        <label>Kepala</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" class="form-control" value="<?= $i['no_urut']; ?>" name="no_urut" placeholder="Mapel Ke" required>
                                        <label>Mapel Ke</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['mapel']; ?>" name="mapel" placeholder="Mapel">
                                        <label>Mapel</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" class="form-control" value="<?= $i['sks']; ?>" name="sks" placeholder="Sks">
                                        <label>Sks</label>
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