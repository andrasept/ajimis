@extends('layouts.app-master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quality Part</h2>
	</div>
	<div class="col-lg-2">
	</div>
</div>

@include('layouts.partials.messages')

<div class="row wrapper-content" style="padding-bottom: 0px; margin-bottom: -20px;">	
	<div class="col-lg-12">
		<div class="ibox ">
			<div class="ibox-title">
				<h5>Add Part</small></h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<form method="POST" action="{{ route('quality.part.store') }}" enctype="multipart/form-data">
					@csrf

					<!-- <div class="form-group row"><label class="col-sm-2 col-form-label">Model</label>
						<div class="col-sm-10">
							<select class="form-control m-b" name="model_id" required>
								<option value="" selected>-- Select Model --</option>
								@foreach ($q_models as $key => $q_model)
								<option value="{{$q_model->id}}">{{$q_model->name}}</option>
								@endforeach
							</select>
						</div>
					</div> -->

					<div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
						<div class="col-sm-10">
							<select id="area-dropdown" class="select2 form-control m-b" name="area_id" required>
								<option value="" selected>-- Select Area --</option>
								@foreach ($q_areas as $key => $q_area)
									<option value="{{$q_area->id}}">{{$q_area->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group row"><label class="col-sm-2 col-form-label">Process</label>
						<div class="col-sm-10">
	                        <select id="process-dropdown" class="select2 form-control m-b" name="process_id" required></select>
						</div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Machine</label>
						<div class="col-sm-10">
	                        <select id="machine-dropdown" class="select2 form-control m-b" name="machine_id" required></select>
						</div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Model</label>
						<div class="col-sm-10">
	                        <select id="model-dropdown" class="select2 form-control m-b" name="model_id" required></select>
						</div>
                    </div>

					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Nama</label>
						<div class="col-sm-10"><input type="text" name="name" class="form-control" required></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10"><input type="text" name="description" class="form-control"></div>
					</div>

					<div class="hr-line-dashed"></div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Grade</label>
	                    <div class="col-sm-10">
                            <div class="i-checks"><label> <input type="checkbox" name="low" value="1"> <i></i> Low </label></div>
                            <div class="i-checks"><label> <input type="checkbox" name="mid" value="1"> <i></i> Mid </label></div>
                            <div class="i-checks"><label> <input type="checkbox" name="high" value="1"> <i></i> High </label></div>
                        </div>
                	</div>

                	<div class="hr-line-dashed"></div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Position</label>
	                    <div class="col-sm-10">
                            <div class="i-checks"><label> <input type="checkbox" name="left" value="1"> <i></i> Left </label></div>
                            <div class="i-checks"><label> <input type="checkbox" name="center" value="1"> <i></i> Center </label></div>
                            <div class="i-checks"><label> <input type="checkbox" name="right" value="1"> <i></i> Right </label></div>
                        </div>
                	</div>

                	<div class="hr-line-dashed"></div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Photo/WI</label>
	                    <div class="col-sm-10">
                            <div class="custom-file">
							    <input id="photo" name="photo" type="file" class="custom-file-input">
							    <label for="photo" class="custom-file-label">Choose image...</label>
							    @error('photo')
			                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
			                    @enderror
							</div> 
                        </div>
                	</div>

					<div class="hr-line-dashed"></div>
					<div class="form-group row">
						<div class="col-sm-4 col-sm-offset-2">
							<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('quality.part.index') }}';" value="Cancel" />
							<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
    	// on change area
        $('#area-dropdown').on('change', function () {
            var idArea = this.value;
            $("#process-dropdown").html('');
            $.ajax({
                url: "{{url('quality/model/fetchProcess/')}}" + '/' + idArea,
                type: "GET",
                data: {
                    area_id: idArea,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                	// console.log(result);
                    $('#process-dropdown').html('<option value="">-- Select Process --</option>');
                    $.each(result.processes, function (key, value) {
                        $("#process-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#machine-dropdown').html('<option value="">-- Select Machine --</option>');
                    $('#model-dropdown').html('<option value="">-- Select Model --</option>');
                }
            });
        });

        // on change process
        $('#process-dropdown').on('change', function () {
            var idProcess = this.value;
            $("#machine-dropdown").html('');
            $.ajax({
                url: "{{url('quality/model/fetchMachine/')}}" + '/' + idProcess,
                type: "GET",
                data: {
                    process_id: idProcess,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#machine-dropdown').html('<option value="">-- Select Machine --</option>');
                    $.each(res.machines, function (key, value) {
                        $("#machine-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#model-dropdown').html('<option value="">-- Select Model --</option>');
                }
            });
        });

        // on change machine
        $('#machine-dropdown').on('change', function () {
            var idMachine = this.value;
            $("#model-dropdown").html('');
            $.ajax({
                url: "{{url('quality/model/fetchModel/')}}" + '/' + idMachine,
                type: "GET",
                data: {
                    machine_id: idMachine,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#model-dropdown').html('<option value="">-- Select Model --</option>');
                    $.each(res.models, function (key, value) {
                        $("#model-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });

        $(".select2").select2();
        
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
@endpush

@push('stylesheets')
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
@endpush
