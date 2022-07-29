<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManPowerDelivery extends Model
{
    use HasFactory;
    protected $fillable=['name','area','npk','position','title','photo','shift'];
    protected $table = "delivery_man_powers";

}
