<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Systems\GroupsModel;
use \Hermawan\DataTables\DataTable;

class SwitchGroups extends BaseController
{
   protected $GroupsModel;


   public function __construct()
   {
      $this->GroupsModel = new GroupsModel();
   }

   public function getIndex()
   {
      return view('Pages/SwitchGroups');
   }

   public function getChange($group_id = 0)
   {
      if (intval(decrypt_text($group_id)) > 0) {
         $groupsModel = new GroupsModel();
         $groups      = $groupsModel->select('title')->where('id', decrypt_text($group_id))->get()->getFirstRow('array');
         if ($groups !== null) {
            session()->set('group_name', $groups['title']);
         }

         session()->set('group_id', $group_id);
         return redirect()->to("/");
      }
   }

   public function postDatatable()
   {
      $user       = auth()->user();
      $in_groups  = $user->getGroups();
      $builder    = $this->GroupsModel->select('title, id')->whereIn('id', $in_groups);

      return DataTable::of($builder)->edit('title', function ($row) {
         return '<a href="' . base_url("pages/switchgroups/change/" . encrypt_text($row->id)) . '">' . $row->title . '</a>';
      })->toJson();
   }
}
