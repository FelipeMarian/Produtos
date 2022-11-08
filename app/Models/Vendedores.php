<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedores extends Model
{
    use HasFactory;
    public function produto() {
        return $this->belongsTo(Produto::class,'idVendedor','id');
    }
}
