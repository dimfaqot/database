<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <div class="input-group input-group-sm mb-3">
        <button data-ekstra="<?= url(5); ?>" type="button" class="btn-sm btn_main modal_cari_db"><i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?></button>
        <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tahun [<?= url(4); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($tahun as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == $i ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i; ?>/<?= url(5); ?>"><?= $i; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <a class="nav-link dropdown-toggle btn_secondary_inactive" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Ekstra [<?= url(5); ?>]
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($ekstra as $i) : ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == $i['singkatan'] ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= $i['singkatan']; ?>"><?= $i['ekstra']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>



    <?php if (count($data) == 0) : ?>
        <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
    <?php else : ?>
        <div class="input-group input-group-sm">
            <span class="input-group-text">Cari <?= menu()['menu']; ?></span>
            <input type="text" class="form-control cari" placeholder="...">
        </div>

        <div class="print_sk_by_check d-none mt-2">
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Check All" href="" class="btn_main_inactive check_all" style="font-style:italic;"><i class="fa-solid fa-list-check"></i> Check All</a>
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download excel" data-order="excel" href="" data-controller="<?= url(); ?>" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-file-excel"></i> Print Excel</a>
            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download pdf" data-order="pdf" href="" data-controller="<?= url(); ?>" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-paste"></i> Print Pdf</a>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Check</th>
                    <th>No. Serifikat</th>
                    <th>No. Id</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody class="tabel_search">
                <?php foreach ($data as $k => $i) : ?>
                    <tr>
                        <th scope="row"><?= ($k + 1); ?></th>
                        <td style="text-align: center;">
                            <input class="form-check-input cetak_check" name="cetak_check" type="checkbox" value="<?= $i['kode']; ?>">
                        </td>
                        <td><?= $i['kode']; ?></td>
                        <td><?= $i['no_id']; ?></td>
                        <td><?= $i['nama']; ?></td>
                        <td contenteditable="" class="update" data-col="kelas" data-db="ekstra" data-tabel="nilai" data-id="<?= str_replace("/", "_", $i['kode']); ?>"><?= $i['kelas']; ?></td>
                        <td><a href="" class="detail" data-id="<?= str_replace("/", "_", $i['kode']); ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen main_color"></i></a> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cetak pdf." data-order="single" href="" data-id="<?= $i['kode']; ?>" data-controller="<?= url(); ?>" class="secondary_dark_color cetak" style="font-size: medium;"><i class="fa-solid fa-file-pdf"></i></a> <a href="" data-method="delete" class="confirm" data-id="<?= str_replace("/", "_", $i['kode']); ?>" data-controller="<?= menu()['controller']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>


    <?php foreach ($data as $i) : ?>
        <!-- Modal update-->
        <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="main_color" style="font-weight: bold;"><i class="<?= menu()['icon']; ?>"></i> Update <?= menu()['menu']; ?></div>
                            <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                        </div>
                        <hr class="dark_color" style="border: 1px solid;">
                        <div class="card">
                            <div class="card-body body_detail">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>



</div>
<?= $this->endSection() ?>