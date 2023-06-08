<?php

namespace App\Controllers\Systems;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserIdentityModel;
use App\Models\Systems\GroupsModel;
use App\Models\Systems\UsersModel;
use App\Models\Systems\GroupsUsersModel;

use \Hermawan\DataTables\DataTable;

class Users extends BaseController
{
	protected $usersEdintityModel;
	protected $usersProvider;
	protected $GroupsModel;
	protected $GroupsUsersModel;
	protected $UsersModel;

	public function __construct()
	{
		$this->usersEdintityModel = new UserIdentityModel();
		$this->usersProvider		  = auth()->getProvider();
		$this->GroupsModel 		  = new GroupsModel();
		$this->GroupsUsersModel   = new GroupsUsersModel();
		$this->UsersModel   		  = new UsersModel();
	}

	public function getIndex()
	{
		return view('Systems/Entity/Users/List');
	}

	public function postDatatable()
	{
		if ($this->request->isAJAX()) {
			$builder = $this->usersEdintityModel->select('users.first_name, users.last_name, auth_identities.secret, auth_identities.last_used_at, users.last_active, auth_identities.user_id')->join('users', 'users.id = auth_identities.user_id', 'LEFT', true);
			return DataTable::of($builder)->edit('user_id', function ($row) {
				return encrypt_text($row->user_id);
			})->addNumbering()->toJson();
		}
		return;
	}

	public function getDatatable_grouplist()
	{
		if ($this->request->isAJAX()) {
			$user_id = decrypt_text($this->request->getGet('user_id'));
			$builder = $this->GroupsUsersModel->select('auth_groups.title, auth_groups.description, auth_groups_users.is_default, auth_groups_users.id, auth_groups.id AS group_id, auth_groups_users.user_id')->join('auth_groups', 'auth_groups_users.group = auth_groups.id', 'left', true)->where('auth_groups.status_cd', 'active')->where('auth_groups_users.user_id', $user_id);
			return DataTable::of($builder)->edit('is_default', function ($row) {
				return '<div class="form-check form-check-custom form-check-solid"><input class="form-check-input is_default_group" data-user-id="' . encrypt_text($row->user_id) . '" data-group-id="' . encrypt_text($row->group_id) . '" type="radio" name="is_default" value="1" ' . ($row->is_default == '1' ? 'checked="checked"' : '') . '/></div>';
			})->edit('id', function ($row) {
				return '<button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px me-2 btn-delete-user-group" data-id="' . encrypt_text($row->id) . '"><i class="fa fa-trash"></i></button>';
			})->addNumbering()->toJson();
		}
		return;
	}

	public function getCreate()
	{
		return view('Systems/Entity/Users/FormAdd');
	}

	public function getEdit($id = null)
	{
		$id   			= decrypt_text($id);
		$userEdintity 	= $this->usersEdintityModel->select('user_id, secret')->where('user_id', $id)->get()->getFirstRow('array');
		$user 			= $this->UsersModel->select('*')->where('id', $id)->get()->getFirstRow('array');
		$dataUser 		= array_merge($user, $userEdintity);

		if ($id !== null && $dataUser !== null) {
			$userProvider  = $this->usersProvider->findById($id);
			$groups 			= $this->GroupsModel->select('id, title')->where('status_cd', 'active')->get()->getResultArray();
			$roles  			= [];
			$data = [
				'data'  	  	 => $dataUser,
				'groups'   	 => $groups,
				'roles'		 => $roles,
				'access'		 => [
					'isInActive'  => $userProvider->isNotActivated(),
					'isBanned' 	  => $userProvider->isBanned(),
					'banMassage'  => $userProvider->getBanMessage(),
					'isPassReset' => $userProvider->requiresPasswordReset()
				]
			];

			return view('Systems/Entity/Users/FormEdit', $data);
		}

		return redirect()->to(site_url("/systems/users"));
	}

	public function postSave()
	{
		if ($this->request->is('post')) {
			$data 	= $this->request->getPost();

			if (isset($data) && count($data) > 0) {
				foreach ($data as $key => $value) {
					$$key = $value;
				}

				$isValid = $this->validate([
					'secret' => ['label' => 'email', 'rules' => 'required|max_length[254]|valid_email|is_unique[auth_identities.secret]']
				]);

				if (!$isValid) {
					return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
				}

				$user = new User([
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email'    => $secret,
					'password' => date('Y-m-d', strtotime($dob)),
				]);

				$this->usersProvider->save($user);

				$user_id   = $this->usersProvider->getInsertID();

				$user = $this->usersProvider->findById($user_id);
				$this->usersProvider->addToDefaultGroup($user);
				$this->usersProvider->activate($user);

				session()->setFlashdata('success', 'Data saved successfully');

				return redirect()->to(site_url("/systems/users/edit/" . encrypt_text($user_id)));
			}
		}
		return redirect()->to(site_url("/systems/users"));
	}

	public function postUpdate()
	{
		if ($this->request->is('post')) {
			$data 		= $this->request->getPost();

			if (count($data) > 0) {
				foreach ($data as $key => $value) {
					$$key = $value;
				}

				$user_id   = decrypt_text($user_id);

				$isValid = $this->validate([
					'secret' => ['label' => 'email', 'rules' => 'required|max_length[254]|valid_email|is_unique[auth_identities.secret,user_id,' . $user_id . ']']
				]);

				if (!$isValid) {
					return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
				}

				$user = $this->usersProvider->findById($user_id);
				$user->fill([
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email'     => $secret,
				]);

				$this->usersProvider->save($user);

				session()->setFlashdata('success', 'Data saved successfully');

				return redirect()->to(site_url("/systems/users/edit/" . encrypt_text($user_id)));
			}
		}

		return redirect()->to(site_url("/systems/users"));
	}

	public function postDelete()
	{
		return $this->response->setJSON(["status" => "error", "message" => 'User cannot be deleted!']);

		// $id 	= $this->request->getPost('id');
		// $this->usersProvider->delete($id)
	}

	public function postAddGroupUser()
	{
		if ($this->request->isAJAX()) {
			$data 	= $this->request->getPost();
			$dataset = [];
			foreach ($data as $key => $value) {
				$dataset[$key] = decrypt_text($value);
				$$key = decrypt_text($value);
			}

			if (count($dataset) > 0) {
				$checkDuplicateGroup = $this->GroupsUsersModel->where('user_id', $user_id)->where('group', $group)->countAllResults();
				if ($checkDuplicateGroup > 0) {
					return json_encode(["status" => "error", "message" => "Duplicate group menu"]);
				}

				$saveGroupMenu = $this->GroupsUsersModel->save($dataset);
				if ($saveGroupMenu) {
					return $this->response->setJSON(["status" => "success", "message" => "success"]);
				} else {
					return $this->response->setJSON(["status" => "error", "message" => $this->GroupsUsersModel->errors()]);
				}
			}
		}
		return;
	}

	public function postDeleteGroupUser()
	{
		if ($this->request->isAJAX()) {
			$id = decrypt_text($this->request->getPost('id'));
			if (intval($id) > 0) {
				$deleteGroupMenu = $this->GroupsUsersModel->where('id', $id)->delete();
				if ($deleteGroupMenu) {
					return $this->response->setJSON(["status" => "success", "message" => "success"]);
				} else {
					return $this->response->setJSON(["status" => "error", "message" => $this->GroupsUsersModel->errors()]);
				}
			}
		}
		return;
	}

	public function postSetDefaultGroupUser()
	{
		if ($this->request->isAJAX()) {
			$user_id  = decrypt_text($this->request->getPost('user_id'));
			$group_id = decrypt_text($this->request->getPost('group_id'));

			if (intval($user_id) > 0 && intval($group_id) > 0) {
				$removeDefaultGroup = $this->GroupsUsersModel->where('user_id', $user_id)->set('is_default', 0)->update();
				if ($removeDefaultGroup) {
					$saveDefaultGroup = $this->GroupsUsersModel->where('user_id', $user_id)->where('group', $group_id)->set('is_default', 1)->update();
					if ($saveDefaultGroup) {
						return $this->response->setJSON(["status" => "success", "message" => "success"]);
					} else {
						return $this->response->setJSON(["status" => "error", "message" => $this->GroupsUsersModel->errors()]);
					}
				}
			}
		}
		return;
	}

	public function postActivatingUser()
	{
		if ($this->request->isAJAX()) {
			$user_id = decrypt_text($this->request->getPost('user_id'));
			$user    = $this->usersProvider->findById($user_id);
			$user->activate();

			return $this->response->setJSON(["status" => "success", "message" => "success"]);
		}
	}

	public function postDeactivatingUser()
	{
		if ($this->request->isAJAX()) {
			$user_id = decrypt_text($this->request->getPost('user_id'));
			$user    = $this->usersProvider->findById($user_id);
			$user->deactivate();
			return $this->response->setJSON(["status" => "success", "message" => "success"]);
		}
	}

	public function postBanningUser()
	{
		if ($this->request->isAJAX()) {
			$user_id = decrypt_text($this->request->getPost('user_id'));
			$reason  = $this->request->getPost('reason');
			$user    = $this->usersProvider->findById($user_id);
			if ($user->ban($reason)) {
				return $this->response->setJSON(["status" => "success", "message" => "success"]);
			}
			return $this->response->setJSON(["status" => "error", "message" => "Failed to banning user, Please try again."]);
		}
	}

	public function postUnBanningUser()
	{
		if ($this->request->isAJAX()) {
			$user_id = decrypt_text($this->request->getPost('user_id'));
			$user    = $this->usersProvider->findById($user_id);
			if ($user->unBan()) {
				return $this->response->setJSON(["status" => "success", "message" => "success"]);
			}
			return $this->response->setJSON(["status" => "error", "message" => "Failed to un-banning user, Please try again."]);
		}
	}

	public function postForceChangePassword()
	{
		if ($this->request->isAJAX()) {
			$user_id = decrypt_text($this->request->getPost('user_id'));
			$user    = $this->usersProvider->findById($user_id);
			$user->forcePasswordReset();
			return $this->response->setJSON(["status" => "success", "message" => "success"]);
		}
	}

	public function postUndoForceChangePassword()
	{
		if ($this->request->isAJAX()) {
			$user_id = decrypt_text($this->request->getPost('user_id'));
			$user    = $this->usersProvider->findById($user_id);
			$user->undoForcePasswordReset();
			return $this->response->setJSON(["status" => "success", "message" => "success"]);
		}
	}
}
