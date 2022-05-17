<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    use HasFactory;

    protected $fillable=["packaging_code","qty_per_pallet","updated_by" ];
    protected $table = "delivery_packagings";
}
