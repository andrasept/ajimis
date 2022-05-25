<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreparationDelivery extends Model
{
    use HasFactory;
    protected $fillable=['customer_pickup_id','cycle','cycle_time_preparation','help_column','time_pickup','shift',
                            'pic','time_hour', 'date_preparation', 'date_delivery', 'start_preparataion', 'end_preparation'
                        ];
    protected $table = "delivery_preparation";

}
