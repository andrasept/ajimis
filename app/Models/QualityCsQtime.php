<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QualityCsQtime extends Model
{
    use HasFactory;

    protected $table = 'quality_cs_qtimes';

    protected $fillable = [
        'quality_monitor_id',
        'shift',   
        'cycle',   
             
        'destructive_test',        
        'destructive_test_remark',        
        'appearance_produk',        
        'appearance_produk_remark',        
        'parting_line',        
        'parting_line_remark',        
        'marking_cek_final',        
        'marking_cek_final_remark',        
        'marking_garansi_function',        
        'marking_garansi_function_remark',        
        'marking_identification',    
        'marking_identification_remark',    

        'kelengkapan_komponen',        
        'kelengkapan_komponen_remark',        
        // 'housing',        
        // 'lens',        
        // 'extension',        
        // 'extension_rs_1',        
        // 'reflector_1',        
        // 'reflector_2',        
        // 'light_guide',        
        // 'base',        
        // 'ldm',        
        // 'wire_harness_1',        
        // 'wire_harness_2',        
        // 'wire_harness_3',        
        // 'wire_harness_4',        
        // 'wire_harness_5',        
        // 'pcb_assy_2',        
        // 'pcb_assy_3',        
        // 'gore_tag',        
        // 'tapping_screw',        
        // 'tapping_screw_assy',        
        // 'screw_pin',        
        // 'non_woven_tape',        
        // 'vant_cap_assy',        
        // 'kondisi_jig',        
        // 'kondisi_pokayoke',        
        // 'operator_wi_qpoint',        
        // 'childpart_identitas',        
        // 'kondisi_parameter',        
        'judge',  

        'approval_status',        

        'created_by',
        'updated_by'
    ];

    protected $dates = ['deleted_at'];
}
