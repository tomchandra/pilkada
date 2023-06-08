<!DOCTYPE html>
<html lang="en">

<head>
   <title><?= $this->renderSection('title'); ?></title>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />

   <link rel="shortcut icon" href="<?= base_url(config('sitesConfig')->favicon) ?>" />
   <link href="<?= base_url("themes/default/assets/css/font.face.css") ?>" rel="stylesheet" type="text/css" />
   <link href="<?= base_url("themes/default/assets/plugins/global/plugins.bundle.css") ?>" rel="stylesheet" type="text/css" />
   <link href="<?= base_url("themes/default/assets/css/style.bundle.css") ?>" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="auth-bg">
   <div class="d-flex flex-column flex-root">
      <div class="d-flex flex-column flex-lg-row flex-column-fluid">
         <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <?= $this->renderSection('main'); ?>
         </div>
         <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(<?= base_url(config('sitesConfig')->banner) ?>)">
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
               <!-- <a href="<?= base_url("/") ?>" class="mb-0 mb-lg-12">
                  <img alt="Logo" src="<?= base_url(config('sitesConfig')->logoLarge) ?>" class="h-60px h-lg-75px" />
               </a> -->
               <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="<?= base_url("assets/images/sites/bg-auth.png") ?>" alt="" />
            </div>
         </div>
      </div>
   </div>

   <script src="<?= base_url("themes/default/assets/plugins/global/plugins.bundle.js ") ?>"></script>
   <script src="<?= base_url("themes/default/assets/js/scripts.bundle.js ") ?>"></script>
   <?= $this->renderSection('script'); ?>
</body>

</html>