 <?= $this->extend('logged') ?>

 <?= $this->section('content') ?>


 <div class="container pt-2" style="margin-bottom:100px;margin-top:55px;">


     <div class="input-group input-group-sm mt-3">
         <button type="button" data-col="nama" data-tabel_api="santri" class="btn-sm btn_main modal_cari_db"><i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?></button>

         <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             Tahun [<?= url(4); ?>]
         </a>
         <ul class="dropdown-menu">
             <?php foreach ($tahun as $i) : ?>
                 <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == $i['tahun'] ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i['tahun']; ?>"><?= $i['tahun']; ?></a></li>
             <?php endforeach; ?>
             <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/All">All</a></li>
         </ul>
     </div>


     <table class="table table-borderless">
         <thead>
             <tr>
                 <th scope="col">#</th>
                 <th>Tahun</th>
                 <th>Pondok</th>
                 <th>Nama</th>
                 <th>Kelas</th>
                 <th>Status Calon</th>
                 <th>No Urut</th>
                 <th>Partai</th>
                 <th>Act</th>
             </tr>
         </thead>
         <tbody class="tabel_search">
             <?php $no_urut = []; ?>
             <?php foreach ($data as $k => $i) : ?>

                 <tr>
                     <td><?= ($k + 1); ?></td>
                     <td><?= $i['tahun']; ?></td>
                     <td><?= $i['pondok']; ?></td>
                     <td><?= $i['nama']; ?></td>
                     <td><?= $i['kelas']; ?></td>
                     <td><?= $i['status_calon']; ?></td>
                     <td><?= $i['no_urut_partai']; ?></td>
                     <td><?= $i['singkatan_partai']; ?></td>
                     <td>
                         <?php if (settings('pemilu_dimulai') == 0 && url(4) == date('Y')) : ?>
                             <a href="" data-bs-toggle="modal" data-bs-target="#update_<?= $i['id']; ?>" type="button" class="main_color" style="font-size: medium;"><i class="fa-solid fa-square-pen"></i></a>
                         <?php else : ?>
                             <i class="fa-solid fa-ban"></i>
                         <?php endif; ?>
                     </td>
                 </tr>

                 <?php if (in_array($i['no_urut_partai'], $no_urut)) : ?>
                     <?php $no_urut[] = $i['no_urut_partai']; ?>
                 <?php endif; ?>
                 <?php if ($i['status_calon'] == 'Cawapres') : ?>
                     <tr class="new_inactive">
                         <td colspan="2">
                             <img width="200" src="<?= base_url() . 'berkas/pemilu/' . $i['flyer']; ?>" class="img-fluid rounded mb-1" alt="Flyer">
                         </td>
                         <td colspan="7">
                             <?php if (settings('pemilu_dimulai') == 0 && url(4) == date('Y')) : ?>
                                 <form method="post" action="<?= base_url(); ?><?= menu()['controller']; ?>/flyer" class="input-group input-group-sm" enctype="multipart/form-data">
                                     <input type="hidden" name="tahun" value="<?= url(4); ?>">
                                     <input type="hidden" name="id" value="<?= $i['id']; ?>">
                                     <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>">
                                     <input type="file" name="flyer" class="form-control">
                                     <button class="btn-sm btn_main" type="submit">Upload Flyer</button>
                                 </form>
                             <?php endif; ?>
                             <?php if (settings('pemilu_dimulai') == 0 && url(4) == date('Y')) : ?>
                                 <form method="post" action="<?= base_url(); ?><?= menu()['controller']; ?>/visi" class="mt-3">
                                     <input type="hidden" name="tahun" value="<?= url(4); ?>">
                                     <input type="hidden" name="id" value="<?= $i['id']; ?>">
                                     <label class="form-label">Visi dan Misi</label>
                                     <textarea id="ck_<?= $i['no_urut_partai']; ?>_<?= $i['pondok']; ?>" name="visi_misi" class="form-control" rows="3"><?= $i['visi_misi']; ?></textarea>
                                     <div class="d-grid">
                                         <button class="btn-sm btn_main" style="border-radius: 1px;" type="submit"><i class="fa-solid fa-square-pen"></i> Save Visi dan Misi</button>
                                     </div>
                                 </form>
                             <?php else : ?>
                                 <p><?= $i['visi_misi']; ?></p>
                             <?php endif; ?>
                         </td>
                     </tr>


                 <?php endif; ?>
             <?php endforeach; ?>

         </tbody>


     </table>
     <?php $ids = []; ?>
     <?php foreach ($data as $i) : ?>
         <?php $ids[] = $i['id']; ?>
         <div class="modal fade" id="update_<?= $i['id']; ?>" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true" style="z-index:9999">
             <div class="modal-dialog modal-dialog-centered modal-lg">
                 <div class="modal-content">
                     <div class="modal-body">
                         <div class="d-flex justify-content-between">
                             <div class="main_color" style="font-weight: bold;"><i class="fa-solid fa-square-pen"></i> Update <?= menu()['menu']; ?></div>
                             <div><a type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark main_color"></i></a></div>
                         </div>
                         <hr class="dark_color" style="border: 1px solid;">
                         <div class="card">
                             <div class="card-body">
                                 <form action="<?= base_url(); ?><?= menu()['controller']; ?>/update" method="post" enctype="multipart/form-data">
                                     <input type="hidden" name="id" value="<?= $i['id']; ?>">
                                     <input type="hidden" name="tahun" value="<?= url(4); ?>">
                                     <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>">
                                     <div class="form-floating mb-3">
                                         <input type="number" class="form-control" name="tahun" value="<?= $i['tahun']; ?>" placeholder="Tahun" required>
                                         <label>Tahun</label>
                                     </div>

                                     <div class="form-floating mb-3">
                                         <select class="form-select" name="pondok">
                                             <option <?= ($i['pondok'] == 'Putra' ? 'selected' : ''); ?> value="Putra">Putra</option>
                                             <option <?= ($i['pondok'] == 'Putri' ? 'selected' : ''); ?> value="Putri">Putri</option>
                                         </select>
                                         <label>Pondok</label>
                                     </div>
                                     <div class="form-floating mb-3">
                                         <select class="form-select" name="partai">
                                             <?php foreach (partai() as $p) : ?>
                                                 <option <?= ($p['partai'] == $i['partai'] ? 'selected' : ''); ?> value="<?= $p['partai']; ?>"><?= $p['partai']; ?></option>
                                             <?php endforeach; ?>
                                         </select>
                                         <label>Partai</label>
                                     </div>

                                     <div class="form-floating mb-3">
                                         <input type="number" class="form-control" name="no_urut_partai" value="<?= $i['no_urut_partai']; ?>" placeholder="No. Urut Partai" required>
                                         <label>No. Urut Partai</label>
                                     </div>

                                     <div class="form-floating mb-3">
                                         <select class="form-select" name="status_calon">
                                             <option <?= ($i['status_calon'] == 'Capres' ? 'selected' : ''); ?> value="Capres">Capres</option>
                                             <option <?= ($i['status_calon'] == 'Cawapres' ? 'selected' : ''); ?> value="Cawapres">Cawapres</option>
                                         </select>
                                         <label>Status Calon</label>
                                     </div>

                                     <div class="form-floating mb-3">
                                         <input type="text" class="form-control" name="nama" value="<?= $i['nama']; ?>" placeholder="Nama" required>
                                         <label>Nama</label>
                                     </div>

                                     <div class="form-floating mb-3">
                                         <input type="text" class="form-control" name="ttl" value="<?= $i['ttl']; ?>" placeholder="Ttl" required>
                                         <label>Ttl</label>
                                     </div>
                                     <div class="form-floating mb-3">
                                         <input type="text" class="form-control" name="kelas" value="<?= $i['kelas']; ?>" placeholder="Kelas" required>
                                         <label>Kelas</label>
                                     </div>

                                     <div class="mb-3">
                                         <img width="100" src="<?= base_url() . 'berkas/pemilu/' . $i['profile']; ?>" class="img-fluid rounded mb-1" alt="Flyer">
                                         <div class="form-label">Photo Resmi</div>
                                         <input class="form-control form-control-sm" name="profile" type="file">
                                     </div>


                                     <div class="mb-3">
                                         <label class="form-label">Riwayat</label>
                                         <textarea id="ck_<?= $i['id']; ?>" name="riwayat" class="form-control" rows="3"><?= $i['riwayat']; ?></textarea>
                                     </div>

                                     <div class="d-grid">
                                         <button type="submit" class="btn-sm btn_main"><i class="fa-solid fa-square-pen"></i> Update</button>
                                     </div>
                                 </form>


                             </div>
                         </div>

                     </div>
                 </div>
             </div>
         </div>
     <?php endforeach; ?>

     <input type="hidden" class="ids" value="<?= implode(",", $ids); ?>">
 </div>
 <?= $this->endSection() ?>