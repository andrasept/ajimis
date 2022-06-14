@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | Delivery')



@section('content')
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">

    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Schedule Delivery</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.delivery.update')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="form-group">
                    <label>Customer</label> 
                    <input type="hidden"name="id"  class="form-control " value="{{$data->id}}" >
                    <input type="text" placeholder="customer" name="customer_pickup_id" id="customer_pickup_id" class="form-control @error('customer_pickup_id') is-invalid @enderror" value="{{$data->customer_pickup_id}}" readonly>
                    @error('customer_pickup_id') 
                        <div class="text-danger">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Cycle</label> 
                    <input type="number" placeholder="cycle" name="cycle" id="cycle" class="form-control @error('cycle') is-invalid @enderror" value="{{$data->cycle}}" readonly>
                    @error('cycle') 
                        <div class="text-danger">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Vendor</label> 
                    <input type="text" placeholder="vendor" name="vendor" id="vendor" class="form-control @error('vendor') is-invalid @enderror" value="{{$data->vendor}}" readonly>
                    @error('vendor') 
                        <div class="text-danger">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Plan Arrival</label> 
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="date" class="form-control" name="date_plan_arrival" id="" value="{{date('Y-m-d', strtotime(explode(' ',$data->arrival_plan)[0]))}}">
                            @error('date_plan_arrival') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" name="time_plan_arrival" autocomplete="off" class="form-control" value="{{date('H:i:s', strtotime(explode(' ',$data->arrival_plan)[1]))}}" >
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                            @error('time_plan_arrival') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                   
                   
                </div>
                <div class="form-group">
                    <label>Plan Departure</label> 
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="date" class="form-control" name="date_plan_departure" id="" value="{{date('Y-m-d', strtotime(explode(' ',$data->departure_plan)[0]))}}">
                            @error('date_plan_departure') 
                            <div class="text-danger">
                                {{$message}}
                            </div>
                        @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" name="time_plan_departure" autocomplete="off" class="form-control" value="{{date('H:i:s', strtotime(explode(' ',$data->departure_plan)[1]))}}" >
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                            @error('time_plan_departure') 
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
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('js/plugins/clockpicker/clockpicker.js')}}"></script>
<script>

    $(".select2_help_column").select2();
    // clockpicker
    $('.clockpicker').clockpicker();
    // mini nav bar
        $("body").addClass("body-small mini-navbar");
    // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});
      $("input").css({fontSize:12});
    // autocomplete pic
      $('#shift').change(function(){
        var shift = $('#shift').val(); 
        $("#pic").attr("disabled", false); 
        $.ajax({
            url: "get_data_pic",
            method: "post",
            data:{
                "shift" : shift,
                "_token": "{{ csrf_token() }}",
            },
            success: function(result){
                $('#pic').empty();
                if (result == '404'  ) {
                    $('#pic').empty();  
                } else {
                    $.each(result, function (key, entry) {
                        $('#pic').append($('<option></option>').attr('value', entry.npk).text(entry.name));
                    })
                }
            }});
      });
    // autocomplete cycle,cycle time, time pickup, time hour
    $('#help_column').change(function(){
        var help_column = $('#help_column').val();

        $.ajax({
            url: "get_data_detail_pickup",
            method: "post",
            data:{
                "help_column" : help_column,
                "_token": "{{ csrf_token() }}",
            },
            success: function(result){
                console.log(result);
                if (result == '404'  ) {
                    alert("gagal");
                } else {
                    var customer = result.customer_pickup_code;
                    var cycle = result.cycle;
                    var cycle_time = result.cycle_time_preparation;
                    var time_pickup = result.time_pickup;
                    var time_hour = cycle_time/60;
                    $('#customer').val(customer);
                    $('#cycle').val(cycle);
                    $('#cycle_time').val(cycle_time);
                    $('#time_pickup').val(time_pickup);
                    $('#time_hour').val(time_hour.toFixed(2));
                }
        }});
    });

    
</script>
@endpush




















