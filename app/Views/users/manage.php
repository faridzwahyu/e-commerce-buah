<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
   <div class="row">
      <div class="col">
         <h4 class="my-3">Daftar User</h4>
         <table class="table table-striped text-center tabel-buah">
            <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama User</th>
                  <th scope="col">Email</th>
                  <th scope="col">Level</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $i = 1; ?>
               <?php foreach($user as $u) : ?>
               <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $u['name']; ?></td>
                  <td><?= $u['email']; ?></td>
                  <td><?= ($u['role_id'] == 1) ? 'Admin' : 'Member'; ?></td>
                  <?php if(session()->get('email') != $u['email'] && $u['email'] != 'admin') : ?>
                  <td><a href="/users/edit/<?= $u['id']; ?>" class="btn btn-primary btn-sm">Edit</a> | 
                  <form action="/users/<?= $u['id']; ?>" method="post" class="d-inline">
                     <?= csrf_field(); ?>
                     <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">Delete</button>
                  </form></td>
                  <?php else : ?>
                        <td></td>
                  <?php endif; ?>
               </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?= $this->endSection(); ?>