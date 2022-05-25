@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">

    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Customer Pickup</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.pickupcustomer.insert')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer Pickup</label> 
                            <input type="text" placeholder="Customer" id="customer" name="customer_pickup_code" class="form-control @error('customer_pickup_code') is-invalid @enderror" value="{{old('packaging_code')}}">
                            @error('customer_pickup_code') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Cycle</label> 
                            <input type="number" id="cycle" placeholder="cycle" name="cycle" class="form-control @error('cycle') is-invalid @enderror" value="{{old('cycle')}}">
                            @error('cycle') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Cycle Time</label> 
                            <input type="number" placeholder="cycle time" name="cycle_time_preparation" class="form-control @error('cycle_time_preparation') is-invalid @enderror" value="{{old('cycle')}}">
                            @error('cycle_time_preparation') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Help Column</label> 
                            <input type="text" id="help_column" placeholder="Help Column" name="help_column" class="form-control @error('help_column') is-invalid @enderror" value="{{old('packaging_code')}}" readonly>
                            @error('help_column') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label>Time Pickup</label> 
                            <input type="time" placeholder="cycle time" name="time_pickup" class="form-control @error('time_pickup') is-invalid @enderror" value="{{old('cycle')}}">
                            @error('time_pickup') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div> --}}
                    </div>
                    <div class="col-md-6">
                        <label for="">Time Pickup</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input type="text" name="time_pickup" class="form-control" value="" >
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
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
<script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>

<script src="{{asset('js/plugins/clockpicker/clockpicker.js')}}"></script>
<script>
    // clockpicker
    $('.clockpicker').clockpicker();
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

       if (cycle == 0) {
            $("#help_column").val(customer);
       } else {
            $("#help_column").val(customer+" Cycle "+cycle);
       }
    });
    $('#customer').change(function(){
        var customer = $('#customer').val();
        var cycle = $('#cycle').val();

        if (cycle == 0) {
            $("#help_column").val(customer);
        } else {
                $("#help_column").val(customer+" Cycle "+cycle);
        }
    });
</script>
@endpush




















