<div class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#app-drawer-org" data-kt-drawer-close="#kt_drawer_example_dismiss_close" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '350px'}">
   <div class="card rounded-0 w-100">

      <div class="card-header">
         <div class="card-title w-100">
            <div class="flex-column-auto w-100">
               <div class="d-flex align-items-center w-100">
                  <form class="w-100 position-relative" autocomplete="off">
                     <span class="search-icon position-absolute top-50 translate-middle-y ms-4">
                        <i class="bi bi-search fs-5"></i>
                     </span>
                     <input type="text" class="search-input form-control form-control-solid ps-13 fs-7 h-40px" name="search" value="" placeholder="Search Organization" />
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="card-body hover-scroll-overlay-y py-3">
         <?php if (isset($orgs) && count($orgs) > 0) : ?>
            <table class="table align-middle gy-1 text-uppercase">
               <?php foreach ($orgs as $items => $item) : ?>
                  <tr>
                     <td>
                        <a href="<?= base_url("systems/groups/orgs/{$item['id']}") ?>" class="btn btn-sm btn-light-primary mb-2 w-100 text-start fw-bold fs-8">
                           <i class="fonticon-layers me-1"></i>
                           <?= $item['name'] ?>
                        </a>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </table>
         <?php endif; ?>
      </div>
      <div class="card-footer py-2">
         <button class="btn btn-sm btn-light-secondary w-100 text-gray-800" data-kt-drawer-dismiss="true">Close</button>
      </div>

   </div>
</div>