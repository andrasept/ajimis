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

<div class="row wrapper-content" style="padding-bottom: 0px; margin-bottom: -20px;">	
	<div class="col-lg-12">
		<div class="ibox ">
			<div class="ibox-title">
				<h5>Member Info and Part</small></h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>

			<div class="ibox-content">
				<h2>
					Validation Wizard Form
				</h2>
				<p>
					This example show how to use Steps with jQuery Validation plugin.
				</p>
				<form id="form" action="#" class="wizard-big">
					<h1>Account</h1>
					<fieldset>
						<h2>Account Information</h2>
						<div class="row">
							<div class="col-lg-8">
								<div class="form-group">
									<label>Username *</label>
									<input id="userName" name="userName" type="text" class="form-control required">
								</div>
								<div class="form-group">
									<label>Password *</label>
									<input id="password" name="password" type="text" class="form-control required">
								</div>
								<div class="form-group">
									<label>Confirm Password *</label>
									<input id="confirm" name="confirm" type="text" class="form-control required">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="text-center">
									<div style="margin-top: 20px">
										<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
									</div>
								</div>
							</div>
						</div>

					</fieldset>
					<h1>Profile</h1>
					<fieldset>
						<h2>Profile Information</h2>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>First name *</label>
									<input id="name" name="name" type="text" class="form-control required">
								</div>
								<div class="form-group">
									<label>Last name *</label>
									<input id="surname" name="surname" type="text" class="form-control required">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Email *</label>
									<input id="email" name="email" type="text" class="form-control required email">
								</div>
								<div class="form-group">
									<label>Address *</label>
									<input id="address" name="address" type="text" class="form-control">
								</div>
							</div>
						</div>
					</fieldset>

					<h1>Warning</h1>
					<fieldset>
						<div class="text-center" style="margin-top: 120px">
							<h2>You did it Man :-)</h2>
						</div>
					</fieldset>

					<h1>Finish</h1>
					<fieldset>
						<h2>Terms and Conditions</h2>
						<input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
					</fieldset>
				</form>
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
                        <div class="col-sm-10"><input type="text" name="doc_number" class="form-control" value="{{now()}}" required readonly></div>
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
							<select class="form-control m-b" name="area_id" required>
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
							<select class="form-control m-b" name="process_id" required>
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
							<select class="form-control m-b" name="model_id" required>
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
							<select class="form-control m-b" name="model_id" required>
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
							<select class="form-control m-b" name="model_id" required>
								<option value="" selected>-- Choose Checksheet --</option>
								<option value="1">Quality Time</option>
								<option value="2">Accuracy</option>
							</select>
						</div>
					</div>
					<div class="hr-line-dashed"></div>

					<div class="form-group row">
						<div class="col-sm-10 col-sm-offset-2">
							<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('quality.part.index') }}';" value="Cancel" />&nbsp;&nbsp;&nbsp;
							<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>List Part</h5>
					<div class="ibox-tools">
					</div>
				</div>
				<div class="ibox-content">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th>Model</th>
									<th>Name</th>
									<th>Description</th>
									<th>Low</th>
									<th>Mid</th>
									<th>High</th>
									<th>Left</th>
									<th>Center</th>
									<th>Right</th>
									<th>Photo</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($q_parts as $key => $q_part)
								<tr class="gradeA">
									<td>
										@foreach ($q_models as $key => $q_models)
											@if($q_models->id == $q_part->model_id)
												{{$q_models->name}}
											@endif
										@endforeach
									</td>
									<td>{{$q_part->name}}</td>
									<td>{{$q_part->description}}</td>
									<td>{{$q_part->low}}</td>
									<td>{{$q_part->mid}}</td>
									<td>{{$q_part->high}}</td>
									<td>{{$q_part->left}}</td>
									<td>{{$q_part->center}}</td>
									<td>{{$q_part->right}}</td>
									<td>{{$q_part->photo}}</td>
									<td>
										<a alt="edit" href="{{ route('quality.part.edit',$q_part->id)}}" class="btn btn-xs btn-outline btn-warning">Edit <i class="fa fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;
										{!! Form::open(['method' => 'DELETE','route' => ['quality.part.destroy', $q_model->id],'style'=>'display:inline']) !!}
										{{Form::button('<i class="fa fa-trash-o"></i>', ['type' =>'submit', 'alt' => 'delete', 'class' => 'btn btn-xs btn-outline btn-danger', 'onclick' => 'return confirm("Are you sure want to delete? All its relation will be deleted too")'])}}
										{!! Form::close() !!}
									</td>
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
<script src="{{asset('js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$(document).ready(function(){
		$('.dataTables-example').DataTable({
			pageLength: 25,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
			{ extend: 'copy'},
			{extend: 'csv'},
			{extend: 'excel', title: 'ExampleFile'},
			{extend: 'pdf', title: 'ExampleFile'},

			{extend: 'print',
			customize: function (win){
				$(win.document.body).addClass('white-bg');
				$(win.document.body).css('font-size', '10px');

				$(win.document.body).find('table')
				.addClass('compact')
				.css('font-size', 'inherit');
			}
		}
		]

	});

	});

</script>


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
<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
<!-- jquery steps -->
<script>
        $(document).ready(function(){
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
                        errorPlacement: function (error, element)
                        {
                            element.before(error);
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
                    });
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
@endpush
