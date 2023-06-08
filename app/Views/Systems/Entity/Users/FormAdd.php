<?= $this->extend(config('SitesConfig')->themes); ?>
<?= $this->section('title'); ?>
Add - User Management
<?= $this->endSection(); ?>

<?= $this->section('buttons'); ?>
<a href="<?= base_url("systems/user") ?>" type="button" class="btn btn-sm btn-bg-light btn-icon-muted btn-text-muted py-1"><i class="bi bi-arrow-left-circle-fill"></i>Back</a>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<form class="form w-100" action="<?= base_url("systems/users/save") ?>" method="post">
   <?= csrf_field() ?>
   <div class="card card-bordered">
      <div class="card-body">
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">Email</span>
            </label>
            <input type="text" class="form-control form-control-sm form-control-solid" name="secret" value="<?= old('secret') ?>">
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>First Name</span>
            </label>
            <input type="text" class="form-control form-control-sm form-control-solid" name="first_name" value="<?= old('first_name') ?>">
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>Last Name</span>
            </label>
            <input type="text" class="form-control form-control-sm form-control-solid" name="last_name" value="<?= old('last_name') ?>">
         </div>
      </div>
      <div class="card-footer  d-flex justify-content-end gap-2 py-3">
         <button type="submit" class="btn btn-sm btn-primary">Save</button>
      </div>
   </div>
</form>
<?= $this->endSection(); ?>

<?= $this->section('extra_js'); ?>

<?= $this->endSection(); ?>