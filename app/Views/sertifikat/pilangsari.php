<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<?php
$asc_icon = '<i class="fa-solid fa-arrow-down-short-wide secondary_dark_color"></i>';
$desc_icon = '<i class="fa-solid fa-arrow-down-wide-short"></i>';

$cetak = ['lunas', 'belum', 'all', 'non'];
$jenis = ['SSJ', 'NONSSJ', 'Kosong'];
?>
<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <?php if (url(8) == 'NONSSJ') : ?>
            <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
                <i class="fa-solid fa-circle-plus"></i> Donatur
            </button>

        <?php endif; ?>
        <button type="button" class="btn-sm btn_secondary_inactive" data-bs-toggle="modal" data-bs-target="#kategori">
            <i class="fa-solid fa-circle-dollar-to-slot"></i> Kategori Donatur
        </button>
        <button type="button" class="btn-sm btn_main_inactive laporan">
            <i class="fa-solid fa-circle-dollar-to-slot"></i> Laporan
        </button>

        <div class="mt-1" style="font-weight: bold;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Jumlah sudah lunas (<?= rupiah($data['lunas']); ?> x Rp 350.000)"><a href="" role="button" data-bs-toggle="modal" data-bs-target="#lunas" class="btn_main_inactive text-success" style="border-radius: 0px;"><?= rupiah($data['lunas'] * 350000); ?></a></div>
        <div class="mt-1" style="font-weight: bold;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Jumlah NONSSJ (<?= rupiah($non_ssj); ?>)"><a href="" role="button" data-bs-toggle="modal" data-bs-target="#non" class="btn_main_inactive text-success" style="border-radius: 0px;"><?= rupiah($non_ssj); ?></a></div>
        <div class="mt-1" style="font-weight: bold;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Jumlah belum lunas (<?= rupiah($data['belum']); ?> x Rp 350.000)"><a href="" role="button" data-bs-toggle="modal" data-bs-target="#belum" class="btn_main_inactive" style="border-radius: 0px;color:#C51605;"><?= rupiah($data['belum'] * 350000); ?></a></div>
        <div class="mt-1" style="font-weight: bold;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Total ((<?= rupiah($data['lunas']); ?> + <?= rupiah($data['belum']); ?>) x Rp 350.000)"><a href="" role="button" data-bs-toggle="modal" data-bs-target="#all" class="btn_main_inactive" style="border-radius: 0px;color:#116A7B;"><?= rupiah(($data['belum'] + $data['lunas']) * 350000); ?></a></div>
    </div>

    <div class="mb-3">
        <?php foreach ($jenis as $i) : ?>
            <a href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= $i; ?>" class="<?= (url(8) == $i ? 'btn_secondary' : 'btn_main_inactive'); ?>"><?= $i; ?></a>
        <?php endforeach; ?>
    </div>

    <!-- modal cetak data -->
    <?php foreach ($cetak as $i) : ?>

        <div class="modal fade" id="<?= $i; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: transparent;border:0px;">
                    <div class="d-flex justify-content-center gap-2">
                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cetak data <?= $i; ?> pdf"><a target="_blank" style="font-size: x-large;" class="btn_main_inactive" href=" <?= base_url(menu()['controller']); ?>/cetak_data/<?= url(8); ?>/<?= url(4); ?>/<?= $i; ?>/pdf"><i class="fa-regular fa-file-pdf"></i></a></div>
                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cetak data <?= $i; ?> excel"><a target="_blank" style="font-size: x-large;" class="btn_main_inactive" href="<?= base_url(menu()['controller']); ?>/cetak_data/<?= url(8); ?>/<?= url(4); ?>/<?= $i; ?>/excel"><i class="fa-regular fa-file-excel"></i></a></div>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>



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
                                <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>">
                                <input type="hidden" name="kategori" value="<?= upper_first(str_replace("_", " ", url(4))); ?>">
                                <input type="hidden" name="jenis" value="<?= url(8); ?>">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="pj" placeholder="Pj" required>
                                    <label>Pj</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Donatur" required>
                                    <label>Nama Donatur</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                                    <label>Alamat</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control uang" name="jml_uang" placeholder="Jumlah Uang" required>
                                    <label>Jumlah Uang</label>
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
    <!-- Modal laporan-->
    <div class="modal fade" id="laporan" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?></div>
                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                    </div>
                    <hr class="dark_color" style="border: 1px solid;">
                    <div class="card">
                        <div class="card-body body_laporan">


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal kategori-->
    <div class="modal fade" id="kategori" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-calendar"></i> Kategori</div>
                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                    </div>
                    <hr class="dark_color" style="border: 1px solid;">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>
                                <tbody class="tabel_search">
                                    <tr>
                                        <th scope="row">Add</th>
                                        <td contenteditable="" class="add" data-db="" data-tabel="options" data-key="Pilangsari" data-col="value"></td>
                                    </tr>
                                    <?php foreach (options('Pilangsari') as $k => $i) : ?>
                                        <tr>
                                            <th scope="row"><?= ($k + 1); ?></th>
                                            <td contenteditable="" class="update" data-col="value" data-tabel="options" data-id="<?= $i['id']; ?>" data-db="" data-tabel="options"><?= $i['value']; ?></td>
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



    <?php if (count($data['data']) == 0) : ?>
        <div class="btn_main_inactive" style="margin-top: -4px;">
            <?php foreach (options('Pilangsari') as $i) : ?>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasar kategori <?= $i['value']; ?>." href="<?= base_url(url()); ?>/<?= upper_first(str_replace(" ", "_", $i['value'])); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>"><span class="badge <?= (url(4) == upper_first(str_replace(" ", "_", $i['value'])) ? 'text-bg-success' : 'text-bg-light'); ?>"><?= $i['value']; ?></span></a>
            <?php endforeach; ?>
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tampilkan semua jenis." href="<?= base_url(url()); ?>/All/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>"><span class="badge <?= (url(4) == 'All' ? 'text-bg-success' : 'text-bg-light'); ?>">All</span></a>
        </div>
        <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
    <?php else : ?>
        <div class="d-flex justify-content-between gap-1 my-2">

            <div class="btn_main_inactive" style="margin-top: -4px;">
                <?php foreach (options('Pilangsari') as $i) : ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasar kategori <?= $i['value']; ?>." href="<?= base_url(url()); ?>/<?= upper_first(str_replace(" ", "_", $i['value'])); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>"><span class="badge <?= (url(4) == upper_first(str_replace(" ", "_", $i['value'])) ? 'text-bg-success' : 'text-bg-light'); ?>"><?= $i['value']; ?></span></a>
                <?php endforeach; ?>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tampilkan semua jenis." href="<?= base_url(url()); ?>/All/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>"><span class="badge <?= (url(4) == 'All' ? 'text-bg-success' : 'text-bg-light'); ?>">All</span></a>
            </div>
        </div>

        <div class="d-flex gap-1 my-2">
            <div class="flex-grow-1">
                <div class="input-group input-group-sm">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." class="input-group-text">Cari <?= menu()['menu']; ?></span>
                    <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." type="text" class="form-control cari" placeholder="...">
                </div>
            </div>
            <div>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tampilkan semua data berdasar filter." href="<?= base_url(url()); ?>/<?= url(4); ?>/<?= (url(5) == 'All' ? 1 : 'All'); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>" type="button" class="btn-sm <?= (url(5) == 'All' ? 'btn_main' : 'btn_main_inactive'); ?>"><i class="fa-solid fa-eye"></i> Show All</a>
            </div>

        </div>
        <div class="d-flex justify-content-between gap-1 my-2">
            <div class="print_sk_by_check d-none">
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Check All" href="" class="btn_main_inactive check_all" style="font-style:italic;"><i class="fa-solid fa-list-check"></i> Check All</a>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download excel" data-order="excel" href="" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-file-excel"></i> Print Excel</a>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download pdf" data-order="pdf" href="" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-paste"></i> Print Pdf</a>
            </div>
            <div>
                <small data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Total data dari total data." class="dark_color"><?= $data['data_ditampilkan']; ?> from <?= $data['total_data']; ?></small>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Check</th>
                    <th>Kategori</th>
                    <?php if (url(8) !== 'NONSSJ') : ?>
                        <th>No <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar nomor" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/no/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(8); ?>"><?= (url(6) == 'no' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <?php endif; ?>
                    <th>Pj <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar pj" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/pj/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(8); ?>"><?= (url(6) == 'pj' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <th>Nama <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar nama" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/nama/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(8); ?>"><?= (url(6) == 'nama' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <th>Alamat <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar alamat" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/alamat/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(8); ?>"><?= (url(6) == 'alamat' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <?php if (url(8) == 'NONSSJ') : ?>
                        <th>Jml. Uang <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan jumlah uang" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/jml_uang/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(8); ?>"><?= (url(6) == 'jml_uang' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <?php else : ?>
                        <th>Ket <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar keterangan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/ket/<?= (url(7) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(8); ?>"><?= (url(6) == 'ket' && url(7) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <?php endif; ?>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data['data'] as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td style="text-align: center;">
                            <input class="form-check-input cetak_check" name="cetak_check" type="checkbox" value="<?= $i['no']; ?>">
                        </td>
                        <td>
                            <select class="form-select form-select-sm update_kategori" data-id="<?= $i['no']; ?>" style="font-size: small;">
                                <option style="font-size: small;" value="">Pilih Kategori</option>
                                <?php foreach (options('Pilangsari') as $k) : ?>
                                    <option style="font-size: small;" <?= (strtolower($i['kategori']) == strtolower($k['value']) ? 'selected' : ''); ?> value="<?= $k['value']; ?>"><?= $k['value']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <?php if (url(8) !== 'NONSSJ') : ?>
                            <td><?= $i['no']; ?></td>
                        <?php endif; ?>
                        <td contenteditable="" class="update" data-col="pj" data-id="<?= $i['no']; ?>" data-tabel="pilangsari" data-db="sertifikat"><?= $i['pj']; ?></td>
                        <td contenteditable="" class="update" data-col="nama" data-id="<?= $i['no']; ?>" data-tabel="pilangsari" data-db="sertifikat"><?= $i['nama']; ?></td>
                        <td contenteditable="" class="update" data-col="alamat" data-id="<?= $i['no']; ?>" data-tabel="pilangsari" data-db="sertifikat"><?= $i['alamat']; ?></td>

                        <?php if (url(8) == 'NONSSJ') : ?>
                            <td contenteditable="" class="update uang" data-col="jml_uang" data-id="<?= $i['no']; ?>" data-tabel="pilangsari" data-db="sertifikat"><?= rupiah($i['jml_uang']); ?></td>
                        <?php else : ?>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input update_pilangsari" data-id="<?= $i['no']; ?>" type="checkbox" role="switch" <?= ($i['ket'] == 1 ? 'checked' : ''); ?>>
                                    <label class="form-check-label label_ket_<?= $i['no']; ?>"><?= ($i['ket'] == 1 ? 'Lunas' : 'Belum'); ?></label>
                                </div>
                            </td>
                        <?php endif; ?>
                        <td><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Data"><a href="" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>_<?= $i['no']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen main_color"></i></a></span> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download Pdf" href="" data-order="single" href="" data-id="<?= $i['no']; ?>" class="cetak" style="font-size: medium;"><i class="fa-regular fa-file-pdf"></i></a> <?= ($i['jenis'] == 'NONSSJ' ? '<a href="" class="confirm" data-id="' . $i['no'] . '" data-order="hapus" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a>' : ''); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-grid text-center">
            <?php if (url(5) == 'All') : ?>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Kurangi data yang ditampilkan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/1/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>" class="btn_main_inactive" style="font-style:italic;">Load less <i class="fa-solid fa-angles-up"></i></a>

            <?php else : ?>
                <?php if ($data['data_ditampilkan'] < $data['total_data']) : ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Perbanyak data yang ditampilkan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5) + 1; ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>" class=" btn_main" style="font-style:italic;">Load more <i class="fa-solid fa-angles-down"></i></a>
                <?php else : ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Kurangi data yang ditampilkan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5) - 1; ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>" class="btn_main_inactive" style="font-style:italic;">Load less <i class="fa-solid fa-angles-up"></i></a>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>





</div>
<?= $this->endSection() ?>