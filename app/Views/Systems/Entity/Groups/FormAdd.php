<?= $this->extend(config('SitesConfig')->themes); ?>
<?= $this->section('title'); ?>
Add - Groups Management
<?= $this->endSection(); ?>

<?= $this->section('buttons'); ?>
<a href="<?= base_url("systems/groups") ?>" type="button" class="btn btn-sm btn-bg-light btn-icon-muted btn-text-muted py-1"><i class="bi bi-arrow-left-circle-fill"></i>Back</a>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<form class="form w-100" action="<?= base_url("systems/groups/save") ?>" method="post">
   <?= csrf_field() ?>
   <div class="card card-bordered">
      <div class="card-body">
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">Group name</span>
            </label>
            <input class="form-control form-control-sm form-control-solid" placeholder="Enter a group name" name="title" value="<?= old('title') ?>">
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>Description</span>
            </label>
            <input class="form-control form-control-sm form-control-solid" placeholder="Enter a group description" name="description" value="<?= old('description') ?>">
         </div>
      </div>
      <div class="card-footer  d-flex justify-content-end gap-2 py-3">
         <a href="<?= base_url("systems/groups") ?>" type="button" class="btn btn-sm btn-light-primary">Cancel</a>
         <button type="submit" class="btn btn-sm btn-primary">Save</button>
      </div>
   </div>
</form>
<?= $this->endSection(); ?>

<?= $this->section('extra_js'); ?>

<?= $this->endSection(); ?>