<?php

namespace App\Libraries\Systems;

use App\Models\Systems\MenusModel;
use App\Models\Systems\GroupsModel;
use App\Models\Systems\GroupsUsersModel;
use App\Models\Systems\GroupsMenusModel;

class AuthAccess
{
   protected $groupsModel;
   protected $GroupsMenusModel;
   protected $GroupsUsersModel;

   public function __construct()
   {
      $this->groupsModel      = new GroupsModel();
      $this->GroupsMenusModel = new GroupsMenusModel();
      $this->GroupsUsersModel = new GroupsUsersModel();
   }

   public function getAuthAccessMenuByUser()
   {
      $user     = auth()->user();
      $group_id = session()->has('group_id') ? decrypt_text(session()->get('group_id')) : 0;
      $menu_id  = session()->has('active_menu_id') ? decrypt_text(session()->get('active_menu_id')) : 0;

      if ($user->inGroup($group_id)) {
         return $this->GroupsMenusModel->select('can_create, can_read, can_update, can_delete')->where('group_id', $group_id)->where('menu_id', $menu_id)->get()->getResultArray();
      }

      return [];
   }

   public function getAuthAccessMenuByGroup()
   {
      $group_id = config('AuthGroups')->defaultGroup;
      $user     = auth()->user();

      if (session()->has('group_id') && intval(decrypt_text(session()->get('group_id'))) > 0) {
         $group_id    = decrypt_text(session()->get('group_id'));
      } else {
         $data = $this->GroupsUsersModel->select('group')->where('user_id', auth()->id())->where('is_default', 1)->get()->getFirstRow('array');

         if ($data !== null) {
            $group_id = $data['group'];
         }
         session()->set('group_id', encrypt_text($group_id));
      }

      $groups = $this->groupsModel->select('title')->where('id', $group_id)->get()->getFirstRow('array');
      if ($groups !== null) {
         session()->set('group_name', $groups['title']);
      }

      if ($user->inGroup($group_id)) {
         $menuModel = new MenusModel();
         $menu      = $menuModel->GroupMenu($group_id);
         if (is_array($menu) && count($menu) > 0) {
            return $this->generateMenu(render_trees($menu));
         }
      }


      return;
   }

   public function getAuthAccessButtons()
   {
      $access  = auth_access();
      $buttons = [];
      if (count($access) > 0) {
         foreach ($access as $key => $value) {
            if ($value['can_create'] == 1) {
               $buttons[] = '<button id="auth-btn-add" type="button" class="btn btn-sm btn-primary py-1">Add</button>';
            }

            if ($value['can_update'] == 1) {
               $buttons[] = '<button id="auth-btn-edit" type="button" class="btn btn-sm btn-primary py-1">Edit</button>';
            }

            if ($value['can_delete'] == 1) {
               $buttons[] = '<button id="auth-btn-delete" type="button" class="btn btn-sm btn-danger py-1">Delete</button>';
            }
         }
      }

      return join("", $buttons);
   }

   private function generateMenu($menus)
   {
      $menu = [];
      if (is_array($menus) && count($menus) > 0) {
         $iter = 0;
         foreach ($menus as $parents => $parent) {
            $modules   = strtolower($parent['modules']);
            $routes    = strtolower($parent['routes']);
            $icons     = strtolower($parent['icons']);
            $isActive  = session()->has("active_menu_id") && decrypt_text(session()->get("active_menu_id")) == $parent['id'] ? 'active' : '';
            $url       = '#';
            if (strlen($modules) > 0 && strlen($routes) > 0) {
               $url       = join("/", [$modules, $routes]);
               if ($routes != '#') {
                  session()->set("menu_id_" . $modules . "_" . $routes, encrypt_text($parent['id']));
               }
            }

            if (isset($parent['children']) && count($parent['children']) > 0) {
               $menu_children = [];
               foreach ($parent['children'] as $childrens => $children) {
                  $menu_children[$children['id']] = $this->generateMenu($parent['children']);
                  $arr_child[] = $children['id'];
               }

               $menu[] = $this->generateMenuItem($parent['id'], $parent['name'], $url, 'multiple', array_unique(array_filter($menu_children)), $isActive, $icons, $arr_child);
            } else {
               $menu[] = $this->generateMenuItem($parent['id'], $parent['name'], $url, 'single', [], $isActive, $icons);
            }
            $iter++;
         }
      }

      return join("", $menu);
   }


   private function generateMenuItem($id, $name, $url, $type, $children, $isActive, $icons, $arr_child = [])
   {
      if ($type == "single") {
         return "<div class='menu-item'><a class='menu-link $isActive' href='" . base_url($url) . "'><span class='menu-icon'><span class='bi $icons fs-4'></span></span><span class='menu-title'>" . $name . "</span></a></div>";
      }

      if ($type == "multiple") {
         $isShow = session()->has("active_menu_id") && in_array(decrypt_text(session()->get("active_menu_id")), $arr_child) ? 'show' : '';
         return "<div data-kt-menu-trigger='click' class='menu-item menu-accordion $isShow'><span class='menu-link'><span class='menu-icon'><span class='bi $icons fs-4'></span></span><span class='menu-title'>" . $name . "</span><span class='menu-arrow'></span></span><div class='menu-sub menu-sub-accordion $isShow'>" . join("", $children) . "</div></div>";
      }
   }
}
