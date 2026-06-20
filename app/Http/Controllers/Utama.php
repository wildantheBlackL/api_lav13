<?php

namespace App\Http\Controllers;
use App\Models\Mdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Utama extends Controller
{
    public function statusAPI(){
        $dtx =["kode"=>"01","status"=>"API berjalan dengan Baik"];
        return response()->json($dtx, 200);
    }

  public function backupData(Request $xyz){
    $nama = $xyz->input("nama_backup");
    $dtx = base64_decode($xyz->input("dtx"));
    $id = floor(microtime(true) * 1000);
    $arr_data = explode("#", $dtx);
    $mx = new Mdata();
    $url = "https://apiexpress-production-c1f5.up.railway.app/notifikasi-backup";
    $proses = $mx->tambahBackup($id, $nama, "laravel");
    if($proses == "1"){
        $berhasil = 0;
        $gagal = 0;
        Http::post($url, [
    'status' => 'mulai',
    'total' => count($arr_data)
]);
        foreach ($arr_data as $k){
            $arr_data2 = explode("|", $k);
            $idx = $arr_data2[0];
            $deskripsix = $arr_data2[1];
            $waktux = $arr_data2[2];
            $nominalx = $arr_data2[3];
            $jenisx = $arr_data2[4];
            $proses2 = $mx->tambahTransaksi($id."-".$idx, $id, $waktux, $nominalx, $jenisx, $deskripsix);
            $proses2 == "1" ? $berhasil++ : $gagal++;
            Http::post($url, [
            'status' => 'progress',
            'selesai' => $berhasil + $gagal,
            'total' => count($arr_data),
            'deskripsi' => $deskripsix
        ]);
             Http::post($url, [
            'status' => 'selesai',
            'berhasil' => $berhasil,
            'gagal' => $gagal
        ]);
        }
        $pesanx = ["kode"=>"01", "status"=>"Proses Backup Berhasil dengan Rincian ", "berhasil"=>$berhasil, "gagal"=>$gagal];
        $kodex = 200;
    }else{
        $pesanx = ["kode"=>"00", "status"=>"Proses Backup Gagal, Periksa Kembali Data Anda"];
        $kodex = 500;
    }
    
    return response()->json($pesanx, $kodex);
}
}
