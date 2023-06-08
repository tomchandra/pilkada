<?php

namespace App\Controllers\Systems;

use App\Controllers\BaseController;
use App\Models\Systems\MenusModel;
use App\Models\Systems\GroupsModel;
use App\Models\Systems\GroupsMenusModel;
use App\Models\Systems\GroupsUsersModel;

use \Hermawan\DataTables\DataTable;

class Groups extends BaseController
{
	protected $GroupsModel;
	protected $MenusModel;
	protected $GroupsMenusModel;
	protected $GroupsUsersModel;
	protected $breadcrumb;

	public function __construct()
	{
		$this->MenusModel  = new MenusModel();
		$this->GroupsModel = new GroupsModel();
		$this->GroupsMenusModel = new GroupsMenusModel();
		$this->GroupsUsersModel = new GroupsUsersModel();
	}

	public function getIndex()
	{
		return view('Systems/Entity/Groups/List');
	}

	public function getCreate()
	{
		return view('Systems/Entity/Groups/FormAdd');
	}

	public function getEdit($id = null)
	{
		$id   = decrypt_text($id);
		$data = $this->GroupsModel->select('id, title, description')->where('id', $id)->get()->getFirstRow('array');
		if ($id !== null && $data !== null) {
			$menu 	  		  = $this->MenusModel->select('id, name, modules, routes')->where('status_cd =', 'active')->orderBy('name', 'asc')->get()->getResultArray();
			$group_menu_list = $this->GroupsMenusModel->GroupMenuList($id);
			$data = [
				'data' => $data,
				'menu' => $menu,
				'group_menu_list' => $group_menu_list
			];

			return view('Systems/Entity/Groups/FormEdit', $data);
		}

		return redirect()->to(site_url("/systems/groups"));
	}

	public function getSyncGroup()
	{
		$this->GroupsModel->syncGroup();
		return redirect()->to(site_url("/systems/groups"));
	}

	public function postSave()
	{
		if ($this->request->is('post')) {
			$data = $this->request->getPost();
			if ($this->GroupsModel->save($data) === false) {
				return redirect()->back()->withInput()->with('errors',  $this->GroupsModel->errors());
			}

			session()->setFlashdata('success', 'Data saved successfully');
			$this->GroupsModel->syncGroup();
			$id = $this->GroupsModel->getInsertID();

			return redirect()->to(site_url("/systems/groups/edit/" . encrypt_text($id)));
		}

		return redirect()->to(site_url("/systems/groups"));
	}

	public function postUpdate()
	{
		if ($this->request->is('post')) {
			$id 		= decrypt_text($this->request->getPost('id'));
			$data 	= $this->request->getPost();
			$dataset = [];
			foreach ($data as $key => $value) {
				$dataset[$key] = $value;
			}

			if (intval($id) > 0 && count($dataset) > 0) {
				if ($this->GroupsModel->update($id, $dataset) === false) {
					return redirect()->back()->withInput()->with('errors',  $this->GroupsModel->errors());
				}
			}

			session()->setFlashdata('success', 'Data changed successfully');
			$this->GroupsModel->syncGroup();

			return redirect()->to(site_url("/systems/groups/edit/" . encrypt_text($id)));
		}

		return redirect()->to(site_url("/systems/groups"));
	}

	public function postDelete()
	{
		if ($this->request->isAJAX()) {
			$id 		= decrypt_text($this->request->getPost('id'));
			$data 	= $this->request->getPost();
			$dataset = [];
			foreach ($data as $key => $value) {
				$dataset[$key] = $value;
			}

			if (intval($id) > 0 && count($dataset) > 0) {
				if ($this->GroupsUsersModel->isGroupsHaveUser($id)) {
					return $this->response->setJSON(["status" => "error", "message" => "Cant delete group because this group have user active"]);
				}

				if ($this->GroupsModel->update($id, $dataset)) {
					return $this->response->setJSON(["status" => "success", "message" => "success"]);
				}
				return $this->response->setJSON(["status" => "error", "message" => $this->GroupsModel->errors()]);
			}
		}
	}

	public function postAddgroupmenu()
	{
		if ($this->request->isAJAX()) {
			$data 	= $this->request->getPost();
			$dataset = [];
			foreach ($data as $key => $value) {
				$dataset[$key] = decrypt_text($value);
				$$key = decrypt_text($value);
			}

			if (count($dataset) > 0) {
				$checkDuplicateMenu = $this->GroupsMenusModel->where('group_id', $group_id)->where('menu_id', $menu_id)->countAllResults();
				if ($checkDuplicateMenu > 0) {
					return json_encode(["status" => "error", "message" => "Duplicate group menu"]);
				}

				$saveGroupMenu = $this->GroupsMenusModel->save($dataset);
				if ($saveGroupMenu) {
					return $this->response->setJSON(["status" => "success", "message" => "success"]);
				}
			}
			return $this->response->setJSON(["status" => "error", "message" => $this->GroupsMenusModel->errors()]);
		}
	}

	public function postDeletegroupmenu()
	{
		if ($this->request->isAJAX()) {
			$id = decrypt_text($this->request->getPost('id'));
			if (intval($id) > 0) {
				$deleteGroupMenu = $this->GroupsMenusModel->where('id', $id)->delete();
				if ($deleteGroupMenu) {
					return $this->response->setJSON(["status" => "success", "message" => "success"]);
				}

				return $this->response->setJSON(["status" => "error", "message" => $this->GroupsMenusModel->errors()]);
			}
		}
	}

	public function postChangegroupmenuaccess()
	{
		if ($this->request->isAJAX()) {
			$id 	  = decrypt_text($this->request->getPost('id'));
			$access = $this->request->getPost('access');
			$state  = $this->request->getPost('state');

			if (intval($id) > 0) {
				if ($access == 'visibility') {
					$changeGroupMenuAccess = $this->GroupsMenusModel->update($id, ['visibility' => $state]);
				} else {
					$changeGroupMenuAccess = $this->GroupsMenusModel->update($id, ['can_' . $access => $state]);
				}

				if ($changeGroupMenuAccess) {
					return $this->response->setJSON(["status" => "success", "message" => "success"]);
				}
				return $this->response->setJSON(["status" => "error", "message" => $this->GroupsMenusModel->errors()]);
			}
		}
	}

	public function postDatatable()
	{
		if ($this->request->isAJAX()) {
			$builder = $this->GroupsModel->select('title, description, id')->where('status_cd !=', 'nullified');
			return DataTable::of($builder)->edit('id', function ($row) {
				return encrypt_text($row->id);
			})->addNumbering()->toJson();
		}
	}

	public function getDatatable_menulist()
	{
		if ($this->request->isAJAX()) {
			$group_id = decrypt_text($this->request->getGet('group_id'));
			$menu_id  = decrypt_text($this->request->getGet('menu_id'));
			$builder  = $this->GroupsMenusModel->GroupMenuListChild($group_id, $menu_id);

			return DataTable::of($builder)->edit('id', function ($row) {
				$btn_add    = '<button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px me-2 btn-view-menu-group" data-menu-name="' . $row->name . '" data-parent-menu-id="' . encrypt_text($row->menu_id) . '" data-group-id="' . encrypt_text($row->group_id) . '"><i class="fa fa-eye"></i></button>';
				$btn_delete = '<button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px me-2 btn-delete-menu-group" data-id="' . encrypt_text($row->id) . '"><i class="fa fa-trash"></i></button>';
				return $row->modules == '#' || $row->routes == '#' ? $btn_add . $btn_delete : $btn_delete;
			})->edit('can_create', function ($row) {
				$check_create = '<label class="form-check form-switch form-check-custom form-check-solid"><input class="form-check-input check-access" type="checkbox" value="1" data-id="' . encrypt_text($row->id) . '" data-access="create" ' . ($row->can_create == 1 ? 'checked="checked"' : '') . '></label>';
				return  $row->modules == '#' || $row->routes == '#' ? '' : $check_create;
			})->edit('can_read', function ($row) {
				$check_read = '<label class="form-check form-switch form-check-custom form-check-solid"><input class="form-check-input check-access" type="checkbox" value="1" data-id="' . encrypt_text($row->id) . '" data-access="read" ' . ($row->can_read == 1 ? 'checked="checked"' : '') . '></label>';
				return $row->modules == '#' || $row->routes == '#' ? '' : $check_read;
			})->edit('can_update', function ($row) {
				$check_update = '<label class="form-check form-switch form-check-custom form-check-solid"><input class="form-check-input check-access" type="checkbox" value="1" data-id="' . encrypt_text($row->id) . '" data-access="update" ' . ($row->can_update == 1 ? 'checked="checked"' : '') . '></label>';
				return $row->modules == '#' || $row->routes == '#' ? '' : $check_update;
			})->edit('can_delete', function ($row) {
				$check_delete = '<label class="form-check form-switch form-check-custom form-check-solid"><input class="form-check-input check-access" type="checkbox" value="1" data-id="' . encrypt_text($row->id) . '" data-access="delete" ' . ($row->can_delete == 1 ? 'checked="checked"' : '') . '></label>';
				return $row->modules == '#' || $row->routes == '#' ? '' : $check_delete;
			})->edit('visibility', function ($row) {
				$check_visibility = '<label class="form-check form-switch form-check-custom form-check-solid"><input class="form-check-input check-access" type="checkbox" value="1" data-id="' . encrypt_text($row->id) . '" data-access="visibility" ' . ($row->visibility == 1 ? 'checked="checked"' : '') . '></label>';
				return $row->modules == '#' || $row->routes == '#' ? '' : $check_visibility;
			})->toJson();
		}
	}
}
