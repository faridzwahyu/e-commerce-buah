<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
   <div class="row">
      <div class="col">
         <h1>Good Morning <?= $user['name']; ?>. Welcome to Buah.com</h1>
         <h1>Happy shopping day.</h1>
         <img src="/img/cart.jpg" width="500">
      </div>
   </div>
</div>

<?= $this->endSection(); ?>