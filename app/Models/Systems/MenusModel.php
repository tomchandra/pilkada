<?php

namespace App\Models\Systems;

use CodeIgniter\Model;

class MenusModel extends Model
{
	protected $DBGroup          = 'default';
	protected $table            = 'menus';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['parent_id', 'name', 'modules', 'routes', 'icons', 'order', 'is_hidden', 'status_cd'];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'name' 		=> ['label' => 'menu name', 'rules' => ['required', 'alpha_space', 'min_length[3]', 'max_length[50]']],
		'modules' 	=> ['label' => 'modules', 'rules' => ['alpha_numeric_punct']],
		'routes' 	=> ['label' => 'routes', 'rules' => ['alpha_numeric_punct']],
		'status_cd' => ['label' => 'status_cd', 'rules' => ['in_list[active,inactive,nullified]']],
	];
	protected $validationMessages   = [
		'is_hidden' => [
			'in_list' => 'The is hidden field must be one of: Yes or No',
		]
	];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = [];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = [];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = [];

	public function GroupMenu($group_id)
	{
		return $this->builder('auth_groups_menus a')
			->select('b.id,
					a.parent_menu_id AS parent_id,
					b.name,
					b.modules,
					b.routes,
					b.icons,
					a.order,
					a.visibility AS is_hidden')
			->join('menus b', 'a.menu_id = b.id', 'left', true)
			->where('a.group_id', $group_id)
			->where('b.status_cd', 'active')
			->where('a.visibility', 1)
			->orderBy('a.order', 'asc')
			->get()
			->getResultArray();
	}
}
