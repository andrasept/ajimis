<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryLayoutArea extends Model
{
    use HasFactory;
    protected $fillable=["position","user_id","henkatan_status","date_henkaten","shift"];
    protected $table = "delivery_henkaten";

   

}
