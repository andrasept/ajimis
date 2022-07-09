<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillMatrixDelivery extends Model
{
    use HasFactory;
    protected $fillable=["value","skill_id","user_id","category"];
    protected $table = "delivery_matrix_skills";   
}
