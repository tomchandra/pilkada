<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
   <div class="post d-flex flex-column-fluid" id="kt_post">
      <div id="kt_content_container" class="container-fluid">
         <?php if (session('error') !== null) : ?>
            <div class="alert alert-danger d-flex align-items-center p-4 mb-5 fs-7">
               <div class="d-flex flex-column">
                  <span><i class="fa fa-light fa-circle-exclamation text-danger me-1"></i> <?= session('error') ?></span>
               </div>
            </div>
         <?php elseif (session('errors') !== null) : ?>
            <div class="alert alert-danger d-flex align-items-center p-4 mb-5 fs-7">
               <div class="d-flex flex-column">
                  <?php foreach (session('errors') as $field => $error) : ?>
                     <span class="mb-1"><i class="fa fa-light fa-circle-exclamation text-danger me-1"></i> <?= esc($error) ?></span>
                  <?php endforeach ?>
               </div>
            </div>
         <?php elseif (session()->getFlashdata('success') !== null) : ?>
            <div class="alert alert-success d-flex align-items-center p-4 mb-5 fs-7">
               <div class="d-flex flex-column">
                  <span><i class="fa fa-light fa-bell text-success me-1"></i> <?= session()->getFlashdata('success') ?></span>
               </div>
            </div>
         <?php endif ?>
         <div class="gap-2 pb-4 d-flex justify-content-end">
            <?= $this->renderSection('buttons'); ?>
         </div>
         <?= $this->renderSection('content'); ?>
      </div>
   </div>
</div>