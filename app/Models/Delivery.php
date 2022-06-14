<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable=['customer_pickup_id','cycle','arrival_plan','arrival_actual','arrival_status',
                        'departure_plan','departure_actual','departure_status','vendor'
                        ];
    protected $table = "delivery_delivery";
}
