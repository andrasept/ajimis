@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
{{-- {{dd(explode(" ",$data->date_delivery)[0])}} --}}
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
                            <label>Delivery Date</label> 
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <input type="date" placeholder="delivery date" name="date_delivery" class="form-control @error('date_delivery') is-invalid @enderror" value="{{explode(" ",$data->date_delivery)[0]}}">
                            @error('date_delivery') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
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
                        <div class="form-group">
                            <label>Cycle Time</label> 
                            <input type="number" placeholder="cycle time" name="cycle_time_preparation" id="cycle_time" class="form-control @error('cycle_time_preparation') is-invalid @enderror" value="" readonly>
                            @error('cycle_time_preparation') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- <div class="form-group">
                            <label>Preparation Date</label> 
                            <input type="date" placeholder="preaparation date" name="date_preparation" class="form-control @error('date_delivery') is-invalid @enderror" value="{{old('date_delivery')}}">
                            @error('date_delivery') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label>Time Pickup</label> 
                            <input type="time" placeholder="cycle time" id="time_pickup" name="time_pickup" class="form-control @error('time_pickup') is-invalid @enderror" value="" readonly>
                            @error('time_pickup') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
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
<script>
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
                    $('#customer').val(customer);
                    $('#cycle').val(cycle);
                    $('#cycle_time').val(cycle_time);
                    $('#time_pickup').val(time_pickup);
                    $('#time_hour').val(time_hour.toFixed(2));
                }
        }});

    });
    // trigger dengan data edit
    $('#help_column').trigger('change');
    $('#shift').trigger('change');
</script>
@endpush




















