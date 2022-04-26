<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPartCard extends Model
{
    use HasFactory;
    protected $fillable=["color_code","description","remark_1","remark_2"];
    protected $table = "delivery_part_cards";
}
