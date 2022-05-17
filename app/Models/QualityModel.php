<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_id',
        'name',
        'description',
        'created_by',
        'updated_by'
    ];
}
