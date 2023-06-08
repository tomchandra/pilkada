"use strict";
let app_row_data = [];
let app_row_id = null;
let apps_table, apps_datatable;

const APPSCore = function() {   
   const initAjax = () => {
      $.ajaxSetup({
         headers: {
            "X-CSRF-TOKEN": $('meta[name="X-CSRF-TOKEN"]').attr("content"),
         },
         complete: function(xhr,status) {
            if(xhr_status != "1"){
               location.reload();               
            }
         }
      });
   };
   
   const initSelectedTab = () => {

      $('button[data-bs-toggle="tab"]').on("shown.bs.tab", function (e) {
         var id = $(e.target).attr("id");
         localStorage.setItem('selectedTab', id)
      });

      var selectedTab = localStorage.getItem('selectedTab');
      if (selectedTab != null && document.querySelector('#'+selectedTab)) {
         var someTabTriggerEl = document.querySelector('#'+selectedTab)
         var tab = new bootstrap.Tab(someTabTriggerEl)

         tab.show()
      }
   }
   
   const initDate = () => {
      $(".app-date").flatpickr();
      $(".app-date-time").flatpickr({
         enableTime: true,
         dateFormat: "Y-m-d H:i",
         time_24hr: true
      });
   }
   
   const initUpdateClock = () => { 
      const today = new Date();
      let h = today.getHours() < 10 ? "0"+today.getHours() : today.getHours();
      let m = today.getMinutes() < 10 ? "0"+today.getMinutes() : today.getMinutes();
      let s = today.getSeconds() < 10 ? "0"+today.getSeconds() : today.getSeconds();
      
      document.getElementById('app-clock').innerHTML =  h + " : " + m + " : " + s;
      
      setTimeout(initUpdateClock, 1000);
   }

   return {
      init: function() {
         initAjax();
         initSelectedTab();
         initDate();
         
         initUpdateClock();
      }
   };
}();

const APPCoreDatatable = function() {

   const initDatatable = (customs_options) => {
      let options = {
         'destroy': true,
         'info': true,
         'order': [
            [0, 'asc']
         ],
         'lengthChange': true,
         'pageLength': 25,
         'select': true,
         "autoWidth": false,
         ...customs_options
      };

      apps_datatable = $(apps_table).DataTable(options);
   }

   const exportButtons = () => {
      const documentTitle = 'Report ' + $('.app-page-title').text();
      var buttons = new $.fn.dataTable.Buttons(apps_table, {
         buttons: [{
               extend: 'copyHtml5',
               title: documentTitle
            },
            {
               extend: 'excelHtml5',
               title: documentTitle,
               exportOptions: {
                  modifier: {
                     page: 'all',
                     search: 'none',
                  }
               }
            },
            {
               extend: 'csvHtml5',
               title: documentTitle
            },
            {
               extend: 'pdfHtml5',
               title: documentTitle
            }
         ]
      }).container().appendTo($('#apps_datatable_buttons'));

      const exportButtons = document.querySelectorAll('#apps_datatable_export [data-kt-export]');
      exportButtons.forEach(exportButton => {
         exportButton.addEventListener('click', e => {
            e.preventDefault();
            const exportValue = e.target.getAttribute('data-kt-export');
            const target = document.querySelector('.dt-buttons .buttons-' + exportValue);
            target.click();
         });
      });
   }

   const handleSearchDatatable = () => {
      const filterSearch = document.querySelector('[data-kt-filter="search"]');
      filterSearch.addEventListener('keyup', function(e) {
         apps_datatable.search(e.target.value).draw();
      });
   }

   const handleClickRowDatatable = (apps_table) => {
      $(apps_table).find('tbody').on('click', 'tr', function() {
         app_row_data = apps_datatable.row(this).data();
         app_row_id = app_row_data !== undefined && app_row_data.length > 0 ? app_row_data[app_row_data.length-1] : null;
      });
   }
   
   const handleReorderRowDatatable = (apps_table) => {
         $(apps_table).on( 'row-reorder', function ( e, diff, edit ) {
        var result = 'Reorder started on row: '+edit.triggerRow.data()[1]+'<br>';
 
        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            var rowData = table.row( diff[i].node ).data();
 
            result += rowData[1]+' updated to be in position '+
                diff[i].newData+' (was '+diff[i].oldData+')<br>';
        }
 
       console.log(result);
    } );
   }

   return {
      init: function(options = {}) {
         apps_table = document.querySelector('#apps_datatable');

         if (!apps_table) {
            return;
         }

         initDatatable(options);
         exportButtons();
         handleSearchDatatable();
         handleClickRowDatatable(apps_table);
         handleReorderRowDatatable(apps_table);
      }
   };
}();

KTUtil.onDOMContentLoaded(function() {
   APPSCore.init();
   APPAuthButtons.init();
});