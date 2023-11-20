  <div class="d-flex gap-1 p-2">

      <?php $settings = ['menu', 'user', 'options', 'settings', 'images', 'informasi', 'cetak', 'rebana', 'rental', 'kamar', 'kelas', 'iswa']; ?>
      <?php $karyawan = ['karyawan', 'recruitment', 'sk', 'pilangsari', 'piagam']; ?>
      <?php $santri = ['santri', 'ppdb', 'ekstra', 'mapel', 'nilai']; ?>
      <?php $pemilu = ['partai', 'calon', 'kategori', 'pemilih', 'hasil', 'pemilu']; ?>
      <?php $news = ['label', 'artikel']; ?>
      <?php $djanasquad = ['pesanan', 'tugasku', 'laporan', 'inventaris', 'nota']; ?>



      <?php foreach (menus() as $k => $i) : ?>
          <?php if ($i['controller'] !== 'menu' && $i['controller'] !== 'user' && $i['controller'] !== 'options' && $i['controller'] !== 'recruitment' && $i['controller'] !== 'ppdb' && $i['controller'] !== 'images' && $i['controller'] !== 'informasi' && $i['controller'] !== 'piagam' && $i['controller'] !== 'pilangsari' && $i['controller'] !== 'mapel' && $i['controller'] !== 'nilai' && $i['controller'] !== 'calon' && $i['controller'] !== 'kategori' && $i['controller'] !== 'pemilih' && $i['controller'] !== 'hasil' && $i['controller'] !== 'pemilu' && $i['controller'] !== 'label' && $i['controller'] !== 'sk' && $i['controller'] !== 'cetak' && $i['controller'] !== 'rebana' &&  $i['controller'] !== 'rental' &&  $i['controller'] !== 'kamar' &&  $i['controller'] !== 'kelas' &&  $i['controller'] !== 'iswa' &&  $i['controller'] !== 'laporan' &&  $i['controller'] !== 'tugasku' &&  $i['controller'] !== 'inventaris' &&  $i['controller'] !== 'nota' &&  $i['controller'] !== 'tujuh' &&  $i['controller'] !== 'delapan' &&  $i['controller'] !== 'sembilan' &&  $i['controller'] !== 'sepuluh' &&  $i['controller'] !== 'sebelas' &&  $i['controller'] !== 'duabelas') : ?>

              <?php if ($i['controller'] == 'settings' || $i['controller'] == 'karyawan' || $i['controller'] == 'santri' || $i['controller'] == 'ekstra' || $i['controller'] == 'partai' || $i['controller'] == 'artikel') : ?>
                  <?php if ($i['controller'] == 'settings') : ?>
                      <a href="" class="<?= (in_array(url(), $settings) ? 'btn_main' : 'btn_main_inactive'); ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= (url() == 'menu' || url() == 'user' || url() == 'options' || url() == 'settings' || url() == 'images' || url() == 'informasi' || url() == 'cetak' || url() == 'rebana' || url() == 'rental' || url() == 'kamar' || url() == 'kelas' || url() == 'iswa' ? '<i class="' . menu()['icon'] . '"></i>' . ' ' . menu()['menu'] : '<i class="' . $i['icon'] . '"></i>' . ' ' . $i['menu']); ?> <i class="fa-solid fa-angles-down"></i></a>
                      <ul class="dropdown-menu px-2">
                          <?php foreach (menus() as $i) : ?>
                              <?php if (in_array($i['controller'], $settings)) : ?>
                                  <li class="d-grid"><a style="border-radius: 3px;" class="<?= (url() == $i['controller'] ? 'btn_main' : 'btn_main_inactive'); ?> mb-1" href="<?= base_url(); ?><?= $i['controller']; ?><?= ($i['controller'] == 'informasi' ? '' : ($i['controller'] == 'menu' ? '/Root' : ($i['controller'] == 'user' ? '/Recruitment' : ($i['controller'] == 'options' ? '/Role' : ($i['controller'] == 'rebana' || $i['controller'] == 'rental' ? '/' . date('Y') . '/' . date('m') : ''))))); ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['menu']; ?></a></li>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </ul>
                  <?php endif; ?>
                  <?php if ($i['controller'] == 'karyawan') : ?>
                      <a href="" class="<?= (in_array(url(), $karyawan) ? 'btn_main' : 'btn_main_inactive'); ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= (url() == 'karyawan' || url() == 'recruitment' || url() == 'sk' || url() == 'pilangsari' || url() == 'piagam' ? '<i class="' . menu()['icon'] . '"></i>' . ' ' . menu()['menu'] : '<i class="' . $i['icon'] . '"></i>' . ' ' . $i['menu']); ?> <i class="fa-solid fa-angles-down"></i></a>
                      <ul class="dropdown-menu px-2">
                          <?php foreach (menus() as $i) : ?>
                              <?php if (in_array($i['controller'], $karyawan)) : ?>
                                  <li class="d-grid"><a style="border-radius: 3px;" class="<?= (url() == $i['controller'] ? 'btn_main' : 'btn_main_inactive'); ?> mb-1" href="<?= base_url(); ?><?= $i['controller']; ?><?= ($i['controller'] == 'karyawan' || $i['controller'] == 'recruitment' ? '/Existing/1/SMP/updated_at/DESC/' . ($i["controller"] == "karyawan" ? "Aktif" : "Register") . '/All' : ($i['controller'] == 'sk' ? '/All/' . date('Y') . '/updated_at/DESC' : ($i['controller'] == 'pilangsari' ? '/Karyawan/1/updated_at/DESC/SSJ'  : ($i['controller'] == 'piagam' ? '/Dinas/' . date('Y') : '')))); ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['menu']; ?></a></li>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </ul>
                  <?php endif; ?>
                  <?php if ($i['controller'] == 'santri') : ?>
                      <a href="" class="<?= (in_array(url(), $santri) ? 'btn_main' : 'btn_main_inactive'); ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= (url() == 'santri' || url() == 'ppdb' || url() == 'ekstra' || url() == 'mapel' || url() == 'nilai' ? '<i class="' . menu()['icon'] . '"></i>' . ' ' . menu()['menu'] : '<i class="' . $i['icon'] . '"></i>' . ' ' . $i['menu']); ?> <i class="fa-solid fa-angles-down"></i></a>
                      <ul class="dropdown-menu px-2">
                          <?php foreach (menus() as $i) : ?>
                              <?php if (in_array($i['controller'], $santri)) : ?>
                                  <li class="d-grid"><a style="border-radius: 3px;" class="<?= (url() == $i['controller'] ? 'btn_main' : 'btn_main_inactive'); ?> mb-1" href="<?= base_url(); ?><?= $i['controller']; ?><?= ($i['controller'] == 'santri' || $i['controller'] == 'ppdb' ? '/' . ($i['controller'] == 'santri' ? 'All' : tahun_santri('ppdb')) . '/Existing/1/SMP/updated_at/DESC/' . ($i["controller"] == "santri" ? "Aktif" : "Register") . '/All' : ($i['controller'] == 'mapel' ? '/MUL' : ($i['controller'] == 'nilai' ? '/' . date('Y') . '/MUL' : ''))); ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['menu']; ?></a></li>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </ul>
                  <?php endif; ?>

                  <?php if ($i['controller'] == 'partai') : ?>
                      <a href="" class="<?= (in_array(url(), $pemilu) ? 'btn_main' : 'btn_main_inactive'); ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= (url() == 'partai' || url() == 'calon' || url() == 'kategori' || url() == 'pemilih' || url() == 'hasil' || url() == 'pemilu' ? '<i class="' . menu()['icon'] . '"></i>' . ' ' . menu()['menu'] : '<i class="' . $i['icon'] . '"></i>' . ' ' . $i['menu']); ?> <i class="fa-solid fa-angles-down"></i></a>
                      <ul class="dropdown-menu px-2">
                          <?php foreach (menus() as $i) : ?>
                              <?php if (in_array($i['controller'], $pemilu)) : ?>
                                  <li class="d-grid"><a style="border-radius: 3px;" class="<?= (url() == $i['controller'] ? 'btn_main' : 'btn_main_inactive'); ?> mb-1" href="<?= base_url(); ?><?= $i['controller']; ?><?= ($i['controller'] == 'calon' || $i['controller'] == 'hasil' ? '/' . date('Y') : ($i['controller'] == 'pemilih' ? '/' . date('Y') . '/Belum/1/Karyawan/Putra/updated_at/DESC' : '')); ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['menu']; ?></a></li>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </ul>
                  <?php endif; ?>
                  <?php if ($i['controller'] == 'artikel') : ?>
                      <a href="" class="<?= (in_array(url(), $news) ? 'btn_main' : 'btn_main_inactive'); ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= (url() == 'label' || url() == 'artikel' ? '<i class="' . menu()['icon'] . '"></i>' . ' ' . menu()['menu'] : '<i class="' . $i['icon'] . '"></i>' . ' ' . $i['menu']); ?> <i class="fa-solid fa-angles-down"></i></a>
                      <ul class="dropdown-menu px-2">
                          <?php foreach (menus() as $i) : ?>
                              <?php if (in_array($i['controller'], $news)) : ?>
                                  <li class="d-grid"><a style="border-radius: 3px;" class="<?= (url() == $i['controller'] ? 'btn_main' : 'btn_main_inactive'); ?> mb-1" href="<?= base_url(); ?><?= $i['controller']; ?><?= ($i['controller'] == 'artikel' ? '/label/Headlines/1/updated_at/DESC' : ''); ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['menu']; ?></a></li>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </ul>
                  <?php endif; ?>

              <?php else : ?>
                  <?php if ($i['controller'] == 'pesanan' || $i['controller'] == 'tugasku' || $i['controller'] == 'laporan' || $i['controller'] == 'inventaris') : ?>
                      <a href="" class="<?= (in_array(url(), $djanasquad) ? 'btn_main' : 'btn_main_inactive'); ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= (url() == 'pesanan' || url() == 'tugasku' || url() == 'laporan' || url() == 'inventaris' || url() == 'nota' ? '<i class="' . menu()['icon'] . '"></i>' . ' ' . menu()['menu'] : '<i class="' . $i['icon'] . '"></i>' . ' ' . $i['menu']); ?> <i class="fa-solid fa-angles-down"></i></a>
                      <ul class="dropdown-menu px-2">
                          <?php foreach (menus() as $i) : ?>
                              <?php if (in_array($i['controller'], $djanasquad)) : ?>
                                  <li class="d-grid"><a style="border-radius: 3px;" class="<?= (url() == $i['controller'] ? 'btn_main' : 'btn_main_inactive'); ?> mb-1" href="<?= base_url(); ?><?= $i['controller']; ?><?= ($i['controller'] == 'pesanan' || $i['controller'] == 'laporan' || $i['controller'] == 'inventaris' || $i['controller'] == 'nota' ? '/' . date('Y') . '/' . date('m') : ($i['controller'] == 'tugasku' ? '/' . date('Y') . '/' . date('m') . '/All' : '')); ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['menu']; ?></a></li>
                              <?php endif; ?>
                          <?php endforeach; ?>
                      </ul>
                  <?php else : ?>
                      <a href="<?= base_url(); ?><?= $i['controller']; ?><?= ($i['controller'] == 'sk' ? '/All/' . date('Y') . '/updated_at/DESC' : ''); ?>" class="<?= (url() == $i['controller'] ? 'btn_main' : 'btn_main_inactive'); ?>"><i class="<?= $i['icon']; ?>"></i> <?= $i['menu']; ?></a>
                  <?php endif; ?>
              <?php endif; ?>
          <?php endif; ?>

      <?php endforeach; ?>


  </div>