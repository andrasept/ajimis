@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Man Power</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div style="overflow-x: auto">
            <form action="{{route('delivery.master.master_manpower.insert')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label> 
                            <input type="text" placeholder="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                            @error('sku') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>NPK</label> 
                            <input type="text" placeholder="npk" name="npk" class="form-control @error('npk') is-invalid @enderror" value="{{old('npk')}}">
                            @error('npk') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Default Area</label> 
                            <select name="area" class="form-control" id="area" required>
                                <option value="delivery_control" {{ old('area') == "delivery_control" ? "selected" : "" }}>delivery control</option>
                                <option value="preparation_pulling_1" {{ old('area') == "preparation_pulling_1" ? "selected" : "" }}>pulling preparation 1</option>
                                <option value="preparation_pulling_2" {{ old('area') == "preparation_pulling_2" ? "selected" : "" }}>pulling preparation 2</option>
                                <option value="pulling_oem_2" {{ old('area') == "pulling_oem_2" ? "selected" : "" }}>pulling oem 2</option>
                                <option value="packaging_2" {{ old('area') == "packaging_2" ? "selected" : "" }}>packaging 2</option>
                                <option value="preparation" {{ old('area') == "preparation" ? "selected" : "" }}>preparation </option>
                                <option value="packaging_1" {{ old('area') == "packaging_1" ? "selected" : "" }}>packaging 1</option>
                                <option value="pulling_oem_1" {{ old('area') == "pulling_oem_1" ? "selected" : "" }}>pulling oem 1</option>
                                <option value="sparepart" {{ old('area') == "sparepart" ? "selected" : "" }}>sparepart</option>
                            </select>
                            @error('area') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>  
                            @enderror   
                        </div>
                        <div class="form-group">
                            <label>Position 1</label> 
                            <select name="position[]" class="form-control" id="position">
                                <option value="-">-</option> 
                                <option value="PPC" >PPC</option> 
                                <option value="PULLING">PULLING</option> 
                                <option value="DELIVERY CONTROL">DELIVERY CONTROL</option> 
                                <option value="PREPARATION ">PREPARATION </option> 
                                <option value="SPAREPART">SPAREPART</option> 
                                <option value="PACKAGING CONTROL">PACKAGING CONTROL</option> 
                            </select>
                            @error('position') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Position 2</label> 
                            <select name="position[]" class="form-control" id="position">
                                <option value="-">-</option> 
                                <option value="PPC" >PPC</option> 
                                <option value="PULLING">PULLING</option> 
                                <option value="DELIVERY CONTROL">DELIVERY CONTROL</option> 
                                <option value="PREPARATION ">PREPARATION </option> 
                                <option value="SPAREPART">SPAREPART</option> 
                                <option value="PACKAGING CONTROL">PACKAGING CONTROL</option> 
                            </select>
                            @error('position') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Position 3</label> 
                            <select name="position[]" class="form-control" id="position">
                                <option value="-">-</option> 
                                <option value="PPC" >PPC</option> 
                                <option value="PULLING">PULLING</option> 
                                <option value="DELIVERY CONTROL">DELIVERY CONTROL</option> 
                                <option value="PREPARATION ">PREPARATION </option> 
                                <option value="SPAREPART">SPAREPART</option> 
                                <option value="PACKAGING CONTROL">PACKAGING CONTROL</option> 
                            </select>
                            @error('position') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label> 
                            <select name="title" class="form-control" id="title">
                                <option value="-">-</option> 
                                <option value="MEMBER" >MEMBER</option> 
                                <option value="LEADER" >LEADER</option> 
                                <option value="FOREMAN" >FOREMAN</option> 
                                <option value="SUPERVISOR" >SUPERVISOR</option> 
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
                                <option value="NON SHIFT" >NON SHIFT</option> 
                                <option value="SHIFT 1" >SHIFT 1</option> 
                                <option value="SHIFT 2" >SHIFT 2</option> 
                            </select>
                            @error('shift') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <div class="custom-file">
                                <input id="photo" name="photo" type="file" class="custom-file-input">
                                <label for="photo" class="custom-file-label">Choose file...</label>
                            </div>
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
            var ext = fileName.split('.').pop();

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




















