@extends('layouts.app-master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quality Machine</h2>
	</div>
	<div class="col-lg-2">
	</div>
</div>

@include('layouts.partials.messages')

<div class="row wrapper-content" style="padding-bottom: 0px; margin-bottom: -20px;">	
	<div class="col-lg-12">
		<div class="ibox ">
			<div class="ibox-title">
				<h5>Add Machine</small></h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<form method="POST" action="{{ route('quality.machine.store') }}">
					@csrf

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

					<div class="form-group row"><label class="col-sm-2 col-form-label">Process</label>
						<div class="col-sm-10">
	                        <select id="process-dropdown" class="select2 form-control m-b" name="process_id" required></select>
						</div>
                    </div>
                    <!-- <div class="form-group row"><label class="col-sm-2 col-form-label">Machine</label>
						<div class="col-sm-10">
	                        <select id="machine-dropdown" class="form-control m-b" name="machine_id" required></select>
						</div>
                    </div> -->


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
						<div class="col-sm-4 col-sm-offset-2">
							<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('quality.machine.index') }}';" value="Cancel" />
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
					<h5>List Machine</h5>
					<div class="ibox-tools">
					</div>
				</div>
				<div class="ibox-content">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th></th>
									<th>Area</th>
									<th>Process</th>
									<th>Name</th>
									<th>Description</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($q_machines as $key => $q_machine)
								<tr class="gradeA">
									<td></td>
									<td>
										@foreach ($q_areas as $key => $q_area)
											@if($q_area->id == $q_machine->area_id)
												{{$q_area->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_processes as $key => $q_process)
											@if($q_process->id == $q_machine->process_id)
												{{$q_process->name}}
											@endif
										@endforeach
									</td>
									<td>{{$q_machine->name}}</td>
									<td>{{$q_machine->description}}</td>
									<td>
										<a alt="edit" href="{{ route('quality.machine.edit',$q_machine->id)}}" class="btn btn-success btn-info"><i class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;
										{!! Form::open(['method' => 'DELETE','route' => ['quality.machine.destroy', $q_machine->id],'style'=>'display:inline']) !!}
										{{Form::button('<i class="fa fa-trash"></i>', ['type' =>'submit', 'alt' => 'delete', 'class' => 'btn btn-danger ', 'onclick' => 'return confirm("Are you sure want to delete? All its relation will be deleted too")'])}}
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
		// ordering number
		var t = $('.dataTables-example').DataTable({
			pageLength: 10,
			responsive: true,
	        columnDefs: [
	            {
	                searchable: false,
	                orderable: false,
	                targets: 0,
	            },
	        ],
	        order: [[1, 'asc']],
	    });
	    t.on('order.dt search.dt', function () {
	        let i = 1;
	 
	        t.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
	            this.data(i++);
	        });
	    }).draw();
	    // ordering number end
	});
</script>

<script>
    $(document).ready(function () {
    	// on change area
        $('#area-dropdown').on('change', function () {
            var idArea = this.value;
            $("#process-dropdown").html('');
            $.ajax({
                url: "{{url('quality/machine/fetchProcess/')}}" + '/' + idArea,
                // url: "{{url('quality/machine/fetchProcess/')}}",
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
                    // $('#machine-dropdown').html('<option value="">-- Select Machine --</option>');
                }
            });
        });

        // on change process
        // $('#process-dropdown').on('change', function () {
        //     var idProcess = this.value;
        //     $("#machine-dropdown").html('');
        //     $.ajax({
        //         url: "{{url('quality/machine/fetchMachine/')}}" + '/' + idProcess,
        //         type: "GET",
        //         data: {
        //             process_id: idProcess,
        //             _token: '{{csrf_token()}}'
        //         },
        //         dataType: 'json',
        //         success: function (res) {
        //             $('#machine-dropdown').html('<option value="">-- Select Machine --</option>');
        //             $.each(res.machines, function (key, value) {
        //                 $("#machine-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
        //             });
        //         }
        //     });
        // });

        $(".select2").select2();
        
    });

</script>
@endpush

@push('stylesheets')
<link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush
