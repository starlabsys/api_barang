<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BarangService;
use App\Utils\ResponseCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    //
    protected $barangService;

    public function __construct(BarangService $barangService)
    {
        $this->barangService = $barangService;
    }

    public function index(){
        // 

        $response = $this->barangService->getBarang();

        return ResponseCode::successGet("Success Get data", $response['data']);
    }

    public function store(Request $request){
        // 

        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'nama_barang' => 'required'
        ]);

        if($validator->fails()){
            return ResponseCode::errorPost($validator->errors()->first());
        }

        $response = $this->barangService->storeBarang($request->all());

        if($response['status']){
            return ResponseCode::successPost("Successfully added new Items");
        }else{
            return ResponseCode::errorPost($response['message']);
        }
    }
}
