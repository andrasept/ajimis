<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QualityMonitor extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes;

    protected $table = 'quality_monitors';

    protected $fillable = [
        'user_id',
        'doc_number',   
        'judgement',   
             
        'quality_area_id',        
        'quality_process_id',        
        'quality_model_id',        
        'quality_part_id',        
        'quality_cs_qtime',        
        'quality_cs_accuracy',        

        'created_by',
        'updated_by'
    ];

    protected $dates = ['deleted_at'];

    // Inverse
    public function qualityArea()
    {
        return $this->belongsTo(QualityArea::class);
    }
    // Inverse
    public function qualityProcess()
    {
        return $this->belongsTo(QualityProcess::class);
    }
    // Inverse
    public function qualityModel()
    {
        return $this->belongsTo(QualityModel::class);
    }
    // Inverse
    public function qualityPart()
    {
        return $this->belongsTo(QualityPart::class);
    }
}
