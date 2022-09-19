<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPrepareCustomer extends Model
{
    use HasFactory;
    protected $fillable=['customer_pickup_code','cycle','cycle_time_preparation','help_column','time_pickup','vendor'];
    protected $table = "delivery_pickup_customer";

}
