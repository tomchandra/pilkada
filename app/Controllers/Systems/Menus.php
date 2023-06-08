<?php

namespace App\Controllers\Systems;

use App\Controllers\BaseController;
use App\Models\Systems\MenusModel;

use \Hermawan\DataTables\DataTable;

class Menus extends BaseController
{
	protected $MenusModel;


	public function __construct()
	{
		$this->MenusModel = new MenusModel();
	}

	public function getIndex()
	{
		return view('Systems/Entity/Menus/List');
	}

	public function getDatatable()
	{
		$builder = $this->MenusModel->select('name, modules, routes, status_cd, id')->where('status_cd !=', 'nullified');
		return DataTable::of($builder)->edit('id', function ($row) {
			return encrypt_text($row->id);
		})->addNumbering()->toJson();
	}

	public function getCreate()
	{
		return view('Systems/Entity/Menus/FormAdd');
	}

	public function getEdit($id = null)
	{
		$id   = decrypt_text($id);
		$data = $this->MenusModel->select('id, name, modules, routes, icons, status_cd')->where('id', $id)->get()->getFirstRow('array');
		if ($id !== null && $data !== null) {
			$menu = $this->MenusModel->select('id, name')->where('status_cd !=', 'nullified')->orderBy('name', 'asc')->get()->getResultArray();
			$data = [
				'data' => $data,
				'menu' => $menu,
			];

			return view('Systems/Entity/Menus/FormEdit', $data);
		}

		return redirect()->to(site_url("/systems/menus"));
	}

	public function postSave()
	{
		$data = $this->request->getPost();
		if ($this->MenusModel->save($data) === false) {
			return redirect()->back()->withInput()->with('errors',  $this->MenusModel->errors());
		}

		session()->setFlashdata('success', 'Data saved successfully');
		$id = $this->MenusModel->getInsertID();

		return redirect()->to(site_url("/systems/menus/edit/" . encrypt_text($id)));
	}

	public function postUpdate()
	{
		$id 		= decrypt_text($this->request->getPost('id'));
		$data 	= $this->request->getPost();
		$dataset = [];
		foreach ($data as $key => $value) {
			$dataset[$key] = $value;
		}

		if (intval($id) > 0 && count($dataset) > 0) {
			if ($this->MenusModel->update($id, $dataset) === false) {
				return redirect()->back()->withInput()->with('errors',  $this->MenusModel->errors());
			}
		}

		session()->setFlashdata('success', 'Data changed successfully');

		return redirect()->to(site_url("/systems/menus/edit/" . encrypt_text($id)));
	}

	public function postDelete()
	{
		$id 		= decrypt_text($this->request->getPost('id'));
		$data 	= $this->request->getPost();
		$dataset = [];
		foreach ($data as $key => $value) {
			$dataset[$key] = $value;
		}

		if (intval($id) > 0 && count($dataset) > 0) {
			if ($this->MenusModel->update($id, $dataset)) {
				return $this->response->setJSON(["status" => "success", "message" => "success"]);
			}
			return $this->response->setJSON(["status" => "error", "message" => $this->MenusModel->errors()]);
		}
	}
}
