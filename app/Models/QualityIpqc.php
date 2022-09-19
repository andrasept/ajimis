<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QualityIpqc extends Model
{
    use HasFactory;

    protected $table = 'quality_ipqcs';

    protected $fillable = [
        'user_id',
        'doc_number',   
        'lot_produksi',   
        'judgement',   
             
        'quality_area_id',        
        'quality_process_id',        
        'quality_machine_id',        
        'quality_model_id',        
        'quality_part_id',    

        'cs_status',        

        'created_by',
        'updated_by'
    ];

    protected $dates = ['deleted_at'];
}
