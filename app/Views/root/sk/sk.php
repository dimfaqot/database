<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<?php
$asc_icon = '<i class="fa-solid fa-arrow-down-short-wide secondary_dark_color"></i>';
$desc_icon = '<i class="fa-solid fa-arrow-down-wide-short"></i>';
$filter_by = ['Existing', 'Deleted', 'All'];
$gender = ['L', 'P', 'All'];


?>


<div class="container" style="margin-top: 60px;">
    <button type="button" data-col="nama" data-tabel_api="karyawan" class="btn-sm btn_main modal_cari_db"><i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?></button>

    <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#tahun">
        <i class="fa-solid fa-calendar"></i> Tahun
    </button>

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
                            <button class="btn-sm btn_main mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#tambah_tahun" aria-expanded="false" aria-controls="tambah_tahun">
                                <i class="fa-solid fa-calendar"></i> Tambah Tahun
                            </button>
                            <div class="collapse" id="tambah_tahun">
                                <div class="card card-body">
                                    <form action="<?= base_url(); ?>tahun/add" method="post">
                                        <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>">
                                        <div class="form-floating mb-2">
                                            <input type="number" class="form-control" name="tahun" value="<?= date('Y'); ?>" placeholder="Tahun" required>
                                            <label>Tahun</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="rapat" placeholder="Tanggal Rapat" required>
                                            <label>Tanggal Rapat</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="penetapan" placeholder="Tanggal Penetapan" required>
                                            <label>Tanggal Penetapan</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="ketua_ypp" placeholder="Ketua Yayasan" required>
                                            <label>Ketua Yayasan</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control kop add_kop" data-order="add" name="kop" placeholder="Kop" required readonly>
                                            <label>Kop</label>
                                        </div>
                                        <div class="modal-body position-absolute top-50 start-50 translate-middle body_kop_add body_kop" style="z-index: 999;">

                                        </div>
                                        <div class="d-grid mt-3">
                                            <button type="submit" class="btn-sm btn_main"><i class="fa-regular fa-floppy-disk"></i> Save</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th>Tahun</th>
                                        <th>Rapat</th>
                                        <th>Penetapan</th>
                                        <th>Ketua Yayasan</th>
                                        <th>kop</th>
                                        <th>Act</th>
                                    </tr>
                                </thead>
                                <tbody class="tabel_search">
                                    <?php foreach ($tahun as $k => $i) : ?>
                                        <tr>
                                            <th scope="row"><?= ($k + 1); ?></th>
                                            <td contenteditable class="update_tahun_tahun_<?= $i['tahun']; ?>"><?= $i['tahun']; ?></td>
                                            <td contenteditable class="update_tahun_rapat_<?= $i['tahun']; ?>"><?= $i['rapat']; ?></td>
                                            <td contenteditable class="update_tahun_penetapan_<?= $i['tahun']; ?>"><?= $i['penetapan']; ?></td>
                                            <td contenteditable class="update_tahun_ketua_ypp_<?= $i['tahun']; ?>"><?= $i['ketua_ypp']; ?></td>
                                            <td class="update_tahun_kop_<?= $i['tahun']; ?>">
                                                <a data-order="tahun" data-id="<?= $i['tahun']; ?>" class="kop" href=""><?= $i['kop']; ?></a>
                                                <div class="modal-body position-absolute top-50 start-50 translate-middle body_kop_tahun_<?= $i['tahun']; ?> body_kop" style="z-index: 999;">

                                                </div>
                                            </td>
                                            <td><a href="" class="main_color update_tahun" data-id="<?= $i['tahun']; ?>" style="font-size: medium;"><i class="fa-solid fa-floppy-disk"></i> <a href="" class="confirm" data-id="<?= $i['tahun']; ?>" data-controller="tahun" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></i></a></td>
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


    <div class="d-flex gap-1 my-2">
        <div class="flex-grow-1">
            <div class="input-group input-group-sm">
                <span class="input-group-text">Cari <?= menu()['menu']; ?></span>
                <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." type="text" class="form-control cari" placeholder="...">
            </div>
        </div>
        <div>
            <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasarkan sub." class="form-select form-select-sm filter_by_sub" data-controller="<?= menu()['controller']; ?>">
                <?php foreach ($subs as $i) : ?>
                    <option <?= ($i['sub'] == str_replace("_", " ", url(4)) ? 'selected' : ''); ?> value="<?= str_replace(" ", "_", $i['sub']); ?>"><?= $i['sub']; ?></option>
                <?php endforeach; ?>
                <option <?= (url(4) == 'All' ? 'selected' : ''); ?> value="All">All</option>
            </select>
        </div>
        <div>
            <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasarkan tahun." class="form-select form-select-sm filter_by_tahun" data-controller="<?= menu()['controller']; ?>">
                <?php foreach ($tahuns as $i) : ?>
                    <option <?= ($i['tahun'] == url(5) ? 'selected' : ''); ?> value="<?= $i['tahun']; ?>"><?= $i['tahun']; ?></option>
                <?php endforeach; ?>
                <option <?= (url(5) == 'All' ? 'selected' : ''); ?> value="All">All</option>
            </select>
        </div>

    </div>

    <div class="d-flex gap-1 mt-2">
        <div class="print_sk_by_check d-none">
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Check All" href="" class="btn_main_inactive check_all" style="font-style:italic;"><i class="fa-solid fa-list-check"></i> Check All</a>
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download excel" data-order="excel" href="" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-file-excel"></i> Print Excel</a>
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download pdf" data-order="pdf" href="" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-paste"></i> Print Pdf</a>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input ttd" type="checkbox" role="switch" checked>
            <label class="form-check-label">Ttd</label>
        </div>
    </div>
    <table class="table table-striped table-hover">
        <thead>
            <th scope="col">#</th>
            <th data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pilih data untuk dicetak.">Check</th>
            <th>Tahun <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar tahun" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/tahun/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>"><?= (url(6) == 'tahun' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
            <th>No. Sk <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar no sk" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/no_sk/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>"><?= (url(6) == 'no_sk' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
            <th>Nama <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar nama" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/nama/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>"><?= (url(6) == 'nama' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
            <th>Niy <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar niy" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/no_id/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>"><?= (url(6) == 'no_id' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
            <th>Sub <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan sub" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/sub/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>"><?= (url(6) == 'sub' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
            <th>Act</th>
        </thead>
        <tbody class="tabel_search">
            <?php foreach ($data as $k => $i) : ?>
                <tr>
                    <th scope="row"><?= ($k + 1); ?></th>
                    <td style="text-align: center;">
                        <input class="form-check-input cetak_check" name="cetak_check" type="checkbox" value="<?= $i['id']; ?>">
                    </td>
                    <td><?= $i['tahun']; ?></td>
                    <td class="check_no_sk has-details" data-order="tabel" data-id="<?= $i['id']; ?>" contenteditable="true"><span class="details d-none alert_<?= $i['id']; ?>">
                            <div class="text-danger body_alert_no_sk_<?= $i['id']; ?>"><i class="fa-solid fa-triangle-exclamation"></i> Checking No. SK</div>
                        </span>
                        <div class="update_no_sk_<?= $i['id']; ?>"><?= $i['no_sk']; ?></div>
                    </td>
                    <td><?= $i['nama']; ?></td>
                    <td><?= $i['no_id']; ?></td>
                    <td><?= $i['sub']; ?></td>
                    <td>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit data." class="main_color" href="<?= base_url(menu()['controller']); ?>/dtl/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen"></i></a> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy data." data-id="<?= $i['id']; ?>" href="" class="dark_color copy_sk" style="font-size: medium;"><i class="fa-solid fa-copy"></i></a> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cetak pdf." data-order="single" href="" data-id="<?= $i['id']; ?>" class="secondary_dark_color cetak" style="font-size: medium;"><i class="fa-solid fa-file-pdf"></i></a> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete permanen data ini." href="" class="confirm text-danger" data-order="delete" data-method="delete" data-id="<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>