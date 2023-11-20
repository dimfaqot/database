<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="container" style="margin-top: 60px;">

    <a href="<?= base_url(menu()['controller']); ?>/<?= url(5); ?>/<?= url(6) ?>/<?= url(7); ?>/<?= url(8); ?>" class=" btn_main"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
    <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#semua_sk">
        <i class="fa-solid fa-wallet"></i> Semua Sk
    </button>


    <!-- Modal all data sk-->
    <div class="modal fade" id="semua_sk" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-wallet"></i> Semua Sk</div>
                        <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                    </div>
                    <hr class="dark_color" style="border: 1px solid;">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-end gap-1 px-2">
                                <div class="mt-1">
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download excel" data-controller="dtl" data-order="excel" data-id="<?= $data['no_id']; ?>" href="" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-file-excel"></i> Print Excel</a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download pdf" data-controller="dtl" data-order="pdf" data-id="<?= $data['no_id']; ?>" href="" class="btn_main_inactive cetak" style="font-style:italic;"><i class="fa-solid fa-paste"></i> Print All Pdf</a>

                                </div>
                                <div class="form-check form-switch mt-1">
                                    <input class="form-check-input ttd" type="checkbox" role="switch">
                                    <label class="form-check-label">TTD</label>
                                </div>

                            </div>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th>Tahun</th>
                                        <th>No. Sk</th>
                                        <th>Ttl</th>
                                        <th>Pendidikan</th>
                                        <th>Rapat</th>
                                        <th>Penetapan</th>
                                        <th>Pertama Diangkat</th>
                                        <th>Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($all_data as $k => $i) : ?>
                                        <tr class="<?= ($i['id'] == $data['id'] ? 'bg-success text-light' : ''); ?>">
                                            <th scope="row"><?= ($k + 1); ?></th>
                                            <td><?= $i['tahun']; ?></td>
                                            <td><?= $i['no_sk']; ?></td>
                                            <td><?= $i['ttl']; ?></td>
                                            <td><?= $i['pendidikan']; ?></td>
                                            <td><?= $i['rapat']; ?></td>
                                            <td><?= $i['penetapan']; ?></td>
                                            <td><?= $i['diangkat']; ?></td>
                                            <td>
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit data." class="main_color" href="<?= base_url(menu()['controller']); ?>/dtl/<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>/<?= $i['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-square-pen"></i></a> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy data." data-id="<?= $i['id']; ?>" href="" class="dark_color copy_sk" style="font-size: medium;"><i class="fa-solid fa-copy"></i></a> <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cetak pdf." data-order="single" href="" data-id="<?= $i['id']; ?>" class="secondary_dark_color cetak" style="font-size: medium;"><i class="fa-solid fa-file-pdf"></i></a>
                                            </td>
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


    <div class="new_inactive identitas my-3 py-2 pb-0"></div>

    <div class="card mt-2">
        <div class="card-body">
            <h6 class="btn_main"><i class="fa-solid fa-user"></i> <?= $data['nama']; ?> [<?= $data['no_id']; ?>]</h6>

            <form action="<?= base_url(menu()['controller']); ?>/update" method="post">
                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                <input type="hidden" name="url" value="<?= url(5); ?>/<?= url(6); ?>/<?= url(7); ?>/<?= url(8); ?>">
                <div class="form-floating mb-2">
                    <input value="<?= $data['tahun']; ?>" type="number" name="tahun" class="form-control" placeholder="Tahun">
                    <label>Tahun</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['no_sk']; ?>" data-id="<?= $data['id']; ?>" name="no_sk" type="text" data-order="detail" class="form-control check_no_sk" placeholder="No. Sk">
                    <label>No. Sk</label>
                    <div class="invalid-feedback body_feedback_no_sk">
                    </div>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['no_id']; ?>" name="no_id" type="text" class="form-control">
                    <label>Niy</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['nama']; ?>" name="nama" type="text" class="form-control" placeholder="Nama">
                    <label>Nama</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['ttl']; ?>" name="ttl" type="text" class="form-control" placeholder="Ttl">
                    <label>Ttl</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['pendidikan']; ?>" name="pendidikan" type="text" class="form-control" placeholder="Pendidikan">
                    <label>Pendidikan</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['sub']; ?>" type="text" name="sub" class="form-control" placeholder="Sub">
                    <label>Sub</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['jabatan']; ?>" name="jabatan" type="text" class="form-control" placeholder="Jabatan">
                    <label>Jabatan</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['tugas']; ?>" type="text" name="tugas" class="form-control" placeholder="Tugas Tambahan">
                    <label>Tugas Tambahan</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['diangkat']; ?>" name="diangkat" type="text" class="form-control" placeholder="Tanggal Diangkat Pertama Kali">
                    <label>Tanggal Diangkat Pertama Kali</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['rapat']; ?>" name="rapat" type="text" class="form-control" placeholder="Tanggal Rapat Ypp">
                    <label>Tanggal Rapat Ypp</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['penetapan']; ?>" name="penetapan" type="text" class="form-control" placeholder="Tanggal Penetapan Ypp">
                    <label>Tanggal Penetapan Ypp</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['jenis']; ?>" name="jenis" type="text" class="form-control" placeholder="Jenis Surat Gty/Pty">
                    <label>Jenis Surat Gty/Pty</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['ketua_ypp']; ?>" name="ketua_ypp" type="text" class="form-control" placeholder="Ketua Yayasan">
                    <label>Ketua Yayasan</label>
                </div>

                <div class="form-floating mb-2">
                    <input value="<?= $data['kop']; ?>" name="kop" type="text" data-order="update" data-id="<?= $data['id']; ?>" class="form-control kop update_kop_<?= $data['id']; ?>" placeholder="Kop" readonly>
                    <label>Kop</label>
                </div>
                <div class="modal-body position-absolute top-50 start-50 translate-middle body_kop body_kop_update_<?= $i['id']; ?>" style="z-index: 999;">

                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn-sm btn_main btn_check"><i class="fa-solid fa-file-pen"></i> Update <?= menu()['menu']; ?></button>
                </div>

            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>