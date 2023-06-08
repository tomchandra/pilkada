<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <title>PILKADA</title>
   <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
   <link href="<?= base_url("themes/default/assets/plugins/global/plugins.bundle.css") ?>" rel="stylesheet" type="text/css" />
   <link href="<?= base_url("themes/default/assets/css/style.bundle.css") ?>" rel="stylesheet" type="text/css" />
   <link href="<?= base_url("themes/default/assets/css/homepage.styles.css") ?>" rel="stylesheet" type="text/css" />
   <style>
      .swal2-modal {
         width: 40% !important;
      }

      .swal2-html-container {
         min-height: 250px !important;
      }
   </style>
</head>

<body id="page-top" style="background-image: url(<?= base_url('themes/default/assets/bg.png') ?>); background-size:cover">
   <!-- Navigation-->
   <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
      <div class="container px-5">
         <a class="navbar-brand fw-bold" href="#page-top">Pilkada</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="bi-list"></i>
         </button>
         <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
            </ul>
            <a href="<?= base_url("/login") ?>" target="_blank" class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0">
               <span class="d-flex align-items-center">
                  <i class="bi-chat-text-fill me-2"></i>
                  <span class="small">Masuk</span>
               </span>
            </a>
         </div>
      </div>
   </nav>
   <!-- Mashead header-->
   <header class="masthead">
      <div class="container px-5">
         <div class="row gx-5 align-items-center">
            <div class="col-lg-6">
               <!-- Mashead text and app badges-->
               <div class="mb-5 mb-lg-0 text-center text-lg-start">
                  <p class="lead fw-normal text-muted">Dapatkan informasi lokasi dan jadwal TPS anda!</p>
                  <div class="input-group mb-3">
                     <input type="number" class="form-control" id="nik" placeholder="Input NIK Anda" aria-describedby="basic-addon2">
                     <div class="input-group-append">
                        <button id="btn-search-nik" class="btn btn-primary" type="button">Cari</button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <!-- Masthead device mockup feature-->
               <div class="masthead-device-mockup">
                  <svg class="circle" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                     <defs>
                        <linearGradient id="circleGradient" gradientTransform="rotate(45)">
                           <stop class="gradient-start-color" offset="0%"></stop>
                           <stop class="gradient-end-color" offset="100%"></stop>
                        </linearGradient>
                     </defs>
                     <circle cx="50" cy="50" r="50"></circle>
                  </svg><svg class="shape-1 d-none d-sm-block" viewBox="0 0 240.83 240.83" xmlns="http://www.w3.org/2000/svg">
                     <rect x="-32.54" y="78.39" width="305.92" height="84.05" rx="42.03" transform="translate(120.42 -49.88) rotate(45)"></rect>
                     <rect x="-32.54" y="78.39" width="305.92" height="84.05" rx="42.03" transform="translate(-49.88 120.42) rotate(-45)"></rect>
                  </svg><svg class="shape-2 d-none d-sm-block" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                     <circle cx="50" cy="50" r="50"></circle>
                  </svg>
                  <div class="device-wrapper">
                     <div class="device" data-device="iPhoneX" data-orientation="portrait" data-color="black">
                        <div class="screen">
                           <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="<?= base_url("assets/images/sites/bg-auth.png") ?>" alt="" />
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </header>
   <script src="<?= base_url("themes/default/assets/plugins/global/plugins.bundle.js") ?>"></script>
   <script src="<?= base_url("themes/default/assets/js/scripts.bundle.js") ?>"></script>
   <script>
      "use strict";
      let host_url = '<?= session()->get('current_page') ?>';
      const MAIN = function() {

         const handleSearch = () => {
            $(document).on('click', '#btn-search-nik', function() {
               $.ajax({
                  url: `<?= base_url('/search') ?>`,
                  type: 'GET',
                  data: {
                     nik: $('#nik').val()
                  },
                  dataType: 'json',
                  success: function(response) {
                     if (response.status == 'success') {
                        Swal.fire({
                           html: response.message,
                           //icon: "info",
                           buttonsStyling: false,
                           showCancelButton: true,
                           confirmButtonText: "Ok",
                           cancelButtonText: 'Batal',
                           customClass: {
                              confirmButton: "btn btn-primary",
                              cancelButton: 'btn btn-danger'
                           }
                        });
                     } else {
                        Swal.fire({
                           html: 'NIK Tidak ditemukan',
                           icon: "warning",
                           confirmButtonText: "Ok"
                        });
                     }
                  }
               });
            });
         }

         return {
            init: function() {
               handleSearch();
            }
         };
      }();


      KTUtil.onDOMContentLoaded(function() {
         MAIN.init();
      });
   </script>
</body>

</html>