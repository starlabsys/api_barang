<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\HistoryBarang;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class BarangService
{
    //

    static function getBarang(){
        $data = Barang::with('history')->get();

        return [
            'status' => true,
            'data' => $data
        ];
    }

    static function storeBarang($data){
        //
        DB::beginTransaction();

        try {
            //code...
            $check = Barang::where('uuid', $data['uuid'])->first();

            if($check){
                return [
                    'status' => false,
                    'message' => 'UUID already exist'
                ];
            }

            $data = Barang::create([
                'uuid' => $data['uuid'],
                'nama_barang' => $data['nama_barang']
            ]);

            $history = HistoryBarang::create([
                'barang_id' => $data->id,
                'user_id' => JWTAuth::user()->id
            ]);

            DB::commit();

            return [
                'status' => true,
                'message' => 'Successfully added new Items'
            ];

            
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return [
                'status' => false,
                'message' => $th->getMessage()
            ];
        }
    }
}