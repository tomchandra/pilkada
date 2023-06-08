<!DOCTYPE html>
<html lang="en">

<head>
   <base href="" />
   <title><?= config('SitesConfig')->title; ?></title>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <?= csrf_meta() ?>

   <link rel="shortcut icon" href="<?= base_url(config('SitesConfig')->favicon) ?>" />
   <link href="<?= base_url("themes/default/assets/css/font.face.css") ?>" rel="stylesheet" type="text/css" />

   <link href="<?= base_url("themes/default/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css") ?>" rel="stylesheet" type="text/css" />
   <link href="<?= base_url("themes/default/assets/plugins/custom/datatables/datatables.bundle.css") ?>" rel="stylesheet" type="text/css" />

   <link href="<?= base_url("themes/default/assets/plugins/global/plugins.bundle.css") ?>" rel="stylesheet" type="text/css" />
   <link href="<?= base_url("themes/default/assets/css/style.bundle.css") ?>" rel="stylesheet" type="text/css" />
   <?= $this->renderSection('extra_css'); ?>
   <style>
      div.dataTables_wrapper div#apps_datatable_length {
         padding: 1rem 5px;
      }

      tr.dtrg-group {
         font-weight: 600;
         text-transform: uppercase;
         pointer-events: none;
         background-color: #ececec !important;
      }

      .tl.tl-2 {
         position: relative;
         padding: 0;
         margin: 0;
      }

      .tl.tl-2 .tl-bar {
         background-color: #EBEDF3;
         position: absolute;
         display: block;
         content: "";
         width: 3px;
         top: -20px;
         bottom: 5px;
         left: 5px;
         z-index: 0;
         margin: 0.5rem 0;
      }

      .tl.tl-2 .tl-item {
         display: -webkit-box;
         display: -ms-flexbox;
         display: flex;
         -webkit-box-align: center;
         -ms-flex-align: center;
         align-items: center;
         padding: 0.5rem 0;
      }

      .tl.tl-2 .tl-item .tl-badge {
         position: relative;
         z-index: 1;
         display: block;
         width: 14px;
         height: 14px;
         border-radius: 100%;
         background-color: #fff;
         border: 3px solid #E4E6EF;
         -ms-flex-negative: 0;
         flex-shrink: 0;
         margin-right: 0.5rem;
         top: 2px;
      }

      .tl.tl-2 .tl-item .tl-badge.active {
         border: 3px solid steelblue;
      }

      .tl.tl-2 .tl-item .tl-content {
         -webkit-box-flex: 1;
         -ms-flex-positive: 1;
         flex-grow: 1;
         min-height: 60px;
      }

      [data-kt-shown-toggle="on"] {
         display: flex !important;
      }
   </style>
   <script>
      if (window.top != window.self) {
         window.top.location.replace(window.self.location.href);
      }
   </script>
</head>

<body id="kt_body" class="header-tablet-and-mobile-fixed aside-enabled" <?= isset($hidden_menu) && $hidden_menu ? "data-kt-aside-minimize='on'" : "" ?>>
   <script>
      var defaultThemeMode = "light";
      var themeMode;
      if (document.documentElement) {
         if (document.documentElement.hasAttribute("data-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-theme-mode");
         } else {
            if (localStorage.getItem("data-theme") !== null) {
               themeMode = localStorage.getItem("data-theme");
            } else {
               themeMode = defaultThemeMode;
            }
         }
         if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
         }
         document.documentElement.setAttribute("data-theme", themeMode);
      }
   </script>

   <div class="d-flex flex-column flex-root">
      <div class="page d-flex flex-row flex-column-fluid">
         <?= $this->include('templates/layouts/_sidebar'); ?>
         <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <?= $this->include('templates/layouts/_header'); ?>
            <?= $this->include('templates/layouts/_content'); ?>
            <?= $this->include('templates/layouts/_footer'); ?>
         </div>
      </div>
   </div>
   <?= $this->include('templates/layouts/_drawer'); ?>
   <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
      <span class="btn btn-icon btn-sm btn-active-color-primary">
         <i class="bi bi-arrow-up-circle-fill"></i>
      </span>
   </div>

   <?= $this->include('templates/layouts/_modal'); ?>

   <script>
      "use strict";
      let base_url = '<?= base_url(); ?>';
      let host_url = '<?= session()->get('current_page') ?>';
      // let modules = '<?= session()->get('current_modules') ?>';
      let xhr_status = '<?= auth()->loggedIn(); ?>';
      let datetime = new Date('<?= date("Y-m-d H:i:s"); ?>');
   </script>

   <script src="<?= base_url("themes/default/assets/plugins/global/plugins.bundle.js") ?>"></script>
   <script src="<?= base_url("themes/default/assets/js/scripts.bundle.js") ?>"></script>
   <script src="<?= base_url("themes/default/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js") ?>"></script>
   <script src="<?= base_url("themes/default/assets/plugins/custom/datatables/datatables.bundle.js") ?>"></script>
   <script src="<?= base_url("assets/js/fn.datatable.pipeline.js") ?>"></script>
   <script src="<?= base_url("assets/js/fn.core.js") ?>"></script>
   <script src="<?= base_url("assets/js/fn.core.function.js") ?>"></script>
   <script src="<?= base_url("assets/js/fn.auth.btn.js") ?>"></script>
   <?= $this->renderSection('extra_js'); ?>
</body>

</html>