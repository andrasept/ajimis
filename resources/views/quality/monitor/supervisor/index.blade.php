@extends('layouts.app-master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quality Monitoring Checksheet | Supervisor Page</h2>
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
					<h5>List Monitoring Checksheet</h5>
					<div class="ibox-tools">
					</div>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th></th>
									<th>Checksheet</th>
									<th>Doc. Number</th>
									<th>Judgement</th>
									<th>Status</th>
									<th>Area</th>
									<th>Process</th>
									<th>Model</th>
									<th>Part</th>
									<th>Created by</th>
									<th>Created at</th>
									<!-- <th>Action</th> -->
								</tr>
							</thead>
							<tbody>
								@foreach ($q_monitors as $key => $q_monitor)
								<tr class="gradeA">
									<td>
										<button class="btn btn-primary btn-circle" type="button" data-toggle="modal" data-target="#myModal{{$q_monitor->id}}"><i class="fa fa-list"></i></button>

										<!-- <a alt="add" href="{{url('')}}/quality/csqtime/create/{{$q_monitor->id}}" class="btn btn-success btn-circle "><i class="fa fa-plus"></i></a> -->

                		<div class="modal inmodal fade" id="myModal{{$q_monitor->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Detail Checksheet</h4>
                            <h5 class="font-bold">
                            	Category : 
                            	@if($q_monitor->quality_cs_qtime == 1)
																QTime
															@elseif($q_monitor->quality_cs_accuracy == 1)
																Accuracy
															@endif
                            </h5>
                            <h5 class="font-bold">Doc. Number : {{$q_monitor->doc_number}}</h5>
                            <h5 class="font-bold">
                            	Line :
                            	@foreach ($q_areas as $key => $q_area)
																@if($q_area->id == $q_monitor->quality_area_id)
																	{{$q_area->name}}
																@endif
															@endforeach 
															-
															@foreach ($q_processes as $key => $q_process)
																@if($q_process->id == $q_monitor->quality_process_id)
																	{{$q_process->name}}
																@endif
															@endforeach
                            </h5>
                            <h5 class="font-bold">
                            	Model Part : 
                            	@foreach ($q_models as $key => $q_model)
																@if($q_model->id == $q_monitor->quality_model_id)
																	{{$q_model->name}}
																@endif
															@endforeach
															-
															@foreach ($q_parts as $key => $q_part)
																@if($q_part->id == $q_monitor->quality_part_id)
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
	                                <th>Checked at</th>
	                                <th>Last Judge by</th>
	                                <th>Last Judge at</th>
		                            </tr>
	                            </thead>
	                            <tbody>
	                            	@php
	                            		$cs_s1 = DB::table('quality_cs_qtimes')->where('shift', 1)->where('quality_monitor_id',$q_monitor->id)->get();
	                            	@endphp
	                            	@foreach ($cs_s1 as $keycs => $q_cs_qtime)
	                            		<tr>
	                            			<td>
	                            				<a alt="add" href="{{url('')}}/quality/csqtime/{{$q_cs_qtime->id}}/edit" class="btn btn-success btn-circle "><i class="fa fa-edit"></i></a>
	                            			</td>
		                            		<td>
																			@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				{{$q_cs_qtime->cycle}}
																			@endif
																		</td>
																		<td>
																			@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				@if($q_cs_qtime->judge == 0)
																					<span class="badge badge-info">Waiting</span>
																				@elseif($q_cs_qtime->judge == 1)
																					<span class="badge badge-primary">OK</span>
																				@elseif($q_cs_qtime->judge == 2)
																					<span class="badge badge-warning">AC</span>
																				@elseif($q_cs_qtime->judge == 3)
																				<span class="badge badge-danger">NG</span>
																				@endif
																			@endif
																		</td>
																		<td>
																			@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				@if($q_cs_qtime->approval_status == 0)
																					<span class="badge badge-primary"><i class="fa fa-check-square"></i></span>
																				@elseif($q_cs_qtime->approval_status == 1)
																					<span class="badge badge-warning">Waiting Leader</span><br/>
																				@elseif($q_cs_qtime->approval_status == 2)
																					<span class="badge badge-warning">Waiting Foreman</span>
																				@elseif($q_cs_qtime->approval_status == 3)
																				<span class="badge badge-warning">Waiting Spv</span>
																				@elseif($q_cs_qtime->approval_status == 4)
																				<span class="badge badge-warning">Waiting Dept Head</span>
																				@elseif($q_cs_qtime->approval_status == 5)
																				<span class="badge badge-warning">Waiting Director</span>
																				@elseif($q_cs_qtime->approval_status == 6)
																				<span class="badge badge-primary">Approved</span>
																				@endif
																			@endif
																		</td>
		                                <td>
		                                	@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				{{$q_cs_qtime->created_at}}
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				@foreach ($users as $key_user => $user)
																					@if($user->id == $q_cs_qtime->updated_by)
																						{{$user->name}}
																					@endif
																				@endforeach
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				{{$q_cs_qtime->updated_at}}
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
	                                <th>Checked at</th>
	                                <th>Last Judge by</th>
	                                <th>Last Judge at</th>
		                            </tr>
	                            </thead>
	                            <tbody>
	                            	@php
	                            	$cs_s2 = DB::table('quality_cs_qtimes')->where('shift', 2)->where('quality_monitor_id',$q_monitor->id)->get();
	                            	@endphp
	                            	@foreach ($cs_s2 as $keycs2 => $q_cs_qtime)
	                            		<tr>
	                            			<td>
	                            				<a alt="add" href="{{url('')}}/quality/csqtime/{{$q_cs_qtime->id}}/edit" class="btn btn-success btn-circle "><i class="fa fa-edit"></i></a>
	                            			</td>
		                            		<td>
																			@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				{{$q_cs_qtime->cycle}}
																			@endif
																		</td>
																		<td>
																			@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				@if($q_cs_qtime->judge == 0)
																					<span class="badge badge-info">Waiting</span>
																				@elseif($q_cs_qtime->judge == 1)
																					<span class="badge badge-primary">OK</span>
																				@elseif($q_cs_qtime->judge == 2)
																					<span class="badge badge-warning">AC</span>
																				@elseif($q_cs_qtime->judge == 3)
																				<span class="badge badge-danger">NG</span>
																				@endif
																			@endif
																		</td>
																		<td>
																			@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				@if($q_cs_qtime->approval_status == 0)
																					<span class="badge badge-primary"><i class="fa fa-check-square"></i></span>
																				@elseif($q_cs_qtime->approval_status == 1)
																					<span class="badge badge-warning">Waiting Leader</span><br/>
																				@elseif($q_cs_qtime->approval_status == 2)
																					<span class="badge badge-warning">Waiting Foreman</span>
																				@elseif($q_cs_qtime->approval_status == 3)
																				<span class="badge badge-warning">Waiting Spv</span>
																				@elseif($q_cs_qtime->approval_status == 4)
																				<span class="badge badge-warning">Waiting Dept Head</span>
																				@elseif($q_cs_qtime->approval_status == 5)
																				<span class="badge badge-warning">Waiting Director</span>
																				@elseif($q_cs_qtime->approval_status == 6)
																				<span class="badge badge-primary">Approved</span>
																				@endif
																			@endif
																		</td>
		                                <td>
		                                	@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				{{$q_cs_qtime->created_at}}
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				@foreach ($users as $key_user => $user)
																					@if($user->id == $q_cs_qtime->updated_by)
																						{{$user->name}}
																					@endif
																				@endforeach
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_qtime->quality_monitor_id == $q_monitor->id)
																				{{$q_cs_qtime->updated_at}}
																			@endif
		                                </td>
	                                </tr>
	                            	@endforeach
	                            </tbody>
	                        	</table>
	                        </div>
	                        @php
                        		// app status di shift 1
                        		$app_status = DB::table('quality_cs_qtimes')
																		->where('quality_monitor_id',$q_monitor->id)
																		->get();	
														//$app_status_unfinish = ["1","2","3","4","5"];
														$app_status_unfinish = array("1","2","3","4","5");
														// cek apakah	ada selain 0 dan 6	
														// var_dump($app_status);
														// if(in_array($app_status_unfinish, $app_status)){
														//	echo "belum finish";
														//} else {
														//	echo "sudah finish";
														//}	
														$finish = "belum";
														foreach($app_status as $as) {
															if($as->approval_status == 1) {
																// echo "belum";
																$finish = "belum";
															} elseif($as->approval_status == 2) {
																$finish = "belum";
															} elseif($as->approval_status == 3) {
																$finish = "belum";
															} elseif($as->approval_status == 4) {
																$finish = "belum";
															} elseif($as->approval_status == 5) {
																$finish = "belum";
															} else {
																$finish = "sudah";
															}
														}
														//echo $finish;
															
                        	@endphp

	                        <div class="modal-footer">
	                          <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
	                          <!-- <button type="button" class="btn btn-primary">Add Cycle</button> -->
	                          &nbsp;&nbsp;&nbsp;
	                          @if($finish == "sudah")
	                          	<button type="button" class="btn btn-primary">Finish Cycle</button>
	                          @else
	                          	<button type="button" class="btn btn-primary" disabled>Finish Cycle</button>
	                          @endif	                          
	                        </div>
                      	</div>
                      </div>
                  	</div>
            			</td>
									<td>
										@if($q_monitor->quality_cs_qtime == 1)
											<label>QTime</label>
										@elseif($q_monitor->quality_cs_accuracy == 1)
											<label>Accuracy</label>
										@endif
									</td>
									<td>{{$q_monitor->doc_number}}</td>
									<td>
										@if($q_monitor->judgement == 0)
											<span class="badge badge-info">In Progress</span>
										@elseif($q_monitor->judgement == 1)
											<span class="badge badge-primary">OK</span>
										@elseif($q_monitor->judgement == 2)
											<span class="badge badge-danger">NG</span>
										@endif
									</td>
									<td>
										@if($q_monitor->cs_status == 0)
											<span class="badge badge-info">In Progress</span>
										@elseif($q_monitor->cs_status == 1)
											<span class="badge badge-warning">Waiting Approval</span>
										@elseif($q_monitor->cs_status == 2)
										<span class="badge badge-info">Back In Cycle</span>
										@elseif($q_monitor->cs_status == 3)
										<span class="badge badge-info">All Checked</span>
										@endif
										<br/>
										<!-- count cycle -->
										@php
                  	$css_s1 = DB::table('quality_cs_qtimes')->where('shift', 1)->where('quality_monitor_id',$q_monitor->id)->get();
                  	$c1 = count($css_s1);
                  	$css_s2 = DB::table('quality_cs_qtimes')->where('shift', 2)->where('quality_monitor_id',$q_monitor->id)->get();
                  	$c2 = count($css_s2);
                  	@endphp
                  	shift 1 : {{$c1}}/7 | shift 2 : {{$c2}}/7
									</td>
									<td>
										@foreach ($q_areas as $key => $q_area)
											@if($q_area->id == $q_monitor->quality_area_id)
												{{$q_area->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_processes as $key => $q_process)
											@if($q_process->id == $q_monitor->quality_process_id)
												{{$q_process->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_models as $key => $q_model)
											@if($q_model->id == $q_monitor->quality_model_id)
												{{$q_model->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_parts as $key => $q_part)
											@if($q_part->id == $q_monitor->quality_part_id)
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
												@if($u->id == $q_monitor->created_by)
													{{$u->name}}
												@endif
											@endforeach
									</td>
									<td>{{$q_monitor->created_at}}</td>
									<!--
									<td>
										<a alt="edit" href="{{ route('quality.monitor.edit',$q_monitor->id)}}" class="btn btn-info "><i class="fa fa-paste"></i><span class="bold"> Edit</span> </a>&nbsp;&nbsp;&nbsp;
										{!! Form::open(['method' => 'DELETE','route' => ['quality.monitor.destroy', $q_monitor->id],'style'=>'display:inline']) !!}
										{{Form::button('<i class="fa fa-trash"></i>', ['type' =>'submit', 'alt' => 'delete', 'class' => 'btn btn-danger ', 'onclick' => 'return confirm("Are you sure want to delete? All its relation will be deleted too")'])}}
										{!! Form::close() !!}
									</td>
									-->	
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
