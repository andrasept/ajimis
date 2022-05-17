@extends('layouts.app-master')

@section('content')

			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Quality Process</h2>
				</div>
				<div class="col-lg-2">
				</div>
			</div>

			@include('layouts.partials.messages')

			<div class="row wrapper-content" style="padding-bottom: 0px; margin-bottom: -20px;">	
				<div class="col-lg-12">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Add Process</small></h5>
							<div class="ibox-tools">
									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>
								</div>
						</div>
						<div class="ibox-content">
							<form method="POST" action="{{ route('quality.process.store') }}">
								@csrf
								
								<div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
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
										<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('quality.process.index') }}';" value="Cancel" />
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
								<h5>List Process</h5>
								<div class="ibox-tools">
								</div>
							</div>
							<div class="ibox-content">

								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
										<thead>
											<tr>
												<th>Area</th>
												<th>Name</th>
												<th>Description</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($q_processes as $key => $q_process)
												<tr class="gradeA">
													<td>
													@foreach ($q_areas as $key => $q_area)
														@if($q_area->id == $q_process->area_id)
														 {{$q_area->name}}
														@endif
													@endforeach
													</td>
													<td>{{$q_process->name}}</td>
													<td>{{$q_process->description}}</td>
													<td>
														<a alt="edit" href="{{ route('quality.process.edit',$q_process->id)}}" class="btn btn-xs btn-outline btn-warning">Edit <i class="fa fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;
									          {!! Form::open(['method' => 'DELETE','route' => ['quality.process.destroy', $q_process->id],'style'=>'display:inline']) !!}
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
			@endpush

			@push('stylesheets')
			<link href="{{asset('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
			@endpush
