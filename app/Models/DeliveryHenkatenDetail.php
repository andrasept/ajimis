<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryHenkatenDetail extends Model
{
    use HasFactory;
    protected $fillable=['area','mp_before','mp_after','reason_henkaten','date_henkaten'];
    protected $table = "delivery_henkaten_detail";

}
