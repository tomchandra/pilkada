<?= $this->extend(config('SitesConfig')->themes); ?>

<?= $this->section('title'); ?>
TPS
<?= $this->endSection(); ?>

<?= $this->section('buttons'); ?>
<?= auth_buttons() ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="card card-bordered">
   <div class="card-header align-items-center py-2 px-2 gap-2 gap-md-5">
      <div class="card-title">
         <div class="d-flex align-items-center position-relative my-1">
            <span class="position-absolute ms-4"><i class="bi bi-search"></i></span>
            <input type="text" data-kt-filter="search" class="form-control form-control-sm form-control-solid w-250px ps-14" placeholder="Search TPS" />
         </div>
      </div>
      <div class="card-toolbar flex-row-fluid justify-content-end gap-2">
         <button type="button" class="btn btn-sm btn-light-primary py-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"><i class="bi bi-cloud-arrow-up-fill fs-4 me-2"></i>Export</button>
         <div id="apps_datatable_export" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
            <div class="menu-item px-3">
               <a href="#" class="menu-link px-3" data-kt-export="copy">
                  Copy to clipboard
               </a>
            </div>
            <div class="menu-item px-3">
               <a href="#" class="menu-link px-3" data-kt-export="excel">
                  Export as Excel
               </a>
            </div>
            <div class="menu-item px-3">
               <a href="#" class="menu-link px-3" data-kt-export="csv">
                  Export as CSV
               </a>
            </div>
            <div class="menu-item px-3">
               <a href="#" class="menu-link px-3" data-kt-export="pdf">
                  Export as PDF
               </a>
            </div>
         </div>
         <div id="apps_datatable_buttons" class="d-none"></div>
      </div>
   </div>
   <div class="card-body px-0 py-0">
      <table id="apps_datatable" class="table table-sm table-striped table-row-bordered gy-3 gs-7 w-100">
         <colgroup>
            <col width="10%">
            <col width="30%">
            <col width="30%">
         </colgroup>
         <thead>
            <tr>
               <th>#</th>
               <th>Nama TPS</th>
               <th>Lokasi TPS</th>
               <th>Waktu Mulai</th>
               <th>Waktu Selesai</th>
               <th>Kuota</th>
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