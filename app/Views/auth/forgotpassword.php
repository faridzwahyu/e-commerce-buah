<?= $this->extend('layout/templateAuth'); ?>

<?= $this->section('content'); ?>
<div id="layoutAuthentication">
   <div id="layoutAuthentication_content">
      <main>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-lg-5">
                  <div class="card shadow-lg border-0 rounded-lg mt-5">
                     <div class="card-header"><h3 class="text-center font-weight-light my-4">Reset Password</h3></div>
                     <div class="card-body">
                        <?php if(session()->getFlashdata('pesan')) { ?>
                        <div class="alert alert-<?= session()->getFlashdata('status'); ?> py-1" role="alert"><?php echo session()->getFlashdata('pesan'); ?></div>
                        <?php } ?>
                        <form action="/auth/resetpassword" method="post">
                           <?= csrf_field(); ?>
                           <div class="mb-3">
                              <input class="form-control <?php echo ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" type="text" placeholder="Email" name="email" value="<?= old('email'); ?>" autocomplete="off" />
                              <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                           </div>
                           <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                              <button type="submit" class="btn btn-primary">Reset Password</button>
                           </div>
                        </form>
                     </div>
                     <div class="card-footer text-center py-3">
                        <div class="small"><a href="/auth">Back</a></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
   </div>
</div>
<?= $this->endSection(); ?>

