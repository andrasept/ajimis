<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPackaging extends Model
{
    use HasFactory;
    protected $fillable=["packaging_code","qty_per_pallet"];
    protected $table = "delivery_packagings";
}
