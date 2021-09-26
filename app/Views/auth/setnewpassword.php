<?= $this->extend('layout/templateAuth'); ?>

<?= $this->section('content'); ?>
<div id="layoutAuthentication">
   <div id="layoutAuthentication_content">
      <main>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-lg-5">
                  <div class="card shadow-lg border-0 rounded-lg mt-5">
                     <div class="card-header">
                        <h3 class="text-center font-weight-light mt-4">Set New Password</h3>
                        <h5 class="text-center"><small><?= session()->get('reset_email'); ?></small></h5>
                     </div>
                     <div class="card-body">
                        <?php if(session()->getFlashdata('pesan')) { ?>
                        <div class="alert alert-<?= session()->getFlashdata('status'); ?> py-1" role="alert"><?php echo session()->getFlashdata('pesan'); ?></div>
                        <?php } ?>
                        <form action="/auth/makepassword" method="post">
                           <?= csrf_field(); ?>
                           <div class="mb-3">
                              <input class="form-control <?php echo ($validation->hasError('password1')) ? 'is-invalid' : ''; ?>" id="password1" type="password" placeholder="New Password" name="password1" autocomplete="off" />
                              <div class="invalid-feedback"><?= $validation->getError('password1'); ?></div>
                           </div>
                           <div class="mb-3">
                              <input class="form-control <?php echo ($validation->hasError('password2')) ? 'is-invalid' : ''; ?>" id="password2" type="password" placeholder="Re-type New Password" name="password2" autocomplete="off" />
                              <div class="invalid-feedback"><?= $validation->getError('password2'); ?></div>
                           </div>
                           <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                              <button type="submit" class="btn btn-primary">Make Password</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
   </div>
</div>
<?= $this->endSection(); ?>

