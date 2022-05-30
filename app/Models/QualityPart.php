<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'name',
        'description',
        'low',
        'mid',
        'high',
        'left',
        'center',
        'right',
        'photo',

        'created_by',
        'updated_by'
    ];
}
