@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Man Power</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div style="overflow-x: auto">
            <form action="{{route('delivery.master.master_manpower.update')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label> 
                            <input type="hidden" name="id" class="form-control" value="{{$data->id}}">
                            <input type="text" placeholder="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$data->name}}">
                            @error('sku') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>NPK</label> 
                            <input type="text" placeholder="npk" name="npk" class="form-control @error('npk') is-invalid @enderror" value="{{$data->npk}}">
                            @error('npk') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        @foreach (explode(",", $data->position) as $item)
                            <div class="form-group">
                                <label>Position {{$loop->iteration}}</label> 
                                <select name="position[]" class="form-control" >
                                    <option value="-">-</option> 
                                    <option value="PPC" {{"PPC" == strtoupper($item)  ? 'selected' : ''}}>PPC</option> 
                                    <option value="PULLING" {{"PULLING" == strtoupper($item)  ? 'selected' : ''}}>PULLING</option> 
                                    <option value="DELIVERY CONTROL" {{"DELIVERY CONTROL" == strtoupper($item)  ? 'selected' : ''}}>DELIVERY CONTROL</option> 
                                    <option value="PREPARATION " {{"PREPARATION" == strtoupper($item)  ? 'selected' : ''}}>PREPARATION </option> 
                                    <option value="SPAREPART" {{"SPAREPART" == strtoupper($item)  ? 'selected' : ''}}>SPAREPART</option> 
                                    <option value="PACKAGING CONTROL" {{"PACKAGING CONTROL" == strtoupper($item)  ? 'selected' : ''}}>PACKAGING CONTROL</option> 
                                </select>
                                @error('position') 
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label>add Position</label> 
                            <select name="position[]" class="form-control" >
                                <option value="-">-</option> 
                                <option value="PPC" >PPC</option> 
                                <option value="PULLING" >PULLING</option> 
                                <option value="DELIVERY CONTROL" >DELIVERY CONTROL</option> 
                                <option value="PREPARATION">PREPARATION </option> 
                                <option value="SPAREPART" >SPAREPART</option> 
                                <option value="PACKAGING CONTROL" >PACKAGING CONTROL</option> 
                            </select>
                            @error('position') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Title</label> 
                            <select name="title" class="form-control" id="title">
                                <option value="-">-</option> 
                                <option value="MEMBER" {{"MEMBER" == strtoupper($data->title)  ? 'selected' : ''}}>MEMBER</option> 
                                <option value="LEADER" {{"LEADER" == strtoupper($data->title)  ? 'selected' : ''}}>LEADER</option> 
                                <option value="FOREMAN" {{"FOREMAN" == strtoupper($data->title)  ? 'selected' : ''}}>FOREMAN</option> 
                                <option value="SUPERVISOR" {{"SUPERVISOR" == strtoupper($data->title)  ? 'selected' : ''}}>SUPERVISOR</option> 
                            </select>
                            @error('title') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Shift</label> 
                            <select name="shift" class="form-control" id="shift">
                                <option value="-">-</option> 
                                <option value="NON SHIFT" {{"NON SHIFT" == strtoupper($data->shift)  ? 'selected' : ''}}>NON SHIFT</option> 
                                <option value="SHIFT 1" {{"SHIFT 1" == strtoupper($data->shift)  ? 'selected' : ''}}>SHIFT 1</option> 
                                <option value="SHIFT 2" {{"SHIFT 2" == strtoupper($data->shift)  ? 'selected' : ''}}>SHIFT 2</option> 
                            </select>
                            @error('shift') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <div class="container mb-2">
                                <img src="{{ url('storage/delivery-manpower-photo/'.$data->photo) }}" style="" class="" alt=""  width='60' height='60'>
                            </div>
                            <div class="custom-file">
                                <input id="photo" name="photo" type="file" class="custom-file-input" value="">
                                <label for="photo" class="custom-file-label">Choose file...</label>
                            </div>
                            {{-- <div  class="remove col-lg-1 m-2" data-photo="{{$data->photo}}" >
                                <input  name="photo" type="hidden" class="custom-file-input" value="{{$data->photo}}">
                                <img src="{{ url('storage/delivery-manpower-photo/'.$data->photo) }}" style="position: absolute;" class="" id-photo="{{$item}}" alt=""  width='60' height='60'>
                            </div> --}}
                            @error('photo') 
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
                <a class="btn btn-default float-left" href="{{route('delivery.master.master_manpower')}}">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Sweet alert -->
<script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
    // mini nav bar
        $("body").addClass("body-small mini-navbar");
    // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});
      $("input").css({fontSize:12});

     $(document).ready(function(){
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            var ext = fileName.split('.')[1];

            if (ext == "png" || ext == "jpg" || ext == "jpeg") {
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                console.log(ext);
                $(this).html("");
                swal("Oops!", "Only JPG,JPEG, & PNG file!", "error");
            }
        });
     });
</script>
@endpush




















