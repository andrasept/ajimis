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
					<h5>Add Monitoring Checksheet</h5>
					<div class="ibox-tools">
					</div>
				</div>
				<div class="ibox-content">
					<form method="POST" action="{{ route('quality.monitor.store') }}">
						@csrf
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Name</label>
	                        <div class="col-sm-10"><p class="form-control-static">{{auth()->user()->name}}</p></div>
	                    </div>
	                    <div class="hr-line-dashed"></div>

	                    <div class="form-group row">
							<label class="col-sm-2 col-form-label">Date</label>
	                        <div class="col-sm-10"><input type="text" name="datetime" class="form-control" value="{{now()}}" required readonly></div>
	                    </div>
	                    <div class="hr-line-dashed"></div>

	                    <div class="form-group row">
							<label class="col-sm-2 col-form-label">Document Number</label>
							<div class="col-sm-10"><input type="text" name="doc_number" class="form-control" value="AJI/QA/{{$randomNumber}}" required readonly></div>
	                    </div>
	                    <div class="hr-line-dashed"></div>

	                    <div class="form-group row">
							<label class="col-sm-2 col-form-label">Area</label>
							<div class="col-sm-10">
								<select class="form-control m-b select2_demo_1" name="quality_area_id" required>
									<option value="" selected>-- Select Area --</option>
									@foreach ($q_areas as $key => $q_area)
									<option value="{{$q_area->id}}">{{$q_area->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="hr-line-dashed"></div>

						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Process</label>
							<div class="col-sm-10">
								<select class="form-control m-b select2_demo_1" name="quality_process_id" required>
									<option value="" selected>-- Select Area --</option>
									@foreach ($q_processes as $key => $q_process)
									<option value="{{$q_process->id}}">{{$q_process->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="hr-line-dashed"></div>

						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Model</label>
							<div class="col-sm-10">
								<select class="form-control m-b select2_demo_1" name="quality_model_id" required>
									<option value="" selected>-- Select Model --</option>
									@foreach ($q_models as $key => $q_model)
									<option value="{{$q_model->id}}">{{$q_model->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="hr-line-dashed"></div>

						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Part</label>
							<div class="col-sm-10">
								<select class="form-control m-b select2_demo_1" name="quality_part_id" required>
									<option value="" selected>-- Select Part --</option>
									@foreach ($q_parts as $key => $q_part)
									<option value="{{$q_part->id}}">{{$q_part->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="hr-line-dashed"></div>

						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Checksheet</label>
							<div class="col-sm-10">
								<select class="form-control m-b select2_demo_1" name="quality_cs" required>
									<option value="" selected>-- Choose Checksheet --</option>
									<option value="1">Quality Time</option>
									<option value="2">Accuracy</option>
								</select>
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