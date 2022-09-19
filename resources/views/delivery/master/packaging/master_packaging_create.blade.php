@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Part</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.master.master_packaging.insert')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Packaging Code</label> 
                            <input type="text" placeholder="packaging code" name="packaging_code" class="form-control @error('packaging_code') is-invalid @enderror" value="{{old('packaging_code')}}">
                            @error('packaging_code') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Qty / Pallet</label> 
                            <input type="number" placeholder="qty" name="qty_per_pallet" class="form-control @error('qty_per_pallet') is-invalid @enderror" value="{{old('qty_per_pallet')}}">
                            @error('qty_per_pallet') 
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
                <a class="btn btn-default float-left" href="{{route('delivery.master.master_packaging')}}">Back</a>
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




















