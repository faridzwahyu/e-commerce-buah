<?= $this->extend('layout/templateAuth'); ?>

<?= $this->section('content'); ?>
<div id="layoutAuthentication">
   <div id="layoutAuthentication_content">
      <main>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-lg-7">
                  <div class="card shadow-lg border-0 rounded-lg mt-5">
                     <div class="card-header"><h3 class="text-center font-weight-light my-4">Create an Account</h3></div>
                     <div class="card-body">
                        <form action="/auth/save" method="post">
                           <?= csrf_field(); ?>
                           <div class="mb-3">
                              <input class="form-control <?php echo ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="name" type="text" placeholder="Username" name="name" value="<?= old('name'); ?>" autocomplete="off" />
                              <div class="invalid-feedback"><?= $validation->getError('name'); ?></div>
                           </div>
                           <div class="mb-3">
                              <input class="form-control <?php echo ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" type="text" placeholder="Email" name="email" value="<?= old('email'); ?>" autocomplete="off" />
                              <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                           </div>
                           <div class="row mb-3">
                              <div class="col-md-6">
                                 <div class="mb-3 mb-md-0">
                                    <input class="form-control <?php echo ($validation->hasError('password1')) ? 'is-invalid' : ''; ?>" id="password1" type="password" placeholder="Password" name="password1" />
                                    <div class="invalid-feedback"><?= $validation->getError('password1'); ?></div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3 mb-md-0">
                                    <input class="form-control <?php echo ($validation->hasError('password2')) ? 'is-invalid' : ''; ?>" id="password2" type="password" placeholder="Confirm password" name="password2" />
                                    <div class="invalid-feedback"><?= $validation->getError('password2'); ?></div>
                                 </div>
                              </div>
                           </div>
                           <div class="mt-4 mb-0">
                              <div class="d-grid">
                                 <button class="btn btn-primary" type="submit">Create Account</button>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="card-footer text-center py-3">
                        <div class="small"><a href="/auth">Have an account? Login</a></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
   </div>
</div>
<?= $this->endSection(); ?>
