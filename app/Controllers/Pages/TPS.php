<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\TPSModel;
use App\Models\Pages\WilayahModel;
use \Hermawan\DataTables\DataTable;

class TPS extends BaseController
{
   protected $TPSModel;
   protected $WilayahModel;

   public function __construct()
   {
      $this->TPSModel  = new TPSModel();
      $this->WilayahModel = new WilayahModel();
   }

   public function getIndex()
   {
      return view('Pages/TPS/Master/List');
   }

   public function getCreate()
   {
      $prov = $this->WilayahModel->select('kode, nama')->where('CHAR_LENGTH(kode)', 2)->get()->getResultArray();
      return view('Pages/TPS/Master/FormAdd', ['prov' => $prov]);
   }

   public function getEdit($id = null)
   {
      $id   = decrypt_text($id);
      $data = $this->TPSModel->select('kode_tps, kode_wilayah, nama_tps, alamat_tps, koordinat_long, koordinat_lat')->where('kode_tps', $id)->get()->getFirstRow('array');
      if ($id !== null && $data !== null) {

         $prov = $this->WilayahModel->select('kode, nama')->where('CHAR_LENGTH(kode)', 2)->get()->getResultArray();
         $kab  = $this->WilayahModel->select('kode, nama')->where('CHAR_LENGTH(kode)', 5)->where('LEFT(kode, 2)', substr($data['kode_wilayah'], 0, 2))->get()->getResultArray();
         $kec  = $this->WilayahModel->select('kode, nama')->where('CHAR_LENGTH(kode)', 8)->where('LEFT(kode, 5)', substr($data['kode_wilayah'], 0, 5))->get()->getResultArray();
         $kel  = $this->WilayahModel->select('kode, nama')->where('CHAR_LENGTH(kode)', 13)->where('LEFT(kode, 8)', substr($data['kode_wilayah'], 0, 8))->get()->getResultArray();

         $data = [
            'data' => $data,
            'wilayah' => [
               'prov' => $prov,
               'kab' => $kab,
               'kec' => $kec,
               'kel' => $kel
            ]
         ];

         return view('Pages/TPS/Master/FormEdit', $data);
      }

      return redirect()->to(site_url("/pages/tps/Master"));
   }

   public function postSave()
   {
      if ($this->request->is('post')) {
         $data = $this->request->getPost();
         if ($this->TPSModel->save($data) === false) {
            return redirect()->back()->withInput()->with('errors',  $this->TPSModel->errors());
         }

         session()->setFlashdata('success', 'Data saved successfully');
         $id = $this->TPSModel->getInsertID();

         return redirect()->to(site_url("/pages/tps/Master/edit/" . encrypt_text($id)));
      }

      return redirect()->to(site_url("/pages/tps/Master"));
   }

   public function postUpdate()
   {
      if ($this->request->is('post')) {
         $id       = decrypt_text($this->request->getPost('kode_tps'));
         $data    = $this->request->getPost();
         $dataset = [];
         foreach ($data as $key => $value) {
            $dataset[$key] = $value;
         }

         if (intval($id) > 0 && count($dataset) > 0) {
            if ($this->TPSModel->update($id, $dataset) === false) {
               return redirect()->back()->withInput()->with('errors',  $this->TPSModel->errors());
            }
         }

         session()->setFlashdata('success', 'Data changed successfully');

         return redirect()->to(site_url("/pages/tps/Master/edit/" . encrypt_text($id)));
      }

      return redirect()->to(site_url("/pages/tps/Master"));
   }

   public function postDelete()
   {
      if ($this->request->isAJAX()) {
         $id      = decrypt_text($this->request->getPost('id'));

         if (intval($id) > 0) {

            if ($this->TPSModel->update($id, ['status' => 0])) {
               return $this->response->setJSON(["status" => "success", "message" => "success"]);
            }
            return $this->response->setJSON(["status" => "error", "message" => $this->TPSModel->errors()]);
         }
      }
   }

   public function postChained()
   {
      if ($this->request->isAJAX()) {
         $charLength = $this->request->getPost('charLength');
         $left = $this->request->getPost('left');
         $searchTerm = $this->request->getPost('searchTerm');

         $data = $this->WilayahModel->select('kode, nama')->where('CHAR_LENGTH(kode)', $charLength)->where('LEFT(kode, ' . $left . ')', $searchTerm)->get()->getResultArray();
         $dataset = [];
         if (count($data) > 0) {
            foreach ($data as $key => $value) {
               $dataset[] = [
                  "id" => $value['kode'],
                  "text" => $value['nama']
               ];
            }
         }

         return json_encode($dataset);
      }
   }

   public function postDatatable()
   {
      if ($this->request->isAJAX()) {
         $builder = $this->TPSModel->select('tps.nama_tps, tps_wilayah.nama, tps.alamat_tps, tps.kode_tps')->join('tps_wilayah', 'tps.kode_wilayah=tps_wilayah.kode', 'LEFT', true)->where('tps.status', 1);
         return DataTable::of($builder)->edit('kode_tps', function ($row) {
            return encrypt_text($row->kode_tps);
         })->addNumbering()->toJson();
      }
   }
}
