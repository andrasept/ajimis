<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'name',
        'description',
        'created_by',
        'updated_by'
    ];

    // Inverse
    public function qualityArea()
    {
        return $this->belongsTo(QualityArea::class);
    }

    // Process -> Model (One to Many)
    public function qualityModels()
    {
        return $this->hasMany(QualityModel::class);
    }

    // Process -> Monitor (One to Many)
    public function qualityMonitors()
    {
        return $this->hasOne(QualityMonitor::class);
    }
}
