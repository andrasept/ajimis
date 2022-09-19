<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logtruck extends Model
{
    use HasFactory;
    protected $fillable=["customer_pickup_id","vendor","jenis","security_name","driver_name" ];
    protected $table = "delivery_log_truck";
}
