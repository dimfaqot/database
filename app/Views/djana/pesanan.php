<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <div class="modal_confirm position-absolute top-50 start-50 translate-middle btn_main_inactive message_info" style="z-index:9999;left:15px;right:15px;display:none;max-width:max-content;">
        <div class="d-flex gap-2 justify-content-center">
            <span style="font-weight:200;" class="body_get_status"></span>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <?php if ($data['belum'] == 0) : ?>
                <div class="alert_success"><i class="fa-solid fa-circle-check"></i> Alhamdulillah semua tugas telah selesai!.</div>
            <?php else : ?>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Klik untuk melihat data." href="" style="text-decoration: none;" class="btn_danger data_belum"><i class="fa-solid fa-triangle-exclamation text-warning"></i> Ada <?= $data['belum']; ?> tugas yang belum selesai!.</a>
            <?php endif; ?>
        </div>
    </div>
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
            <?php foreach ($data['tahun'] as $i) : ?>
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

    <?php if (session('role') == 'Root' || session('role') == 'Admin') : ?>
        <div class="modal fade" id="images" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-images"></i> Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <?php foreach (get_files('djana') as $k => $i) : ?>
                                <?php if ($i !== 'berkas/djana/logo.png' && $i !== 'berkas/djana/file_not_found.jpg') : ?>
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
            <input type="hidden" name="folder" value="djana">
            <div class="input-group input-group-sm mb-3 line_warning_img">
                <input type="file" class="form-control file" name="file" data-col="img" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pilih gambar.">
                <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Upload gambar." class="btn_main_inactive" type="submit"><i class="fa-solid fa-circle-arrow-up"></i> Upload</button>
                <button data-bs-toggle="modal" data-bs-target="#images" class="btn_main" type="button"><i data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lihat gambar." class="fa-solid fa-images"></i></button>
            </div>
        </form>

    <?php endif; ?>

    <!-- Modal add-->
    <div class="modal fade" id="<?= menu()['controller']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <label style="width: 120px;" class="input-group-text">Tgl. Order</label>
                                            <input type="date" data-date="" class="form-control test input_date" style="padding-bottom: 25px;" name="tgl_order" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <span style="width: 120px;" class="input-group-text">Barang</span>
                                            <input type="text" name="barang" class="form-control" value="" placeholder="Barang" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <label style="width: 120px;" class="input-group-text">Penerima Order</label>
                                            <select class="form-select" name="penerima_order" required>
                                                <option value="">-</option>
                                                <?php foreach (get_users_djana() as $u) : ?>
                                                    <option <?= ($u == session('username') ? 'selected' : ''); ?> value="<?= $u; ?>"><?= upper_first($u); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <label style="width: 120px;" class="input-group-text">Tgl. Deadline</label>

                                            <input type="text" class="form-control input_deadline" name="deadline" value="-" readonly>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <span style="width: 120px;" class="input-group-text">Pemesan</span>
                                            <input type="text" name="pemesan" value="" class="form-control" placeholder="Pemesan" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <span style="width: 120px;" class="input-group-text">Catatan</span>
                                            <input type="text" name="catatan_order" value="" class="form-control" placeholder="Catatan">
                                        </div>
                                    </div>
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


    <?php if (count($data['data']) == 0) : ?>
        <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
    <?php else : ?>
        <div class="input-group input-group-sm">
            <span style="width: 92px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." class="input-group-text">Cari <?= menu()['menu']; ?></span>
            <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." type="text" class="form-control cari" placeholder="...">
        </div>
        <?php if (session('role') == 'Root' || session('role') == 'Admin') : ?>
            <div class="check_all_pesanan d-none mt-2 d-flex gap-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Check All">
                <a href="" class="btn_check_all_pesanan btn_bright_sm" data-status="no" style="font-style:italic;"><i class="fa-solid fa-list-check"></i> Check All</a>
                <button href="" class="btn_laporan bg_main px-2" style="border-radius: 7px;text-decoration:none;font-size:10px"><i class="fa-regular fa-copy"></i> Laporan</button>
            </div>


        <?php endif; ?>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <?php if (session('role') == 'Root' || session('role') == 'Admin') : ?>
                        <th>Check</th>
                    <?php endif; ?>
                    <th class="d-none d-md-table-cell">Tgl</th>
                    <th>Barang</th>
                    <th class="d-none d-md-table-cell">Pemesan</th>
                    <th class="d-none d-md-table-cell">Teller</th>
                    <th>Ket</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data['data'] as $k => $i) : ?>
                    <tr <?= ($i['is_inv'] == 1 ? 'class="table-success"' : ''); ?>>
                        <th scope="row" style="width: 35px;"><?= ($k + 1); ?></th>
                        <?php if (session('role') == 'Root' || session('role') == 'Admin') : ?>
                            <td style="text-align: center;width:20px;">
                                <input class="form-check-input pesanan_list" name="pesanan_list" type="checkbox" value="<?= $i['id']; ?>">
                            </td>
                        <?php endif; ?>
                        <td class="d-none d-md-table-cell"><?= date('d/m/Y', $i['tgl_order']); ?></td>
                        <td data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail barang."><a data-bs-toggle="modal" data-bs-target="#detail_<?= $i['id']; ?>" href="" class="btn_bright_sm"><?= $i['barang']; ?></a></td>
                        <td class="d-none d-md-table-cell"><?= $i['pemesan']; ?></td>
                        <td class="d-none d-md-table-cell"><?= $i['penerima_order']; ?></td>
                        <td><a href="" class="get_status" data-status="<?= $i['status']; ?>"><?= $i['icon']; ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal update-->
        <?php foreach ($data['data'] as $i) : ?>

            <div class="modal fade" id="detail_<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="d-flex justify-content-between btn_main_inactive py-2 px-3" style="border-radius:0px;">
                            <div>
                                <div class="main_color"><i class="fa-solid fa-bag-shopping"></i> <?= $i['barang']; ?></div>

                            </div>
                            <a href="" data-bs-dismiss="modal" class="danger_color">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        </div>
                        <div class="modal-body py-2">

                            <div class="card">
                                <div class="card-body bg_light py-1">
                                    <div class="d-flex gap-2 pt-0">
                                        <?php foreach (get_icon(null, 'ok') as $k => $ic) : ?>
                                            <div class="d-flex gap-2">
                                                <?= ($k > 0 ? '<span><i class="fa-solid fa-arrow-right-long light_color"></i></span>' : ''); ?><span class="<?= ($i['status'] == $ic['status'] ? 'success_color' : 'light_color'); ?>"><?= $ic['icon']; ?></span>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                    <!-- order -->
                                    <form action="<?= base_url(); ?><?= menu()['controller']; ?>/update" method="post">
                                        <input type="hidden" name="id" value="<?= $i['id']; ?>">
                                        <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>">
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <div class="btn_secondary mb-1 d-flex justify-content-between" style="border-radius: 4px 4px 0px 0px;">
                                                    <div>ORDER</div>
                                                    <?php if (session('role') == 'Root' || session('role') == 'Admin') : ?>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input selesai" data-id="<?= $i['id']; ?>" type="checkbox" role="switch" <?= ($i['selesai'] == 1 ? 'checked' : ''); ?>>
                                                            <label class="form-check-label">Selesai</label>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" data-id="<?= $i['id']; ?>" type="checkbox" role="switch" <?= ($i['selesai'] == 1 ? 'checked' : ''); ?> disabled>
                                                            <label class="form-check-label">Selesai</label>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control" value="Inv. Djana">
                                                            <div class="input-group-text">
                                                                <input class="form-check-input mt-0" name="is_inv" type="checkbox" <?= ($i['is_inv'] == 1 ? 'checked' : ''); ?> <?= ($i['selesai'] == 1 ? 'disabled' : ''); ?>>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Tgl. Order</label>
                                                            <?php if ($i['tgl_order'] == 0) : ?>
                                                                <input type="text" class="form-control input_tgl input_tgl_order_<?= $i['id']; ?>" data-id="<?= $i['id']; ?>" data-val="<?= $i['tgl_order']; ?>" name="tgl_order" value="-" <?= ($i['selesai'] == 1 ? 'disabled' : 'readonly'); ?>>
                                                            <?php else : ?>
                                                                <input type="date" data-date="" class="form-control test input_date" style="padding-bottom: 25px;" name="tgl_order" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d', $i['tgl_order']); ?>" <?= ($i['selesai'] == 1 ? 'disabled' : ''); ?>>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <span style="width: 120px;" class="input-group-text">Barang</span>
                                                            <input type="text" name="barang" class="form-control" value="<?= $i['barang']; ?>" placeholder="Barang" required <?= ($i['selesai'] == 1 ? 'disabled' : ''); ?>>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Penerima Order</label>
                                                            <select class="form-select" name="penerima_order" required <?= ($i['selesai'] == 1 ? 'disabled' : ''); ?>>
                                                                <option value="">-</option>
                                                                <?php foreach (get_users_djana() as $u) : ?>
                                                                    <option <?= ($u == $i['penerima_order'] ? 'selected' : ''); ?> value="<?= $u; ?>"><?= upper_first($u); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Pj Order</label>
                                                            <select class="form-select" name="pj_order" required <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                                <option value="">-</option>
                                                                <?php foreach (get_users_djana() as $u) : ?>
                                                                    <option <?= ($u == $i['pj_order'] ? 'selected' : ''); ?> value="<?= $u; ?>"><?= upper_first($u); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Tgl. Deadline</label>
                                                            <?php if ($i['deadline'] == 0) : ?>
                                                                <input type="text" class="form-control input_tgl input_deadline_<?= $i['id']; ?>" data-id="<?= $i['id']; ?>" data-val="<?= $i['deadline']; ?>" name="deadline" value="-" <?= ($i['selesai'] == 1 ? 'disabled' : 'readonly'); ?>>
                                                            <?php else : ?>
                                                                <input type="date" data-date="" class="form-control input_date" style="padding-bottom: 25px;" name="deadline" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d', $i['deadline']); ?>" <?= ($i['selesai'] == 1 ? 'disabled' : ''); ?>>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <span style="width: 120px;" class="input-group-text">Pemesan</span>
                                                            <input type="text" name="pemesan" value="<?= $i['pemesan']; ?>" class="form-control" placeholder="Pemesan" required <?= ($i['selesai'] == 1 ? 'disabled' : ''); ?>>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <span style="width: 120px;" class="input-group-text">Catatan</span>
                                                            <input type="text" name="catatan_order" value="<?= $i['catatan_order']; ?>" class="form-control" placeholder="Catatan" <?= ($i['selesai'] == 1 ? 'disabled' : ''); ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- dp -->
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <div class="btn_secondary mb-1" style="border-radius: 4px 4px 0px 0px;">DP</div>
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Tgl. Dp</label>
                                                            <?php if ($i['tgl_dp'] == 0) : ?>
                                                                <input type="text" class="form-control input_tgl input_tgl_dp_<?= $i['id']; ?>" data-id="<?= $i['id']; ?>" data-val="<?= $i['tgl_dp']; ?>" name="tgl_dp" value="-" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? 'readonly' : 'disabled')); ?>>
                                                            <?php else : ?>
                                                                <input type="date" data-date="" class="form-control input_date" style="padding-bottom: 25px;" name="tgl_dp" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d', $i['tgl_dp']); ?>" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <span style="width: 120px;" class="input-group-text">Jml. Dp</span>
                                                            <input type="text" name="jml_dp" class="form-control uang" value="<?= rupiah($i['jml_dp']); ?>" placeholder="Jumlah Dp" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Pj Dp</label>
                                                            <select class="form-select" name="pj_dp" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                                <option value="">-</option>
                                                                <?php foreach (get_users_djana() as $u) : ?>
                                                                    <option <?= ($u == $i['pj_dp'] ? 'selected' : ''); ?> value="<?= $u; ?>"><?= upper_first($u); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <span style="width: 120px;" class="input-group-text">Catatan</span>
                                                            <input type="text" name="catatan_dp" value="<?= $i['catatan_dp']; ?>" class="form-control" placeholder="Catatan" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- lunas -->
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <div class="btn_secondary mb-1 mb-1" style="border-radius: 4px 4px 0px 0px;">LUNAS</div>
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Tgl. Lunas</label>
                                                            <?php if ($i['tgl_lunas'] == 0) : ?>
                                                                <input type="text" class="form-control input_tgl input_tgl_lunas_<?= $i['id']; ?>" data-id="<?= $i['id']; ?>" data-val="<?= $i['tgl_lunas']; ?>" name="tgl_lunas" value="-" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? 'readonly' : 'disabled')); ?>>
                                                            <?php else : ?>
                                                                <input type="date" data-date="" class="form-control input_date" style="padding-bottom: 25px;" name="tgl_lunas" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d', $i['tgl_lunas']); ?>" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <span style="width: 120px;" class="input-group-text">Jml. Lunas</span>
                                                            <input type="text" name="jml_lunas" class="form-control uang" value="<?= rupiah($i['jml_lunas']); ?>" placeholder="Jumlah lunas" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Pj Lunas</label>
                                                            <select class="form-select" name="pj_lunas" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                                <option value="">-</option>
                                                                <?php foreach (get_users_djana() as $u) : ?>
                                                                    <option <?= ($u == $i['pj_lunas'] ? 'selected' : ''); ?> value="<?= $u; ?>"><?= upper_first($u); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <span style="width: 120px;" class="input-group-text">Catatan</span>
                                                            <input type="text" name="catatan_lunas" value="<?= $i['catatan_lunas']; ?>" class="form-control" placeholder="Catatan" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Uang Masuk -->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="btn_secondary mb-1" style="border-radius: 4px 4px 0px 0px;">UANG MASUK</div>
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Tgl. Uang Masuk</label>
                                                            <?php if ($i['tgl'] == 0) : ?>
                                                                <input type="text" class="form-control input_tgl input_tgl_<?= $i['id']; ?>" data-id="<?= $i['id']; ?>" data-val="<?= $i['tgl']; ?>" name="tgl" value="-" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? 'readonly' : 'disabled')); ?>>
                                                            <?php else : ?>
                                                                <input type="date" data-date="" class="form-control input_date" style="padding-bottom: 25px;" name="tgl" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d', $i['tgl']); ?>" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <span style="width: 120px;" class="input-group-text">Jml. Uang Masuk</span>
                                                            <input type="text" name="jml" class="form-control uang" value="<?= rupiah($i['jml']); ?>" placeholder="Jumlah Uang Masuk" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <label style="width: 120px;" class="input-group-text">Penerima</label>
                                                            <select class="form-select" name="penerima" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                                <option value="">-</option>
                                                                <?php foreach (get_users_djana() as $u) : ?>
                                                                    <option <?= ($u == $i['penerima'] ? 'selected' : ''); ?> value="<?= $u; ?>"><?= upper_first($u); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm">
                                                            <span style="width: 120px;" class="input-group-text">Catatan</span>
                                                            <input type="text" name="catatan" value="<?= $i['catatan']; ?>" class="form-control" placeholder="Catatan" <?= ($i['selesai'] == 1 ? 'disabled' : (session('role') == 'Root' || session('role') == 'Admin' ? '' : 'disabled')); ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2 justify-content-center mt-2">
                                            <?php if ($i['selesai'] == 0) : ?>
                                                <button data-id="<?= $i['id']; ?>" data-order="hapus" data-method="delete" class="btn_danger confirm"><i class="fa-regular fa-trash-can"></i> Delete</button>
                                                <button class="btn_main"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                                            <?php endif; ?>
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


    <!-- modal date -->
    <div class="modal_input_tgl position-absolute top-50 start-50 translate-middle" style="z-index:9000;display:none;">
        <div class="card shadow shadow-lg pb-0">
            <div class="card-header bg_secondary">
                Masukkan Tanggal
            </div>
            <div class="card-body">
                <input type="date" data-date="" class="form-control form-control-sm input_date val_input_tgl" name="tgl" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d'); ?>" required>

                <div class="d-flex justify-content-center gap-2 mt-2 body_btn_modal_input_tgl"></div>
            </div>
        </div>
    </div>
    <!-- modal data belum -->
    <div class="modal fade" id="modal_data_belum" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="d-flex justify-content-between btn_main py-2 px-3" style="border-radius:0px;">
                    <div>
                        <div><i class="fa-solid fa-spinner"></i> Data yang Belum Selesai</div>

                    </div>
                    <a href="" data-bs-dismiss="modal" class="light_color">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </a>
                </div>
                <div class="modal-body py-2">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Tgl</th>
                                <th>Barang</th>
                                <th class="d-none d-md-table-cell">Pemesan</th>
                                <th class="d-none d-md-table-cell">Teller</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody class="body_modal_data_belum">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>