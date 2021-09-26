<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
   <div class="row">
      <div class="col-lg-6 my-3">
         <?php if(session()->getFlashdata('pesan')) { ?>
         <div class="alert alert-danger py-1" role="alert">
            <?php echo session()->getFlashdata('pesan'); ?>
         </div>
         <?php } ?>
         <form action="/profile/changepassword" method="post">
            <?= csrf_field(); ?>
            <div class="mb-3">
               <input type="hidden" id="id" name="id" value="<?= $user['id']; ?>">
               <input class="form-control <?php echo ($validation->hasError('passwordlama')) ? 'is-invalid' : ''; ?>" id="passwordlama" type="password" placeholder="Password Lama" name="passwordlama" />
               <div class="invalid-feedback"><?= $validation->getError('passwordlama'); ?></div>
            </div>
            <div class="mb-3">
               <input class="form-control <?php echo ($validation->hasError('passwordbaru1')) ? 'is-invalid' : ''; ?>" id="passwordbaru1" type="password" placeholder="Password Baru" name="passwordbaru1" />
               <div class="invalid-feedback"><?= $validation->getError('passwordbaru1'); ?></div>
            </div>
            <div class="mb-3">
               <input class="form-control <?php echo ($validation->hasError('passwordbaru2')) ? 'is-invalid' : ''; ?>" id="passwordbaru2" type="password" placeholder="Ulangi Password Baru" name="passwordbaru2" />
               <div class="invalid-feedback"><?= $validation->getError('passwordbaru2'); ?></div>
            </div>
            <button type="submit" class="btn btn-primary">Ubah Password</button>
         </form>
      </div>
   </div>
</div>

<?= $this->endSection(); ?>