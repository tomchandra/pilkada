<?= $this->extend(config('SitesConfig')->themes); ?>
<?= $this->section('title'); ?>
Edit - Menu Management
<?= $this->endSection(); ?>

<?= $this->section('buttons'); ?>
<a href="<?= base_url("systems/menus") ?>" type="button" class="btn btn-sm btn-bg-light btn-icon-muted btn-text-muted py-1"><i class="bi bi-arrow-left-circle-fill"></i>Back</a>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<?php if (isset($data) && count($data) > 0) : ?>
   <form class="form w-100" action="<?= base_url("systems/menus/update") ?>" method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="id" value="<?= encrypt_text($data['id']) ?>">
      <div class="card card-bordered">
         <div class="card-body">
            <div class="mb-5">
               <label class="fs-7 fw-bold form-label mb-2">
                  <span class="required">Menu name</span>
               </label>
               <input class="form-control form-control-sm form-control-solid" name="name" value="<?= $data['name'] ?>">
            </div>
            <div class="mb-5">
               <div class="row">
                  <div class="col-lg-6">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span>Modules</span>
                     </label>
                     <input class="form-control form-control-sm form-control-solid" name="modules" value="<?= $data['modules'] ?>">
                  </div>
                  <div class="col-lg-6">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span>Routes</span>
                     </label>
                     <input class="form-control form-control-sm form-control-solid" name="routes" value="<?= $data['routes'] ?>">
                  </div>
               </div>
            </div>
            <div class="mb-5">
               <div class="row">
                  <div class="col-lg-12">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span>Icons</span>
                     </label>
                     <select name="icons" id="icons" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
                        <option></option>
                        <?php if (count(bootstrap_icons()) > 0) : ?>
                           <?php foreach (bootstrap_icons() as $key => $value) : ?>
                              <option value="bi-<?= $value; ?>" data-select2-icons="bi bi-<?= $value ?>" <?= ($data['icons'] == "bi-" . $value ? "selected" : "") ?>><?= $value ?></option>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </select>
                  </div>
               </div>
            </div>
            <div class="mb-5">
               <div class="row">
                  <div class="col-lg-6">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span>Status</span>
                     </label>
                     <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="statusCd" <?= ($data['status_cd'] == 'active' ? "checked='checked'" : "") ?> value="active" name="status_cd">
                        <label class="form-check-label" for="statusCd"></label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="card-footer  d-flex justify-content-end gap-2 py-3">
            <a href="<?= base_url("systems/menus") ?>" type="button" class="btn btn-sm btn-light-primary">Cancel</a>
            <button type="submit" class="btn btn-sm btn-primary">Save</button>
         </div>
      </div>
   </form>
<?php endif; ?>
<?= $this->endSection(); ?>

<?= $this->section('extra_js'); ?>
<script>
   "use strict";

   const handleSelec2Icons = () => {
      var optionFormat = function(item) {
         if (!item.id) {
            return item.text;
         }

         var span = document.createElement('span');
         var icons = item.element.getAttribute('data-select2-icons');
         var template = '';

         template = '<i class="' + icons + ' fs-2"></i>';
         template += '<span class="ms-2" style="vertical-align:text-bottom;">' + item.text + '</span>';

         span.innerHTML = template;

         return $(span);
      }

      $('#icons').select2({
         templateSelection: optionFormat,
         templateResult: optionFormat
      });

   }
   const MAIN = function() {
      return {
         init: function() {
            handleSelec2Icons();
         }
      };
   }();


   KTUtil.onDOMContentLoaded(function() {
      MAIN.init();
   });
</script>
<?= $this->endSection(); ?>