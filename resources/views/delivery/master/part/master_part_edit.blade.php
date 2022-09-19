@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
{{-- {{dd($data->color_id)}} --}}
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Part</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div style="overflow-x: auto">
            <form action="{{route('delivery.master.master_part.update')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>SKU</label> 
                            <input type="number" placeholder="Enter sku" name="sku" class="form-control" value="{{$data->sku}}">
                            <input type="hidden" name="id" class="form-control" value="{{$data->id}}">
                            <input type="hidden" name="updated_by" class="form-control" value="{{Auth::user()->name}}">
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
                            <label>Packaging Code</label> 
                            <select name="packaging_id" class="form-control" id="packaging_id">
                                <option value="-">-</option> 
                                @foreach ($packagings as $packaging)
                                <option value="{{$packaging->packaging_code}}" {{$packaging->packaging_code == strtoupper($data->packaging_id)  ? 'selected' : ''}}>{{$packaging->packaging_code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Part Card</label> 
                            <select name="color_id" class="form-control" id="color_id">
                                <option value="-">-</option> 
                                @foreach ($partcards as $partcard)
                                <option value="{{$partcard->color_code}}" {{strtoupper($partcard->color_code) == strtoupper($data->color_id)  ? 'selected' : ''}}>{{$partcard->description}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Addresing</label> 
                            <input type="text" placeholder="Enter name" name="addresing" class="form-control" value="{{$data->addresing}}">
                        </div>
                    </div>
                    <div class="col-md-6">
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
                            <input type="number" placeholder="Enter name" name="cycle_time" class="form-control" value="{{$data->cycle_time}}">
                        </div>
                        
                        <div class="form-group">
                            <label>Customer</label> 
                            <select name="customer_id" class="form-control" id="customer_id">
                                <option value="-">-</option> 
                                @foreach ($customers as $customer)
                                <option value="{{$customer->customer_code}}" {{strtoupper($customer->customer_code) == strtoupper($data->customer_id)  ? 'selected' : ''}}>{{$customer->customer_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Line</label> 
                            <select name="line_id" class="form-control" id="line_id">
                                <option value="-">-</option> 
                                @foreach ($lines as $line)
                                <option value="{{$line->line_code}}" {{strtoupper($line->line_code) == strtoupper($data->line_id)  ? 'selected' : ''}}>{{$line->line_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Category</label> 
                            <select name="category" class="form-control" id="category">
                                <option value="-">-</option> 
                                <option value="FG" {{ "FG" == strtoupper($data->category)  ? 'selected' : ''}}>FG</option> 
                                <option value="SFG" {{ "SFG" == strtoupper($data->category)  ? 'selected' : ''}}>SFG</option> 
                            </select>
                        </div>
                        
                    </div>
                </div>
          </div>
        </div>
        <div class="ibox-footer text-right">
                <button class="btn btn-primary btn-sm " >Save</button>
        </form>
                <a class="btn btn-default btn-sm float-left" href="{{route('delivery.master.master_part')}}">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
@endpush




















