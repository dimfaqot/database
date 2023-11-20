<?= $this->extend('guest') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-center" style="margin-top:200px;">
    <div class="card" style="width:500px;">
        <div class="card-body text-center p-5">
            <img class="mb-3 mt-2" width="100" src="<?= base_url(); ?>berkas/menu/karyawan.png" alt="LOGO">
            <form action="<?= base_url(); ?>login" method="post">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Username</span>
                    <input name="username" type="text" class="form-control" placeholder="Username" autofocus required>
                </div>
                <div class="input-group input-group-sm my-3">
                    <span class="input-group-text">Password</span>
                    <input name="password" type="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="d-grid">
                    <button class="btn_main btn-sm" type="submit">Login</button>
                </div>

            </form>
        </div>
    </div>

</div>
<?= $this->endSection() ?>