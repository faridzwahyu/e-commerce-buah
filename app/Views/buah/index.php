<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
   <div class="row">
      <h3 class="my-3">Welcome <?= $user['name']; ?>, You're Admin.</h3>
      <div class="col-6">
         <h4 class="my-3">Daftar Buah</h4>
         <form action="" method="post">
            <div class="input-group">
               <input type="text" class="form-control" placeholder="Pencarian..." name="keyword">
               <div class="input-group-append">
                  <button class="btn btn-primary lh-lg" type="submit" name="submit">Cari</button>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="row">
      <div class="col">
         <a href="/buah/create" class="btn btn-primary mt-3">Tambah Data Buah</a>
         <?php if(session()->getFlashdata('pesan')) { ?>
         <div class="alert alert-success my-3 col-3 py-1" role="alert">
            <?php echo session()->getFlashdata('pesan'); ?>
         </div>
         <?php } ?>
         <table class="table table-striped text-center tabel-buah">
            <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama Buah</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php $i = 1 + (5 * ($currentPage - 1)); ?>
               <?php foreach($buah as $b) : ?>
               <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $b['nama']; ?></td>
                  <td>Rp <?= $b['harga']; ?></td>
                  <td><a href="/buah/detail/<?= $b['slug']; ?>" class="btn btn-primary btn-sm">Detail</a> | <a href="/buah/edit/<?= $b['slug']; ?>" class="btn btn-warning btn-sm">Ubah</a> | 
                  <form action="/buah/<?= $b['id']; ?>" method="post" class="d-inline">
                     <?= csrf_field(); ?>
                     <input type="hidden" name="_method" value="DELETE">
                     <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah kamu yakin ?')">Hapus</button>
                  </form>
               </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
         <?= $pager->links('buah', 'buah_pagination'); ?>
      </div>
   </div>
</div>
<?= $this->endSection(); ?>