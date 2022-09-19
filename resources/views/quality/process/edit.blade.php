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
				<h5>Edit Process</small></h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<form method="POST" action="{{ route('quality.process.update', $QualityProcess->id) }}">
					@method('patch')
                	@csrf
                	<div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
						<div class="col-sm-10">
							<select class="select2 form-control m-b" name="area_id" required>
								@foreach ($q_areas as $key => $q_area)
									@if($q_area->id == $QualityProcess->area_id)
										<option value="{{$q_area->id}}" selected>{{$q_area->name}}</option>
									@else
										<option value="{{$q_area->id}}">{{$q_area->name}}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Nama</label>
						<div class="col-sm-10"><input type="text" name="name" class="form-control" value="{{$QualityProcess->name}}" required></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10"><input type="text" name="description" class="form-control" value="{{$QualityProcess->description}}"></div>
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

@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
	});
</script>
@endpush

@push('stylesheets')
@endpush