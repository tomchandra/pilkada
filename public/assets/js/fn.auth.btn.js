"use strict";

const APPAuthButtons = function() {
   const handleAuthAddButton = () => {
      $(document).on('click', '#auth-btn-add', function(e) {
         e.preventDefault();
         window.location.href = host_url + '/create';
      });
   }

   const handleAuthEditButton = () => {
      $(document).on('click', '#auth-btn-edit', function(e) {
         e.preventDefault();
         if (app_row_id == null) {
            return Swal.fire({
               html: "Please select the row to modify data!",
               icon: "warning"
            });
         }

         window.location.href = host_url + '/edit/' + app_row_id;
      });
   }

   const handleAuthDeleteButton = () => {
      $(document).on('click', '#auth-btn-delete', function(e) {
         e.preventDefault();
         if (app_row_id == null) {
            return Swal.fire({
               html: "Please select the row to delete data!",
               icon: "warning"
            });
         }

         Swal.fire({
            text: "Are you sure want to delete this data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it',
            cancelButtonText: 'Cancel'
         }).then((result) => {
            $.ajax({
               url: `${host_url}/delete`,
               type: 'POST',
               data: {
                  id:app_row_id,
                  status_cd: 'nullified'
               },
               dataType: 'json',
               success: function(response) {
                  if (response.status == 'success') {
                     Swal.fire({
                        text: "Success",
                        icon: "success",
                        confirmButtonText: "Ok"
                     }).then(() => {
                        window.location.href = host_url;
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
      });
   }

   return {
      init: function() {
         if(host_url !== null){            
            handleAuthAddButton(host_url);
            handleAuthEditButton(host_url);
            handleAuthDeleteButton(host_url);
         }
      }
   };
}();