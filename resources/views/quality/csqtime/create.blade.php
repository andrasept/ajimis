@extends('layouts.app-master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quality Monitoring</h2>
	</div>
	<div class="col-lg-2">
	</div>
</div>

@include('layouts.partials.messages')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Add QTime Checksheet</h5>
					<div class="ibox-tools">
					</div>
				</div>
				<div class="ibox-content">
					<form method="POST" action="{{ route('quality.csqtime.store') }}">
						@csrf
						<!-- Checksheet Info -->
						<div class="form-group row">
							<label class="col-sm-2 col-form-label"><strong>Checkshet Category</strong></label>
	                        <div class="col-sm-4"><p class="form-control-static">{{$cs_category}}</p></div>
	                        <label class="col-sm-2 col-form-label"><strong>Line</strong></label>
	                        <div class="col-sm-4"><p class="form-control-static">{{$cs_area}} - {{$cs_process}}</p></div>
	                    </div>
	                    <div class="form-group row">
							<label class="col-sm-2 col-form-label"><strong>Document Number</strong></label>
	                        <div class="col-sm-4"><p class="form-control-static">{{$doc_number}}</p></div>
	                        <label class="col-sm-2 col-form-label"><strong>Model Part</strong></label>
	                        <div class="col-sm-4"><p class="form-control-static">{{$cs_model}} - {{$cs_part}} - {{$part_ver}} {{$part_hor}}</p></div>
	                    </div>
	                    <!-- Photo Info -->
	                    <div class="ibox">
	                        <div class="ibox-title">
	                            <label class="col-sm-2 col-form-label"><strong>Photo Instructions</strong></label>
	                            <div class="ibox-tools">
	                                <a class="collapse-link">
	                                    <i class="fa fa-chevron-up"></i>
	                                </a>
	                            </div>
	                        </div>
	                        <div class="ibox-content">
	                        	-- Photo --
	                        </div>
	                    </div>
	                    <div class="hr-line-dashed"></div>
	                    <!-- Select Shift and Cycle -->
	                    <div class="form-group row">
	                    	<label class="col-sm-2 col-form-label"><strong>Shift</strong></label>
	                        <div class="col-sm-4">
	                        	<select class="form-control m-b" name="shift" required>
                                    <option value="" selected>--Select Shift--</option>
                                    <option value="1">Shift 1</option>
                                    <option value="2">Shift 2</option>
                                </select>
	                        </div>
	                        <label class="col-sm-2 col-form-label"><strong>Cycle</strong></label>
	                        <div class="col-sm-4">
	                        	<select class="form-control m-b" name="cycle" required>
                                    <option value="" selected>--Select Cycle--</option>
                                    <option value="1">Cycle 1</option>
                                    <option value="2">Cycle 2</option>
                                    <option value="3">Cycle 3</option>
                                    <option value="4">Cycle 4</option>
                                    <option value="5">Cycle 5</option>
                                    <option value="6">Cycle 6</option>
                                    <option value="7">Cycle 7</option>
                                </select>
	                        </div>
	                    </div>
	                    <div class="hr-line-dashed"></div>
	                    <!-- Input Checksheet -->	                    
	                    <div class="form-group row">
	                    	<div class="col-md-7">
	                    		<h3>Item Cek</h3>
	                    	</div>
	                    	<div class="col-md-3">
	                    		<p class="font-bold">Standard</p>
	                    	</div>
	                    	<div class="col-md-2">
	                    		<p class="font-bold">Method</p>
	                    	</div>
	                    </div>
	                    <input type="hidden" name="quality_monitor_id" value="{{$q_monitor_id}}" \>
                    	<p class="font-bold">1. Appearance</p>                    	
	                    <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Destructive Test</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="destructive_test" id="destructive_test_ok" value="1" required>
                                            <span class="badge badge-primary" for="destructive_test_ok">OK</span>
                                            
                                            <input type="radio" name="destructive_test" id="destructive_test_ac" value="2">
                                            <span class="badge badge-warning" for="destructive_test_ac">AC</span>
                                            
                                            <input type="radio" name="destructive_test" id="destructive_test_ng" value="3">
                                            <span class="badge badge-danger" for="destructive_test_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Tidak Bocor, Follow Limit sample</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Appearance Produk</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="appearance_produk" id="appearance_produk_ok" value="1"required>
                                            <span class="badge badge-primary" for="appearance_produk_ok">OK</span>
                                            
                                            <input type="radio" name="appearance_produk" id="appearance_produk_ac" value="2">
                                            <span class="badge badge-warning" for="appearance_produk_ac">AC</span>
                                            
                                            <input type="radio" name="appearance_produk" id="appearance_produk_ng" value="3">
                                            <span class="badge badge-danger" for="appearance_produk_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>General Standard Apperance/Limit Sample</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Parting Line</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="parting_line" id="parting_line_ok" value="1" required>
                                            <span class="badge badge-primary" for="parting_line_ok">OK</span>
                                            
                                            <input type="radio" name="parting_line" id="parting_line_ac" value="2">
                                            <span class="badge badge-warning" for="parting_line_ac">AC</span>
                                            
                                            <input type="radio" name="parting_line" id="parting_line_ng" value="3">
                                            <span class="badge badge-danger" for="parting_line_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Tidak Burry tajam</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>	  

                        <p class="font-bold">2. Marking Garansi</p>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Marking Cek Final</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="marking_cek_final" id="marking_cek_final_ok" value="1" required>
                                            <span class="badge badge-primary" for="marking_cek_final_ok">OK</span>
                                            
                                            <input type="radio" name="marking_cek_final" id="marking_cek_final_ac" value="2">
                                            <span class="badge badge-warning" for="marking_cek_final_ac">AC</span>
                                            
                                            <input type="radio" name="marking_cek_final" id="marking_cek_final_ng" value="3">
                                            <span class="badge badge-danger" for="marking_cek_final_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terlihat Jelas</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Marking Garansi Function</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="marking_garansi_function" id="marking_garansi_function_ok" value="1" required>
                                            <span class="badge badge-primary" for="marking_garansi_function_ok">OK</span>
                                            
                                            <input type="radio" name="marking_garansi_function" id="marking_garansi_function_ac" value="2">
                                            <span class="badge badge-warning" for="marking_garansi_function_ac">AC</span>
                                            
                                            <input type="radio" name="marking_garansi_function" id="marking_garansi_function_ng" value="3">
                                            <span class="badge badge-danger" for="marking_garansi_function_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Sesuai Shift O/P F/I</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Marking Identification</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="marking_identification" id="marking_identification_ok" value="1" required>
                                            <span class="badge badge-primary" for="marking_identification_ok">OK</span>
                                            
                                            <input type="radio" name="marking_identification" id="marking_identification_ac" value="2">
                                            <span class="badge badge-warning" for="marking_identification_ac">AC</span>
                                            
                                            <input type="radio" name="marking_identification" id="marking_identification_ng" value="3">
                                            <span class="badge badge-danger" for="marking_identification_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Low Gride (4R/4L)</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <p class="font-bold">3. Komponen</p>                    	
	                    <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Housing</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="housing" id="housing_ok" value="1" required>
                                            <span class="badge badge-primary" for="housing_ok">OK</span>
                                            
                                            <input type="radio" name="housing" id="housing_ac" value="2">
                                            <span class="badge badge-warning" for="housing_ac">AC</span>
                                            
                                            <input type="radio" name="housing" id="housing_ng" value="3">
                                            <span class="badge badge-danger" for="housing_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Tidak boleh crack, scrath, burry, dented, short mold, deform, over cut, lain nya.</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Lens</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="lens" id="lens_ok" value="1" required>
                                            <span class="badge badge-primary" for="lens_ok">OK</span>
                                            
                                            <input type="radio" name="lens" id="lens_ac" value="2">
                                            <span class="badge badge-warning" for="lens_ac">AC</span>
                                            
                                            <input type="radio" name="lens" id="lens_ng" value="3">
                                            <span class="badge badge-danger" for="lens_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Tidak boleh bubble, crack, scrath, dented, kontaminasi, silver, weldline, sinkmark, lain nya.</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Extension</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="extension" id="extension_ok" value="1" required>
                                            <span class="badge badge-primary" for="extension_ok">OK</span>
                                            
                                            <input type="radio" name="extension" id="extension_ac" value="2">
                                            <span class="badge badge-warning" for="extension_ac">AC</span>
                                            
                                            <input type="radio" name="extension" id="extension_ng" value="3">
                                            <span class="badge badge-danger" for="extension_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Reflector 1</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="reflector_1" id="reflector_1_ok" value="1" required>
                                            <span class="badge badge-primary" for="reflector_1_ok">OK</span>
                                            
                                            <input type="radio" name="reflector_1" id="reflector_1_ac" value="2">
                                            <span class="badge badge-warning" for="reflector_1_ac">AC</span>
                                            
                                            <input type="radio" name="reflector_1" id="reflector_1_ng" value="3">
                                            <span class="badge badge-danger" for="reflector_1_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Reflector 2</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="reflector_2" id="reflector_2_ok" value="1" required>
                                            <span class="badge badge-primary" for="reflector_2_ok">OK</span>
                                            
                                            <input type="radio" name="reflector_2" id="reflector_2_ac" value="2">
                                            <span class="badge badge-warning" for="reflector_2_ac">AC</span>
                                            
                                            <input type="radio" name="reflector_2" id="reflector_2_ng" value="3">
                                            <span class="badge badge-danger" for="reflector_2_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">LDM</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="ldm" id="ldm_ok" value="1" required>
                                            <span class="badge badge-primary" for="ldm_ok">OK</span>
                                            
                                            <input type="radio" name="ldm" id="ldm_ac" value="2">
                                            <span class="badge badge-warning" for="ldm_ac">AC</span>
                                            
                                            <input type="radio" name="ldm" id="ldm_ng" value="3">
                                            <span class="badge badge-danger" for="ldm_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Wire Harness 2</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="wire_harness_2" id="wire_harness_2_ok" value="1" required>
                                            <span class="badge badge-primary" for="wire_harness_2_ok">OK</span>
                                            
                                            <input type="radio" name="wire_harness_2" id="wire_harness_2_ac" value="2">
                                            <span class="badge badge-warning" for="wire_harness_2_ac">AC</span>
                                            
                                            <input type="radio" name="wire_harness_2" id="wire_harness_2_ng" value="3">
                                            <span class="badge badge-danger" for="wire_harness_2_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Wire Harness 3</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="wire_harness_3" id="wire_harness_3_ok" value="1" required>
                                            <span class="badge badge-primary" for="wire_harness_3_ok">OK</span>
                                            
                                            <input type="radio" name="wire_harness_3" id="wire_harness_3_ac" value="2">
                                            <span class="badge badge-warning" for="wire_harness_3_ac">AC</span>
                                            
                                            <input type="radio" name="wire_harness_3" id="wire_harness_3_ng" value="3">
                                            <span class="badge badge-danger" for="wire_harness_3_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Wire Harness 4</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="wire_harness_4" id="wire_harness_4_ok" value="1" required>
                                            <span class="badge badge-primary" for="wire_harness_4_ok">OK</span>
                                            
                                            <input type="radio" name="wire_harness_4" id="wire_harness_4_ac" value="2">
                                            <span class="badge badge-warning" for="wire_harness_4_ac">AC</span>
                                            
                                            <input type="radio" name="wire_harness_4" id="wire_harness_4_ng" value="3">
                                            <span class="badge badge-danger" for="wire_harness_4_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Wire Harness 5</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="wire_harness_5" id="wire_harness_5_ok" value="1" required>
                                            <span class="badge badge-primary" for="wire_harness_5_ok">OK</span>
                                            
                                            <input type="radio" name="wire_harness_5" id="wire_harness_5_ac" value="2">
                                            <span class="badge badge-warning" for="wire_harness_5_ac">AC</span>
                                            
                                            <input type="radio" name="wire_harness_5" id="wire_harness_5_ng" value="3">
                                            <span class="badge badge-danger" for="wire_harness_5_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">PCB Assy 2</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="pcb_assy_2" id="pcb_assy_2_ok" value="1" required>
                                            <span class="badge badge-primary" for="pcb_assy_2_ok">OK</span>
                                            
                                            <input type="radio" name="pcb_assy_2" id="pcb_assy_2_ac" value="2">
                                            <span class="badge badge-warning" for="pcb_assy_2_ac">AC</span>
                                            
                                            <input type="radio" name="pcb_assy_2" id="pcb_assy_2_ng" value="3">
                                            <span class="badge badge-danger" for="pcb_assy_2_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">PCB Assy 3</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="pcb_assy_3" id="pcb_assy_3_ok" value="1" required>
                                            <span class="badge badge-primary" for="pcb_assy_3_ok">OK</span>
                                            
                                            <input type="radio" name="pcb_assy_3" id="pcb_assy_3_ac" value="2">
                                            <span class="badge badge-warning" for="pcb_assy_3_ac">AC</span>
                                            
                                            <input type="radio" name="pcb_assy_3" id="pcb_assy_3_ng" value="3">
                                            <span class="badge badge-danger" for="pcb_assy_3_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Gore Tag</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="gore_tag" id="gore_tag_ok" value="1" required>
                                            <span class="badge badge-primary" for="gore_tag_ok">OK</span>
                                            
                                            <input type="radio" name="gore_tag" id="gore_tag_ac" value="2">
                                            <span class="badge badge-warning" for="gore_tag_ac">AC</span>
                                            
                                            <input type="radio" name="gore_tag" id="gore_tag_ng" value="3">
                                            <span class="badge badge-danger" for="gore_tag_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Tapping Screw</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="tapping_screw" id="tapping_screw_ok" value="1" required>
                                            <span class="badge badge-primary" for="tapping_screw_ok">OK</span>
                                            
                                            <input type="radio" name="tapping_screw" id="tapping_screw_ac" value="2">
                                            <span class="badge badge-warning" for="tapping_screw_ac">AC</span>
                                            
                                            <input type="radio" name="tapping_screw" id="tapping_screw_ng" value="3">
                                            <span class="badge badge-danger" for="tapping_screw_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Tapping Screw Assy</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="tapping_screw_assy" id="tapping_screw_assy_ok" value="1" required>
                                            <span class="badge badge-primary" for="tapping_screw_assy_ok">OK</span>
                                            
                                            <input type="radio" name="tapping_screw_assy" id="tapping_screw_assy_ac" value="2">
                                            <span class="badge badge-warning" for="tapping_screw_assy_ac">AC</span>
                                            
                                            <input type="radio" name="tapping_screw_assy" id="tapping_screw_assy_ng" value="3">
                                            <span class="badge badge-danger" for="tapping_screw_assy_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Screw Pin</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="screw_pin" id="screw_pin_ok" value="1" required>
                                            <span class="badge badge-primary" for="screw_pin_ok">OK</span>
                                            
                                            <input type="radio" name="screw_pin" id="screw_pin_ac" value="2">
                                            <span class="badge badge-warning" for="screw_pin_ac">AC</span>
                                            
                                            <input type="radio" name="screw_pin" id="screw_pin_ng" value="3">
                                            <span class="badge badge-danger" for="screw_pin_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar, tidak boleh ngambang, miring, amblas.</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Non Woven Tape</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="non_woven_tape" id="non_woven_tape_ok" value="1" required>
                                            <span class="badge badge-primary" for="non_woven_tape_ok">OK</span>
                                            
                                            <input type="radio" name="non_woven_tape" id="non_woven_tape_ac" value="2">
                                            <span class="badge badge-warning" for="non_woven_tape_ac">AC</span>
                                            
                                            <input type="radio" name="non_woven_tape" id="non_woven_tape_ng" value="3">
                                            <span class="badge badge-danger" for="non_woven_tape_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar, tidak boleh miring</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Vent Cap Assy</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="vent_cap_assy" id="vent_cap_assy_ok" value="1" required>
                                            <span class="badge badge-primary" for="vent_cap_assy_ok">OK</span>
                                            
                                            <input type="radio" name="vent_cap_assy" id="vent_cap_assy_ac" value="2">
                                            <span class="badge badge-warning" for="vent_cap_assy_ac">AC</span>
                                            
                                            <input type="radio" name="vent_cap_assy" id="vent_cap_assy_ng" value="3">
                                            <span class="badge badge-danger" for="vent_cap_assy_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Terpasang dengan benar, tidak boleh miring</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <p class="font-bold">4. Line Process</p>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Kondisi Jig</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="kondisi_jig" id="kondisi_jig_ok" value="1" required>
                                            <span class="badge badge-primary" for="kondisi_jig_ok">OK</span>
                                            
                                            <input type="radio" name="kondisi_jig" id="kondisi_jig_ac" value="2">
                                            <span class="badge badge-warning" for="kondisi_jig_ac">AC</span>
                                            
                                            <input type="radio" name="kondisi_jig" id="kondisi_jig_ng" value="3">
                                            <span class="badge badge-danger" for="kondisi_jig_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Bersih</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Kondisi Pokayoke</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="kondisi_pokayoke" id="kondisi_pokayoke_ok" value="1" required>
                                            <span class="badge badge-primary" for="kondisi_pokayoke_ok">OK</span>
                                            
                                            <input type="radio" name="kondisi_pokayoke" id="kondisi_pokayoke_ac" value="2">
                                            <span class="badge badge-warning" for="kondisi_pokayoke_ac">AC</span>
                                            
                                            <input type="radio" name="kondisi_pokayoke" id="kondisi_pokayoke_ng" value="3">
                                            <span class="badge badge-danger" for="kondisi_pokayoke_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Berfungsi dengan baik</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Operator bekerja sesuai WI dan Q-point</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="operator_wi_qpoint" id="operator_wi_qpoint_ok" value="1" required>
                                            <span class="badge badge-primary" for="operator_wi_qpoint_ok">OK</span>
                                            
                                            <input type="radio" name="operator_wi_qpoint" id="operator_wi_qpoint_ac" value="2">
                                            <span class="badge badge-warning" for="operator_wi_qpoint_ac">AC</span>
                                            
                                            <input type="radio" name="operator_wi_qpoint" id="operator_wi_qpoint_ng" value="3">
                                            <span class="badge badge-danger" for="operator_wi_qpoint_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Sesuai urutan WI dan Q-point</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Penempatan childpart sesuai identitas</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="childpart_identitas" id="childpart_identitas_ok" value="1" required>
                                            <span class="badge badge-primary" for="childpart_identitas_ok">OK</span>
                                            
                                            <input type="radio" name="childpart_identitas" id="childpart_identitas_ac" value="2">
                                            <span class="badge badge-warning" for="childpart_identitas_ac">AC</span>
                                            
                                            <input type="radio" name="childpart_identitas" id="childpart_identitas_ng" value="3">
                                            <span class="badge badge-danger" for="childpart_identitas_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Sesuai identitas</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-7">                                
                                <div class="form-group row">
                                	<label class="col-md-4 col-form-label">Kondisi Parameter</label>
                                    <div class="col-md-8">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="kondisi_parameter" id="kondisi_parameter_ok" value="1" required>
                                            <span class="badge badge-primary" for="kondisi_parameter_ok">OK</span>
                                            
                                            <input type="radio" name="kondisi_parameter" id="kondisi_parameter_ac" value="2">
                                            <span class="badge badge-warning" for="kondisi_parameter_ac">AC</span>
                                            
                                            <input type="radio" name="kondisi_parameter" id="kondisi_parameter_ng" value="3">
                                            <span class="badge badge-danger" for="kondisi_parameter_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Sesuai std parameter setting</p>
                            </div>
                            <div class="col-md-2">
                                <p>Dilihat</p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>	

						<div class="form-group row">
							<div class="col-sm-10 col-sm-offset-2">
								<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('quality.monitor.index') }}';" value="Cancel" />&nbsp;&nbsp;&nbsp;
								<button class="btn btn-primary btn-sm" type="submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<!-- data tables -->
<script src="{{asset('js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$(document).ready(function(){
		$('.dataTables-example').DataTable({
			rowReorder: {
	            selector: 'td:nth-child(2)'
	        },
			pageLength: 25,
			responsive: true,
			// dom: '<"top"i>rt<"bottom"flp><"clear">',
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
				// {extend: 'copy'},
				// {extend: 'csv'},
				// {extend: 'excel', title: 'ExampleFile'},
				// {extend: 'pdf', title: 'ExampleFile'},
				// {extend: 'print',
				// 	customize: function (win){
				// 		$(win.document.body).addClass('white-bg');
				// 		$(win.document.body).css('font-size', '10px');

				// 		$(win.document.body).find('table')
				// 		.addClass('compact')
				// 		.css('font-size', 'inherit');
				// 	}
				// }
			]
		});
	});
</script>
<!-- data tables responsive -->
<script src="{{asset('js/dataTables.rowReorder.min.js')}}"></script>
<script src="{{asset('js/dataTables.responsive.min.js')}}"></script>

<!-- iCheck -->
<script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
<!-- Select2 -->
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
<script>
        $(document).ready(function(){
        	$(".select2_demo_1").select2();
    	});
</script>
<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
<!-- jquery steps -->
<script>
        $(document).ready(function(){
            $("#wizard").steps();
       });
    </script>
@endpush

@push('stylesheets')
<link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
<!-- Select2  -->
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<!-- jQuery steps -->
<link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
<!-- jquery animate -->
<link href="{{asset('css/animate.css')}}" rel="stylesheet">
<!-- data tables responsive -->
<link href="{{asset('css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/rowReorder.dataTables.min.css')}}" rel="stylesheet">
@endpush