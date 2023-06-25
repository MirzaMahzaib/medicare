<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id','product_id','qty','price','pack','total','supplier'];

    public function products(){
        return $this->belongsTo(Product::class,'id');
    }
}
