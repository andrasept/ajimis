<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Part extends Model
{
    use HasFactory;

    protected $fillable=["sku","part_no_customer","part_no_aji",
                        "part_name","model","customer_id","category","cycle_time",
                        "addresing","color_id","line_id","packaging_id","updated_by" ];
    protected $table = "delivery_parts";


}
