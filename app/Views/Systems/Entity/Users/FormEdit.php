<?= $this->extend(config('SitesConfig')->themes); ?>
<?= $this->section('title'); ?>
Edit - User Management
<?= $this->endSection(); ?>

<?= $this->section('buttons'); ?>
<a href="<?= base_url("systems/users") ?>" type="button" class="btn btn-sm btn-bg-light btn-icon-muted btn-text-muted py-1"><i class="bi bi-arrow-left-circle-fill"></i>Back</a>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<?php if (isset($data) && count($data) > 0) : ?>

   <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
         <button class="nav-link active" id="nav-users-tab" data-bs-toggle="tab" data-bs-target="#nav-users" type="button">Users</button>
         <button class="nav-link" id="nav-users-groups-tab" data-bs-toggle="tab" data-bs-target="#nav-users-groups" type="button">Users Groups</button>
         <button class="nav-link" id="nav-users-permissions-tab" data-bs-toggle="tab" data-bs-target="#nav-users-permissions" type="button">Users Permissions</button>
         <button class="nav-link" id="nav-users-logs-tab" data-bs-toggle="tab" data-bs-target="#nav-users-logs" type="button">Users Logs</button>
      </div>
   </nav>
   <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active card card-bordered rounded-0" id="nav-users">
         <form class="form w-100" action="<?= base_url("systems/users/update") ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" id="user_id" name="user_id" value="<?= encrypt_text($data['user_id']) ?>">
            <div class="card">
               <div class="card-body">
                  <div class="mb-5">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span class="required">Email</span>
                     </label>
                     <input class="form-control form-control-sm form-control-solid" name="secret" value="<?= $data['secret'] ?>">
                  </div>
                  <div class="mb-5">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span>First Name</span>
                     </label>
                     <input class="form-control form-control-sm form-control-solid" name="first_name" value="<?= $data['first_name'] ?>">
                  </div>
                  <div class="mb-5">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span>Last Name</span>
                     </label>
                     <input class="form-control form-control-sm form-control-solid" name="last_name" value="<?= $data['last_name'] ?>">
                  </div>
               </div>
               <div class="card-footer  d-flex justify-content-end gap-2 py-3">
                  <a href="<?= base_url("systems/users") ?>" type="button" class="btn btn-sm btn-light-primary">Cancel</a>
                  <button type="submit" class="btn btn-sm btn-primary">Save</button>
               </div>
            </div>
         </form>
      </div>
      <div class="tab-pane fade card card-bordered rounded-0" id="nav-users-groups">
         <div class="card">
            <div class="card-body pb-0">
               <label class="fs-7 fw-bold form-label mb-2">
                  <span class="required">Group</span>
               </label>
               <div class="row">
                  <div class="col-11">
                     <select id="group_id" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
                        <option></option>
                        <?php if (isset($groups) && count($groups) > 0) : ?>
                           <?php foreach ($groups as $key => $value) : ?>
                              <option value="<?= encrypt_text($value['id']) ?>"><?= $value['title'] ?></option>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </select>
                  </div>
                  <div class="col-1">
                     <button type="button" class="btn btn-sm btn-primary w-100 btn-add-user-group">Add</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="separator my-4"></div>
         <div class="card">
            <div class="card-body pt-0">
               <label class="fs-7 fw-bold form-label mb-4">
                  Group User List
               </label>
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
                        <colgroup>
                           <col width="5%">
                           <col>
                           <col width="40%">
                           <col width="5%">
                           <col width="5%">
                        </colgroup>
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Descriptions</th>
                              <th>Default</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="tab-pane fade card card-bordered rounded-0" id="nav-users-permissions">
         <div class="card">

            <div class="card-body">
               <label class="fs-7 fw-bold form-label mb-4">
                  User Access
               </label>
               <div class="card card-bordered mb-5">
                  <div class="card-body p-2">
                     <?php if (isset($access) && count($access) > 0) : ?>
                        <div class="gap-2">
                           <?php if ($access['isInActive']) : ?>
                              <button type="button" class="btn btn-sm btn-primary py-1 btn-user-access" data-access="activatinguser">Activing User</button>
                           <?php else : ?>
                              <button type="button" class="btn btn-sm btn-danger py-1 btn-user-access" data-access="deactivatinguser">In-active User</button>
                           <?php endif; ?>
                           <?php if ($access['isBanned']) : ?>
                              <button type="button" class="btn btn-sm btn-primary py-1 btn-user-access" data-access="unbanninguser">Un-banning User</button>
                           <?php else : ?>
                              <button type="button" class="btn btn-sm btn-danger py-1 btn-user-access" data-access="banninguser">Banning User</button>
                           <?php endif; ?>
                           <?php if ($access['isPassReset']) : ?>
                              <button type="button" class="btn btn-sm btn-primary py-1 btn-user-access" data-access="undoforcechangepassword">Un-Force Change Password</button>
                           <?php else : ?>
                              <button type="button" class="btn btn-sm btn-danger py-1 btn-user-access" data-access="forcechangepassword">Force Change Password</button>
                           <?php endif; ?>
                        </div>
                        <div id="container_banMassage" class="mt-5 <?= ($access['isBanned'] ? '' : 'd-none') ?>">
                           <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                              <i class="bi bi-shield-fill-exclamation fs-2hx text-danger me-4"></span></i>
                              <div class="d-flex flex-column">
                                 <h4 class="mb-1 text-danger">This Account is Banned</h4>
                                 <span><?= $access['banMassage'] ?></span>
                              </div>
                           </div>
                        </div>
                     <?php endif; ?>
                  </div>
               </div>
               <div class="card mt-5">
                  <div class="card-body p-0">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span class="required">Role</span>
                     </label>
                     <div class="row">
                        <div class="col-11">
                           <select id="group_id" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
                              <option></option>
                              <?php if (isset($roles) && count($roles) > 0) : ?>
                                 <?php foreach ($roles as $key => $value) : ?>
                                    <option value="<?= encrypt_text($value['id']) ?>"><?= $value['role'] ?></option>
                                 <?php endforeach; ?>
                              <?php endif; ?>
                           </select>
                        </div>
                        <div class="col-1">
                           <button type="button" class="btn btn-sm btn-primary w-100 btn-add-user-group">Add</button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="separator my-4"></div>
               <label class="fs-7 fw-bold form-label mb-4">
                  User Roles
               </label>
               <div class="card card-bordered">
                  <div class="card-body">

                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="tab-pane fade card card-bordered rounded-0" id="nav-users-logs">
         <div class="card">
            <div class="card-body">D</div>
         </div>
      </div>
   </div>


<?php endif; ?>
<?= $this->endSection(); ?>

<?= $this->section('extra_js'); ?>
<script>
   "use strict";
   const handleViewUserGroup = () => {
      let user_id = $('#user_id').val();
      let options = {
         "select": false,
         "processing": true,
         "serverSide": true,
         "ajax": $.fn.dataTable.pipeline({
            url: host_url + '/datatable_grouplist?user_id=' + user_id,
            pages: 5
         })
      };

      APPCoreDatatable.init(options);
   }

   const handleButtonAddUserGroup = () => {
      $(document).on('click', '.btn-add-user-group', function(e) {
         let group = $('#group_id').val();
         let user_id = $('#user_id').val();
         $.ajax({
            url: `${host_url}/addgroupuser`,
            type: 'POST',
            data: {
               group,
               user_id
            },
            dataType: 'JSON',
            success: function(response) {
               if (response.status == 'success') {
                  Swal.fire({
                     text: "Success",
                     icon: "success",
                     confirmButtonText: "Ok"
                  }).then(() => {
                     apps_datatable.ajax.url(host_url + '/datatable_grouplist?user_id=' + user_id).load();
                  });
               } else {
                  Swal.fire({
                     html: _parseErrors(response.message),
                     icon: "error",
                     confirmButtonText: "Ok"
                  });
               }
            }
         });
      });
   }

   const handleButtonDeleteUserGroup = () => {
      $(document).on('click', '.btn-delete-user-group', function(e) {
         Swal.fire({
            text: "Apa anda yakin akan menghapus menu ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batalkan'
         }).then((result) => {
            if (result.isConfirmed) {
               let id = $(this).data('id');
               let user_id = $('#user_id').val();
               $.ajax({
                  url: `${host_url}/deletegroupuser`,
                  type: 'POST',
                  data: {
                     id
                  },
                  dataType: 'JSON',
                  success: function(response) {
                     if (response.status == 'success') {
                        Swal.fire({
                           text: "Success",
                           icon: "success",
                           confirmButtonText: "Ok"
                        }).then(() => {
                           apps_datatable.ajax.url(host_url + '/datatable_grouplist?user_id=' + user_id).load();
                        });
                     } else {
                        Swal.fire({
                           html: _parseErrors(response.message),
                           icon: "error",
                           confirmButtonText: "Ok"
                        });
                     }
                  }
               });
            }
         });
      });
   }

   const handleSetDafultUserGroup = () => {
      $(document).on('change', '.is_default_group', function(e) {
         if ($(this).is(':checked')) {
            let user_id = $(this).data('user-id');
            let group_id = $(this).data('group-id');
            $.ajax({
               url: `${host_url}/setdefaultgroupuser`,
               type: 'POST',
               data: {
                  user_id,
                  group_id
               },
               dataType: 'JSON',
               success: function(response) {
                  if (response.status == 'success') {

                  } else {
                     Swal.fire({
                        html: _parseErrors(response.message),
                        icon: "error",
                        confirmButtonText: "Ok"
                     });
                  }
               }
            });
         }
      });
   }

   const handleButtonUserAccess = () => {
      $(document).on('click', '.btn-user-access', function(e) {
         let access = $(this).data('access');
         let user_id = $('#user_id').val();

         $.ajax({
            url: `${host_url}/${access}`,
            type: 'POST',
            data: {
               user_id
            },
            dataType: 'JSON',
            success: function(response) {
               if (response.status == 'success') {
                  Swal.fire({
                     text: "Success",
                     icon: "success",
                     confirmButtonText: "Ok"
                  }).then(() => {
                     location.reload();
                  });
               } else {
                  Swal.fire({
                     html: _parseErrors(response.message),
                     icon: "error",
                     confirmButtonText: "Ok"
                  });
               }
            }
         });
         console.log(access);
      });
   }

   const MAIN = function() {
      return {
         init: function() {
            handleViewUserGroup();
            handleButtonAddUserGroup();
            handleButtonDeleteUserGroup();
            handleSetDafultUserGroup();
            handleButtonUserAccess();

            $('button[data-bs-toggle="tab"]').on('click', function(e) { // here is the new selected tab id     
               var selectedTabId = e.target.id;
               console.log('tab changed', selectedTabId);

            });
         }
      };
   }();


   KTUtil.onDOMContentLoaded(function() {
      MAIN.init();
   });
</script>
<?= $this->endSection(); ?>