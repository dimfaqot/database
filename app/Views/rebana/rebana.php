<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">
    <!-- Button trigger modal -->
    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> Tambah <?= menu()['menu']; ?>
        </button>
        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tahun [<?= url(4); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($tahun as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == $i ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i; ?>/<?= url(5); ?>"><?= $i; ?></a></li>
            <?php endforeach; ?>
            <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/All/<?= url(5); ?>">All</a></li>
        </ul>
        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Bulan [<?= url(5); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach (bulan() as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == $i['angka'] ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= $i['angka']; ?>"><?= $i['bulan']; ?></a></li>
            <?php endforeach; ?>
            <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/All">All</a></li>
        </ul>

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
                        <?php foreach (get_files('rebana') as $k => $i) : ?>
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
                            <form action="<?= base_url(); ?><?= menu()['controller']; ?>/add" method="post">
                                <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>">
                                <div class="mb-2">
                                    <label>Tanggal</label>
                                    <input type="date" data-date="" class="form-control form-control-sm input_date mt-1" name="tgl" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d'); ?>" required>
                                </div>
                                <div class="form-floating mb-2">
                                    <select class="form-select" name="pasaran">
                                        <?php foreach (pasaran() as $i) : ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="floatingSelect">Pasaran</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <textarea class="form-control" placeholder="Alamat" name="alamat" style="height: 100px" required></textarea>
                                    <label>Alamat</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="jam" placeholder="Jam" required>
                                    <label>Jam</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="acara" placeholder="Acara" required>
                                    <label>Acara</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="panitia" placeholder="Panitia" required>
                                    <label>Panitia</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="telepon" placeholder="Telepon" required>
                                    <label>Telepon</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="penjemputan" placeholder="Penjemputan" required>
                                    <label>Penjemputan</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="keterangan" placeholder="Keterangan" required>
                                    <label>Keterangan</label>
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

        <div class="row g-2">
            <div class="col-md-8">
                <input type="text" class="form-control form-control-sm cari" placeholder="Cari <?= menu()['menu']; ?>">
            </div>
            <div class="col-md-2 pt-1">
                <a href="<?= base_url(); ?><?= menu()['controller']; ?>/cetak/<?= url(4); ?>/<?= url(5); ?>/pdf" target="_blank" class="btn_main_inactive" style="font-style:italic;"><i class="fa-solid fa-paste"></i> Download Pdf</a>
            </div>
            <div class="col-md-2 pt-1">
                <a href="<?= base_url(); ?><?= menu()['controller']; ?>/cetak/<?= url(4); ?>/<?= url(5); ?>/excel" target="_blank" class="btn_main_inactive" style="font-style:italic;"><i class="fa-solid fa-file-excel"></i> Download Excel</a>

            </div>

        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Tgl</th>
                    <th>Alamat</th>
                    <th>Jam</th>
                    <th>Acara</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= hari(date('l', $i['tgl']))['indo']; ?>, <?= date('d/m/Y', $i['tgl']); ?></td>
                        <td><?= $i['alamat']; ?></td>
                        <td><?= $i['jam']; ?></td>
                        <td><?= $i['acara']; ?></td>
                        <td><?= (session('role') == 'Root' || session('role') == 'Admin' ? '<a href="" data-bs-toggle="modal" data-bs-target="#update_' . $i['id'] . '" type="button" class="main_color" style="font-size: medium;"><i class="fa-solid fa-square-pen"></i></a>' : ''); ?> <a data-bs-toggle="modal" data-bs-target="#update_lagu_<?= $i['id']; ?>" type="button" class="dark_color" href=""><i class="fa-solid fa-music"></i></a> <a href="" class="confirm" data-method="delete" data-id="<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <!-- Modal update-->

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
                                        <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>">
                                        <input type="hidden" name="id" value="<?= $i['id']; ?>">

                                        <div class="mb-2">
                                            <label>Tanggal</label>
                                            <input type="date" data-date="" class="form-control form-control-sm input_date mt-1" name="tgl" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d', $i['tgl']); ?>">
                                        </div>
                                        <div class="form-floating mb-2">
                                            <select class="form-select" name="pasaran">
                                                <?php foreach (pasaran() as $p) : ?>
                                                    <option <?= ($i['pasaran'] == $p ? 'selected' : ''); ?> value="<?= $p; ?>"><?= $p; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="floatingSelect">Pasaran</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <textarea class="form-control" placeholder="Alamat" name="alamat" style="height: 100px"><?= $i['alamat']; ?></textarea>
                                            <label>Alamat</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" value="<?= $i['jam']; ?>" class="form-control" name="jam" placeholder="Jam" required>
                                            <label>Jam</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" value="<?= $i['acara']; ?>" class="form-control" name="acara" placeholder="Acara" required>
                                            <label>Acara</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" value="<?= $i['panitia']; ?>" class="form-control" name="panitia" placeholder="Panitia" required>
                                            <label>Panitia</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" value="<?= $i['telepon']; ?>" class="form-control" name="telepon" placeholder="Telepon" required>
                                            <label>Telepon</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" value="<?= $i['penjemputan']; ?>" name="penjemputan" placeholder="Penjemputan" required>
                                            <label>Penjemputan</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" value="<?= $i['keterangan']; ?>" name="keterangan" placeholder="Keterangan" required>
                                            <label>Keterangan</label>
                                        </div>


                                        <div class="d-grid mt-3">
                                            <button type="submit" class="btn-sm btn_main"><i class="fa-solid fa-square-pen"></i> Update Data</button>

                                        </div>
                                    </form>



                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="update_lagu_<?= $i['id']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
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

                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text">Jumlah Lagu</span>
                                        <input type="number" class="form-control value_daftar_lagu">
                                        <button class="btn btn-outline-secondary daftar_lagu" type="button">Ok</button>
                                    </div>
                                    <div>
                                        <?php
                                        $songs = $i['lagu'];
                                        $exp = explode(",", $songs);
                                        ?>
                                        <table class="table table-bordered body_daftar_lagu">
                                            <?php if ($songs !== '') : ?>
                                                <?php foreach ($exp as $k => $e) : ?>
                                                    <tr class="daftar_lagu_<?= $k; ?>">
                                                        <th scope="row" style="width: 40px;"><?= ($k + 1); ?></th>
                                                        <td contenteditable="true" class="get_daftar_lagu"><?= $e; ?></td>
                                                        <td style="width: 20px;"><a href="" class="danger_color remove_daftar_lagu" data-i="<?= $k; ?>" style="font-size: medium;"><i class="fa-solid fa-circle-xmark danger_color"></i></a></td>
                                                    </tr>


                                                <?php endforeach; ?>

                                            <?php endif; ?>
                                        </table>
                                    </div>


                                    <div class="d-grid mt-3">
                                        <button type="button" class="btn-sm btn_main update_daftar_lagu" data-id="<?= $i['id']; ?>"><i class="fa-solid fa-music"></i> Update Daftar Lagu</button>

                                    </div>



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