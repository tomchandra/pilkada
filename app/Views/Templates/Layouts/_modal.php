<?= $this->renderSection('modal'); ?>

<!-- MODAL CRUD -->
<div class="modal bg-white fade" tabindex="-1" id="app-modal-crud">
   <div class="modal-dialog modal-fullscreen">
      <div class="modal-content shadow-none">
         <div class="modal-header">
            <h3 class="modal-title"></h3>
         </div>
         <div class="modal-body">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" id="app-btn-act-save" class="btn btn-sm btn-primary">Save</button>
         </div>
      </div>
   </div>
</div>
<!-- END MODAL CRUD -->