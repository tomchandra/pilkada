<?= $this->extend(config('SitesConfig')->themes); ?>

<?= $this->section('title'); ?>
Switch Group
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="card card-bordered">
   <div class="card-header align-items-center py-2 px-2 gap-2 gap-md-5">
      <div class="card-title">
         <div class="d-flex align-items-center position-relative my-1">
            <span class="position-absolute ms-4"><i class="bi bi-search"></i></span>
            <input type="text" data-kt-filter="search" class="form-control form-control-sm form-control-solid w-250px ps-14" placeholder="Search Group" />
         </div>
      </div>
      <div class="card-toolbar flex-row-fluid justify-content-end gap-2">
         <div id="apps_datatable_buttons" class="d-none"></div>
      </div>
   </div>
   <div class="card-body px-0 py-0">
      <table id="apps_datatable" class="table table-sm table-striped table-row-bordered gy-3 gs-7 w-100">
         <thead>
            <tr>
               <th>Groups</th>
               <th></th>
            </tr>
         </thead>
      </table>
   </div>
</div>
<?= $this->endSection(); ?>


<?= $this->section('extra_js'); ?>
<script>
   "use strict";

   const MAIN = function() {
      return {
         init: function() {
            let options = {
               "processing": true,
               "serverSide": true,
               "ajax": $.fn.dataTable.pipeline({
                  method: 'POST',
                  url: host_url + '/datatable',
                  pages: 5
               }),
               columnDefs: [{
                  target: -1,
                  visible: false,
                  searchable: false,
               }],
            };

            APPCoreDatatable.init(options);
         }
      };
   }();


   KTUtil.onDOMContentLoaded(function() {
      MAIN.init();
   });
</script>

<?= $this->endSection(); ?>