@extends('layouts.app-master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quality Monitoring IPQC</h2>
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
					<h5>Add IPQC Checksheet</h5>
					<div class="ibox-tools">
					</div>
				</div>
				<div class="ibox-content">
					<form method="POST" action="{{ route('quality.csipqc.store') }}">
						@csrf
						<!-- Checksheet Info -->
						<div class="form-group row">
							<label class="col-sm-2 col-form-label"><strong>Line</strong></label>
	                        <div class="col-sm-4"><p class="form-control-static">{{$cs_area}} - {{$cs_process}}</p></div>
	                        <label class="col-sm-2 col-form-label"><strong>Machine</strong></label>
	                        <div class="col-sm-4"><p class="form-control-static">{{$cs_machine}}</p></div>
	                    </div>
	                    <div class="form-group row">
							<label class="col-sm-2 col-form-label"><strong>Lot Produksi</strong></label>
	                        <div class="col-sm-4"><p class="form-control-static">{{$lot_produksi}}</p></div>
	                        <label class="col-sm-2 col-form-label"><strong>Model Part</strong></label>
	                        <div class="col-sm-4"><p class="form-control-static">{{$cs_model}} - {{$cs_part}} - {{$part_hor}} - {{$part_ver}}</p></div>
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
	                        	<img src="{{asset('quality/wi/'.$cs_photo)}}" \>
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
	                    	<div class="col-md-5">
	                    		<h3>Item Cek</h3>
	                    	</div>
	                    	<div class="col-md-3">
	                    		<p class="font-bold">Method &<br/>Standard</p>
	                    	</div>
	                    	<div class="col-md-4">
	                    		<p class="font-bold">Remark</p>
	                    	</div>
	                    </div>
	                    <input type="hidden" name="quality_monitor_id" value="{{$q_ipqc_id}}" \>
                    	<p class="font-bold">1. Appearance</p>                    	
	                    <div class="form-group row">	
                            <div class="col-md-5">                                
                                <div class="form-group row">
                                	<label class="col-lg-5 col-md-12 col-form-label">Destructive Test</label>
                                    <div class="col-lg-7 col-md-12">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="destructive_test" id="destructive_test_ok" value="1" required>
                                            <span class="badge badge-primary" for="destructive_test_ok">OK</span>
                                           	                                            
                                            <input type="radio" name="destructive_test" id="destructive_test_ng" value="3" class="destructive_test_ng" >
                                            <span class="badge badge-danger" for="destructive_test_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p>Dilihat</p>
                                <p>Tidak Bocor, Follow Limit sample</p>
                            </div>
                            <div class="col-md-4">
                                <div id="destructive_test_show" class="" style="display:none;">

                        			<textarea class="form-control" id="destructive_test_remark" name="destructive_test_remark" rows="2"></textarea>
                        			
                                   	<br/><hr/>
                                   	Hold : 
                                   	<input type="radio" name="destructive_test_hold_status" id="destructive_test_hold_status_yes" value="1" data-toggle="modal" data-target="#myModal6">
                                    <span class="badge badge-primary" for="destructive_test_hold_status_yes">Ya</span>
                                    <input type="radio" name="destructive_test_hold_status" id="destructive_test_hold_status_no" value="0">
                                    <span class="badge badge-danger" for="destructive_test_hold_status_no">Tidak</span>

                                    <div id="destructive_test_hold_status_yes_show" style="display: none;">
                                    	<label class="col-form-label">Quantity : </label><br/>
                                    	<input type="number" class="form-control" name="destructive_test_qty">
                                    	<br/>
                                    	<select class="form-control m-b" name="destructive_test_hold_cat">
		                                    <option value="" selected>-- Hold Status --</option>
		                                    <option value="1">Pending</option>
		                                    <option value="2">Sortir</option>
		                                    <option value="3">Repair</option>
		                                </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">	
                            <div class="col-md-5">                                
                                <div class="form-group row">
                                	<label class="col-lg-5 col-md-12 col-form-label">Appearance Produk</label>
                                    <div class="col-lg-7 col-md-12">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="appearance_produk" id="appearance_produk_ok" value="1"required>
                                            <span class="badge badge-primary" for="appearance_produk_ok">OK</span>
                                            
                                            <input type="radio" name="appearance_produk" id="appearance_produk_ng" value="3">
                                            <span class="badge badge-danger" for="appearance_produk_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            	<p>Dilihat</p>
                                <p>General Standard Apperance/Limit Sample</p>
                            </div>
                            <div class="col-md-4">
                                <!-- <textarea class="form-control" id="appearance_produk_remark" name="appearance_produk_remark" rows="2"></textarea> -->
                                <div id="appearance_produk_show" class="" style="display:none;">
                                	<select class="form-control m-b" name="appearance_produk_ng_cat">
	                                    <option value="" selected>--Jenis NG--</option>
	                                    @foreach($q_ngcategories as $ngc)
	                                    	<option value="{{$ngc->id}}">{{$ngc->name}}</option>
	                                    @endforeach
	                                </select>
					                <button class="btn btn-danger btn-circle" type="button" style="position: absolute; left:-20px;"><i class="fa fa-trash" onclick="appearanceClearImage()"></i></button>
	                                <input class="form-control" type="file" id="appearance_produk_photo" onchange="appearancePreview()" accept="image/*;capture=camera" name="appearance_produk_photo" placeholder="Upload Photo">
	                                <br/><br/>
					                <img width="200px" id="appearance_produk_img" src="" class="img-fluid" />
					                <br/>
					                <textarea class="form-control" id="appearance_produk_causes" name="appearance_produk_causes" rows="2" placeholder="Causes"></textarea>
					                <br/>
					                <textarea class="form-control" id="appearance_produk_repair" name="appearance_produk_repair" rows="2" placeholder="Repair"></textarea>
					                <br/>
					                Repair Result 
					                <input type="radio" name="appearance_produk_repair_res" id="appearance_produk_repair_res_ok" value="1">
                                    <span class="badge badge-primary" for="appearance_produk_repair_res_ok">OK</span>
                                    <input type="radio" name="appearance_produk_repair_res" id="appearance_produk_repair_res_ng" value="3">
                                    <span class="badge badge-danger" for="appearance_produk_repair_res_ng">NG</span>
                                   	<br/><hr/>
                                   	Hold : 
                                   	<input type="radio" name="appearance_produk_hold_status" id="appearance_produk_hold_status_yes" value="1" data-toggle="modal" data-target="#myModal6">
                                    <span class="badge badge-primary" for="appearance_produk_hold_status_yes">Ya</span>
                                    <input type="radio" name="appearance_produk_hold_status" id="appearance_produk_hold_status_no" value="0">
                                    <span class="badge badge-danger" for="appearance_produk_hold_status_no">Tidak</span>

                                    <div id="appearance_produk_hold_status_yes_show" style="display: none;">
                                    	<label class="col-form-label">Quantity : </label><br/>
                                    	<input type="number" class="form-control" name="appearance_produk_qty">
                                    	<br/>
                                    	<select class="form-control m-b" name="appearance_produk_hold_cat">
		                                    <option value="" selected>-- Hold Status --</option>
		                                    <option value="1">Pending</option>
		                                    <option value="2">Sortir</option>
		                                    <option value="3">Repair</option>
		                                </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-5">                                
                                <div class="form-group row">
                                	<label class="col-lg-5 col-md-12 col-form-label">Parting Line</label>
                                    <div class="col-lg-7 col-md-12">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="parting_line" id="parting_line_ok" value="1" required>
                                            <span class="badge badge-primary" for="parting_line_ok">OK</span>
                                            
                                            <!-- <input type="radio" name="parting_line" id="parting_line_ac" value="2">
                                            <span class="badge badge-warning" for="parting_line_ac">AC</span> -->
                                            
                                            <input type="radio" name="parting_line" id="parting_line_ng" value="3">
                                            <span class="badge badge-danger" for="parting_line_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            	<p>Dilihat</p>
                                <p>Tidak Burry tajam</p>
                            </div>
                            <div class="col-md-4">
                                <textarea class="form-control" id="parting_line_remark" name="parting_line_remark" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>	  

                        <p class="font-bold">2. Marking Garansi</p>
                        <div class="form-group row">	
                            <div class="col-md-5">                                
                                <div class="form-group row">
                                	<label class="col-lg-5 col-md-12 col-form-label">Marking Cek Final</label>
                                    <div class="col-lg-7 col-md-12">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="marking_cek_final" id="marking_cek_final_ok" value="1" required>
                                            <span class="badge badge-primary" for="marking_cek_final_ok">OK</span>
                                            
                                            <!-- <input type="radio" name="marking_cek_final" id="marking_cek_final_ac" value="2">
                                            <span class="badge badge-warning" for="marking_cek_final_ac">AC</span> -->
                                            
                                            <input type="radio" name="marking_cek_final" id="marking_cek_final_ng" value="3">
                                            <span class="badge badge-danger" for="marking_cek_final_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            	<p>Dilihat</p>
                                <p>Terlihat Jelas</p>
                            </div>
                            <div class="col-md-4">
                                <textarea class="form-control" id="marking_cek_final_remark" name="marking_cek_final_remark" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-5">                                
                                <div class="form-group row">
                                	<label class="col-lg-5 col-md-12 col-form-label">Marking Garansi Function</label>
                                    <div class="col-lg-7 col-md-12">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="marking_garansi_function" id="marking_garansi_function_ok" value="1" required>
                                            <span class="badge badge-primary" for="marking_garansi_function_ok">OK</span>
                                            
                                            <!-- <input type="radio" name="marking_garansi_function" id="marking_garansi_function_ac" value="2">
                                            <span class="badge badge-warning" for="marking_garansi_function_ac">AC</span> -->
                                            
                                            <input type="radio" name="marking_garansi_function" id="marking_garansi_function_ng" value="3">
                                            <span class="badge badge-danger" for="marking_garansi_function_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            	<p>Dilihat</p>
                                <p>Sesuai Shift O/P F/I</p>
                            </div>
                            <div class="col-md-4">
                                <textarea class="form-control" id="marking_garansi_function_remark" name="marking_garansi_function_remark" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">	
                            <div class="col-md-5">                                
                                <div class="form-group row">
                                	<label class="col-lg-5 col-md-12 col-form-label">Marking Identification</label>
                                    <div class="col-lg-7 col-md-12">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="marking_identification" id="marking_identification_ok" value="1" required>
                                            <span class="badge badge-primary" for="marking_identification_ok">OK</span>
                                            
                                            <!-- <input type="radio" name="marking_identification" id="marking_identification_ac" value="2">
                                            <span class="badge badge-warning" for="marking_identification_ac">AC</span> -->
                                            
                                            <input type="radio" name="marking_identification" id="marking_identification_ng" value="3">
                                            <span class="badge badge-danger" for="marking_identification_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            	<p>Dilihat</p>
                                <p>Low Gride (4R/4L)</p>
                            </div>
                            <div class="col-md-4">
                                <textarea class="form-control" id="marking_identification_remark" name="marking_identification_remark" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <p class="font-bold">3. Komponen</p>   
                        <div class="form-group row">	
                            <div class="col-md-5">                                
                                <div class="form-group row">
                                	<label class="col-lg-5 col-md-12 col-form-label">Kelengkapan Komponen</label>
                                    <div class="col-lg-7 col-md-12">
                                    	<div class="i-checks radio">
                                            <input type="radio" name="kelengkapan_komponen" id="kelengkapan_komponen_ok" value="1" required>
                                            <span class="badge badge-primary" for="kelengkapan_komponen_ok">OK</span>
                                            
                                            <!-- <input type="radio" name="kelengkapan_komponen" id="kelengkapan_komponen_ac" value="2">
                                            <span class="badge badge-warning" for="kelengkapan_komponen_ac">AC</span> -->
                                            
                                            <input type="radio" name="kelengkapan_komponen" id="kelengkapan_komponen_ng" value="3">
                                            <span class="badge badge-danger" for="kelengkapan_komponen_ng">NG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p></p>
                            </div>
                            <div class="col-md-4">
                                <textarea class="form-control" id="kelengkapan_komponen_remark" name="kelengkapan_komponen_remark" rows="2"></textarea>
                            </div>
                        </div> 
                        <div class="ibox">
	                        <div class="ibox-title">
	                            <label class="col-sm-2 col-form-label"><strong>List Komponen</strong></label>
	                            <div class="ibox-tools">
	                                <a class="collapse-link">
	                                    <i class="fa fa-chevron-up"></i>
	                                </a>
	                            </div>
	                        </div>
	                        <div class="ibox-content">
	                        	<div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Housing</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Tidak boleh crack, scrath, burry, dented, short mold, deform, over cut, lain nya.</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Lens</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Tidak boleh bubble, crack, scrath, dented, kontaminasi, silver, weldline, sinkmark, lain nya.</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Extension</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Reflector 1</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Reflector 2</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">LDM</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Wire Harness 2</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Wire Harness 3</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Wire Harness 4</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Wire Harness 5</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">PCB Assy 2</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">PCB Assy 3</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Gore Tag</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Tapping Screw</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Tapping Screw Assy</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Screw Pin</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar, tidak boleh ngambang, miring, amblas.</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Non Woven Tape</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar, tidak boleh miring</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
		                        <div class="form-group row">	
		                            <div class="col-md-4">                                
		                                <div class="form-group row">
		                                	<label class="col-md-4 col-form-label">Vent Cap Assy</label>
		                                </div>
		                            </div>
		                            <div class="col-md-5">
		                                <p>Terpasang dengan benar, tidak boleh miring</p>
		                            </div>
		                            <div class="col-md-3">
		                                <p>Dilihat</p>
		                            </div>
		                        </div>
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
	function destructivePreview() {
        destructive_test_img.src = URL.createObjectURL(event.target.files[0]);
    }
    function destructiveClearImage() {
        document.getElementById('destructive_test_photo').value = null;
        destructive_test_img.src = "";
    }
    function appearancePreview() {
        appearance_produk_img.src = URL.createObjectURL(event.target.files[0]);
    }
    function appearanceClearImage() {
        document.getElementById('appearance_produk_photo').value = null;
        appearance_produk_img.src = "";
    }
    $(document).ready(function () {
        // $('.i-checks').iCheck({
        //     checkboxClass: 'icheckbox_square-green',
        //     radioClass: 'iradio_square-green',
        // });

        // Destructive Test
        $("#destructive_test_ng").click(function() {
	        $("div#destructive_test_show").show();
	        $("div#destructive_test_show textarea#destructive_test_causes").prop('required',true);
	    });
	    $("#destructive_test_ok").click(function() {
	        $("div#destructive_test_show").hide();
	        $("div#destructive_test_show textarea#destructive_test_causes").prop('required',false);
	    });
	    // destructive_test_hold_status_yes_show
	    $("#destructive_test_hold_status_yes").click(function() {
	        $("div#destructive_test_hold_status_yes_show").show();
	    });
	    $("#destructive_test_hold_status_no").click(function() {
	        $("div#destructive_test_hold_status_yes_show").hide();
	    });

	    // Appearance Produk
	    $("#appearance_produk_ng").click(function() {
	        $("div#appearance_produk_show").show();
	    });
	    $("#appearance_produk_ok").click(function() {
	        $("div#appearance_produk_show").hide();
	    });
	    // appearance_produk_hold_status_yes_show
	    $("#appearance_produk_hold_status_yes").click(function() {
	        $("div#appearance_produk_hold_status_yes_show").show();
	    });
	    $("#appearance_produk_hold_status_no").click(function() {
	        $("div#appearance_produk_hold_status_yes_show").hide();
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

<!-- radio button click NG -->
<script>
	
</script>


<!-- <script>
$(document).ready(function(){
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        var ext = fileName.split('.').pop();
        if (ext == "png" || ext == "jpg" || ext == "jpeg") {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        } else {
            console.log(ext);
            $(this).html("");
            swal("Oops!", "Only JPG,JPEG, & PNG file!", "error");
        }
    });
    $(".add").click(function(){ 
        var html = '<div class="custom-file mt-2 "><input  name="photo[]" type="file" class="custom-file-input"><label for="photo" class="custom-file-label">Choose file...</label></div>';
        $(".increment").append(html);
        
        // ulang untuk pick file
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            var ext = fileName.split('.').pop();
            if (ext == "png" || ext == "jpg" || ext == "jpeg") {
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                console.log(ext);
                $(this).html("");
                swal("Oops!", "Only JPG,JPEG, & PNG file!", "error");
            }
        });
        // remove ulang
        $("body").on("click",".btn-danger",function(){ 
            $('div.clone').children().last().remove();
        });
    });
    $("body").on("click",".btn-danger",function(){ 
        $('div.increment').children().last().remove();
    });

    function preview() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }
    function clearImage() {
        document.getElementById('custom-file-input').value = null;
        frame.src = "";
    }

});

</script> -->

@endpush

@push('stylesheets')
<style type="text/css">
	input[type='radio'] { 
	    transform: scale(1.7); 
	    margin-right: 5px;
	    margin-left: 5px;
 	}
</style>
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