<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
   <div class="row">
      <div class="col-8">
         <h2 class="my-3">Form Tambah Data Buah</h2>
         <form action="/buah/save" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="mb-3">
               <label for="nama" class="form-label">Nama Buah</label>
               <input type="text" class="form-control <?php echo ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama'); ?>" autocomplete="off" autofocus>
               <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>
            </div>
            <div class="mb-3">
               <label for="agen" class="form-label">Nama Agen</label>
               <input type="text" class="form-control <?php echo ($validation->hasError('agen')) ? 'is-invalid' : ''; ?>" id="agen" name="agen" value="<?= old('agen'); ?>" autocomplete="off">
               <div class="invalid-feedback"><?= $validation->getError('agen'); ?></div>
            </div>
            <div class="mb-3">
               <label for="stok" class="form-label">Stok Buah</label>
               <input type="text" class="form-control <?php echo ($validation->hasError('stok')) ? 'is-invalid' : ''; ?>" placeholder="kg" id="stok" name="stok" value="<?= old('stok'); ?>" autocomplete="off">
               <div class="invalid-feedback"><?= $validation->getError('stok'); ?></div>
            </div>
            <div class="mb-3">
               <label for="harga" class="form-label">Harga</label>
               <input type="text" class="form-control <?php echo ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" placeholder="Rupiah/kg" id="harga" name="harga" value="<?= old('harga'); ?>" autocomplete="off">
               <div class="invalid-feedback"><?= $validation->getError('harga'); ?></div>
            </div>
            <div class="mb-3">
               <label for="gambar" class="form-label ">Gambar</label>
               <input type="file" class="form-control <?php echo ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" id="gambar" name="gambar">
               <div class="invalid-feedback"><?= $validation->getError('gambar'); ?></div>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Data</button>
         </form>
      </div>
   </div>
</div>
<?= $this->endSection(); ?>