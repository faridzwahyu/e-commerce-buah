<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container d-flex justify-content-center mt-5">
   <div class="row">
      <div class="col">
         <?php if(session()->getFlashdata('pesan')) { ?>
         <div class="alert alert-success py-1 my-3" role="alert">
            <?php echo session()->getFlashdata('pesan'); ?>
         </div>
         <?php } ?>
         <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
               <div class="col-md-4">
                  <img src="/img/profile/default.jpg" class="img-fluid rounded-start" alt="...">
               </div>
               <div class="col-md-8">
                  <div class="card-body">
                     <h5 class="card-title"><?= $user['name']; ?></h5>
                     <p class="card-text"><?= $user['email']; ?></p>
                     <?php if($user['role_id'] == 1) { ?>
                           <p class="card-text">You are Admin</p>                        
                        <?php } else { ?>
                           <p class="card-text"><small class="text-muted">You registered at <?= $user['created_at']; ?></small></p>
                           <p class="card-text"><small class="text-muted">Last update at <?= $user['updated_at']; ?></small></p>
                     <?php } ?>
                     <a href="/profile/ubahpassword">Ubah Password</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?= $this->endSection(); ?>