<?= $this->extend('logged') ?>

<?= $this->section('content') ?>
<div class="container" style="margin-top: 60px;">

    <div class="d-none d-md-block" style="min-height: 100vh;">
        <div class="row">
            <div class="col-2">
                <?= view('menu/anggotakelas'); ?>
            </div>
            <div class="col">
                <div class="row pe-3 py-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                This is some text within a card body.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                This is some text within a card body.
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h6>Anggota Kelas <?= menu_kelas()['menu']; ?></h6>
                    <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
                        <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
                    </button>

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

                                            <form action="<?= base_url(); ?><?= menu()['controller']; ?>/add" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? 'Tujuh' : url(4)); ?>">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control cari_nama_db add_wali_kamar_1" data-gender="<?= (session('role') == 'Root' ? (url(4) == '' ? 'L' : url(4)) : session('gender')); ?>" data-order="add" name="wali_kamar_1" data-tabel="santri" placeholder="Wali kamar 1">
                                                    <label>Wali Kamar 1</label>
                                                    <ul class="p-1 dropdown-menu body_add_wali_kamar_1" style="font-size:small;">

                                                    </ul>
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
                    <?php if (count(anggota_kelas()) == 0) : ?>

                    <?php else : ?>

                        <table class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (anggota_kelas() as $k => $i) : ?>
                                    <tr>
                                        <td><?= ($k + 1); ?></td>
                                        <td><?= $i['profile']['no_id']; ?></td>
                                        <td><?= $i['profile']['nama']; ?></td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>