@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')



@section('content')
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
{{-- <link href="{{asset('css/animate.css')}}" rel="stylesheet"> --}}
{{-- <link href="{{asset('css/style.css')}}" rel="stylesheet">
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"> --}}


    <div class="ibox " >
        {{-- {{dd($data);}} --}}
        <div class="ibox-title">
            <h4>Edit Skill</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.skills.update')}}" enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label> <br>
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <select name="category" id="category" style="width:100%" class="select2_category form-control" required>
                                <option value="PPC" {{"PPC" == $data->category  ? 'selected' : ''}}>PPC</option>
                                <option value="Pulling FG OEM" {{"Pulling FG OEM" == $data->category  ? 'selected' : ''}}>Pulling FG OEM</option>
                                <option value="Delivery Control" {{"Delivery Control" == $data->category  ? 'selected' : ''}}>Delivery Control</option>
                                <option value="Preparation Delivery OEM" {{"Preparation Delivery OEM" == $data->category  ? 'selected' : ''}}>Preparation Delivery OEM</option>
                                <option value="Sparepart" {{"Sparepart" == $data->category  ? 'selected' : ''}}>Sparepart</option>
                                <option value="Packaging Control" {{"Packaging Control" == $data->category  ? 'selected' : ''}}>Packaging Control</option>
                               
                            </select>
                            @error('category') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Skill Code</label>  
                            <input type="text" id="skill_code" placeholder="skill_code" name="skill_code" class="form-control" value="{{$data->skill_code}}" autocomplete="off">
                            @error('skill_code') 
                            <div class="text-danger">
                            {{$message}}    
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Skill Description</label>  
                            <input type="text" id="skill" placeholder="skill" name="skill" class="form-control" value="{{$data->skill}}" autocomplete="off">
                            @error('skill') 
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

    $(".select2_part_number").select2();
    $(".select2_customer_pickup_id").select2();
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




















