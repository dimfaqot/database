<?= $this->extend('logged') ?>

<?= $this->section('content') ?>
<div class="container" style="margin-top: 60px;">
    <?php foreach ($data as $i) : ?>
        <h4 class="bg_main" style="border-radius: 4px;padding:8px;text-align:center;">TAHUN <?= $i['tahun']; ?></h4>

        <?php foreach ($i['detail'] as $d) : ?>
            <h5 style="border-radius: 4px;padding:8px;" class="btn_secondary"><?= $d['pondok']; ?></h5>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($d['data'] as $t) : ?>
                            <div class="col-md-4">
                                <div class="btn_main_inactive" style="border-radius: 0px;font-weight:bold;"><?= $t['no_partai']; ?>/<?= $t['partai']; ?>/<?= $t['singkatan_partai']; ?></div>
                                <img style="max-width: 100%;" src="<?= base_url(); ?>berkas/pemilu/<?= $t['flyer']; ?>" alt="">
                                <div class="my-3">
                                    <a role="button" class="btn_main_inactive" data-bs-toggle="modal" data-bs-target="#<?= $d['pondok']; ?>_<?= $i['tahun']; ?>_<?= $t['no_partai']; ?>_<?= $t['capres']['status_calon']; ?>"><?= $t['capres']['nama']; ?></a> <a href="" class="btn_main_inactive" data-bs-toggle="modal" data-bs-target="#<?= $d['pondok']; ?>_<?= $i['tahun']; ?>_<?= $t['no_partai']; ?>_<?= $t['cawapres']['status_calon']; ?>"><?= $t['cawapres']['nama']; ?></a>
                                </div>
                                <div class="d-grid my-1" style="text-align: center;font-weight:bold;"><a href="" role="button" class="btn_main_inactive" data-bs-toggle="modal" data-bs-target="#<?= $d['pondok']; ?>_<?= $i['tahun']; ?>_<?= $t['no_partai']; ?>" class=" btn_secondary_inactive">Visi Misi</a></div>
                                <div class="d-grid btn_main" style="text-align: center;font-weight:bold;"><?= (info_pemilu() == 0 ? 0 : $t['suara']); ?> Suara</div>
                            </div>

                            <!-- modal capres-->
                            <div class="modal fade" id="<?= $d['pondok']; ?>_<?= $i['tahun']; ?>_<?= $t['no_partai']; ?>_<?= $t['capres']['status_calon']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="card">
                                                <img src="<?= base_url(); ?>berkas/pemilu/<?= $t['capres']['profile']; ?>" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $t['capres']['nama']; ?></h5>
                                                    <div class="mb-2">
                                                        <label style="font-size: small;" class="form-label">No. Id</label>
                                                        <input type="text" value="<?= $t['capres']['id']; ?>" class="form-control form-control-sm" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label style="font-size: small;" class="form-label">Ttl</label>
                                                        <input type="text" value="<?= $t['capres']['ttl']; ?>" class="form-control form-control-sm" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label style="font-size: small;" class="form-label">Kelas</label>
                                                        <input type="text" value="<?= $t['capres']['kelas']; ?>" class="form-control form-control-sm" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label style="font-size: small;" class="form-label">Riwayat</label>
                                                        <p><?= $t['capres']['riwayat']; ?></p>
                                                    </div>
                                                    <div class="d-grid mt-3">
                                                        <a style="text-align: center;" href="#" class="btn_main" data-bs-dismiss="modal" aria-label="Close">Close</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal cawapres-->
                            <div class="modal fade" id="<?= $d['pondok']; ?>_<?= $i['tahun']; ?>_<?= $t['no_partai']; ?>_<?= $t['cawapres']['status_calon']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img src="<?= base_url(); ?>berkas/pemilu/<?= $t['cawapres']['profile']; ?>" class="card-img-top" alt="...">

                                            <h5 class="card-title"><?= $t['cawapres']['nama']; ?></h5>
                                            <div class="mb-2">
                                                <label style="font-size: small;" class="form-label">No. Id</label>
                                                <input type="text" value="<?= $t['cawapres']['id']; ?>" class="form-control form-control-sm" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label style="font-size: small;" class="form-label">Ttl</label>
                                                <input type="text" value="<?= $t['cawapres']['ttl']; ?>" class="form-control form-control-sm" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label style="font-size: small;" class="form-label">Kelas</label>
                                                <input type="text" value="<?= $t['cawapres']['kelas']; ?>" class="form-control form-control-sm" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label style="font-size: small;" class="form-label">Riwayat</label>
                                                <p><?= $t['cawapres']['riwayat']; ?></p>
                                            </div>
                                            <div class="d-grid mt-3">
                                                <a style="text-align: center;" href="#" class="btn_main" data-bs-dismiss="modal" aria-label="Close">Close</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal visi_misi-->
                            <div class="modal fade" id="<?= $d['pondok']; ?>_<?= $i['tahun']; ?>_<?= $t['no_partai']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <p><?= $t['visi_misi']; ?></p>

                                            <div class="d-grid mt-3">
                                                <a style="text-align: center;" href="#" class="btn_main" data-bs-dismiss="modal" aria-label="Close">Close</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>


                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

</div>
<?= $this->endSection() ?>