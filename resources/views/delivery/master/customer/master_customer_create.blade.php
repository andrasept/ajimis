@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | CREATE LINE')
 
 
@section('content')
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Customer</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.master.master_customer.insert')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer Code</label> 
                            <input type="text" placeholder="customer code" name="customer_code" class="form-control @error('customer_code') is-invalid @enderror" value="{{old('customer_code')}}">
                            @error('customer_code') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Customer Name</label> 
                            <input type="text" placeholder="customer name" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{old('customer_name')}}">
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
                <a class="btn btn-default float-left" href="{{route('delivery.master.master_customer')}}">Back</a>
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
</script>
@endpush




















