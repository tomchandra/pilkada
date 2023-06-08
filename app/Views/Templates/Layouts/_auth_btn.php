<?php if (count(auth_access()) > 0) : ?>
   <?php foreach (auth_access() as $key => $value) : ?>
      <?php if ($value['can_create'] == 1) : ?>
         <button id="auth-btn-add" type="button" class="btn btn-sm btn-primary py-1">Add</button>
      <?php endif; ?>
      <?php if ($value['can_update'] == 1) : ?>
         <button id="auth-btn-edit" type="button" class="btn btn-sm btn-primary py-1">Edit</button>
      <?php endif; ?>
      <?php if ($value['can_delete'] == 1) : ?>
         <button id="auth-btn-delete" type="button" class="btn btn-sm btn-danger py-1">Delete</button>
      <?php endif; ?>
   <?php endforeach; ?>
   <?= $this->section('extra_js'); ?>
   <script src="<?= base_url("assets/js/fn.auth.btn.js") ?>"></script>
   <?= $this->endSection(); ?>
<?php endif ?>