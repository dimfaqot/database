<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<?php
$asc_icon = '<i class="fa-solid fa-arrow-down-short-wide secondary_dark_color"></i>';
$desc_icon = '<i class="fa-solid fa-arrow-down-wide-short"></i>';

?>
<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
            <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
        </button>

        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Label [<?= url(5); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($label as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == $i['label'] ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/label/<?= $i['label']; ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>"><?= $i['label']; ?></a></li>
            <?php endforeach; ?>
            <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/label/All/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>">All</a></li>
        </ul>
    </div>

    <div class="modal fade" id="artikel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 main_color" id="staticBackdropLabel"><i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url(); ?><?= menu()['controller']; ?>/add" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="url" value="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>">
                        <div class="form-floating mb-2">
                            <select style="font-size: small;" class="form-select" name="label" required>
                                <?php foreach ($label as $i) : ?>
                                    <option <?= ($i['label'] == url(5) ? 'selected' : ''); ?> value="<?= $i['label']; ?>"><?= $i['label']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label>Pilih Label</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="judul" placeholder="Judul" required>
                            <label>Judul</label>
                        </div>

                        <div class="card-body mb-2">
                            <label class="form-label">Artikel</label>
                            <textarea name="artikel" class="form-control form-control-sm" id="ck_artikel" rows="10"></textarea>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Gambar</label>
                            <input class="form-control form-control-sm" name="gambar" type="file" required>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn-sm btn_main"><i class="fa-regular fa-floppy-disk"></i> Save</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php if (count($data['data']) == 0) : ?>
        <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
    <?php else : ?>

        <div class="input-group input-group-sm">
            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." class="input-group-text">Cari <?= menu()['menu']; ?></span>
            <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." type="text" class="form-control cari" placeholder="...">
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Tgl <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar tanggal" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/tgl/<?= (url(8) == 'ASC' ? 'DESC' : 'ASC'); ?>"><?= (url(7) == 'tgl' && url(8) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <th>Label <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar label" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/label/<?= (url(8) == 'ASC' ? 'DESC' : 'ASC'); ?>"><?= (url(7) == 'label' && url(8) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <th>Judul <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar judul" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/judul/<?= (url(8) == 'ASC' ? 'DESC' : 'ASC'); ?>"><?= (url(7) == 'judul' && url(8) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <th>Penulis <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Urutkan berdasar penulis" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/penulis/<?= (url(8) == 'ASC' ? 'DESC' : 'ASC'); ?>"><?= (url(7) == 'penulis' && url(8) == 'DESC' ? $desc_icon : $asc_icon); ?></a></th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data['data'] as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td><?= date('d/m/Y', $i['tgl']); ?></td>
                        <td><?= $i['label']; ?></td>
                        <td><?= $i['judul']; ?></td>
                        <td><?= $i['penulis']; ?></td>
                        <td><a href="<?= base_url(menu()['controller']); ?>/penulis/<?= $i['username']; ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>"></a></td>
                        <td><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Data"><a href="" data-bs-toggle="modal" data-bs-target="#update_<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen main_color"></i></a></span> <a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lihat hasil" href="<?= base_url(); ?>public/news/single/<?= $i['slug']; ?>" style="font-size: medium;"><i class="fa-regular fa-eye"></i></a> <a href="" class="confirm" data-id="<?= $i['id']; ?>" data-order="hapus" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-grid text-center">
            <?php if (url(6) == 'All') : ?>
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Kurangi data yang ditampilkan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/1/<?= url(7); ?>/<?= url(8); ?>" class="btn_main_inactive" style="font-style:italic;">Load less <i class="fa-solid fa-angles-up"></i></a>

            <?php else : ?>
                <?php if ($data['data_ditampilkan'] < $data['total_data']) : ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Perbanyak data yang ditampilkan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) + 1; ?>/<?= url(7); ?>/<?= url(8); ?>" class=" btn_main" style="font-style:italic;">Load more <i class="fa-solid fa-angles-down"></i></a>
                <?php else : ?>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Kurangi data yang ditampilkan" href="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6) - 1; ?>/<?= url(7); ?>/<?= url(8); ?>" class="btn_main_inactive" style="font-style:italic;">Load less <i class="fa-solid fa-angles-up"></i></a>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php $ids = []; ?>
    <?php foreach ($data['data'] as $k => $i) : ?>
        <?php $ids[] = $i['id']; ?>
        <div class="modal fade" id="update_<?= $i['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 main_color" id="staticBackdropLabel"><i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url(); ?><?= menu()['controller']; ?>/update" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="url" value="<?= base_url() . url(3); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>">
                            <input type="hidden" name="id" value="<?= $i['id']; ?>">
                            <div class="form-floating mb-2">
                                <select style="font-size: small;" class="form-select" name="label" required>
                                    <?php foreach ($label as $l) : ?>
                                        <option <?= ($l['label'] == $i['label'] ? 'selected' : ''); ?> value="<?= $l['label']; ?>"><?= $l['label']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label>Pilih Label</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" value="<?= $i['judul']; ?>" name="judul" placeholder="Judul" required>
                                <label>Judul</label>
                            </div>

                            <div class="card-body mb-2">
                                <label class="form-label">Artikel</label>
                                <textarea name="artikel" class="form-control form-control-sm" id="ck_<?= $i['id']; ?>" rows="10"><?= $i['artikel']; ?></textarea>
                            </div>

                            <div class="mb-2">
                                <h2 class="form-label btn_main_inactive" style="border-radius: 0px;text-align:center;">Gambar</h2>
                                <img class="img-fluid mb-1" src="<?= base_url(); ?>berkas/news/<?= $i['img']; ?>" alt="GAMBAR">
                                <input class="form-control form-control-sm" name="gambar" type="file">
                            </div>

                            <div class="d-grid mt-3">
                                <button type="submit" class="btn-sm btn_main"><i class="fa-regular fa-floppy-disk"></i> Save</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>


    <input type="hidden" class="ids" value="<?= implode(",", $ids); ?>">

</div>
<?= $this->endSection() ?>