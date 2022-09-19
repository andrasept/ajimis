<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityMachine extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'process_id',
        'name',
        'description',
        'created_by',
        'updated_by'
    ];
}
