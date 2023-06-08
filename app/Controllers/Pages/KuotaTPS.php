<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\TPSModel;
use App\Models\Pages\WilayahModel;
use App\Models\Pages\KuotaModel;
use \Hermawan\DataTables\DataTable;

class KuotaTPS extends BaseController
{
   protected $TPSModel;
   protected $WilayahModel;
   protected $KuotaModel;

   public function __construct()
   {
      $this->TPSModel  = new TPSModel();
      $this->KuotaModel  = new KuotaModel();
      $this->WilayahModel = new WilayahModel();
   }

   public function getIndex()
   {
      return view('Pages/TPS/Kuota/List');
   }


   public function getCreate()
   {
      $tps = $this->TPSModel->select('kode_tps, kode_wilayah, nama_tps, alamat_tps')->where('status', 1)->get()->getResultArray();
      if ($tps) {
         $i = 0;
         foreach ($tps as $key => $value) {
            $prov = $this->WilayahModel->select('nama')->where('kode', substr($value['kode_wilayah'], 0, 2))->get()->getFirstRow();
            $kab  = $this->WilayahModel->select('nama')->where('kode', substr($value['kode_wilayah'], 0, 5))->get()->getFirstRow();
            $kec  = $this->WilayahModel->select('nama')->where('kode', substr($value['kode_wilayah'], 0, 8))->get()->getFirstRow();
            $kel  = $this->WilayahModel->select('nama')->where('kode', $value['kode_wilayah'])->get()->getFirstRow();

            $tps[$i++]['alamat_tps'] = join(" - ", [$prov->nama, $kab->nama, $kec->nama, $kel->nama]);
         }
      }

      return view('Pages/TPS/Kuota/FormAdd', ['tps' => $tps]);
   }

   public function getEdit($id = null)
   {
      $id   = decrypt_text($id);
      $data = $this->KuotaModel->select('id, kode_tps, waktu_mulai, waktu_selesai, kuota_tps')->where('id', $id)->where('status', 1)->get()->getFirstRow('array');
      if ($id !== null && $data !== null) {
         $tps  = $this->TPSModel->select('kode_tps, nama_tps, alamat_tps')->where('status', 1)->get()->getResultArray();
         $data = [
            'data' => $data,
            'tps'  => $tps
         ];

         return view('Pages/TPS/Kuota/FormEdit', $data);
      }

      return redirect()->to(site_url("/pages/kuotatps"));
   }

   public function postSave()
   {
      if ($this->request->is('post')) {
         $data = $this->request->getPost();
         if ($this->KuotaModel->save($data) === false) {
            return redirect()->back()->withInput()->with('errors',  $this->KuotaModel->errors());
         }

         session()->setFlashdata('success', 'Data saved successfully');
         $id = $this->KuotaModel->getInsertID();

         return redirect()->to(site_url("/pages/kuotatps/edit/" . encrypt_text($id)));
      }

      return redirect()->to(site_url("/pages/kuotatps"));
   }

   public function postUpdate()
   {
      if ($this->request->is('post')) {
         $id      = decrypt_text($this->request->getPost('id'));
         $data    = $this->request->getPost();
         $dataset = [];
         foreach ($data as $key => $value) {
            $dataset[$key] = $value;
         }

         if (intval($id) > 0 && count($dataset) > 0) {
            if ($this->KuotaModel->update($id, $dataset) === false) {
               return redirect()->back()->withInput()->with('errors',  $this->KuotaModel->errors());
            }
         }

         session()->setFlashdata('success', 'Data changed successfully');

         return redirect()->to(site_url("/pages/kuotatps/edit/" . encrypt_text($id)));
      }

      return redirect()->to(site_url("/pages/kuotatps"));
   }

   public function postDelete()
   {
      if ($this->request->isAJAX()) {
         $id      = decrypt_text($this->request->getPost('id'));

         if (intval($id) > 0) {

            if ($this->KuotaModel->update($id, ['status' => 0])) {
               return $this->response->setJSON(["status" => "success", "message" => "success"]);
            }
            return $this->response->setJSON(["status" => "error", "message" => $this->KuotaModel->errors()]);
         }
      }
   }

   public function postDatatable()
   {
      if ($this->request->isAJAX()) {
         $builder = $this->KuotaModel->select('tps.nama_tps, tps.alamat_tps, tps_kuota.waktu_mulai, tps_kuota.waktu_selesai, tps_kuota.kuota_tps, tps.kode_tps')->join('tps', 'tps.kode_tps=tps_kuota.kode_tps', 'LEFT', true)->where('tps_kuota.status', 1);
         return DataTable::of($builder)->edit('kode_tps', function ($row) {
            return encrypt_text($row->kode_tps);
         })->addNumbering()->toJson();
      }
   }
}
