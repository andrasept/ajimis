@extends('layouts.app-master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quality Monitoring IPQC | Member Page</h2>
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
					<div class="row">
						<div class="col-sm-10">
							<a alt="add" href="{{ route('quality.ipqc.create')}}" class="btn btn-success "><i class="fa fa-plus"> </i><span class="bold"> &nbsp; Add Checksheet</span> </a><br/><br/>
						</div>						
					</div>
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
								@foreach ($q_ipqcs as $key => $q_ipqc)
								<tr class="gradeA">
									<td>								
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
                            @php
                            	$cycle_button = 0;
                            	$finish_button = 0;
                            	$judgement_status = DB::table('quality_ipqcs')
							                ->where('id', $q_ipqc->id)->get();
							                // echo "tess".$judgement_status;
							                // var_dump($judgement_status);
							                foreach($judgement_status as $js){
							                	$judgement = $js->judgement;
							                }
							                if($judgement > 0){
							                	$finish_button = 1;
							                }
                            @endphp
                          </div>
	                        <div class="modal-body">
	                        	<h3><i>Shift 1</i></h3>
	                          <table class="table">
	                            <thead>
		                            <tr>
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

	                            	$array_judge1 = array();
	                            	$array_app1 = array();
	                            	@endphp
	                            	@foreach ($cs_s1 as $keycs => $q_cs_qtime)
	                            		<tr>
		                            		<td>
																			@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_qtime->cycle}}
																			@endif
																		</td>
																		<td>
																			@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
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
																			@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
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
																			@if($q_cs_qtime->destructive_test_approval_qtyok > 0 || $q_cs_qtime->destructive_test_approval_qtyng > 0)
																				Destructive Test :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_qtime->destructive_test_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_qtime->destructive_test_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_qtime->appearance_produk_approval_qtyok > 0 || $q_cs_qtime->appearance_produk_approval_qtyng > 0)
																				Appear. Produk :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_qtime->appearance_produk_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_qtime->appearance_produk_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_qtime->parting_line_approval_qtyok > 0 || $q_cs_qtime->parting_line_approval_qtyng > 0)
																				Parting Line :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_qtime->parting_line_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_qtime->parting_line_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_qtime->kelengkapan_komponen_approval_qtyok > 0 || $q_cs_qtime->kelengkapan_komponen_approval_qtyng > 0)
																				Kelengkapan Komponen :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_qtime->kelengkapan_komponen_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_qtime->kelengkapan_komponen_approval_qtyng}} pcs<br/>
																			@endif
																		</td>
		                                <td>
		                                	@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_qtime->created_at}}
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
																				@foreach ($users as $key_user => $user)
																					@if($user->id == $q_cs_qtime->updated_by)
																						{{$user->name}}
																					@endif
																				@endforeach
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_qtime->updated_at}}
																			@endif
		                                </td>
	                                </tr>
                                	@php
                                		$array_judge1[] = $q_cs_qtime->judge;
                                		$array_app1[] = $q_cs_qtime->approval_status;
                                	@endphp
	                            	@endforeach
	                            	@php
	                            		$disable_cycle = 0;
				                        	// if in_array judge=2/3 dan in_array approval_status!=6 maka disable add cycle
				                        	if( (in_array(2,$array_judge1) || in_array(3,$array_judge1)) && (!in_array(6,$array_app1)) ) {
																	    echo "disable";
																	    $disable_cycle = 1;
																	}
	                            	@endphp
	                            </tbody>
	                        	</table>
	                        	<div class="hr-line-dashed"></div>
	                        	<h3><i>Shift 2</i></h3>
	                          <table class="table">
	                            <thead>
		                            <tr>
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

	                            	$array_judge2 = array();
	                            	$array_app2 = array();
	                            	@endphp
	                            	@foreach ($cs_s2 as $keycs2 => $q_cs_qtime)
	                            		<tr>
		                            		<td>
																			@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_qtime->cycle}}
																			@endif
																		</td>
																		<td>
																			@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
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
																			@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
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
																			@if($q_cs_qtime->destructive_test_approval_qtyok > 0 || $q_cs_qtime->destructive_test_approval_qtyng > 0)
																				Destructive Test :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_qtime->destructive_test_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_qtime->destructive_test_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_qtime->appearance_produk_approval_qtyok > 0 || $q_cs_qtime->appearance_produk_approval_qtyng > 0)
																				Appear. Produk :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_qtime->appearance_produk_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_qtime->appearance_produk_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_qtime->parting_line_approval_qtyok > 0 || $q_cs_qtime->parting_line_approval_qtyng > 0)
																				Parting Line :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_qtime->parting_line_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_qtime->parting_line_approval_qtyng}} pcs<br/>
																			@endif
																			<br/>
																			@if($q_cs_qtime->kelengkapan_komponen_approval_qtyok > 0 || $q_cs_qtime->kelengkapan_komponen_approval_qtyng > 0)
																				Kelengkapan Komponen :<br/>
																				<span class="badge badge-primary">OK</span> {{$q_cs_qtime->kelengkapan_komponen_approval_qtyok}} pcs<br/>
																				<span class="badge badge-danger">NG</span>{{$q_cs_qtime->kelengkapan_komponen_approval_qtyng}} pcs<br/>
																			@endif
																		</td>
		                                <td>
		                                	@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_qtime->created_at}}
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
																				@foreach ($users as $key_user => $user)
																					@if($user->id == $q_cs_qtime->updated_by)
																						{{$user->name}}
																					@endif
																				@endforeach
																			@endif
		                                </td>
		                                <td>
		                                	@if($q_cs_qtime->quality_ipqc_id == $q_ipqc->id)
																				{{$q_cs_qtime->updated_at}}
																			@endif
		                                </td>
	                                </tr>
	                                @php
                                		$array_judge2[] = $q_cs_qtime->judge;
                                		$array_app2[] = $q_cs_qtime->approval_status;
                                	@endphp
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
	                        @endphp
	                        @php
	                        	// if in_array judge=2/3 dan in_array approval_status!=6 maka disable add cycle
	                        	if( (in_array(2,$array_judge2) || in_array(3,$array_judge2)) && (!in_array(6,$array_app2)) ) {
														    echo "disable";
														    $disable_cycle = 1;
														}
                        	@endphp
	                        <div class="modal-footer">
	                          <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

	                          @if($finish_button > 0)
	                          	<a alt="add" href=""><button type="button" class="btn btn-primary" disabled>Add Cycle</button></a>
	                          @else
	                          	<a alt="add" href="{{url('')}}/quality/csipqc/create/{{$q_ipqc->id}}"><button type="button" class="btn btn-primary">Add Cycle</button></a>
	                          @endif
	                          &nbsp;&nbsp;&nbsp;
	                         	@if($finish_button > 0)
	                          	<button type="button" class="btn btn-primary" disabled>Finish Cycle</button>
	                          @else
	                          	<a alt="finish" href="{{url('')}}/quality/ipqc/{{$q_ipqc->id}}/finish" class="" onclick="return confirm('Are you sure to finish this checksheet?')"><button type="button" class="btn btn-primary" >Finish Cycle</button></i></a>
	                          @endif	
	                        </div>
                      	</div>
                      </div>
                  	</div>

                  	<button class="btn btn-primary btn-circle" type="button" data-toggle="modal" data-target="#myModal{{$q_ipqc->id}}"><i class="fa fa-list"></i></button>	

                  	@if( (!$disable_cycle) )   
                  		@if ($q_ipqc->judgement == 0)
                  			<!-- <a alt="add" href="{{url('')}}/quality/csipqc/create/{{$q_ipqc->id}}" class="btn btn-success btn-circle "><i class="fa fa-plus"></i></a> -->
                  		@endif               		
                  	@endif		

                  	@if($finish_button == 0)
                    	<a alt="add" href="{{url('')}}/quality/csipqc/create/{{$q_ipqc->id}}" class="btn btn-success btn-circle "><i class="fa fa-plus"></i></a>
                    @endif					

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
									<!--
									<td>
										<a alt="edit" href="{{ route('quality.monitor.edit',$q_ipqc->id)}}" class="btn btn-info "><i class="fa fa-paste"></i><span class="bold"> Edit</span> </a>&nbsp;&nbsp;&nbsp;
										{!! Form::open(['method' => 'DELETE','route' => ['quality.monitor.destroy', $q_ipqc->id],'style'=>'display:inline']) !!}
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
			order: [['2', 'asc']],
			rowReorder: {
	            selector: 'td:nth-child(2)'
	        },
			pageLength: 25,
			responsive: true,
			// dom: '<"top"i>rt<"bottom"flp><"clear">',
			dom: '<"html5buttons"B>lTfgitp',
			 // dom: 'lrtip',
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
