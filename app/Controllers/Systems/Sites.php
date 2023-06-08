<?php

namespace App\Controllers\Systems;

use App\Controllers\BaseController;

class Sites extends BaseController
{
    public function getIndex()
    {
        return view('Systems/Sites/List');
    }
}
