<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<?php $order = ['Penerima Order', 'Pj Order', 'Pj Dp', 'Pj Lunas', 'Penerima Uang Masuk', 'All']; ?>
<div class="container" style="margin-top: 60px;">
    <div class="modal_confirm position-absolute top-50 start-50 translate-middle btn_main_inactive message_info" style="z-index:9999;left:15px;right:15px;display:none;max-width:max-content;">
        <div class="d-flex gap-2 justify-content-center">
            <span style="font-weight:200;" class="body_get_status"></span>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <?php if ($data['belum'] == 0) : ?>
                <div class="alert_success"><i class="fa-solid fa-circle-check"></i> Alhamdulillah semua tugasmu telah selesai!.</div>
            <?php else : ?>
                <a href="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Klik untuk melihat data." style="text-decoration: none;" class="btn_danger data_belum"><i class="fa-solid fa-triangle-exclamation text-warning"></i> Ada <?= $data['belum']; ?> tugas terkait denganmu belum selesai!.</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Button trigger modal -->
    <div class="input-group input-group-sm mb-3">
        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tahun [<?= url(4); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($data['tahun'] as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == $i ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i; ?>/<?= url(5); ?>/<?= url(6); ?>"><?= $i; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Bulan [<?= url(5); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach (bulan() as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == $i['angka'] ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= $i['angka']; ?>/<?= url(5); ?>/<?= url(6); ?>"><?= $i['bulan']; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tugasku [<?= str_replace("-", " ", url(6)); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($order as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (str_replace("-", " ", url(6)) == $i ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= str_replace(" ", "-", $i); ?>"><?= $i; ?></a></li>
            <?php endforeach; ?>
        </ul>

    </div>

    <?php if (count($data['data']) == 0) : ?>
        <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
    <?php else : ?>
        <div class="input-group input-group-sm">
            <span style="width: 92px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." class="input-group-text">Cari <?= menu()['menu']; ?></span>
            <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." type="text" class="form-control cari" placeholder="...">
        </div>
        <div class="check_all_pesanan d-none mt-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Check All" href="" class="btn_bright_sm btn_check_all_pesanan" style="font-style:italic;"><i class="fa-solid fa-list-check"></i> Check All</a>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Check</th>
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
                        <td style="text-align: center;width:20px;">
                            <input class="form-check-input pesanan_check" name="pesanan_check" type="checkbox" value="<?= $i['id']; ?>">
                        </td>
                        <td class="d-none d-md-table-cell"><?= date('d/m/Y', $i['tgl_order']); ?></td>
                        <td data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail barang."><a data-bs-toggle="modal" data-bs-target="#detail_<?= $i['id']; ?>" href="" class="btn_bright_sm"><?= $i['barang']; ?></a></td>
                        <td class="d-none d-md-table-cell"><?= $i['pemesan']; ?></td>
                        <td class="d-none d-md-table-cell"><?= $i['penerima_order']; ?></td>
                        <td><a href="" class="get_status" data-status="<?= $i['status']; ?>"><?= $i['icon']; ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal detail-->
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
                                <div class="card-body bg_light">
                                    <div class="d-flex gap-2 pt-0">
                                        <?php foreach (get_icon(null, 'ok') as $k => $ic) : ?>
                                            <div class="d-flex gap-2">
                                                <?= ($k > 0 ? '<span><i class="fa-solid fa-arrow-right-long light_color"></i></span>' : ''); ?><span class="<?= ($i['status'] == $ic['status'] ? 'success_color' : 'light_color'); ?>"><?= $ic['icon']; ?></span>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                    <!-- order -->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="btn_secondary mb-1" style="border-radius: 4px 4px 0px 0px;">
                                                <div>ORDER</div>

                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control" value="Inv. Djana">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0" name="is_inv" type="checkbox" <?= ($i['is_inv'] == 1 ? 'checked' : ''); ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <label style="width: 120px;" class="input-group-text">Tgl. Order</label>
                                                        <input class="form-control" value="<?= ($i['tgl_order'] == 0 ? '-' : date('d/m/Y', $i['tgl_order'])); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span style="width: 120px;" class="input-group-text">Barang</span>
                                                        <input type="text" name="barang" class="form-control" value="<?= $i['barang']; ?>" placeholder="Barang">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <label style="width: 120px;" class="input-group-text">Penerima Order</label>
                                                        <input type="text" class="form-control <?= ($i['penerima_order'] == session('username') ? 'bg_danger' : ''); ?>" value="<?= upper_first($i['penerima_order']); ?>" placeholder="Penerima Order" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <label style="width: 120px;" class="input-group-text">Pj Order</label>
                                                        <input type="text" class="form-control <?= ($i['pj_order'] == session('username') ? 'bg_danger' : ''); ?>" value="<?= upper_first($i['pj_order']); ?>" placeholder="Pj Order" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <label style="width: 120px;" class="input-group-text">Tgl. Deadline</label>
                                                        <input class="form-control" value="<?= ($i['deadline'] == 0 ? '-' : date('d/m/Y', $i['deadline'])); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span style="width: 120px;" class="input-group-text">Pemesan</span>
                                                        <input type="text" name="pemesan" value="<?= $i['pemesan']; ?>" class="form-control" placeholder="Pemesan" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span style="width: 120px;" class="input-group-text">Catatan</span>
                                                        <input type="text" name="catatan_order" value="<?= $i['catatan_order']; ?>" class="form-control" placeholder="Catatan">
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
                                                        <input class="form-control" value="<?= ($i['tgl_dp'] == 0 ? '-' : date('d/m/Y', $i['tgl_dp'])); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span style="width: 120px;" class="input-group-text">Jml. Dp</span>
                                                        <input type="text" name="jml_dp" class="form-control uang" value="<?= rupiah($i['jml_dp']); ?>" placeholder="Jumlah Dp" <?= (session('role') !== 'Root' && session('role') !== 'Admin' ? 'readonly' : ''); ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <label style="width: 120px;" class="input-group-text">Pj Dp</label>
                                                        <input type="text" class="form-control <?= ($i['pj_dp'] == session('username') ? 'bg_danger' : ''); ?>" value="<?= upper_first($i['pj_dp']); ?>" placeholder="Pj Dp" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span style="width: 120px;" class="input-group-text">Catatan</span>
                                                        <input type="text" name="catatan_dp" value="<?= $i['catatan_dp']; ?>" class="form-control" placeholder="Catatan" <?= (session('role') !== 'Root' && session('role') !== 'Admin' ? 'readonly' : ''); ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- lunas -->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class=" mb-1 mb-1" style="border-radius: 4px 4px 0px 0px;">LUNAS</div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <label style="width: 120px;" class="input-group-text">Tgl. Lunas</label>
                                                        <?php if ($i['tgl_lunas'] == 0) : ?>
                                                            <input type="text" class="form-control input_tgl input_tgl_lunas_<?= $i['id']; ?>" data-id="<?= $i['id']; ?>" data-val="<?= $i['tgl_lunas']; ?>" name="tgl_lunas" value="-" readonly>
                                                        <?php else : ?>
                                                            <input type="date" data-date="" class="form-control input_date" style="padding-bottom: 25px;" name="tgl_lunas" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d', $i['tgl_lunas']); ?>" <?= (session('role') !== 'Root' && session('role') !== 'Admin' ? 'readonly' : ''); ?>>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span style="width: 120px;" class="input-group-text">Jml. Lunas</span>
                                                        <input type="text" name="jml_lunas" class="form-control uang" value="<?= rupiah($i['jml_lunas']); ?>" placeholder="Jumlah lunas" <?= (session('role') !== 'Root' && session('role') !== 'Admin' ? 'readonly' : ''); ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <label style="width: 120px;" class="input-group-text">Pj Lunas</label>
                                                        <input type="text" class="form-control <?= ($i['pj_lunas'] == session('username') ? 'bg_danger' : ''); ?>" value="<?= upper_first($i['pj_lunas']); ?>" placeholder="Pj Lunas" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span style="width: 120px;" class="input-group-text">Catatan</span>
                                                        <input type="text" name="catatan_lunas" value="<?= $i['catatan_lunas']; ?>" class="form-control" placeholder="Catatan" <?= (session('role') !== 'Root' && session('role') !== 'Admin' ? 'readonly' : ''); ?>>
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
                                                        <input class="form-control" value="<?= ($i['tgl'] == 0 ? '-' : date('d/m/Y', $i['tgl'])); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span style="width: 120px;" class="input-group-text">Jml. Uang Masuk</span>
                                                        <input type="text" name="jml" class="form-control uang" value="<?= rupiah($i['jml']); ?>" placeholder="Jumlah Uang Masuk" <?= (session('role') !== 'Root' && session('role') !== 'Admin' ? 'readonly' : ''); ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <label style="width: 120px;" class="input-group-text">Penerima</label>
                                                        <input type="text" class="form-control <?= ($i['penerima'] == session('username') ? 'bg_danger' : ''); ?>" value="<?= upper_first($i['penerima']); ?>" placeholder="Penerima Uang" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span style="width: 120px;" class="input-group-text">Catatan</span>
                                                        <input type="text" name="catatan" value="<?= $i['catatan']; ?>" class="form-control" placeholder="Catatan" <?= (session('role') !== 'Root' && session('role') !== 'Admin' ? 'readonly' : ''); ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>

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