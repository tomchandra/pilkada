<?= $this->extend(config('SitesConfig')->themes); ?>
<?= $this->section('title'); ?>
Add - Kuota TPS
<?= $this->endSection(); ?>

<?= $this->section('buttons'); ?>
<a href="<?= base_url("pages/kuotatps") ?>" type="button" class="btn btn-sm btn-bg-light btn-icon-muted btn-text-muted py-1"><i class="bi bi-arrow-left-circle-fill"></i>Back</a>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<form class="form w-100" action="<?= base_url("pages/kuotatps/save") ?>" method="post">
   <?= csrf_field() ?>
   <div class="card card-bordered">
      <div class="card-body">
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>TPS</span>
            </label>
            <select name="kode_tps" id="prov" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
               <option></option>
               <?php if (count($tps) > 0) : ?>
                  <?php foreach ($tps as $key => $value) : ?>
                     <option value="<?= $value['kode_tps']; ?>"><?= $value['nama_tps'] ?> [<?= $value['alamat_tps'] ?>]
                     </option>
                  <?php endforeach; ?>
               <?php endif; ?>
            </select>
         </div>
         <div class="mb-5">
            <div class="row">
               <div class="col-6">
                  <label class="fs-7 fw-bold form-label mb-2">
                     <span>Waktu Mulai</span>
                  </label>
                  <input class="form-control form-control-sm form-control-solid app-date-time" name="waktu_mulai">
               </div>
               <div class="col-6">
                  <label class="fs-7 fw-bold form-label mb-2">
                     <span>Waktu Selesai</span>
                  </label>
                  <input class="form-control form-control-sm form-control-solid app-date-time" name="waktu_selesai">
               </div>
            </div>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>Kuota</span>
            </label>
            <input class="form-control form-control-sm form-control-solid" type="number" min="0" name="kuota_tps">
         </div>
         <div class="card-footer  d-flex justify-content-end gap-2 py-3">
            <button type="submit" class="btn btn-sm btn-primary">Save</button>
         </div>
      </div>
</form>
<?= $this->endSection(); ?>

<?= $this->section('extra_js'); ?>

<script>
   "use strict";

   const MAIN = function() {

      return {
         init: function() {

         }
      };
   }();


   KTUtil.onDOMContentLoaded(function() {
      MAIN.init();
   });
</script>
<?= $this->endSection(); ?>