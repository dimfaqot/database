<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container pt-2" style="margin-bottom:100px;margin-top:10px;">
    <?php if ($pemilih['voted'] == 3) : ?>
        <div class="btn_main" style="border-radius:0px;position:fixed;z-index:999; top:0;bottom:0px;left:0px;right:0px;">
            <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
                <img class="mb-2" width="70px;" src="<?= base_url(); ?>berkas/menu/pemilu.png" alt="Logo">
                <p>The ballot is stronger than the bullet. ― Abraham Lincoln</p>
                <?php if (session('role') == 'Member') : ?>
                    <span class="btn_secondary" style="font-size:large;"><i class="fa-brands fa-golang"></i> Thank You</span>
                <?php else : ?>
                    <a href="<?= base_url(); ?>pemilu" class="btn_secondary" style="font-size:large;"><i class="fa-brands fa-golang"></i> Get Started</a>

                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">
            <h6 class="btn_main p-2" style="font-style: italic;"><i class="fa-solid fa-fingerprint"></i> <?= $pemilih['no_id']; ?> <i class="fa-solid fa-person-booth"></i> <?= $pemilih['nama']; ?> <?= ($pemilih['kategori'] !== 'Santri' ? ' <i class="fa-solid fa-school"></i> ' . $pemilih['sub'] : ''); ?></h6>
            <h6 style="font-style: italic;font-size:smaller;"><i class="fa-solid fa-circle-info text-danger"></i> Klik pada gambar untuk memilih!.</h6>
            <?php foreach ($partai as  $i) : ?>

                <div class="card mb-3">
                    <div class="new_active" style="border-radius: 2px;">
                        <h4 style="text-align: center;padding:5px;"><?= strtoupper($i['pondok']); ?></h4>
                    </div>
                    <div class="card-body px-0 py-2">
                        <div class="container px-4 text-center">
                            <div class="row g-3 text-center">
                                <?php if (count($i['data']) == 0) : ?>
                                    <h6 class="btn_main_secondary" style="font-size: small;"><i class="fa-brands fa-golang"></i> Anda sudah memilih pada <?= date('M d, Y H:m a', $pemilih['tgl']); ?></h6>

                                <?php else : ?>

                                    <?php foreach ($i['data'] as $d) : ?>
                                        <?php foreach ($d as $p) : ?>

                                            <?php if ($p['status_calon'] == 'Cawapres') : ?>
                                                <div class="col-md-4">
                                                    <div class="card shadow shadow-sm">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?= $p['singkatan_partai']; ?>/<?= $p['no_urut_partai']; ?></h5>
                                                            <a href="" class="confirm_vote" data-url="<?= base_url(); ?>pemilu" data-order="vote" data-id_calon="<?= $p['id']; ?>" data-id_pemilih="<?= $pemilih['no_id']; ?>" data-message="Yakin Anda memilih <?= $p['singkatan_partai']; ?>?"><img src="<?= base_url(); ?>berkas/pemilu/<?= $p['flyer']; ?>" class="card-img-top" alt="Flyer"></a>
                                                            <h6 class="mt-2 new_active" style="border-radius: 4px;"><?= capres_cawapres($p['tahun'], $p['pondok'], $p['no_urut_partai'], 'nama'); ?></h6>

                                                            <div class="list-group">
                                                                <button data-bs-toggle="modal" data-bs-target="#detail_Capres_<?= $p['pondok']; ?>_<?= $p['no_urut_partai']; ?>" type="button" class="list-group-item list-group-item-action">Profile Capres</button>
                                                                <button data-bs-toggle="modal" data-bs-target="#detail_Cawapres_<?= $p['pondok']; ?>_<?= $p['no_urut_partai']; ?>" type="button" class="list-group-item list-group-item-action">Profile Cawapres</button>
                                                                <button data-bs-toggle="modal" data-bs-target="#detail_visi_misi_<?= $p['pondok']; ?>_<?= $p['no_urut_partai']; ?>" type="button" class="list-group-item list-group-item-action">Visi Misi Paslon</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>





        </div>
    </div>
    <!-- modal -->
    <?php foreach ($partai as  $i) : ?>
        <?php foreach ($i['data'] as $d) : ?>
            <?php foreach ($d as $p) : ?>
                <div class="modal fade" id="detail_<?= $p['status_calon']; ?>_<?= $p['pondok']; ?>_<?= $p['no_urut_partai']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="d-flex justify-content-between">
                                    <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-square-pen"></i> Detail <?= $p['status_calon']; ?> <?= $p['nama']; ?></div>
                                    <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                                </div>
                                <hr class="dark_color" style="border: 1px solid;">
                                <div class="card">
                                    <div class="card-body">
                                        <img width="200px" src="<?= base_url(); ?>berkas/pemilu/<?= $p['profile']; ?>" class="img-fluid" alt="Profile">
                                        <p><?= $p['riwayat']; ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($p['status_calon'] == 'Cawapres') : ?>
                    <div class="modal fade" id="detail_visi_misi_<?= $p['pondok']; ?>_<?= $p['no_urut_partai']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-square-pen"></i> Detail Visi Misi <?= $p['singkatan_partai']; ?></div>
                                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                                    </div>
                                    <hr class="dark_color" style="border: 1px solid;">
                                    <div class="card">
                                        <div class="card-body">
                                            <p><?= $p['visi_misi']; ?></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <!-- modal confirm vote-->

    <div class="modal fade" id="confirm_vote" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body body_confirm_vote">

                </div>

            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>