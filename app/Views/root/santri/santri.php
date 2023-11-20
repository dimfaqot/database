<?= $this->extend('logged') ?>

<?= $this->section('content') ?>
<?php
$asc_icon = '<i class="fa-solid fa-arrow-down-short-wide secondary_dark_color"></i>';
$desc_icon = '<i class="fa-solid fa-arrow-down-wide-short"></i>';
$filter_by = ['Existing', 'Deleted', 'All'];
$gender = ['L', 'P', 'All'];
?>

<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tambah data baru." class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
        </button>
        <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter data berdasar data yang eksis atau sudah dihapus." class="form-select filter_by">
            <?php foreach ($filter_by as $i) : ?>
                <option <?= ($i == url(5) ? 'selected' : ''); ?> value="<?= $i; ?>"><?= $i; ?></option>
            <?php endforeach; ?>
        </select>
        <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasarkan tahun masuk" class="form-select filter_by_tahun">
            <?php foreach (tahun_group(menu()['tabel'], 'masuk') as $i) : ?>
                <option <?= ($i['tahun_masuk'] == url(4) ? 'selected' : ''); ?> value="<?= $i['tahun_masuk']; ?>"><?= $i['tahun_masuk']; ?></option>
            <?php endforeach; ?>
            <option <?= (url(4) == 'All' ? 'selected' : ''); ?> value="All">All</option>
        </select>
        <select data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasarkan status <?= menu()['controller']; ?>." class="form-select filter_by_status">
            <?php foreach (options('Status') as $i) : ?>
                <option <?= ($i['value'] == url(10) ? 'selected' : ''); ?> value="<?= $i['value']; ?>"><?= $i['value']; ?></option>
            <?php endforeach; ?>
            <option <?= (url(10) == 'All' ? 'selected' : ''); ?> value="All">All</option>
        </select>
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
                            <form action="<?= base_url(menu()['controller']); ?>/add" method="post">
                                <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7) ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>">
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control check_tahun_masuk" name="tahun_masuk" value="<?= tahun_santri('santri'); ?>" placeholder="Tahun Masuk">
                                    <label>Tahun Masuk</label>
                                    <div class="body_feedback_tahun_masuk invalid-feedback"></div>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control check_nama" placeholder="Nama" name="nama" required>
                                    <label>Nama</label>
                                    <div class="body_feedback_nama invalid-feedback"></div>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control check_hp_ayah" name="hp_ayah" placeholder="No. Hp Ayah" required>
                                    <label>No. Hp Ayah</label>
                                    <div class="body_feedback_hp_ayah invalid-feedback"></div>
                                </div>
                                <div class="form-floating mb-2">
                                    <select style="font-size: small;" class="form-select check_gender" name="gender" required>
                                        <option value="">Click to gender</option>
                                        <option value="L">L</option>
                                        <option value="P">P</option>
                                    </select>
                                    <label>Pilih Gender</label>
                                    <div class="body_feedback_gender invalid-feedback"></div>
                                </div>
                                <div class="form-floating mb-2">
                                    <select style="font-size: small;" class="form-select check_sub" name="sub" required>
                                        <option value="">Click to select sub</option>
                                        <?php foreach (sub() as $i) : ?>
                                            <?php if ($i['singkatan'] == 'SMP' || $i['singkatan'] == 'SMA') : ?>
                                                <option value="<?= $i['singkatan']; ?>"><?= $i['singkatan']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Pilih Sub</label>
                                    <div class="body_feedback_sub invalid-feedback"></div>
                                </div>
                                <div class="form-floating mb-2">
                                    <select style="font-size: small;" class="form-select check_pondok" name="pondok" required>
                                        <option value="">Click to select pondok</option>
                                        <?php foreach (options('Pondok') as $i) : ?>
                                            <option <?= ($i['value'] == 'Induk' ? 'selected' : ''); ?> value="<?= $i['value']; ?>"><?= $i['value']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Pilih Pondok</label>
                                    <div class="body_feedback_pondok invalid-feedback"></div>
                                </div>

                                <div class="d-grid mt-3">
                                    <button type="button" class="btn-sm new_active btn_main btn_check"><i class="fa-regular fa-floppy-disk"></i> Save</button>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
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
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tampilkan semua data berdasar filter." href="<?= base_url(url()); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= (url(6) == 'All' ? 1 : 'All'); ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>" type="button" class="btn-sm <?= (url(6) == 'All' ? 'btn_main' : 'btn_main_inactive'); ?>"><i class="fa-solid fa-eye"></i> Show All</a>
        </div>

    </div>

    <div class="d-none d-md-block mt-2">
        <div class="d-flex gap-1 mb-2">
            <?php foreach (sub() as $i) : ?>
                <?php if ($i['singkatan'] == 'KB' || $i['singkatan'] == 'TK' || $i['singkatan'] == 'SDI' || $i['singkatan'] == 'SMP' || $i['singkatan'] == 'SMA') : ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasar sub <?= $i['singkatan']; ?>." href="<?= base_url(url()); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= $i['singkatan']; ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>" class="<?= (strtolower(url(7)) == strtolower($i['singkatan']) ? 'btn_secondary' : 'btn_main_inactive'); ?>">
                        <i class="fa-solid fa-sitemap"></i> <?= $i['singkatan']; ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tampilkan semua sub." href="<?= base_url(url()); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/All/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>" class="<?= (url(7) == 'All' ? 'btn_secondary' : 'btn_main_inactive'); ?>">
                <i class="fa-solid fa-sitemap"></i> All
            </a>
        </div>
    </div>

    <!-- sub menu sm -->
    <div class="d-block d-md-none d-sm-block mt-2">
        <button class="btn-sm btn_main_inactive" type="button" data-bs-toggle="offcanvas" data-bs-target="#sub_menu" aria-controls="sub_menu"><i class="fa-solid fa-bars"></i> Filter</button>
    </div>

    <!-- off canvas sub menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sub_menu" aria-labelledby="sub_menuLabel" style="width: 70%;">
        <div class="offcanvas-header shadow shadow-sm">
            <h6 class="offcanvas-title main_color" id="sub_menuLabel">Filter Sub</h6>
            <button type="button" class="btn-close main_color" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body px-1">
            <div class="list-group">
                <?php foreach (sub() as $i) : ?>
                    <a href="<?= base_url(url()); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= $i['singkatan']; ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>" type="button" class="<?= (url(6) == $i['singkatan'] ? 'btn_secondary' : 'btn_main_inactive'); ?> mb-1 sub_menu" data-sub_menu="<?= $i['singkatan']; ?>" style="border-radius: 3px; text-align:left;"><i class="fa-solid fa-sitemap"></i> <?= $i['singkatan']; ?></a>
                <?php endforeach; ?>
                <a href="<?= base_url(url()); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/All/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>" class="<?= (url(6) == 'All' ? 'btn_secondary' : 'btn_main_inactive'); ?>">
                    <i class="fa-solid fa-sitemap"></i> All
                </a>
            </div>
        </div>
    </div>

    <?php if (count($data['data']) == 0) : ?>
        <div class="d-flex justify-content-between mb-2">
            <div class="d-flex gap-1">
                <div class="btn_main_inactive">
                    <?php foreach ($gender as $i) : ?>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasar gender(<?= $i; ?>)." href="<?= base_url(url()); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= $i; ?>"><span class="badge <?= (url(11) == $i ? 'text-bg-success' : 'text-bg-light'); ?>"><?= $i; ?></span></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
    <?php else : ?>
        <div class="d-flex justify-content-between mb-2">
            <div>
                <small data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Total data dari total data." class="dark_color"><?= $data['data_ditampilkan']; ?> from <?= $data['total_data']; ?></small>
            </div>
            <div class="d-flex gap-1">
                <div class="btn_main_inactive">
                    <?php foreach ($gender as $i) : ?>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter berdasar gender(<?= $i; ?>)." href="<?= base_url(url()); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= $i; ?>"><span class="badge <?= (url(11) == $i ? 'text-bg-success' : 'text-bg-light'); ?>"><?= $i; ?></span></a>
                    <?php endforeach; ?>
                </div>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download excel" target="_blank" href="<?= base_url(menu()['controller']); ?>/cetak/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>/excel" class="btn_main_inactive" style="font-style:italic;"><i class="fa-solid fa-file-excel"></i> Print Excel</a>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download pdf" target="_blank" href="<?= base_url(menu()['controller']); ?>/cetak/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>/pdf" class="btn_main_inactive" style="font-style:italic;"><i class="fa-solid fa-paste"></i> Print Pdf</a>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <th scope="col">#</th>
                <th>No. Id <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar no. id" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/no_id/<?= (url(9) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(10); ?>/<?= url(11); ?>"><?= (url(8) == 'no_id' && url(9) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                <th>Nama <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar nama" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/nama/<?= (url(9) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(10); ?>/<?= url(11); ?>"><?= (url(8) == 'nama' && url(9) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>

                <!-- <th>Hp Ayah <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar hp_ayah" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/hp_ayah/<?= (url(9) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(10); ?>/<?= url(11); ?>"><?= (url(8) == 'hp_ayah' && url(9) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                <th>Umur <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar umur" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/umur/<?= (url(9) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(10); ?>/<?= url(11); ?>"><?= (url(8) == 'umur' && url(9) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th> -->

                <th>Sub <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar sub" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/sub/<?= (url(9) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(10); ?>/<?= url(11); ?>"><?= (url(8) == 'sub' && url(9) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                <th>Pondok <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar pondok" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/pondok/<?= (url(9) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(10); ?>/<?= url(11); ?>"><?= (url(8) == 'pondok' && url(9) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>

                <th>Masa Belajar <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan masa belajar" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/pengabdian/<?= (url(9) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(10); ?>/<?= url(11); ?>"><?= (url(8) == 'pengabdian' && url(9) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                <th>Status <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar status" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/status/<?= (url(9) == 'ASC' ? 'DESC' : 'ASC'); ?>/<?= url(10); ?>/<?= url(11); ?>"><?= (url(8) == 'status' && url(9) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                <th>Act</th>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data['data'] as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= $i['no_id']; ?></td>
                        <td><?= $i['nama']; ?></td>
                        <!-- <td><?= ($i['hp_ayah'] == '' || strlen($i['hp_ayah']) < 11 ? '-' : '<a class="btn_main send_wa" data-col="hp_ayah" data-order-id="' . $i['no_id'] . '" data-sapaan="Ayahanda" data-nama="' . $i['nama'] . '" data-no="+62' . substr($i['hp_ayah'], 1) . '" style="font-size:10px;" href=""><i class="fa-brands fa-whatsapp"></i> ' . $i['hp_ayah'] . '</a>'); ?></td>
                        <td><?= $i['umur']; ?></td> -->

                        <td>
                            <select class="form-select form-select-sm change_status" data-id="<?= $i['no_id']; ?>" data-col="sub" data-tabel="<?= menu()['tabel']; ?>">
                                <?php foreach (sub() as $s) : ?>
                                    <option <?= ($i['sub'] == $s['singkatan'] ? 'selected' : ''); ?> value="<?= $s['singkatan']; ?>"><?= $s['singkatan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-select form-select-sm change_status" data-id="<?= $i['no_id']; ?>" data-col="pondok" data-tabel="<?= menu()['tabel']; ?>">
                                <?php foreach (options('Pondok') as $s) : ?>
                                    <option <?= ($i['pondok'] == $s['value'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?= $i['pengabdian']; ?></td>
                        <td>
                            <select class="form-select form-select-sm change_status" data-id="<?= $i['no_id']; ?>" data-col="status" data-tabel="<?= menu()['tabel']; ?>">
                                <?php foreach (options('Status') as $s) : ?>
                                    <option <?= ($i['status'] == $s['value'] ? 'selected' : ''); ?> value="<?= $s['value']; ?>"><?= $s['value']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <span class="btn_main_inactive"><a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit data." class="main_color" href="<?= base_url() . url(3); ?>/detail/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>/<?= $i['no_id']; ?>/Profile" style="font-size: medium;"><i class="fa-solid fa-square-pen"></i></a> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cetak pdf." style="font-size: 14px;" target="_blank" href="<?= base_url(menu()['controller']); ?>/cetak/single/<?= $i['no_id']; ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>/pdf" class="dark_color"><i class="fa-solid fa-file-pdf"></i></a> <?= ($i['deleted'] == 0 ? '<a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove data ini." href="" class="confirm" data-order="remove" data-method="remove" data-id="' . $i['no_id'] . '" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a>' : '<a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restore data ini." href="" class="confirm secondary_dark_color" data-order="restore" data-method="restore" data-id="' . $i['no_id'] . '" style="font-size: medium;"><i class="fa-solid fa-rotate-left"></i></a> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete permanen data ini." href="" class="confirm text-danger" data-order="delete" data-method="delete" data-id="' . $i['no_id'] . '" style="font-size: medium;"><i class="fa-solid fa-trash"></i></a>'); ?></span>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-grid text-center">
            <?php if (url(6) == 'All') : ?>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Kurangi data yang ditampilkan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/1/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>" class="btn_main_inactive" style="font-style:italic;">Load less <i class="fa-solid fa-angles-up"></i></a>

            <?php else : ?>
                <?php if ($data['data_ditampilkan'] < $data['total_data']) : ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Perbanyak data yang ditampilkan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) + 1; ?>/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>" class=" btn_main" style="font-style:italic;">Load more <i class="fa-solid fa-angles-down"></i></a>
                <?php else : ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Kurangi data yang ditampilkan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/1/<?= url(7); ?>/<?= url(8); ?>/<?= url(9); ?>/<?= url(10); ?>/<?= url(11); ?>" class="btn_main_inactive" style="font-style:italic;">Load less <i class="fa-solid fa-angles-up"></i></a>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>