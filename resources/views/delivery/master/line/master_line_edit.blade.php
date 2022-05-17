@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT LINE')
 
 
@section('content')
{{-- {{dd($data->color_id)}} --}}
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Line</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div>
            <form action="{{route('delivery.master.master_line.update')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>line Code</label> 
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <input type="text" placeholder="line code" name="line_code" class="form-control @error('line_code') is-invalid @enderror" value="{{$data->line_code}}">
                            @error('line_code') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Line Name</label> 
                            <input type="text" placeholder="qty" name="line_name" class="form-control @error('line_name') is-invalid @enderror" value="{{$data->line_name}}">
                            @error('line_name') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Line Category</label> 
                            <input type="text" placeholder="qty" name="line_category" class="form-control @error('line_category') is-invalid @enderror" value="{{$data->line_category}}">
                            @error('line_category') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tonase</label> 
                            <input type="text" placeholder="tonase" name="tonase" class="form-control @error('tonase') is-invalid @enderror" value="{{$data->tonase}}">
                            @error('tonase') 
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
                <a class="btn btn-default btn-sm float-left" href="{{route('delivery.master.master_line')}}">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
@endpush




















