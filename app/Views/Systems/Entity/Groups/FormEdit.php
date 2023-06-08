<?= $this->extend(config('SitesConfig')->themes); ?>
<?= $this->section('title'); ?>
Edit - Groups Management
<?= $this->endSection(); ?>

<?= $this->section('buttons'); ?>
<a href="<?= base_url("systems/groups") ?>" type="button" class="btn btn-sm btn-bg-light btn-icon-muted btn-text-muted py-1"><i class="bi bi-arrow-left-circle-fill"></i>Back</a>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<?php if (isset($data) && count($data) > 0) : ?>
   <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
         <button class="nav-link active" id="nav-groups-tab" data-bs-toggle="tab" data-bs-target="#nav-groups" type="button">Groups</button>
         <button class="nav-link" id="nav-groups-menus-tab" data-bs-toggle="tab" data-bs-target="#nav-groups-menus" type="button">Groups Menus</button>
      </div>
   </nav>
   <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active card card-bordered rounded-0" id="nav-groups">
         <form class="form w-100" action="<?= base_url("systems/groups/update") ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="group_id" value="<?= encrypt_text($data['id']) ?>">
            <div class="card">
               <div class="card-body">
                  <div class="mb-5">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span class="required">Group name</span>
                     </label>
                     <input class="form-control form-control-sm form-control-solid" placeholder="Enter a group name" name="title" value="<?= $data['title'] ?>">
                  </div>
                  <div class="mb-5">
                     <label class="fs-7 fw-bold form-label mb-2">
                        <span>Description</span>
                     </label>
                     <input class="form-control form-control-sm form-control-solid" placeholder="Enter a group description" name="description" value="<?= $data['description'] ?>">
                  </div>
               </div>
               <div class="card-footer  d-flex justify-content-end gap-2 py-3">
                  <button type="submit" class="btn btn-sm btn-primary">Save</button>
               </div>
            </div>
         </form>
      </div>
      <div class="tab-pane fade card card-bordered rounded-0" id="nav-groups-menus">
         <div class="card">
            <div class="card-body pb-0">
               <label class="fs-7 fw-bold form-label mb-2">
                  <span class="required">Menu</span>
               </label>
               <div class="row">
                  <div class="col-11">
                     <input type="hidden" id="parent_menu_id" value="<?= encrypt_text(0) ?>">
                     <select id="menu_id" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
                        <option></option>
                        <?php if (isset($menu) && count($menu) > 0) : ?>
                           <?php foreach ($menu as $key => $value) : ?>
                              <?php $mark_parent = $value['modules'] == '#' || $value['routes'] == '#' ? ' - Parents' : '';  ?>
                              <option value="<?= encrypt_text($value['id']) ?>"><?= $value['name'] . $mark_parent ?></option>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </select>
                  </div>
                  <div class="col-1">
                     <button type="button" class="btn btn-sm btn-primary w-100 btn-add-menu-group">Add</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="separator my-4"></div>
         <div class="card">
            <div class="card-body pt-0">
               <label class="fs-7 fw-bold form-label mb-4">
                  Group Menu List
               </label>
               <?php if (isset($group_menu_list) && count($group_menu_list) > 0) : ?>
                  <?php foreach ($group_menu_list as $key => $value) : ?>

                     <div class="d-flex flex-stack">
                        <div class="symbol symbol-35px me-4">
                           <div class="symbol-label fs-2 fw-semibold bg-success text-inverse-success"><?= $value['name'][0] ?></div>
                        </div>
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                           <div class="flex-grow-1 me-2">
                              <span class="text-gray-800 text-hover-primary fs-7"><?= $value['name'] ?></span>
                              <span class="text-muted fw-semibold d-block fs-9"><?= $value['modules'] == '#' || $value['routes'] == '#'  ? 'Parent Menu' : 'Single Menu' ?></span>
                           </div>
                           <?php if ($value['modules'] != '#' || $value['routes'] != '#') : ?>
                              <div class="flex-grow-1">
                                 <div class="row">
                                    <div class="col-lg-2 col-sm-6">
                                       <label class="form-check form-switch form-check-custom form-check-solid">
                                          <input class="form-check-input check-access" type="checkbox" value="1" data-id="<?= encrypt_text($value['id']) ?>" data-access="create" <?= ($value['can_create'] == 1 ? 'checked="checked"' : '') ?>>
                                          <span class="form-check-label fw-semibold text-nowrap text-muted">
                                             Create
                                          </span>
                                       </label>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                       <label class="form-check form-switch form-check-custom form-check-solid">
                                          <input class="form-check-input check-access" type="checkbox" value="1" data-id="<?= encrypt_text($value['id']) ?>" data-access="read" <?= ($value['can_read'] == 1 ? 'checked="checked"' : '') ?>>
                                          <span class="form-check-label fw-semibold text-nowrap text-muted">
                                             Read
                                          </span>
                                       </label>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                       <label class="form-check form-switch form-check-custom form-check-solid">
                                          <input class="form-check-input check-access" type="checkbox" value="1" data-id="<?= encrypt_text($value['id']) ?>" data-access="update" <?= ($value['can_update'] == 1 ? 'checked="checked"' : '') ?>>
                                          <span class="form-check-label fw-semibold text-nowrap text-muted">
                                             Update
                                          </span>
                                       </label>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                       <label class="form-check form-switch form-check-custom form-check-solid">
                                          <input class="form-check-input check-access" type="checkbox" value="1" data-id="<?= encrypt_text($value['id']) ?>" data-access="delete" <?= ($value['can_delete'] == 1 ? 'checked="checked"' : '') ?>>
                                          <span class="form-check-label fw-semibold text-nowrap text-muted">
                                             Delete
                                          </span>
                                       </label>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                       <label class="form-check form-switch form-check-custom form-check-solid">
                                          <input class="form-check-input check-access" type="checkbox" value="1" data-id="<?= encrypt_text($value['id']) ?>" data-access="visibility" <?= ($value['visibility'] == 1 ? 'checked="checked"' : '') ?>>
                                          <span class="form-check-label fw-semibold text-nowrap text-muted">
                                             Visibility
                                          </span>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                           <?php else : ?>
                              <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px me-2 btn-view-menu-group" data-menu-name="<?= $value['name'] ?>" data-parent-menu-id="<?= encrypt_text($value['menu_id']) ?>" data-group-id="<?= encrypt_text($value['group_id']) ?>">
                                 <i class="fa fa-eye"></i>
                              </button>
                           <?php endif; ?>
                           <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px btn-delete-menu-group" data-id="<?= encrypt_text($value['id']) ?>">
                              <i class="fa fa-trash"></i>
                           </button>
                        </div>
                     </div>
                     <div class="separator separator-dashed my-4"></div>
                  <?php endforeach; ?>
               <?php else : ?>
                  <div class="d-flex flex-stack"><span class="text-muted">No data</span></div>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
   <div class="modal modal-xl fade" tabindex="-1" id="app-modal-menu">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header p-3">
               <h3 class="modal-title"></h3>
               <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fa fa-xmark fs-1"></i>
               </div>
            </div>
            <div class="modal-body p-3">
               <label class="fs-7 fw-bold form-label mb-2">
                  <span class="required">Menu</span>
               </label>
               <div class="row">
                  <div class="col-11">
                     <input type="hidden" id="modal_group_id">
                     <input type="hidden" id="modal_parent_menu_id">
                     <select id="modal_menu_id" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
                        <option></option>
                        <?php if (isset($menu) && count($menu) > 0) : ?>
                           <?php foreach ($menu as $key => $value) : ?>
                              <?php $mark_parent = $value['modules'] == '#' || $value['routes'] == '#' ? ' - Parents' : '';  ?>
                              <option value="<?= encrypt_text($value['id']) ?>"><?= $value['name'] . $mark_parent ?></option>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </select>
                  </div>
                  <div class="col-1">
                     <button type="button" class="btn btn-sm btn-primary w-100 btn-modal-add-menu-group">Add</button>
                  </div>
               </div>
               <div class="separator separator-dashed my-4"></div>
               <div class="card card-bordered">
                  <div class="card-header align-items-center py-2 px-2 gap-2 gap-md-5">
                     <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                           <span class="position-absolute ms-4"><i class="bi bi-search"></i></span>
                           <input type="text" data-kt-filter="search" class="form-control form-control-sm form-control-solid w-250px ps-14" placeholder="Search Menu" />
                        </div>
                     </div>
                     <div class="card-toolbar flex-row-fluid justify-content-end gap-2">
                        <div id="apps_datatable_buttons" class="d-none"></div>
                     </div>
                  </div>
                  <div class="card-body px-0 py-0">
                     <table id="apps_datatable" class="table table-sm table-striped table-row-bordered gy-3 gs-7 w-100">
                        <colgroup>
                           <col>
                           <col width="5%">
                           <col width="5%">
                           <col width="5%">
                           <col width="5%">
                           <col width="5%">
                           <col width="10%">
                        </colgroup>
                        <thead>
                           <tr>
                              <th>Menu Name</th>
                              <th>Create</th>
                              <th>Read</th>
                              <th>Update</th>
                              <th>Delete</th>
                              <th>Visibility</th>
                              <th></th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php endif; ?>
<?= $this->endSection(); ?>

<?= $this->section('extra_js'); ?>
<script>
   "use strict";

   const MAIN = function() {
      let el_modal_menu = document.getElementById('app-modal-menu');
      let modal_menu = new bootstrap.Modal(el_modal_menu, {
         keyboard: false,
         backdrop: 'static',
      });

      const handleButtonViewMenuGroup = () => {
         $(document).on('click', '.btn-view-menu-group', function(e) {

            let menu_nm = $(this).data('menu-name');
            let menu_id = $(this).data('parent-menu-id');
            let group_id = $(this).data('group-id');
            let options = {
               "select": false,
               "processing": true,
               "serverSide": true,
               "ajax": $.fn.dataTable.pipeline({
                  url: host_url + '/datatable_menulist?menu_id=' + menu_id + '&group_id=' + group_id,
                  pages: 5
               }),
               "columnDefs": [{
                     className: 'dt-center',
                     targets: [1, 2, 3, 4, 5, 6]
                  }, {
                     className: 'dt-right',
                     targets: [6]
                  },
                  {
                     target: -1,
                     orderable: false,
                     searchable: false,
                  }
               ]
            };

            APPCoreDatatable.init(options);

            $('.modal-title').html('Child Menu of ' + menu_nm);
            $('#modal_group_id').val(group_id);
            $('#modal_parent_menu_id').val(menu_id);
            modal_menu.show();
         });
      }

      const handleButtonAddMenuGroup = () => {
         $(document).on('click', '.btn-add-menu-group', function(e) {
            let group_id = $('#group_id').val();
            let parent_menu_id = $('#parent_menu_id').val();
            let menu_id = $('#menu_id').val();
            $.ajax({
               url: `${host_url}/addgroupmenu`,
               type: 'POST',
               data: {
                  group_id,
                  parent_menu_id,
                  menu_id
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
         });
      }

      const handleButtonAddMenuGroupChild = () => {
         $(document).on('click', '.btn-modal-add-menu-group', function(e) {
            let group_id = $('#modal_group_id').val();
            let parent_menu_id = $('#modal_parent_menu_id').val();
            let menu_id = $('#modal_menu_id').val();
            $.ajax({
               url: `${host_url}/addgroupmenu`,
               type: 'POST',
               data: {
                  group_id,
                  parent_menu_id,
                  menu_id
               },
               dataType: 'JSON',
               success: function(response) {
                  if (response.status == 'success') {
                     Swal.fire({
                        text: "Success",
                        icon: "success",
                        confirmButtonText: "Ok"
                     }).then(() => {
                        apps_datatable.ajax.url(host_url + '/datatable_menulist?menu_id=' + parent_menu_id + '&group_id=' + group_id).load();
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

      const handleButtonDeleteMenuGroup = () => {
         $(document).on('click', '.btn-delete-menu-group', function(e) {
            Swal.fire({
               text: "Apa anda yakin akan menghapus menu ini",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonText: 'Ya, Hapus',
               cancelButtonText: 'Batalkan'
            }).then((result) => {
               if (result.isConfirmed) {
                  let id = $(this).data('id');
                  $.ajax({
                     url: `${host_url}/deletegroupmenu`,
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
                              if ($('#app-modal-menu').css('display') == 'block') {
                                 let group_id = $('#modal_group_id').val();
                                 let parent_menu_id = $('#modal_parent_menu_id').val();
                                 apps_datatable.ajax.url(host_url + '/datatable_menulist?menu_id=' + parent_menu_id + '&group_id=' + group_id).load();
                              } else {
                                 location.reload();
                              }
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

      const handleCheckAccess = () => {
         $(document).on('change', '.check-access', function(e) {
            let id = $(this).data('id');
            let access = $(this).data('access');
            let state = $(this).is(':checked') ? 1 : 0;
            $.ajax({
               url: `${host_url}/changegroupmenuaccess`,
               type: 'POST',
               data: {
                  id,
                  access,
                  state
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
            }).fail(function(jqXHR, textStatus, errorThrown) {
               Swal.fire({
                  html: 'Error',
                  icon: "error",
                  confirmButtonText: "Ok"
               });
            });

         });
      }

      return {
         init: function() {
            handleButtonViewMenuGroup();
            handleButtonAddMenuGroup();
            handleButtonAddMenuGroupChild();
            handleButtonDeleteMenuGroup();

            handleCheckAccess();
         }
      };
   }();


   KTUtil.onDOMContentLoaded(function() {
      MAIN.init();
   });
</script>
<?= $this->endSection(); ?>