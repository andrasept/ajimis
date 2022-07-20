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
				<form method="POST" action="{{ route('quality.part.store') }}">
					@csrf

					<div class="form-group row"><label class="col-sm-2 col-form-label">Model</label>
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
						<label class="col-sm-2 col-form-label">H Position</label>
	                    <div class="col-sm-10">
                            <div class="i-checks"><label> <input type="checkbox" name="left" value="1"> <i></i> Left </label></div>
                            <div class="i-checks"><label> <input type="checkbox" name="center" value="1"> <i></i> Center </label></div>
                            <div class="i-checks"><label> <input type="checkbox" name="right" value="1"> <i></i> Right </label></div>
                        </div>
                	</div>

                	<div class="hr-line-dashed"></div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Photo</label>
	                    <div class="col-sm-10">
                            <div class="custom-file">
							    <input id="logo" type="file" class="custom-file-input">
							    <label for="logo" class="custom-file-label">Choose file...</label>
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
@endpush

@push('stylesheets')
<link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
@endpush
