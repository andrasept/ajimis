@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')



@section('content')
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">


    <div class="ibox " >
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
                            <label>Area</label>
                            </br>
                            <select name="position" class="form-control" id="position" required>
                                <option value="">-</option>
                                @foreach ($area as $item)
                                <option value="{{$item->area}}" {{ old('position') == $item->area ? "selected" : "" }}>{{$item->area}}</option>
                                @endforeach
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
                                <option value="-" {{ old('user_id') == '-' ? "selected" : "" }}>-</option>
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
        $('#position').change(function(){
            var area = this.value;
            $.ajax({
                    url: "{{route('delivery.layout_area.get_mp_where_area')}}",
                    method: "post",
                    data:{
                        "area" : area,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(result){
                        $('#user_id').empty();
                        if (result != '404') {
                            $.each(result, function (key, entry) {
                                $('#user_id').append($('<option></option>').attr('value', entry.npk).text(entry.name));
                            })
                        } else {
                            
                        }
                    }
            });
        });
    });

    
</script>
@endpush




















