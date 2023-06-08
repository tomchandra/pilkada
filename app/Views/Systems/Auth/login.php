<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>
<?= lang('Auth.login') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="d-flex flex-center flex-column flex-lg-row-fluid">
   <div class="w-lg-500px p-10">
      <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="<?= url_to('login') ?>" method="post">
         <?= csrf_field() ?>
         <div class="text-center mb-11">

            <h1 class="text-dark fw-bolder mb-3"><?= lang('Auth.login') ?></h1>

            <?php if (session('error') !== null) : ?>
               <div class="alert alert-danger" role="alert">
                  <?= session('error') ?>
               </div>
            <?php elseif (session('errors') !== null) : ?>
               <div class="alert alert-danger" role="alert">
                  <?php if (is_array(session('errors'))) : ?>
                     <?php foreach (session('errors') as $error) : ?>
                        <?= $error ?>
                        <br>
                     <?php endforeach ?>
                  <?php else : ?>
                     <?= session('errors') ?>
                  <?php endif ?>
               </div>
            <?php endif ?>

            <?php if (session('message') !== null) : ?>
               <div class="alert alert-success" role="alert">
                  <?= session('message') ?>
               </div>
            <?php endif ?>
         </div>

         <?php if (config('SitesConfig')->allowAuthWithGoogle) : ?>
            <div class="row g-3 mb-9">
               <div class="col-md-12">
                  <a href="<?= base_url("oauth/google") ?>" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                     <img alt="Logo" src="<?= base_url("themes/default/assets/media/svg/brand-logos/google-icon.svg") ?>" class="h-15px me-3" />
                     Sign in with Google
                  </a>
               </div>
            </div>
            <div class="separator separator-content my-14">
               <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
            </div>
         <?php endif ?>
         <div class="fv-row mb-8">
            <input type="text" placeholder="Email" name="email" class="form-control bg-transparent" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
         </div>
         <div class="fv-row mb-3">
            <input type="password" placeholder="Password" name="password" class="form-control bg-transparent" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required />
         </div>
         <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
               <div class="form-check">
                  <label class="form-check-label">
                     <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked<?php endif ?>>
                     <?= lang('Auth.rememberMe') ?>
                  </label>
               </div>
            <?php endif; ?>
            <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
               <a href="<?= url_to('magic-link') ?>" class="link-primary"><?= lang('Auth.forgotPassword') ?></a>
            <?php endif ?>
         </div>
         <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary"><?= lang('Auth.login') ?></button>
         </div>
         <?php if (setting('Auth.allowRegistration')) : ?>
            <div class="text-gray-500 text-center fw-semibold fs-6">
               <?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>" class="link-primary"><?= lang('Auth.register') ?></a>
            </div>
         <?php endif ?>
      </form>
   </div>
</div>
<?= $this->endSection() ?>