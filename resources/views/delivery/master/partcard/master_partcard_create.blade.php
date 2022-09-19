@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | CREATE LINE')
 
 
@section('content')
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Part Card</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.master.master_partcard.insert')}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Part Card Code</label> 
                            <input type="text" placeholder="color code" name="color_code" class="form-control @error('color_code') is-invalid @enderror" value="{{old('color_code')}}">
                            @error('color_code') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label> 
                            <input type="text" placeholder="Description" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}">
                            @error('description') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Remark 1</label> 
                            <input type="text" placeholder="remark 1" name="remark_1" class="form-control @error('remark_1') is-invalid @enderror" value="{{old('remark_1')}}">
                            @error('remark_1') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Remark 2</label> 
                            <input type="text" placeholder="remark 2" name="remark_2" class="form-control @error('remark_2') is-invalid @enderror" value="{{old('remark_2')}}">
                            @error('remark_2') 
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
                <a class="btn btn-default float-left" href="{{route('delivery.master.master_partcard')}}">Back</a>
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




















