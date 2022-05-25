<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPickupCustomer extends Model
{
    use HasFactory;
    protected $fillable=['customer_pickup_code','cycle','cycle_time_preparation','help_column','time_pickup'];
    protected $table = "delivery_pickup_customer";

}
