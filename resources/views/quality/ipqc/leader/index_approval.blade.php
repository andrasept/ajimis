@extends('layouts.app-master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quality Monitoring IPQC | Approval Page</h2>
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
					<h5>List Monitoring IPQC</h5>
					<div class="ibox-tools">
					</div>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th></th>
									<th>Lot Produksi</th>
									<th>Judgement</th>
									<th>Status</th>
									<th>Area</th>
									<th>Process</th>
									<th>Machine</th>
									<th>Model</th>
									<th>Part</th>
									<th>Created by</th>
									<th>Created at</th>
									<!-- <th>Action</th> -->
								</tr>
							</thead>
							<tbody>
								@foreach ($q_ipqc_leaders as $key => $q_ipqc)
								<tr class="gradeA">
									<td>
										<button class="btn btn-primary btn-circle" type="button" data-toggle="modal" data-target="#myModal{{$q_ipqc->id}}"><i class="fa fa-list"></i></button>

										<!-- <a alt="add" href="{{url('')}}/quality/csqtime/create/{{$q_ipqc->id}}" class="btn btn-success btn-circle "><i class="fa fa-plus"></i></a> -->

                		<div class="modal inmodal fade" id="myModal{{$q_ipqc->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Detail Checksheet</h4>
                            <h5 class="font-bold">
                            	Lot Produksi : {{$q_ipqc->lot_produksi}}
                            </h5>
                            <h5 class="font-bold">
                            	Line :
                            	@foreach ($q_areas as $key => $q_area)
																@if($q_area->id == $q_ipqc->quality_area_id)
																	{{$q_area->name}}
																@endif
															@endforeach 
															-
															@foreach ($q_processes as $key => $q_process)
																@if($q_process->id == $q_ipqc->quality_process_id)
																	{{$q_process->name}}
																@endif
															@endforeach
															-
															@foreach ($q_machines as $key => $q_machine)
																@if($q_machine->id == $q_ipqc->quality_machine_id)
																	{{$q_machine->name}}
																@endif
															@endforeach
                            </h5>
                            <h5 class="font-bold">
                            	Model Part : 
                            	@foreach ($q_models as $key => $q_model)
																@if($q_model->id == $q_ipqc->quality_model_id)
																	{{$q_model->name}}
																@endif
															@endforeach
															-
															@foreach ($q_parts as $key => $q_part)
																@if($q_part->id == $q_ipqc->quality_part_id)
																	{{$q_part->name}} - 
																	@php
																		if ($q_part->left) {
												                $part_hor = "Left";
												            } elseif ($q_part->center) {
												                $part_hor = "Center";
												            } elseif ($q_part->right) {
												                $part_hor = "Right";
												            } else {
												                $part_hor = "";
												            }
																		if ($q_part->low) {
											                $part_grade = "Low";
												            } elseif ($q_part->mid) {
												                $part_grade = "Mid";
												            } elseif ($q_part->high) {
												                $part_grade = "High";
												            } else {
												                $part_grade = "";
												            }								            
																	@endphp		
																	{{$part_hor}}	- {{$part_grade}}
																@endif
															@endforeach
                            </h5>
                          </div>
	                        <div class="modal-body">
	                        	<h3><i>Shift 1</i></h3>
	                          <table class="table">
	                            <thead>
		                            <tr>
	                                <th>Action</th>
	                                <th>Cycle</th>
	                                <th>Judge</th>
	                                <th>Approval</th>
	                                <th>Action Result</th>
	                                <th>Checked at</th>
	                                <th>Last Judge by</th>
	                                <th>Last Judge at</th>
		                            </tr>
	                            </thead>
	                            <tbody>
	                            	@php
	                            		$cs_s1 = DB::table('quality_cs_ipqcs')->where('shift', 1)->where('quality_ipqc_id',$q_ipqc->id)->get();
	                            	@endphp
	                            	@foreach ($cs_s1 as $keycs => $q_cs_ipqc)
	                            		<tr>
	                            			<td>
	                            				<a alt="edit" href="{{url('')}}/quality/csipqc/{{$q_cs_ipqc->id}}/edit" class="btn btn-success btn-circle "><i class="fa fa-edit"></i></a>
	                            			</td>
		                            		<td>
																			@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_ipqc->cycle}}
																			@endif
																		</td>
																		<td>
																			@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				@if($q_cs_ipqc->judge == 0)
																					<span class="badge badge-info">Waiting</span>
																				@elseif($q_cs_ipqc->judge == 1)
																					<span class="badge badge-primary">OK</span>
																				@elseif($q_cs_ipqc->judge == 2)
																					<span class="badge badge-warning">AC</span>
																				@elseif($q_cs_ipqc->judge == 3)
																				<span class="badge badge-danger">NG</span>
																				@endif
																			@endif
																		</td>
																		<td>
																			@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				@if($q_cs_ipqc->approval_status == 0)
																					<span class="badge badge-primary"><i class="fa fa-check-square"></i></span>
																				@elseif($q_cs_ipqc->approval_status == 1)
																					<span class="badge badge-warning">Waiting Leader</span><br/>
																				@elseif($q_cs_ipqc->approval_status == 2)
																					<span class="badge badge-warning">Waiting Foreman</span>
																				@elseif($q_cs_ipqc->approval_status == 3)
																				<span class="badge badge-warning">Waiting Spv</span>
																				@elseif($q_cs_ipqc->approval_status == 4)
																				<span class="badge badge-warning">Waiting Dept Head</span>
																				@elseif($q_cs_ipqc->approval_status == 5)
																				<span class="badge badge-warning">Waiting Director</span>
																				@elseif($q_cs_ipqc->approval_status == 6)
																				<span class="badge badge-primary">Approved</span>
																				@endif
																			@endif
																		</td>
																		<td>
																			@if($q_cs_ipqc->destructive_test_approval_qtyok > 0 || $q_cs_ipqc->destructive_test_approval_qtyng > 0)
																				Destructive Test :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_ipqc->destructive_test_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_ipqc->destructive_test_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_ipqc->appearance_produk_approval_qtyok > 0 || $q_cs_ipqc->appearance_produk_approval_qtyng > 0)
																				Appear. Produk :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_ipqc->appearance_produk_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_ipqc->appearance_produk_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_ipqc->parting_line_approval_qtyok > 0 || $q_cs_ipqc->parting_line_approval_qtyng > 0)
																				Parting Line :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_ipqc->parting_line_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_ipqc->parting_line_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_ipqc->kelengkapan_komponen_approval_qtyok > 0 || $q_cs_ipqc->kelengkapan_komponen_approval_qtyng > 0)
																				Kelengkapan Komponen :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_ipqc->kelengkapan_komponen_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_ipqc->kelengkapan_komponen_approval_qtyng}} pcs<br/>
																			@endif
																		</td>
		                                <td>
		                                	@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_ipqc->created_at}}
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				@foreach ($users as $key_user => $user)
																					@if($user->id == $q_cs_ipqc->updated_by)
																						{{$user->name}}
																					@endif
																				@endforeach
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_ipqc->updated_at}}
																			@endif																			
		                                </td>
	                                </tr>
	                            	@endforeach	                            	
	                            </tbody>
	                        	</table>	                        	
	                        	<div class="hr-line-dashed"></div>
	                        	<h3><i>Shift 2</i></h3>
	                          <table class="table">
	                            <thead>
		                            <tr>
	                                <th>Action</th>
	                                <th>Cycle</th>
	                                <th>Judge</th>
	                                <th>Approval</th>
	                                <th>Action Result</th>
	                                <th>Checked at</th>
	                                <th>Last Judge by</th>
	                                <th>Last Judge at</th>
		                            </tr>
	                            </thead>
	                            <tbody>
	                            	@php
	                            	$cs_s2 = DB::table('quality_cs_ipqcs')->where('shift', 2)->where('quality_ipqc_id',$q_ipqc->id)->get();
	                            	@endphp
	                            	@foreach ($cs_s2 as $keycs2 => $q_cs_ipqc)
	                            		<tr>
	                            			<td>
	                            				<a alt="add" href="{{url('')}}/quality/csipqc/{{$q_cs_ipqc->id}}/edit" class="btn btn-success btn-circle "><i class="fa fa-edit"></i></a>
	                            			</td>
		                            		<td>
																			@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_ipqc->cycle}}
																			@endif
																		</td>
																		<td>
																			@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				@if($q_cs_ipqc->judge == 0)
																					<span class="badge badge-info">Waiting</span>
																				@elseif($q_cs_ipqc->judge == 1)
																					<span class="badge badge-primary">OK</span>
																				@elseif($q_cs_ipqc->judge == 2)
																					<span class="badge badge-warning">AC</span>
																				@elseif($q_cs_ipqc->judge == 3)
																				<span class="badge badge-danger">NG</span>
																				@endif
																			@endif
																		</td>
																		<td>
																			@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				@if($q_cs_ipqc->approval_status == 0)
																					<span class="badge badge-primary"><i class="fa fa-check-square"></i></span>
																				@elseif($q_cs_ipqc->approval_status == 1)
																					<span class="badge badge-warning">Waiting Leader</span><br/>
																				@elseif($q_cs_ipqc->approval_status == 2)
																					<span class="badge badge-warning">Waiting Foreman</span>
																				@elseif($q_cs_ipqc->approval_status == 3)
																				<span class="badge badge-warning">Waiting Spv</span>
																				@elseif($q_cs_ipqc->approval_status == 4)
																				<span class="badge badge-warning">Waiting Dept Head</span>
																				@elseif($q_cs_ipqc->approval_status == 5)
																				<span class="badge badge-warning">Waiting Director</span>
																				@elseif($q_cs_ipqc->approval_status == 6)
																				<span class="badge badge-primary">Approved</span>
																				@endif
																			@endif
																		</td>
																		<td>
																			@if($q_cs_ipqc->destructive_test_approval_qtyok > 0 || $q_cs_ipqc->destructive_test_approval_qtyng > 0)
																				Destructive Test :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_ipqc->destructive_test_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_ipqc->destructive_test_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_ipqc->appearance_produk_approval_qtyok > 0 || $q_cs_ipqc->appearance_produk_approval_qtyng > 0)
																				Appear. Produk :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_ipqc->appearance_produk_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_ipqc->appearance_produk_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_ipqc->parting_line_approval_qtyok > 0 || $q_cs_ipqc->parting_line_approval_qtyng > 0)
																				Parting Line :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_ipqc->parting_line_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_ipqc->parting_line_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_ipqc->kelengkapan_komponen_approval_qtyok > 0 || $q_cs_ipqc->kelengkapan_komponen_approval_qtyng > 0)
																				Kelengkapan Komponen :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_ipqc->kelengkapan_komponen_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_ipqc->kelengkapan_komponen_approval_qtyng}} pcs<br/>
																			@endif
																		</td>
		                                <td>
		                                	@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_ipqc->created_at}}
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				@foreach ($users as $key_user => $user)
																					@if($user->id == $q_cs_ipqc->updated_by)
																						{{$user->name}}
																					@endif
																				@endforeach
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_ipqc->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_ipqc->updated_at}}
																			@endif
		                                </td>
	                                </tr>
	                            	@endforeach
	                            </tbody>
	                        	</table>
	                        </div>

	                        @php
	                        	$hasil = "sudah finish";
	                        	$app_status1 = DB::table('quality_cs_ipqcs')
																		->where('quality_ipqc_id',$q_ipqc->id)
																		->get();
																		//->toArray();
	                        	// $app_status_unfinish = array(1,2,3,4,5);
														// cek apakah	ada selain 0 dan 6	
														// dd($app_status1);
														// if(in_array($app_status_unfinish, $app_status1)){
														//	echo "belum finish";
														// } else {
														//	echo "sudah finish";
														// }
														foreach($app_status1 as $as) {
															if($as->approval_status == 1) {
																$hasil = "belum finish";
															} elseif($as->approval_status == 2) {
																$hasil = "belum finish";
															} elseif($as->approval_status == 3) {
																$hasil = "belum finish";
															} elseif($as->approval_status == 4) {
																$hasil = "belum finish";
															} elseif($as->approval_status == 5) {
																$hasil = "belum finish";
															} 
														}
														// echo $hasil;
														// echo $q_ipqc->id;
                        	@endphp

	                        <div class="modal-footer">
	                          <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
	                        </div>
                      	</div>
                      </div>
                  	</div>
            			</td>
									<td>
										{{$q_ipqc->lot_produksi}}
									</td>
									<td>
										@if($q_ipqc->judgement == 0)
											<span class="badge badge-info">In Progress</span>
										@elseif($q_ipqc->judgement == 1)
											<span class="badge badge-primary">OK</span> 
										@elseif($q_ipqc->judgement == 2)
											<span class="badge badge-danger">NG</span>
										@endif
									</td>
									<td>
										@if($q_ipqc->cs_status == 0)
											<span class="badge badge-info">In Progress</span>
										@elseif($q_ipqc->cs_status == 1)
											<span class="badge badge-warning">Waiting Approval</span>
										@elseif($q_ipqc->cs_status == 2)
										<span class="badge badge-info">Back In Cycle</span>
										@elseif($q_ipqc->cs_status == 3)
										<span class="badge badge-info">All Checked</span>
										@endif

										@if($hasil == "sudah finish")
										<!-- <span class="badge badge-primary">All Checked</span> -->
										@endif

										<br/>
										<!-- count cycle -->
										@php
                  	$css_s1 = DB::table('quality_cs_ipqcs')->where('shift', 1)->where('quality_ipqc_id',$q_ipqc->id)->get();
                  	$c1 = count($css_s1);
                  	$css_s2 = DB::table('quality_cs_ipqcs')->where('shift', 2)->where('quality_ipqc_id',$q_ipqc->id)->get();
                  	$c2 = count($css_s2);
                  	@endphp
                  	shift 1 : {{$c1}}/7 | shift 2 : {{$c2}}/7
									</td>
									<td>
										@foreach ($q_areas as $key => $q_area)
											@if($q_area->id == $q_ipqc->quality_area_id)
												{{$q_area->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_processes as $key => $q_process)
											@if($q_process->id == $q_ipqc->quality_process_id)
												{{$q_process->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_machines as $key => $q_machine)
											@if($q_machine->id == $q_ipqc->quality_machine_id)
												{{$q_machine->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_models as $key => $q_model)
											@if($q_model->id == $q_ipqc->quality_model_id)
												{{$q_model->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_parts as $key => $q_part)
											@if($q_part->id == $q_ipqc->quality_part_id)
												{{$q_part->name}} - 
													@php
														if ($q_part->left) {
								                $part_hor = "Left";
								            } elseif ($q_part->center) {
								                $part_hor = "Center";
								            } elseif ($q_part->right) {
								                $part_hor = "Right";
								            } else {
								                $part_hor = "";
								            }
														if ($q_part->low) {
							                $part_grade = "Low";
								            } elseif ($q_part->mid) {
								                $part_grade = "Mid";
								            } elseif ($q_part->high) {
								                $part_grade = "High";
								            } else {
								                $part_grade = "";
								            }								            
													@endphp		
													{{$part_hor}}	- {{$part_grade}}						

											@endif
										@endforeach
									</td>
									<td>
										@foreach($users as $u)
											@if($u->id == $q_ipqc->created_by)
												{{$u->name}}
											@endif
										@endforeach
									</td>
									<td>{{$q_ipqc->created_at}}</td>
								</tr>
								@endforeach										
							</tbody>
						</table>
					</div>

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
