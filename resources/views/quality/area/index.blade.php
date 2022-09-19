@extends('layouts.app-master')

@section('content')

			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Quality Area</h2>
				</div>
				<div class="col-lg-2">
				</div>
			</div>

			@include('layouts.partials.messages')

			<div class="row wrapper-content" style="padding-bottom: 0px; margin-bottom: -20px;">	
				<div class="col-lg-12">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Add Area</small></h5>
							<div class="ibox-tools">
									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>
								</div>
						</div>
						<div class="ibox-content">
							<form method="POST" action="{{ route('quality.area.store') }}">
								@csrf
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
										<!-- <button class="btn btn-white btn-sm" type="button">Cancel</button> -->
										<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('quality.area.index') }}';" value="Cancel" />
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
								<h5>List Area</h5>
								<div class="ibox-tools">
								</div>
							</div>
							<div class="ibox-content">

								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
										<thead>
											<tr>
												<th></th>
												<th>Name</th>
												<th>Description</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($q_areas as $key => $q_area)
												<tr class="gradeA">
													<td></td>
													<td>{{$q_area->name}}</td>
													<td>{{$q_area->description}}</td>
													<td>
														<a alt="edit" href="{{ route('quality.area.edit',$q_area->id)}}" class="btn btn-success btn-info "><i class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;

											          	{!! Form::open(['method' => 'DELETE','route' => ['quality.area.destroy', $q_area->id],'style'=>'display:inline']) !!}
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
			@endpush

			@push('stylesheets')
			<link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
			@endpush
