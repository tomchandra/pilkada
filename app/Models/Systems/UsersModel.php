<?php

namespace App\Models\Systems;

use CodeIgniter\Shield\Models\UserModel;

class UsersModel extends UserModel
{
   protected $allowedFields  = [
      'username',
      'status',
      'status_message',
      'active',
      'last_active',
      'deleted_at',
      'first_name',
      'last_name',
      'avatar',
      'scope',
   ];
}
