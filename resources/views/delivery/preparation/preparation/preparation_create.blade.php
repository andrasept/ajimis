@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')



@section('content')
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">

    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Preparation</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.preparation.insert')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer Cycle</label> <br>
                            <select name="help_column" id="help_column" style="width:100%" class="select2_help_column form-control">
                                <option value="-">-</option>
                                @foreach ($customers as $column)
                                    <option value="{{$column->help_column}}" >{{$column->help_column}}</option>
                                @endforeach
                            </select>
                            @error('help_column') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Plan Preparation</label> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="date" placeholder="delivery plan date" name="plan_date_preparation" class="form-control @error('plan_date_preparation') is-invalid @enderror" value="{{old('plan_date_preparation')}}">
                                    @error('plan_date_preparation') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group clockpicker" data-autoclose="true">
                                        <input type="text" name="plan_time_preparation" autocomplete="off" class="form-control" value="{{old('plan_time_preparation')}}" >
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
                                    <input type="date" class="form-control" name="date_plan_arrival" id="" value="{{old('date_plan_arrival')}}">
                                    @error('date_plan_arrival') 
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group clockpicker" data-autoclose="true">
                                        <input type="text" name="time_plan_arrival" id="time_plan_arrival" autocomplete="off" class="form-control" value="{{old('time_plan_arrival')}}" >
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
                                    <input type="date" class="form-control" name="date_plan_departure" id="" value="{{old('date_plan_departure')}}">
                                    @error('date_plan_departure') 
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group clockpicker" data-autoclose="true">
                                        <input type="text" name="time_plan_departure" id="time_plan_departure" autocomplete="off" class="form-control" value="{{old('time_plan_departure')}}" >
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
                            <input type="text" id="customer" placeholder="customer" name="customer_pickup_id" class="form-control" value="{{old('customer_pickup_id')}}" readonly>
                            @error('customer_pickup_id') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Cycle</label> 
                            <input type="number" placeholder="cycle" name="cycle" id="cycle" class="form-control @error('cycle') is-invalid @enderror" value="{{old('cycle')}}" readonly>
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
                            <input type="number" placeholder="cycle time" name="cycle_time_preparation" id="cycle_time" class="form-control @error('cycle_time_preparation') is-invalid @enderror" value="{{old('cycle_time_preparation')}}" readonly>
                            @error('cycle_time_preparation') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Vendor</label> 
                            <input type="text" placeholder="vendor" name="vendor" id="vendor" class="form-control @error('vendor') is-invalid @enderror" value="{{old('vendor')}}" readonly >
                            @error('vendor') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Time Hour</label> 
                            <input type="number" placeholder="cycle time" id="time_hour" name="time_hour" class="form-control @error('time_hour') is-invalid @enderror" value="{{old('time_hour')}}" readonly>
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
                                @foreach ($shifts as $data)
                                <option value="{{$data->shift}}" >{{$data->shift}}</option>
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
                            <select name="pic" id="pic" class="form-control " value="" disabled>
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
                <button class="btn btn-primary btn-sm " >Save</button>
        </form>
                <a class="btn btn-default float-left" onClick="history.back()">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('js/plugins/clockpicker/clockpicker.js')}}"></script>
<script src="{{asset('js/moment.min.js')}}"></script>
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
                    var vendor = result.vendor;
                    var plan_departure = moment("1/1/2022 "+time_pickup).add(20, 'minutes').format('HH:mm:ss');    
                    
                    $('#customer').val(customer);
                    $('#cycle').val(cycle);
                    $('#vendor').val(vendor);
                    $('#cycle_time').val(cycle_time);
                    $('#time_plan_departure').val(plan_departure);
                    $('#time_plan_arrival').val(time_pickup);
                    $('#time_hour').val(time_hour.toFixed(2));
                }
        }});
    });

    
</script>
@endpush




















