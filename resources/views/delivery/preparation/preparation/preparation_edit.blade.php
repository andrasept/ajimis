@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">

    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Preparation</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.preparation.update')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Help Column</label> 
                            <select name="help_column" id="help_column" class="form-control">
                                <option value="-">-</option>
                                @foreach ($customers as $column)
                                    <option value="{{$column->help_column}}" {{$column->help_column == $data->help_column  ? 'selected' : ''}}>{{$column->help_column}}</option>
                                @endforeach
                            </select>
                            @error('help_column') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Preparation Plan</label> 
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="date" placeholder="delivery plan date" name="plan_date_preparation" class="form-control @error('plan_date_preparation') is-invalid @enderror" value="{{$data->plan_date_preparation}}">
                                    @error('plan_date_preparation') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group clockpicker" data-autoclose="true">
                                        <input type="text" name="plan_time_preparation" autocomplete="off" class="form-control" value="{{$data->plan_time_preparation}}" >
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                    </div>
                                    @error('plan_time_preparation') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
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
                                        <input type="text" name="time_plan_arrival" id="time_plan_arrival" autocomplete="off" class="form-control" value="{{date('H:i:s', strtotime(explode(' ',$data->arrival_plan)[1]))}}" >
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
                                        <input type="text" name="time_plan_departure" id="time_plan_departure" autocomplete="off" class="form-control" value="{{date('H:i:s', strtotime(explode(' ',$data->departure_plan)[1]))}}" >
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
                        <div class="form-group">
                            <label>Customer Pickup</label>  
                            <input type="text" id="customer" placeholder="customer" name="customer_pickup_id" class="form-control" readonly>
                            @error('customer_pickup_id') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Cycle</label> 
                            <input type="number" placeholder="cycle" name="cycle" id="cycle" class="form-control @error('cycle') is-invalid @enderror" value="" readonly>
                            @error('cycle') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cycle Time</label> 
                            <input type="number" placeholder="cycle time" name="cycle_time_preparation" id="cycle_time" class="form-control @error('cycle_time_preparation') is-invalid @enderror" value="" readonly>
                            @error('cycle_time_preparation') 
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
                        {{-- <div class="form-group">
                            <label>Time Pickup</label> 
                            <input type="time" placeholder="cycle time" id="time_pickup" name="time_pickup" class="form-control @error('time_pickup') is-invalid @enderror" value="" readonly>
                            @error('time_pickup') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label>Time Hour</label> 
                            <input type="number" placeholder="cycle time" id="time_hour" name="time_hour" class="form-control @error('time_hour') is-invalid @enderror" value="" readonly>
                            @error('time_hour') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Shift</label> 
                            <select name="shift" id="shift" class="form-control">
                                <option value="-">-</option>
                                @foreach ($shifts as $jadwal)
                                <option value="{{$jadwal->shift}}" {{strtoupper($jadwal->shift) == strtoupper($data->shift)  ? 'selected' : ''}}>{{$jadwal->shift}}</option>
                                @endforeach
                            </select>
                            @error('shift') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>PIC</label> 
                            <select name="pic" id="pic" class="form-control " disabled>
                            </select>
                            @error('pic') 
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
                <button class="btn btn-primary btn-sm " >Update</button>
        </form>
                <a class="btn btn-default float-left" onClick="history.back()">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{asset('js/plugins/clockpicker/clockpicker.js')}}"></script>

<script>
    // mini nav bar
        $("body").addClass("body-small mini-navbar");
    // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});
      $("input").css({fontSize:12});
    // clockpicker
    $('.clockpicker').clockpicker();
    // autocomplete pic
      $('#shift').change(function(){
        var shift = $('#shift').val(); 
        $("#pic").attr("disabled", false); 
        $.ajax({
            url: "{{route('delivery.preparation.get_data_pic')}}",
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
            url: "{{route('delivery.preparation.get_data_detail_pickup')}}",
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
                    var vendor = result.vendor;
                    $('#customer').val(customer);
                    $('#cycle').val(cycle);
                    $('#cycle_time').val(cycle_time);
                    $('#time_plan_departure').val(time_pickup);
                    $('#time_plan_arrival').val(time_pickup);
                    $('#vendor').val(vendor);
                    $('#time_hour').val(time_hour.toFixed(2));
                }
        }});

    });
    // trigger dengan data edit
    $('#help_column').trigger('change');
    $('#shift').trigger('change');
</script>
@endpush




















