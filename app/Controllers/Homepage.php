<?php

namespace App\Controllers;

use App\Models\Pages\PemilihModel;
use App\Models\Pages\WilayahModel;

class Homepage extends BaseController
{

   protected $PemilihModel;
   protected $WilayahModel;

   public function __construct()
   {
      $this->PemilihModel  = new PemilihModel();
      $this->WilayahModel = new WilayahModel();
   }

   public function index()
   {
      return view('homepage');
   }

   public function search()
   {
      $nik = $this->request->getGet('nik');
      $data = $this->PemilihModel->select('tps_pemilih.nik, tps_pemilih.nama_pemilih, tps.nama_tps, tps.alamat_tps, tps.kode_wilayah, tps_kuota.waktu_mulai, tps_kuota.waktu_selesai')->join('tps_kuota', 'tps_kuota.id= tps_pemilih.kode_kuota', 'LEFT')->join('tps', 'tps.kode_tps=tps_kuota.kode_tps')->where('tps_pemilih.nik', $nik)->get()->getFirstRow();
      if ($data) {

         $prov = $this->WilayahModel->select('nama')->where('kode', substr($data->kode_wilayah, 0, 2))->get()->getFirstRow();
         $kab  = $this->WilayahModel->select('nama')->where('kode', substr($data->kode_wilayah, 0, 5))->get()->getFirstRow();
         $kec  = $this->WilayahModel->select('nama')->where('kode', substr($data->kode_wilayah, 0, 8))->get()->getFirstRow();
         $kel  = $this->WilayahModel->select('nama')->where('kode', $data->kode_wilayah)->get()->getFirstRow();

         $info = '
         <h2>Data ditemukan!</h2>
         <table class="table table-row-bordered gy-2" width="100%" style="text-align:start">
            <tr>
               <td>NIK</td>
               <td>' . $data->nik . '</td>
            </tr>
            <tr>
               <td>Nama</td>
               <td>' . $data->nama_pemilih . '</td>
            </tr>
            <tr>
               <td>TPS</td>
               <td>' . $data->nama_tps . '</td>
            </tr>
            <tr>
               <td>Alamat TPS</td>
               <td>' . $data->alamat_tps . '</td>
            </tr>
            <tr>
               <td>Wilayah</td>
               <td>' . join(" / ", [$prov->nama, $kab->nama, $kec->nama, $kel->nama]) . '</td>
            </tr>
            <tr>
               <td>Waktu</td>
               <td>' . date("d F Y", strtotime($data->waktu_mulai)) . ' ' . date("H:i", strtotime($data->waktu_mulai)) . ' s/d ' . date("H:i", strtotime($data->waktu_selesai)) . '</td>
            </tr>
         </table>
         ';

         return $this->response->setJSON(["status" => "success", "message" => $info]);
      }

      return $this->response->setJSON(["status" => "error", "message" => "Not Found"]);
   }
}
