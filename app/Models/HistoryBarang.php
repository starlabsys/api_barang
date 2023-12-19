<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function barang(){
        return $this->hasMany(Barang::class, 'barang_id', 'id');
    }
    
}
