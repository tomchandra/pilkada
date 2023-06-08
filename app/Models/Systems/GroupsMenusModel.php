<?php

namespace App\Models\Systems;

use CodeIgniter\Model;

class GroupsMenusModel extends Model
{
   protected $DBGroup = 'default';
   protected $table = 'auth_groups_menus';
   protected $primaryKey = 'id';
   protected $useAutoIncrement = true;
   protected $insertID = 0;
   protected $returnType = 'array';
   protected $useSoftDeletes = false;
   protected $protectFields = true;
   protected $allowedFields = ['group_id', 'parent_menu_id', 'menu_id', 'can_create', 'can_read', 'can_update', 'can_delete', 'visibility'];

   // Dates
   protected $useTimestamps = false;
   protected $dateFormat = 'datetime';
   protected $createdField = 'created_at';
   protected $updatedField = 'updated_at';
   protected $deletedField = 'deleted_at';

   // Validation
   protected $validationRules = [];
   protected $validationMessages = [];
   protected $skipValidation = false;
   protected $cleanValidationRules = true;

   // Callbacks
   protected $allowCallbacks = true;
   protected $beforeInsert = [];
   protected $afterInsert = [];
   protected $beforeUpdate = [];
   protected $afterUpdate = [];
   protected $beforeFind = [];
   protected $afterFind = [];
   protected $beforeDelete = [];
   protected $afterDelete = [];


   public function GroupMenuList($group_id)
   {
      return $this->builder('auth_groups_menus a')
         ->select('a.id,
            a.menu_id,
            a.group_id,
            b.name,
            b.modules,
            b.routes,
            a.can_create,
            a.can_read,
            a.can_update,
            a.can_delete,
            a.visibility,
            a.order')
         ->join('menus b', 'a.menu_id = b.id', 'left', true)
         ->where('a.group_id', $group_id)
         ->where('a.parent_menu_id', 0)
         ->where('b.status_cd', 'active')
         ->orderBy('a.order', 'asc')
         ->get()
         ->getResultArray();
   }

   public function GroupMenuListChild($group_id, $parent_menu_id)
   {
      return $this->builder('auth_groups_menus a')
         ->select('
            b.name,
            a.can_create,
            a.can_read,
            a.can_update,
            a.can_delete,
            a.visibility,
            a.id,
            a.menu_id,
            a.group_id,
            b.modules,
            b.routes')
         ->join('menus b', 'a.menu_id = b.id', 'left', true)
         ->where('a.group_id', $group_id)
         ->where('a.parent_menu_id', $parent_menu_id)
         ->where('b.status_cd', 'active')
         ->orderBy('a.order', 'asc');
   }
}
