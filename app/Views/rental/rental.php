   <?= $this->extend('logged') ?>

   <?= $this->section('content') ?>

   <div class="container" style="margin-top: 60px;">
       <div class="input-group input-group-sm mb-3">
           <button type="button" class="btn-sm btn_main" data-bs-toggle="modal" data-bs-target="#<?= menu()['controller']; ?>">
               <i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?>
           </button>
           <a class="nav-link dropdown-toggle btn_secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Tahun [<?= url(4); ?>]
           </a>
           <ul class="dropdown-menu">
               <?php foreach ($tahuns as $i) : ?>
                   <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == $i ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i; ?>/<?= url(5); ?>"><?= $i; ?></a></li>
               <?php endforeach; ?>
           </ul>
           <a class="nav-link dropdown-toggle btn_secondary_inactive" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Bulan [<?= url(5); ?>]
           </a>
           <ul class="dropdown-menu">
               <?php foreach (bulan() as $i) : ?>
                   <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == $i['angka'] ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= $i['angka']; ?>"><?= $i['bulan']; ?></a></li>
               <?php endforeach; ?>
           </ul>
           <?php if (session('role') == 'Root') : ?>
               <a class="nav-link dropdown-toggle btn_secondary_inactive" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   Kategori [<?= (url(6) == '' ? 'Bus' : url(6)); ?>]
               </a>
               <ul class="dropdown-menu">
                   <?php foreach (options('Rental') as $i) : ?>
                       <li style="font-size: small;"><a class="dropdown-item <?= (url(6) == '' && $i['value'] == 'Bus' ? 'bg_main' : (url(6) !== '' && $i['value'] == url(6) ? 'bg_main' : '')); ?>" href="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>/<?= $i['value']; ?>"><?= $i['value']; ?></a></li>
                   <?php endforeach; ?>
               </ul>

           <?php endif; ?>
       </div>

       <div class="modal fade" id="images" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-images"></i> Images</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                       <div class="row g-2">
                           <?php foreach (get_files(menu()['controller']) as $k => $i) : ?>
                               <?php if ($i !== 'berkas/ekstra/sertifikat1.jpg' && $i !== 'berkas/ekstra/sertifikat2.jpg') : ?>

                                   <div class="col-md-4">
                                       <div style="position: relative;">
                                           <div class="modal_confirm position-absolute top-50 start-50 d-none translate-middle btn_main_inactive message_confirm_<?= $k; ?>" style="z-index:9999;left:15px;right:15px;">
                                               <div class="d-flex gap-2 justify-content-center">
                                                   <span style="font-weight:500;">Delete?</span> <a href="" class="delete_file" data-dir="<?= $i; ?>"><i class="fa-solid fa-circle-check text-success"></i></a> <a href="" class="cancel_delete_file" data-i="<?= $k; ?>"><i class="fa-solid fa-circle-xmark text-danger"></i></a>
                                               </div>
                                           </div>
                                           <div class="card">
                                               <div class="card-body p-1">
                                                   <a href="" class="top_right_corner confirm_delete_file" data-i="<?= $k; ?>"><i class="fa-solid fa-circle-xmark"></i></a>
                                                   <img class="img-fluid" src="<?= base_url() . $i; ?>" alt="<?= $i; ?>">
                                               </div>
                                           </div>

                                       </div>
                                   </div>

                               <?php endif; ?>
                           <?php endforeach; ?>

                       </div>
                   </div>
               </div>
           </div>
       </div>

       <small class="body_warning_img text-danger"></small>
       <form method="post" action="<?= base_url(); ?><?= menu()['controller']; ?>/add_image" class="form-floating mb-2" enctype="multipart/form-data">
           <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>">
           <input type="hidden" name="folder" value="<?= menu()['controller']; ?>">
           <div class="input-group input-group-sm mb-3 line_warning_img">
               <input type="file" class="form-control file" name="file" data-col="img" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pilih gambar.">
               <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Upload gambar." class="btn_main_inactive" type="submit"><i class="fa-solid fa-circle-arrow-up"></i> Upload</button>
               <button data-bs-toggle="modal" data-bs-target="#images" class="btn_main" type="button"><i data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lihat gambar." class="fa-solid fa-images"></i></button>
           </div>
       </form>

       <!-- Modal tambah data-->
       <div class="modal fade" id="<?= menu()['controller']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambah_dataLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <div class="modal-header">
                       <h1 class="modal-title fs-5" id="tambah_dataLabel"><i class="fa-solid fa-circle-plus"></i> Tambah <?= menu()['menu']; ?> <?= session('role'); ?></h1>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                       <form action="<?= base_url(menu()['controller']); ?>/add" method="post">
                           <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= url(4); ?>/<?= url(5); ?>">
                           <div class="mb-2">
                               <label>Tanggal</label>
                               <input type="date" data-date="" class="form-control form-control-sm input_date mt-1" name="tgl" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d'); ?>" required>
                           </div>
                           <div class="row g-2">
                               <?php if (session('role') == 'Root') : ?>
                                   <div class="col-md-6">
                                       <div class="input-group input-group-sm">
                                           <label style="width: 120px; font-size:small" class="input-group-text">Kategori</label>
                                           <select style="font-size: small;" class="form-select" name="kategori" required>
                                               <?php foreach (options('Rental') as $i) : ?>
                                                   <option <?= (url(6) == '' && $i['value'] == 'Bus' ? 'selected' : (url(6) !== '' && $i['value'] == url(6) ? 'selected' : '')); ?> value="<?= $i['value']; ?>"><?= $i['value']; ?></option>
                                               <?php endforeach; ?>
                                           </select>
                                       </div>
                                   </div>
                               <?php endif; ?>
                               <div class="col-md">
                                   <div class="input-group input-group-sm">
                                       <span style="width: 120px; font-size:small" class="input-group-text">Waktu</span>
                                       <input style="font-size: small;" type="text" name="waktu" class="form-control" placeholder="Waktu Keberangkatan">
                                   </div>
                               </div>
                               <div class="col-md-6">
                                   <div class="input-group input-group-sm">
                                       <span style="width: 120px; font-size:small" class="input-group-text">Pemakai</span>
                                       <input style="font-size: small;" type="text" name="pemakai" class="form-control" placeholder="Pemakai/penyewa bus">
                                   </div>
                               </div>
                               <div class="col-md-6 mb-2">
                                   <div class="input-group input-group-sm mb-3">
                                       <span style="width: 120px; font-size:small" class="input-group-text">Pj.</span>
                                       <input style="font-size: small;" type="text" name="pj" class="form-control" placeholder="Penanggung jawab">
                                   </div>
                               </div>
                           </div>
                           <div class="d-grid p-2">
                               <button type="submit" class="btn btn-primary btn_main" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                   <i class="fa-regular fa-floppy-disk"></i> Save
                               </button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>

       <?php if (count($data) == 0) : ?>
           <div class="mt-2 text-danger"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!.</div>
       <?php else : ?>
           <div class="input-group input-group-sm mb-3">
               <span style="width: 120px; font-size:small" class="input-group-text">Cari</span>
               <input style="font-size: small;" type="text" class="form-control cari" placeholder="...">
           </div>



           <table class="table table-sm table-striped table-bordered">
               <thead>
                   <tr>
                       <th scope="col">#</th>
                       <th scope="col">Tgl</th>
                       <th scope="col">Waktu</th>
                       <th scope="col">Pemakai</th>
                       <th scope="col">Pj</th>
                       <th scope="col">Del</th>
                   </tr>
               </thead>
               <tbody class="tabel_search">
                   <?php foreach ($data as $k => $i) : ?>
                       <tr>
                           <th scope="row"><?= $k + 1; ?></th>
                           <td><a href="" class="btn_bright_sm" data-bs-toggle="modal" data-bs-target="#modal_update_tgl_rental_<?= $i['id']; ?>"><?= date('d/m/Y', $i['tgl']); ?></a></td>
                           <td data-id="<?= $i['id']; ?>" class="update_blur_rental" contenteditable="true" data-col="waktu"><?= $i['waktu']; ?></td>
                           <td data-id="<?= $i['id']; ?>" class="update_blur_rental" contenteditable="true" data-col="pemakai"><?= $i['pemakai']; ?></td>
                           <td data-id="<?= $i['id']; ?>" class="update_blur_rental" contenteditable="true" data-col="pj"><?= $i['pj']; ?></td>
                           <td data-id="<?= $i['id']; ?>" data-col="waktu"><a href="" class="confirm" data-id="<?= $i['id']; ?>" data-order="hapus" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-square-xmark danger_color"></i></a></td>
                       </tr>
                   <?php endforeach; ?>
               </tbody>
           </table>

           <?php foreach ($data as $i) : ?>
               <!-- Modal tambah update tgl-->
               <div class="modal fade" id="modal_update_tgl_rental_<?= $i['id']; ?>" tabindex="-1" aria-labelledby="update_tglLabel" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-body body_update_tgl_rental">
                               <form action="<?= base_url(menu()['controller']); ?>/update_tgl" method="post">
                                   <input type="hidden" name="id" value="<?= $i['id']; ?>">
                                   <input type="hidden" name="tabel" value="<?= (url(6) == '' ? 'Bus' : url(6)); ?>">
                                   <div class="d-flex justify-content-center gap-2">
                                       <input type="date" data-date="" class="form-control form-control-sm input_date mt-1" name="tgl" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d', $i['tgl']); ?>">
                                       <button type="submit" class="main_color" style="font-size:medium;background-color:transparent;border:0px;padding-top:5px;"><i class="fa-solid fa-circle-check"></i></button>
                                   </div>
                               </form>
                           </div>
                       </div>
                   </div>
               </div>
           <?php endforeach; ?>
       <?php endif; ?>
   </div>
   <?= $this->endSection() ?>