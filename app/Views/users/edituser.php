<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
   <div class="row">
      <div class="col-4">
         <form action="/users/update/<?= $user['id']; ?>" method="post">
            <?= csrf_field(); ?>
            <div class="my-3">
               <input type="hidden" name="id" value="<?= $user['id']; ?>">
               <select class="form-select" aria-label="Default select example" name="level">
                  <option selected>Change Level User</option>
                  <option value="1">Admin</option>
                  <option value="2">Member</option>
               </select>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
         </form>
      </div>
   </div>
</div>
<?= $this->endSection(); ?>

