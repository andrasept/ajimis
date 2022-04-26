@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
    <div class="ibox col-lg-6" >
        <div class="ibox-title">
            <h4>Edit Part</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
          <div style="overflow-x: auto">
            <form action="{{route('delivery.master.master_part.update')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="form-group">
                    <label>SKU</label> 
                    <input type="text" placeholder="Enter email" name="sku" class="form-control" value="{{$data->sku}}">
                    <input type="hidden" name="id" class="form-control" value="{{$data->id}}">
                </div>
                <div class="form-group">
                    <label>Part Name</label> 
                    <input type="text" placeholder="Enter name" name="part_name" class="form-control" value="{{$data->part_name}}">
                </div>
                <div class="form-group">
                    <label>Part No Customer</label> 
                    <input type="text" placeholder="Enter name" name="part_no_customer" class="form-control" value="{{$data->part_no_customer}}">
                </div>
                <div class="form-group">
                    <label>Part No AJI</label> 
                    <input type="text" placeholder="Enter name" name="part_no_aji" class="form-control" value="{{$data->part_no_aji}}">
                </div>
                <div class="form-group">
                    <label>Model</label> 
                    <input type="text" placeholder="Enter name" name="model" class="form-control" value="{{$data->model}}">
                </div>
                <div class="form-group">
                    <label>Cycle Time</label> 
                    <input type="text" placeholder="Enter name" name="cycle_time" class="form-control" value="{{$data->cycle_time}}">
                </div>
                <div class="form-group">
                    <label>Addresing</label> 
                    <input type="text" placeholder="Enter name" name="addresing" class="form-control" value="{{$data->addresing}}">
                </div>
                <div class="form-group">
                    <label>Customer</label> 
                    <select name="customer_id" class="form-control" id="customer_id">
                        @foreach ($customers as $customer)
                        <option value="{{$customer->customer_code}}" {{$customer->customer_code == $data->customer_id  ? 'selected' : ''}}>{{$customer->customer_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Line</label> 
                    <select name="line_id" class="form-control" id="line_id">
                        @foreach ($lines as $line)
                        <option value="{{$line->line_code}}" {{$line->line_code == $data->line_id  ? 'selected' : ''}}>{{$line->line_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Qty/Pallet</label> 
                    <select name="packaging_id" class="form-control" id="packaging_id">
                        @foreach ($packagings as $packaging)
                        <option value="{{$packaging->packaging_code}}" {{$packaging->packaging_code == $data->packaging_id  ? 'selected' : ''}}>{{$packaging->qty_per_pallet}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Part Card</label> 
                    <select name="color_id" class="form-control" id="packaging_id">
                        @foreach ($partcards as $partcard)
                        <option value="{{$partcard->color_code}}" {{$partcard->color_code == $data->color_id  ? 'selected' : ''}}>{{$partcard->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button class="btn btn-primary btn-sm float-right" >Save</button>
                </div>
            </form>
                <div>
                    <button class="btn btn-default btn-sm float-left" onClick="history.back()">Back</button>
                </div>
          </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush




















