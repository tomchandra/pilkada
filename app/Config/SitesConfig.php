<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class SitesConfig extends BaseConfig
{
   public string $themes      = 'Templates/theme';
   public string $favicon     = 'themes/default/assets/media/logos/favicon.ico';
   public string $logoSmall   = 'themes/default/assets/media/logos/logo-hospital-light.png';
   public string $logoLarge   = 'themes/default/assets/media/logos/logo-hospital.png';
   public string $banner      = 'themes/default/assets/media/misc/auth-bg.png';
   public string $title       = 'Pilkada';

   public bool $allowAuthWithGoogle = false;
   public bool $haveHomepage = false;

   public bool $isHaveEntity     = false;
   public string $defaultEntity  = 'NAME';
}
