<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mdata extends Model{
    
    public function tambahBackup($id, $nama, $channel){
        $dt = DB::insert("INSERT INTO backup VALUES('$id', '$nama', '$channel', NOW())");
        return $dt;
    }
    
    public function tambahTransaksi($idx, $id, $waktux, $nominalx, $jenisx, $deskripsix){
        $dt = DB::insert("INSERT INTO backup_transaksi VALUES('$idx', '$id', '$waktux', '$nominalx', '$jenisx', '$deskripsix')");
        return $dt;
    }
}