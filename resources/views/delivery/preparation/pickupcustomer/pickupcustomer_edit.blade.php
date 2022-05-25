@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Customer Pickup</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.pickupcustomer.update')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer Pickup</label> 
                            <input type="hidden"  name="id"  value="{{$data->id}}">
                            <input type="text" placeholder="Customer" id="customer" name="customer_pickup_code" class="form-control @error('customer_pickup_code') is-invalid @enderror" value="{{$data->customer_pickup_code}}">
                            @error('customer_pickup_code') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Cycle</label> 
                            <input type="number" placeholder="cycle" id="cycle" name="cycle" class="form-control @error('cycle') is-invalid @enderror" value="{{$data->cycle}}">
                            @error('cycle') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Cycle Time</label> 
                            <input type="number" placeholder="cycle time" id="cycle_time" name="cycle_time_preparation" class="form-control @error('cycle_time_preparation') is-invalid @enderror" value="{{$data->cycle_time_preparation}}">
                            @error('cycle_time_preparation') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Help Column</label> 
                            <input type="text" placeholder="Help Column" id="help_column" name="help_column" class="form-control @error('help_column') is-invalid @enderror" value="{{$data->help_column}}" readonly>
                            @error('help_column') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Time Pickup</label> 
                            <input type="time" placeholder="cycle time" id="time_pickup" name="time_pickup" class="form-control @error('time_pickup') is-invalid @enderror" value="{{$data->time_pickup}}">
                            @error('time_pickup') 
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
                <a class="btn btn-default float-left" onClick="history.back()">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // mini nav bar
        $("body").addClass("body-small mini-navbar");
    // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});
      $("input").css({fontSize:12});
      //   autofill help column
    $('#cycle').change(function(){
        var customer = $('#customer').val();
        var cycle = $('#cycle').val();

        $("#help_column").val(customer+" Cycle "+cycle);
    });
    $('#customer').change(function(){
        var customer = $('#customer').val();
        var cycle = $('#cycle').val();

        $("#help_column").val(customer+" Cycle "+cycle);
    });
</script>
@endpush




















