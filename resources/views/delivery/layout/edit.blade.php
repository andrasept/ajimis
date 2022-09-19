@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')



@section('content')
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">


    <div class="ibox " >
        {{-- {{dd($data);}} --}}
        <div class="ibox-title">
            <h4>Edit Position</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('delivery.layout_area.update')}}" enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Position</label>
                            <input type="hidden" class="form-control" name="id" id="id" readonly value="{{$data->id}}">
                            <input type="text" class="form-control" name="position" id="position" readonly value="{{$data->position}}">
                        </div>
                        <div class="form-group">
                            <label>Man Power</label>  <br/>
                            <select name="user_id" class="form-control" id="user_id" required>
                                @foreach ($mps as $mp)
                                    <option value="{{$mp->npk}}"  {{ $data->user_id == $mp->npk ? "selected" : "" }}>{{$mp->name}} </option>
                                @endforeach
                                {{-- <option value="-" {{ old('user_id') == '-' ? "selected" : "" }}>-</option> --}}
                            </select>
                            @error('user_id') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Henkaten</label> </br>
                            <select name="henkaten_status" class="form-control" id="henkaten_status" required>
                                <option value="0" {{ $data->henkaten_status == "0" ? "selected" : "" }}>No</option>
                                <option value="1" {{ $data->henkaten_status == "1" ? "selected" : "" }}>Yes</option>
                            </select>
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

        $("body").tooltip({ selector: '[data-toggle=tooltip]' });

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

        $(".add").click(function(){ 
            var html = '<div class="custom-file mt-2 "><input  name="photo[]" type="file" class="custom-file-input"><label for="photo" class="custom-file-label">Choose file...</label></div>';
            $(".increment").append(html);
            
            // ulang untuk pick file
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

            // remove ulang
            $("body").on("click",".btn-danger",function(){ 
                $('div.clone').children().last().remove();
            });
        });
        $("body").on("click",".btn-danger",function(){ 
            $('div.increment').children().last().remove();
        });
        $("body").on("click",".remove",function(){ 
            var photo= $(this).attr("data-photo");
            var element= '<input  name="delete[]" type="text" class="custom-file-input d-none" value="'+photo+'">';
            $(this).empty().html(element);
        });
        // autocomplete part
            $('#part_number').change(function(){
                var part_no = $('#part_number').val(); 
                
                $.ajax({
                    url: "{{route('delivery.claim.get_data_part')}}",
                    method: "post",
                    data:{
                        "part_no" : part_no,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(result){
                        console.log(result);
                        $('#part_name').empty();
                        if (result == '404'  ) {
                            $('#part_name').empty();  
                            $('#customer_id').empty();  
                        } else {
                            $('#part_name').val(result.part_name);  
                            $('#customer_pickup_id').val(result.customer_id);  
                        }
                    }});
            });

        $('[name=part_number]').val("{{$data->part_number}}").trigger("change");  
    });

    
</script>
@endpush




















