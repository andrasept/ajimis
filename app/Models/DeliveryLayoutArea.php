<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryLayoutArea extends Model
{
    use HasFactory;
    protected $fillable=["position","user_id","henkatan_status","date_henkaten"];
    protected $table = "delivery_henkaten";

    public function users()
    {
        return $this->hasOne(ManPowerDelivery::class, 'npk', 'user_id');
    }

}
