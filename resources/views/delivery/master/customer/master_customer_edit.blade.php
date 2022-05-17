@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT LINE')
 
 
@section('content')
{{-- {{dd($data->color_id)}} --}}
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Customer</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div>
            <form action="{{route('delivery.master.master_customer.update')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer Code</label> 
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <input type="text" placeholder="customer code" name="customer_code" class="form-control @error('customer_code') is-invalid @enderror" value="{{$data->customer_code}}">
                            @error('customer_code') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Customer Name</label> 
                            <input type="text" placeholder="qty" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{$data->customer_name}}">
                            @error('customer_name') 
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
                <a class="btn btn-default btn-sm float-left" href="{{route('delivery.master.master_customer')}}">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
@endpush




















