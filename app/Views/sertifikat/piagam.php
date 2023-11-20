<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
        </button>
        <button type="button" class="btn-sm btn_secondary" data-bs-toggle="modal" data-bs-target="#tahun">
            <i class="fa-solid fa-calendar"></i> Tahun
        </button>

        <select class="form-select filter_by" aria-label="Example select with button addon">
            <?php foreach ($tahuns as $i) : ?>
                <option <?= ($i['tahun'] == url(4) ? 'selected' : ''); ?> value="<?= $i['tahun']; ?>"><?= $i['tahun']; ?></option>
            <?php endforeach; ?>
            <option <?= (url(4) == 'All' ? 'selected' : ''); ?> value="All">All</option>
        </select>

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
                                <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>">
                                <input type="hidden" name="tahun" value="<?= url(5); ?>">
                                <div class="add_no_id"></div>
                                <div class="form-floating mb-2">
                                    <select style="font-size: small;" class="form-select" name="jenis" required>
                                        <option>Click to select</option>
                                        <?php foreach (options('Piagam') as $i) : ?>
                                            <option value="<?= $i['value']; ?>"><?= $i['value']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Pilih Jenis Piagam</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="lomba" placeholder="Nama Lomba" required>
                                    <label>Nama Lomba</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="sebagai" placeholder="Sebagai" required>
                                    <label>Sebagai</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="capaian" placeholder="Capian yang diraih" required>
                                    <label>Capaian yang diraih</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control cari_db add_nama" data-order="add" name="nama" placeholder="Tabel">
                                    <label>Nama Pembimbing</label>
                                    <ul class="p-1 dropdown-menu add_body_search_nama" style="font-size:small;">

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
    <!-- Modal tahun-->
    <div class="modal fade" id="tahun" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-calendar"></i> Tahun</div>
                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                    </div>
                    <hr class="dark_color" style="border: 1px solid;">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th>Tahun</th>
                                        <th>Kepala Kb</th>
                                        <th>Kepala Tk</th>
                                        <th>Kepala Sdi</th>
                                        <th>Kepala Smp</th>
                                        <th>Kepala Sma</th>
                                        <th>Kepala Pondok Putra</th>
                                        <th>Kepala Pondok Putri</th>
                                    </tr>
                                </thead>
                                <tbody class="tabel_search">
                                    <?php foreach ($tahuns as $k => $i) : ?>
                                        <tr>
                                            <th scope="row"><?= ($k + 1); ?></th>
                                            <td><?= $i['tahun']; ?></td>
                                            <td contenteditable data-id="<?= $i['tahun']; ?>" data-col="kepala_kb" class="update"><?= $i['kepala_kb']; ?></td>
                                            <td contenteditable data-id="<?= $i['tahun']; ?>" data-col="kepala_tk" class="update"><?= $i['kepala_tk']; ?></td>
                                            <td contenteditable data-id="<?= $i['tahun']; ?>" data-col="kepala_sdi" class="update"><?= $i['kepala_sdi']; ?></td>
                                            <td contenteditable data-id="<?= $i['tahun']; ?>" data-col="kepala_smp" class="update"><?= $i['kepala_smp']; ?></td>
                                            <td contenteditable data-id="<?= $i['tahun']; ?>" data-col="kepala_sma" class="update"><?= $i['kepala_sma']; ?></td>
                                            <td contenteditable data-id="<?= $i['tahun']; ?>" data-col="kepala_pondok_putra" class="update"><?= $i['kepala_pondok_putra']; ?></td>
                                            <td contenteditable data-id="<?= $i['tahun']; ?>" data-col="kepala_pondok_putri" class="update"><?= $i['kepala_pondok_putri']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-between gap-1 my-2">
        <div class="d-flex gap-1">
            <div class="print_sk_by_check d-none">
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Check All" href="" class="btn_main_inactive check_all" style="font-style:italic;"><i class="fa-solid fa-list-check"></i> Check All</a>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download excel" data-order="excel" href="" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-file-excel"></i> Print Excel</a>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download pdf" data-order="pdf" href="" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-paste"></i> Print Pdf</a>
            </div>
            <div class="btn_main_inactive" style="margin-top: -4px;">
                <?php foreach (options('Piagam') as $i) : ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasar jenis <?= $i['value']; ?>." href="<?= base_url(url()); ?>/<?= $i['value']; ?>/<?= url(5); ?>"><span class="badge <?= (url(4) == $i['value'] ? 'text-bg-success' : 'text-bg-light'); ?>"><?= $i['value']; ?></span></a>
                <?php endforeach; ?>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tampilkan semua jenis." href="<?= base_url(url()); ?>/All/<?= url(5); ?>"><span class="badge <?= (url(4) == 'All' ? 'text-bg-success' : 'text-bg-light'); ?>">All</span></a>
            </div>

        </div>
        <div class="form-check form-switch">
            <input class="form-check-input ttd" checked type="checkbox" role="switch">
            <label class="form-check-label">TTD</label>
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
                    <th>Tahun</th>
                    <th>Nama</th>
                    <th>Sub</th>
                    <th>Jenis</th>
                    <th>Lomba</th>
                    <th>Capaian</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td style="text-align: center;">
                            <input class="form-check-input cetak_check" name="cetak_check" type="checkbox" value="<?= $i['id']; ?>">
                        </td>
                        <td><?= $i['tahun']; ?></td>
                        <td><?= $i['nama']; ?></td>
                        <td><?= $i['sub']; ?></td>
                        <td><?= $i['jenis']; ?></td>
                        <td><?= $i['lomba']; ?></td>
                        <td><?= $i['capaian']; ?></td>
                        <td><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Data"><a href="" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>_<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen main_color"></i></a></span> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download Pdf" data-order="single" href="" data-id="<?= $i['id']; ?>" href="" class="cetak" style="font-size: medium;"><i class="fa-regular fa-file-pdf"></i></a> <a href="" class="confirm" data-id="<?= $i['id']; ?>" data-order="hapus" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
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
                                    <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>">
                                    <div class="form-floating mb-2">
                                        <input type="number" class="form-control" value="<?= $i['tahun']; ?>" name="tahun" placeholder="Tahun" required>
                                        <label>Tahun</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['no_surat']; ?>" name="no_surat" placeholder="No. Surat">
                                        <label>No. Surat</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="date" class="form-control" value="<?= date('Y-m-d', $i['tgl']); ?>" name="tgl" placeholder="Tanggal">
                                        <label>Tanggal</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['nama']; ?>" name="nama" placeholder="Nama Pembimbing">
                                        <label>Nama Pembimbing</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <select class="form-select" name="sub" required>
                                            <?php foreach (sub() as $r) : ?>
                                                <option <?= ($i['sub'] == $r['singkatan'] ? 'selected' : ''); ?> value="<?= $r['singkatan']; ?>"><?= $r['singkatan']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Sub</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['sebagai']; ?>" name="sebagai" placeholder="Sebagai">
                                        <label>Sebagai</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <select class="form-select" name="jenis" required>
                                            <?php foreach (options('Piagam') as $r) : ?>
                                                <option <?= ($i['jenis'] == $r['value'] ? 'selected' : ''); ?> value="<?= $r['value']; ?>"><?= $r['value']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>Jenis Lomba</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['lomba']; ?>" name="lomba" placeholder="Nama Lomba" required>
                                        <label>Nama Lomba</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" value="<?= $i['capaian']; ?>" name="capaian" placeholder="Capaian yang diraih" required>
                                        <label>Capaian yang diraih</label>
                                    </div>

                                    <img width="90" src="<?= base_url($i['qr_code']); ?>" class="img-thumbnail" alt="QR CODE">

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