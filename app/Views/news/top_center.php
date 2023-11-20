 <div class="carousel slide" data-bs-ride="carousel">

     <!-- Indicators/dots -->
     <div class="carousel-indicators">
         <?php foreach (get_news('Headlines') as $k => $i) : ?>
             <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $k; ?>" <?= ($k == 0 ? 'class="active"' : ''); ?>></button>
         <?php endforeach; ?>
     </div>

     <!-- The slideshow/carousel -->
     <div class="carousel-inner">
         <?php foreach (get_news('Headlines') as $k => $i) : ?>
             <a href="<?= base_url(); ?>public/news/single/<?= $i['slug']; ?>" class="carousel-item <?= ($k == 0 ? 'active' : ''); ?>">
                 <img src="<?= base_url(); ?>berkas/news/<?= $i['img']; ?>" alt="Los Angeles" class="d-block" style="width:100%">
                 <div class="carousel-caption" style="background-color: rgba(0, 0, 0, 0.2);">
                     <h5><?= $i['judul']; ?></h5>
                     <p><?= date('d/m/Y H:i:s', $i['tgl']); ?></p>
                 </div>
             </a>
         <?php endforeach; ?>
     </div>

     <!-- Left and right controls/icons -->
     <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
         <span class="carousel-control-prev-icon"></span>
     </button>
     <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
         <span class="carousel-control-next-icon"></span>
     </button>
 </div>