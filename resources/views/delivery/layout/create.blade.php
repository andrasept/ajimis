@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')



@section('content')
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">


    <div class="ibox " >
        {{-- {{dd($data);}} --}}
        <div class="ibox-title">
            <h4>Create Position</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.layout_area.insert')}}" enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Position</label>
                            </br>
                            <select name="position" class="form-control" id="position" required>
                                <option value="admin_delivery" {{ old('position') == "admin_delivery" ? "selected" : "" }}>admin delivery</option>
                                <option value="finish_goods_1" {{ old('position') == "finish_goods_1" ? "selected" : "" }}>finish goods 1</option>
                                <option value="finish_goods_2" {{ old('position') == "finish_goods_2" ? "selected" : "" }}>finish goods 2</option>
                                <option value="preparation_1" {{ old('position') == "preparation_1" ? "selected" : "" }}>preparation 1</option>
                                <option value="preparation_2" {{ old('position') == "preparation_2" ? "selected" : "" }}>preparation 2</option>
                                <option value="preparation_3" {{ old('position') == "preparation_3" ? "selected" : "" }}>preparation 3</option>
                                <option value="packaging" {{ old('position') == "packaging" ? "selected" : "" }}>packaging</option>
                                <option value="pulling_sparepart" {{ old('position') == "pulling_sparepart" ? "selected" : "" }}>pulling sparepart</option>
                                <option value="sparepart" {{ old('position') == "sparepart" ? "selected" : "" }}>sparepart</option>
                            </select>
                            @error('position') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Man Power</label>  <br/>
                            <select name="user_id" class="form-control" id="user_id" required>
                                @foreach ($mps as $mp)
                                    <option value="{{$mp->npk}}" {{ old('user_id') == $mp->npk ? "selected" : "" }}>{{$mp->name}} </option>
                                @endforeach
                                {{-- <option value="-" {{ old('user_id') == '-' ? "selected" : "" }}>-</option> --}}
                            </select>
                            @error('user_id') 
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
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>


<script>

    // mini nav bar
        $("body").addClass("body-small mini-navbar");
    // huruf kecil table
    $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
    $("select").css({fontSize:12});
    $("input").css({fontSize:12});

    $(document).ready(function(){

    });

    
</script>
@endpush




















