<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPlanningRefreshment extends Model
{
    use HasFactory;
    protected $fillable=['training','user_id','plan_date_time','actual_date_time','status'];
    protected $table = "delivery_planning_refreshment";
}
