@extends('layouts.app-master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>IPQC Monitoring</h2>
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
					<form method="POST" action="{{ route('quality.ipqc.store') }}">
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
							<label class="col-sm-2 col-form-label">Lot Produksi</label>
							<div class="col-sm-10"><input type="text" name="lot_produksi" class="form-control" value="" required></div>
	                    </div>
	                    <div class="hr-line-dashed"></div>

	                    <div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
							<div class="col-sm-10">
								<select id="area-dropdown" class="select2 form-control m-b" name="area_id" required>
									<option value="10" selected> IPQC </option>
								</select>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group row"><label class="col-sm-2 col-form-label">Process</label>
							<div class="col-sm-10">
		                        <select id="process-dropdown" class="select2 form-control m-b" name="process_id" required>
									<option value="">-- Select Process --</option>
									@foreach ($q_processes as $key => $q_process)
										<option value="{{$q_process->id}}">{{$q_process->name}}</option>
									@endforeach
								</select>
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
	                    <div class="form-group row"><label class="col-sm-2 col-form-label">Part</label>
							<div class="col-sm-10">
		                        <select id="part-dropdown" class="select2 form-control m-b" name="part_id" required></select>
							</div>
	                    </div>
	                    <div class="hr-line-dashed"></div>

						<div class="form-group row">
							<div class="col-sm-10 col-sm-offset-2">
								<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('quality.ipqc.index') }}';" value="Cancel" />&nbsp;&nbsp;&nbsp;
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
<script>
    $(document).ready(function () {
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
                success: function (result) {
                	// console.log(result);
                    $('#machine-dropdown').html('<option value="">-- Select Machine --</option>');
                    $.each(result.machines, function (key, value) {
                        $("#machine-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#model-dropdown').html('<option value="">-- Select Model --</option>');
                    $('#Part-dropdown').html('<option value="">-- Select Part --</option>');
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
                    $('#part-dropdown').html('<option value="">-- Select Part --</option>');
                }
            });
        });

        // on change model
        $('#model-dropdown').on('change', function () {
            var idModel = this.value;
            $("#part-dropdown").html('');
            $.ajax({
                url: "{{url('quality/model/fetchPart/')}}" + '/' + idModel,
                type: "GET",
                data: {
                    model_id: idModel,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#part-dropdown').html('<option value="">-- Select Part --</option>');
                    $.each(res.parts, function (key, value) {
                        $("#part-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
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