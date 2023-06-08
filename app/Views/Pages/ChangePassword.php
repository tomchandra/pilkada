<?= $this->extend(config('SitesConfig')->themes); ?>

<?= $this->section('title'); ?>
Change Password
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<form class="form w-100" action="<?= base_url("pages/changepassword/save") ?>" method="post">
   <?= csrf_field() ?>
   <input type="hidden" id="score" name="score" value="<?= old('score') ?>">
   <div class="card card-bordered">
      <div class="card-body">
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">Old Password</span>
            </label>
            <input type="password" class="form-control form-control-sm form-control-solid" name="old_password" autocomplete="current-password" value="<?= old('old_password') ?>">
         </div>
         <div class="mb-5">
            <div id="password_meter" class="fv-row" data-kt-password-meter="true">
               <div class="mb-1">
                  <label class="form-label fw-bold fs-7 mb-2">
                     <span class="required">New Password</span>
                  </label>
                  <div class="position-relative mb-3">
                     <input class="form-control form-control-sm form-control-solid" type="password" placeholder="" name="new_password" autocomplete="off" value="<?= old('new_password') ?>" />
                     <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye fs-2"></i>
                        <i class="bi bi-eye-slash d-none fs-2"></i>
                     </span>
                  </div>
                  <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                     <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                     <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                     <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                     <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                  </div>
               </div>
               <div class="text-muted">
                  Use 8 or more characters with a mix of letters, numbers & symbols.
               </div>
            </div>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">Confirm New Password</span>
            </label>
            <input type="password" class="form-control form-control-sm form-control-solid" name="confirm_password" autocomplete="new-password" value="<?= old('confirm_password') ?>">
         </div>
      </div>
      <div class="card-footer  d-flex justify-content-end gap-2 py-3">
         <button type="submit" id="btn-change-password" class="btn btn-sm btn-primary">Save</button>
      </div>
   </div>
</form>
<?= $this->endSection(); ?>


<?= $this->section('extra_js'); ?>
<script>
   "use strict";
   const handlePasswordMeter = () => {
      $(document).on('keyup', '[name="new_password"]', function(e) {
         const passwordMeterElement = document.querySelector("#password_meter");
         const passwordMeter = KTPasswordMeter.getInstance(passwordMeterElement);
         const score = passwordMeter.getScore();

         $('#score').val(score);
      });
   }

   const MAIN = function() {
      return {
         init: function() {
            handlePasswordMeter();
         }
      };
   }();


   KTUtil.onDOMContentLoaded(function() {
      MAIN.init();
   });
</script>
<?= $this->endSection(); ?>