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
					<h5>List Monitoring Checksheet</h5>
					<div class="ibox-tools">
					</div>
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-sm-10">
							<a alt="add" href="{{ route('quality.monitor.create')}}" class="btn btn-success "><i class="fa fa-plus"> </i><span class="bold"> &nbsp; Add Monitoring</span> </a><br/><br/>
						</div>						
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th></th>
									<th>Checksheet</th>
									<th>Doc. Number</th>
									<th>Judgement</th>
									<th>Area</th>
									<th>Process</th>
									<th>Model</th>
									<th>Part</th>
									<th>Created at</th>
									<!-- <th>Action</th> -->
								</tr>
							</thead>
							<tbody>
								@foreach ($q_monitors as $key => $q_monitor)
								<tr class="gradeA">
									<td>
										<button class="btn btn-primary btn-circle" type="button" data-toggle="modal" data-target="#myModal5"><i class="fa fa-list"></i></button>

										<a alt="add" href="{{url('')}}/quality/csqtime/create/{{$q_monitor->id}}" class="btn btn-success btn-circle "><i class="fa fa-plus"></i></a>

                                		<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
			                                <div class="modal-dialog modal-lg">
			                                    <div class="modal-content">
			                                        <div class="modal-header">
			                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			                                            <h4 class="modal-title">Detail Checksheet</h4>
			                                            <h5 class="font-bold">Category :</h5>
			                                            <h5 class="font-bold">Doc. Number :</h5>
			                                            <h5 class="font-bold">Model Part :</h5>
			                                        </div>
			                                        <div class="modal-body">
			                                        	<h3><i>Shift 1</i></h3>
			                                            <table class="table">
								                            <thead>
									                            <tr>
									                                <th>Cycle</th>
									                                <th>Judge</th>
									                                <th>Check at</th>
									                                <th>Last Judge by</th>
									                                <th>Last Judge at</th>
									                            </tr>
								                            </thead>
								                            <tbody>
									                            <tr>
									                                <td>1</td>
									                                <td></td>
									                                <td></td>
									                                <td></td>
									                                <td></td>
									                            </tr>
								                            </tbody>
								                        </table>
								                        <div class="hr-line-dashed"></div>
								                        <h3><i>Shift 2</i></h3>
			                                            <table class="table">
								                            <thead>
									                            <tr>
									                                <th>Cycle</th>
									                                <th>Judge</th>
									                                <th>Check at</th>
									                                <th>Last Judge by</th>
									                                <th>Last Judge at</th>
									                            </tr>
								                            </thead>
								                            <tbody>
									                            <tr>
									                                <td>1</td>
									                                <td></td>
									                                <td></td>
									                                <td></td>
									                                <td></td>
									                            </tr>
								                            </tbody>
								                        </table>
			                                        </div>

			                                        <div class="modal-footer">
			                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
			                                            <button type="button" class="btn btn-primary">Add Cycle</button>
			                                            &nbsp;&nbsp;&nbsp;
			                                            <button type="button" class="btn btn-primary">Finish Cycle</button>
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
												{{$q_part->name}}
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
