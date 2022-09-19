@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT LINE')
 
 
@section('content')
{{-- {{dd($data->color_id)}} --}}
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Part Card</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div>
            <form action="{{route('delivery.master.master_partcard.update')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Part Card Code</label> 
                            <input type="hidden" name="id" class="form-control" value="{{$data->id}}">
                            <input type="hidden" name="updated_by" class="form-control" value="{{Auth::user()->name}}">
                            <input type="text" placeholder="color code" name="color_code" class="form-control @error('color_code') is-invalid @enderror" value="{{$data->color_code}}">
                            @error('color_code') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label> 
                            <input type="text" placeholder="Description" name="description" class="form-control @error('description') is-invalid @enderror" value="{{$data->description}}">
                            @error('description') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Remark 1</label> 
                            <input type="text" placeholder="remark 1" name="remark_1" class="form-control @error('remark_1') is-invalid @enderror" value="{{$data->remark_1}}">
                            @error('remark_1') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Remark 2</label> 
                            <input type="text" placeholder="remark 2" name="remark_2" class="form-control @error('remark_2') is-invalid @enderror" value="{{$data->remark_2}}">
                            @error('remark_2') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
          </div>
        </div>
        <div class="ibox-footer text-right">
                <button class="btn btn-primary btn-sm " >Save</button>
        </form>
                <a class="btn btn-default btn-sm float-left" href="{{route('delivery.master.master_partcard')}}">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
@endpush




















