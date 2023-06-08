<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>
<?= lang('Auth.register') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="d-flex flex-center flex-column flex-lg-row-fluid">
   <div class="w-lg-500px p-10">
      <form class="form w-100" action="<?= url_to('register') ?>" method="post">
         <?= csrf_field() ?>
         <div class="text-center mb-11">
            <h1 class="text-dark fw-bolder mb-3"><?= lang('Auth.register') ?></h1>
            <?php if (session('error') !== null) : ?>
               <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
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
         </div>
         <?php if (setting('Auth.allowAuthWithGoogle')) : ?>
            <div class="row g-3 mb-9">
               <div class="col-md-12">
                  <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
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
            <input type="text" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required class="form-control bg-transparent" />
         </div>
         <div class="fv-row mb-8">
            <input type="text" name="first_name" inputmode="text" autocomplete="first_name" placeholder="First Name" value="<?= old('first_name') ?>" required class="form-control bg-transparent" />
         </div>
         <div class="fv-row mb-8">
            <input type="text" name="last_name" inputmode="text" autocomplete="last_name" placeholder="Last Name" value="<?= old('last_name') ?>" required class="form-control bg-transparent" />
         </div>
         <div class="fv-row mb-8">
            <input type="password" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required class="form-control bg-transparent" />
         </div>
         <div class="fv-row mb-8">
            <input type="password" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required class="form-control bg-transparent" />
         </div>
         <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary"><?= lang('Auth.register') ?></button>
         </div>
         <div class="text-gray-500 text-center fw-semibold fs-6"><?= lang('Auth.haveAccount') ?>
            <a href="<?= url_to('login') ?>" class="link-primary fw-semibold"><?= lang('Auth.login') ?></a>
         </div>
      </form>
   </div>
</div>
<?= $this->endSection() ?>