<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QualityCsIpqc extends Model
{
    use HasFactory;

    protected $table = 'quality_cs_ipqcs';

    protected $fillable = [
        'quality_ipqc_id',
        'shift',   
        'cycle',   
             
        'destructive_test',        
        'destructive_test_remark', 
        'destructive_test_hold_status',
        'destructive_test_qty',           
        'destructive_test_hold_cat',           

        'appearance_produk',        
        'appearance_produk_remark',    
        'appearance_produk_ng_cat',   
        'appearance_produk_photo',
        'appearance_produk_causes',
        'appearance_produk_repair',
        'appearance_produk_repair_res',
        'appearance_produk_hold_status',
        'appearance_produk_qty',
        'appearance_produk_hold_cat',

        'parting_line',        
        'parting_line_remark',
        'parting_line_ng_cat',
        'parting_line_photo',
        'parting_line_causes',
        'parting_line_repair',
        'parting_line_repair_res',
        'parting_line_hold_status',
        'parting_line_qty',
        'parting_line_hold_cat',

        'marking_cek_final',        
        'marking_cek_final_remark',        
        'marking_garansi_function',        
        'marking_garansi_function_remark',        
        'marking_identification',    
        'marking_identification_remark',    

        'kelengkapan_komponen',        
        'kelengkapan_komponen_remark',        
        'kelengkapan_komponen_hold_status',        
        'kelengkapan_komponen_qty',        
        'kelengkapan_komponen_hold_cat',        
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
