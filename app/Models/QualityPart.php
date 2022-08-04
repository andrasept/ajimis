<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'process_id',
        'machine_id',
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

    // Inverse
    public function qualityModel()
    {
        return $this->belongsTo(QualityModel::class);
    }

    // Part -> Monitor (One to Many)
    public function qualityMonitors()
    {
        return $this->hasOne(QualityMonitor::class);
    }
}
