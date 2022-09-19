<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryClaim extends Model
{
    use HasFactory;

    protected $fillable=["customer_pickup_id","claim_date","problem","part_number","part_number_actual","part_name","part_name_actual","category","qty","evidence","corrective_action"];
    protected $table = "delivery_claim";
}
