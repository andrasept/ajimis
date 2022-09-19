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
					<a alt="edit" href="{{ route('quality.part.create')}}" class="btn btn-success btn-info"><i class="fa fa-plus"></i> Add</a>&nbsp;&nbsp;&nbsp;<br/><br/>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th></th>
									<th>Area</th>
									<th>Process</th>
									<th>Machine</th>
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
									<td></td>
									<td>
										@foreach ($q_areas as $key => $q_area)
											@if($q_area->id == $q_part->area_id)
												{{$q_area->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_processes as $key => $q_process)
											@if($q_process->id == $q_part->process_id)
												{{$q_process->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_machines as $key => $q_machine)
											@if($q_machine->id == $q_part->machine_id)
												{{$q_machine->name}}
											@endif
										@endforeach
									</td>
									<td>
										@foreach ($q_models as $key => $q_model)
											@if($q_model->id == $q_part->model_id)
												{{$q_model->name}}
											@endif
										@endforeach
									</td>
									<td>{{$q_part->name}}</td>
									<td>{{$q_part->description}}</td>
									<td>
										@if($q_part->low)
											V
										@endif
									</td>
									<td>
										@if($q_part->mid)
											V
										@endif
									</td>
									<td>
										@if($q_part->high)
											V
										@endif
									</td>
									<td>
										@if($q_part->left)
											V
										@endif
									</td>
									<td>
										@if($q_part->center)
											V
										@endif
									</td>
									<td>
										@if($q_part->right)
											V
										@endif
									</td>
									<td>
										@if($q_part->photo)
											<img src="{{asset('quality/wi/'.$q_part->photo)}}" width="100" \>
										@endif										
									</td>
									<td>
										<a alt="edit" href="{{ route('quality.part.edit',$q_part->id)}}" class="btn btn-success btn-info"><i class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;
										<!-- {!! Form::open(['method' => 'DELETE','route' => ['quality.part.destroy', $q_model->id],'style'=>'display:inline']) !!}
										{{Form::button('<i class="fa fa-trash-o"></i>', ['type' =>'submit', 'alt' => 'delete', 'class' => 'btn btn-xs btn-outline btn-danger', 'onclick' => 'return confirm("Are you sure want to delete? All its relation will be deleted too")'])}}
										{!! Form::close() !!} -->

										{!! Form::open(['method' => 'DELETE','route' => ['quality.part.destroy', $q_part->id],'style'=>'display:inline']) !!}
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
<link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
@endpush
