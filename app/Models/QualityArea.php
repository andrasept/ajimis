<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by'
    ];

    // Area -> Process (One to Many)
    public function qualityProcesses()
    {
        return $this->hasMany(QualityProcess::class);
    }

    // Area -> Monitor (One to Many)
    public function qualityMonitors()
    {
        return $this->hasOne(QualityMonitor::class);
    }
}
