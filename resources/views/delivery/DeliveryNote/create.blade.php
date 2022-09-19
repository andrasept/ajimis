@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')



@section('content')
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Claim</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.delivery_note.insert')}}" enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer</label> <br>
                            <select name="customer" id="customer" style="width:100%" class="select2_customer form-control" required>
                                <option value="-">-</option>
                                @foreach ($customers as $customer)
                                <option value="{{$customer->customer_code}}">{{$customer->customer_code}}</option>
                                @endforeach
                            </select>
                            @error('customer') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Delivery Note</label>  
                            <input type="text" id="delivery_note" placeholder="delivery note" name="delivery_note" class="form-control" value="{{old('delivery_note')}}" required>
                            @error('delivery_note') 
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
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>

<script src="{{asset('js/js_agil/dataTables.responsive.js')}}"></script>

<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>

    $(".select2_part_number").select2();
    $(".select2_customer_pickup_id").select2();
    // clockpicker
    // $('.clockpicker').clockpicker();
    // mini nav bar
        $("body").addClass("body-small mini-navbar");
    // huruf kecil table
    $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
    $("select").css({fontSize:12});
    $("input").css({fontSize:12});


    
</script>
@endpush




















