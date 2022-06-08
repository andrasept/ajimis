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

    // Inverse
    public function qualityProcess()
    {
        return $this->belongsTo(QualityProcess::class);
    }

    // Model -> Part (One to Many)
    public function qualityParts()
    {
        return $this->hasMany(QualityPart::class);
    }

    // Model -> Monitor (One to Many)
    public function qualityMonitors()
    {
        return $this->hasOne(QualityMonitor::class);
    }
}
