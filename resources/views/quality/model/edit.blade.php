@extends('layouts.app-master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quality Model</h2>
	</div>
	<div class="col-lg-2">
	</div>
</div>

@include('layouts.partials.messages')

<div class="row wrapper-content" style="padding-bottom: 0px; margin-bottom: -20px;">	
	<div class="col-lg-12">
		<div class="ibox ">
			<div class="ibox-title">
				<h5>Edit Model</small></h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<form method="POST" action="{{ route('quality.model.update', $QualityModel->id) }}">
					@method('patch')
                	@csrf
                	<div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
						<div class="col-sm-10">
							<select id="area-dropdown" class="select2 form-control m-b" name="area_id" required>
								@foreach ($q_areas as $key => $q_area)
									@if($q_area->id == $QualityModel->area_id)
										<option value="{{$q_area->id}}" selected>{{$q_area->name}}</option>
									@else
										<option value="{{$q_area->id}}">{{$q_area->name}}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group row"><label class="col-sm-2 col-form-label">Process</label>
						<div class="col-sm-10">
	                        <select id="process-dropdown" class="select2 form-control m-b" name="process_id" required>
	                        	@foreach ($q_processes as $key => $q_process)
									@if($q_process->id == $QualityModel->process_id)
										<option value="{{$q_process->id}}" selected>{{$q_process->name}}</option>
									@else
										<option value="{{$q_process->id}}">{{$q_process->name}}</option>
									@endif
								@endforeach
	                        </select>
						</div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Machine</label>
						<div class="col-sm-10">
	                        <select id="machine-dropdown" class="select2 form-control m-b" name="machine_id" required>
	                        	@foreach ($q_machines as $key => $q_machine)
									@if($q_machine->id == $QualityModel->machine_id)
										<option value="{{$q_machine->id}}" selected>{{$q_machine->name}}</option>
									@else
										<option value="{{$q_machine->id}}">{{$q_machine->name}}</option>
									@endif
								@endforeach
	                        </select>
						</div>
                    </div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Nama</label>
						<div class="col-sm-10"><input type="text" name="name" class="form-control" value="{{$QualityModel->name}}" required></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10"><input type="text" name="description" class="form-control" value="{{$QualityModel->description}}"></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group row">
						<div class="col-sm-4 col-sm-offset-2">
							<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('quality.model.index') }}';" value="Cancel" />
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
                }
            });
        });

        $(".select2").select2();
        
    });

</script>
@endpush

@push('stylesheets')
@endpush