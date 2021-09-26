<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
   <div class="row">
      <div class="col">
         <div class="card" style="width: 18rem;">
            <img src="/img/<?= $buah['gambar']; ?>" class="card-img-top">
            <div class="card-body">
               <h5 class="card-title"><?= $buah['nama']; ?></h5>
               <p class="card-text">Harga : <?= $buah['harga']; ?></p>
               <p class="card-text">Stok : <?= $buah['stok']; ?></p>
               <p class="card-text">Agen : <?= $buah['agen']; ?></p>
               <a href="/buah" class="btn btn-primary">Kembali</a>
            </div>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection(); ?>