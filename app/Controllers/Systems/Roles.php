<?php

namespace App\Controllers\Systems;

use App\Controllers\BaseController;
use App\Models\Systems\RolesModel;

use \Hermawan\DataTables\DataTable;

class Roles extends BaseController
{
    protected $RolesModel;


    public function __construct()
    {
        $this->RolesModel = new RolesModel();
    }
    public function getIndex()
    {
        return view('Systems/Entity/Roles/List');
    }

    public function getDatatable()
    {
        $builder = $this->RolesModel->select('name, status_cd, permission_id')->where('status_cd !=', 'nullified');
        return DataTable::of($builder)->edit('permission_id', function ($row) {
            return encrypt_text($row->id);
        })->addNumbering()->toJson();
    }
}
