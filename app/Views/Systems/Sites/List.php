<?= $this->extend(config('SitesConfig')->themes); ?>

<?= $this->section('title'); ?>
Sites Management
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<form class="form w-100" action="<?= base_url("systems/users/save") ?>" method="post">
   <?= csrf_field() ?>
   <div class="card card-bordered">
      <div class="card-header">
         <div class="card-title m-0">
            <h3 class="fw-bold m-0">Sites</h3>
         </div>
      </div>
      <div class="card-body">
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">Sites Title</span>
            </label>
            <input type="text" class="form-control form-control-sm form-control-solid" name="">
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">Site have Hompegage</span>
            </label>
            <div class="form-check form-switch">
               <input class="form-check-input" type="checkbox" role="switch" id="" value="active" name="status_cd">
               <label class="form-check-label" for=""></label>
            </div>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">Organizations</span>
            </label>
            <div class="form-check form-switch">
               <input class="form-check-input" type="checkbox" role="switch" id="" value="active" name="status_cd">
               <label class="form-check-label" for=""></label>
            </div>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">User's can Register</span>
            </label>
            <div class="form-check form-switch">
               <input class="form-check-input" type="checkbox" role="switch" id="" value="active" name="status_cd">
               <label class="form-check-label" for=""></label>
            </div>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">Email Verification</span>
            </label>
            <input type="text" class="form-control form-control-sm form-control-solid" name="">
         </div>
      </div>
      <div class="card-footer  d-flex justify-content-end gap-2 py-3">
         <button type="submit" class="btn btn-sm btn-primary">Save</button>
      </div>
   </div>
</form>

<form class="form w-100" action="<?= base_url("systems/users/save") ?>" method="post">
   <?= csrf_field() ?>
   <div class="card card-bordered mt-5">
      <div class="card-header">
         <div class="card-title m-0">
            <h3 class="fw-bold m-0">Images</h3>
         </div>
      </div>
      <div class="card-body">
         <div class="fv-row mb-5">
            <div class="dropzone" id="upload-image">
               <div class="dz-message needsclick">
                  <i class="bi bi-cloud-arrow-up-fill fs-3x text-primary"></span></i>
                  <div class="ms-4">
                     <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                     <span class="fs-7 fw-semibold text-gray-400">Accepted file: favicon.ico, logo-light.png, logo-dark.png, auth-banner.png</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
<?= $this->endSection(); ?>


<?= $this->section('extra_js'); ?>
<script>
   "use strict";
   const handleUploadFile = () => {
      var uploadFile = new Dropzone("#upload-image", {
         url: "#", // Set the url for your upload script location
         paramName: "file",
         maxFiles: 4,
         maxFilesize: 1, // MB
         addRemoveLinks: true,
         acceptedFiles: "image/*",
         accept: function(file, done) {
            if (file.name != "favicon.ico") {
               done("Naha, you don't.");
            } else {
               done();
            }
         }
      });
   }
   const MAIN = function() {
      return {
         init: function() {
            handleUploadFile();
         }
      };
   }();


   KTUtil.onDOMContentLoaded(function() {
      MAIN.init();
   });
</script>

<?= $this->endSection(); ?>