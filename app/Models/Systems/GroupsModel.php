<?php

namespace App\Models\Systems;

use CodeIgniter\Model;

class GroupsModel extends Model
{
	protected $DBGroup          = 'default';
	protected $table            = 'auth_groups';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['title', 'description', 'status_cd'];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'title'       => ['label' => 'group name', 'rules' => ['required', 'alpha_space', 'min_length[3]', 'max_length[50]']],
		'description' => ['alpha_space', 'max_length[100]']
	];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = ['updateInsertedUser'];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = ['updateUpdatedUser'];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = [];

	protected function updateInsertedUser(array $data)
	{
		$this->builder()->set('created_user_id', auth()->id());
		$this->builder()->set('created_at', date('Y-m-d H:i:s'));
		$this->builder()->where('id', $data['id']);
		$this->builder()->update();

		$this->addGroup($data);

		return $data['result'];
	}

	protected function updateUpdatedUser(array $data)
	{
		if (isset($data['data']['status_cd'])) {
			if ($data['data']['status_cd'] == 'nullified') {
				$this->builder()->set('deleted_user_id', auth()->id());
				$this->builder()->set('deleted_at', date('Y-m-d H:i:s'));
				$this->builder()->where('id', $data['id']);
				$this->builder()->update();

				$this->deleteGroup($data);
			}
		} else {
			$this->builder()->set('updated_user_id', auth()->id());
			$this->builder()->set('updated_at', date('Y-m-d H:i:s'));
			$this->builder()->where('id', $data['id']);
			$this->builder()->update();

			$this->updateGroup($data);
		}
		return $data['result'];
	}

	protected function addGroup(array $data)
	{
		$groupConfig = setting('AuthGroups.groups');
		$groupConfig[$data['id']] = [
			'title'       => $data['data']['title'],
			'description' => '',
		];

		if (empty($groupConfig['user'])) {
			$groupConfig['user'] = [
				'title'       => 'User',
				'description' => 'General users of the site',
			];
		}

		service('settings')->set('AuthGroups.groups', $groupConfig);
	}

	protected function updateGroup(array $data)
	{
		$groupConfig = setting('AuthGroups.groups');
		if (!empty($groupConfig[$data['id'][0]])) {

			$groupConfig[$data['id'][0]] = [
				'title'       => $data['data']['title'],
				'description' => '',
			];

			$groupConfig['user'] = [
				'title'       => 'User',
				'description' => 'General users of the site',
			];

			service('settings')->forget('AuthGroups.groups');
			service('settings')->set('AuthGroups.groups', $groupConfig);
		}
	}

	protected function deleteGroup(array $data)
	{
		$checkUsedGroup = $this->builder('auth_groups_users')->select('group')->where('id', $data['id'][0])->countAllResults();
		if ($checkUsedGroup < 1) {

			$groupConfig = setting('AuthGroups.groups');
			if (!empty($groupConfig[$data['id'][0]])) {

				unset($groupConfig[$data['id'][0]]);

				$groupConfig['user'] = [
					'title'       => 'User',
					'description' => 'General users of the site',
				];

				service('settings')->forget('AuthGroups.groups');
				service('settings')->set('AuthGroups.groups', $groupConfig);
			}
		}
	}

	public function syncGroup()
	{
		$availableGroup = $this->builder()->select('id, title')->where('status_cd !=', 'nullified')->get()->getResultArray();
		$groupConfig = [];
		if ($availableGroup) {
			foreach ($availableGroup as $key => $data) {
				$groupConfig[$data['id']] = [
					'title'       => $data['title'],
					'description' => ''
				];
			}
		}

		$groupConfig['user'] = [
			'title'       => 'User',
			'description' => 'General users of the site',
		];

		service('settings')->forget('AuthGroups.groups');
		if (count($groupConfig) > 0) {
			service('settings')->set('AuthGroups.groups', $groupConfig);
		}
	}
}
