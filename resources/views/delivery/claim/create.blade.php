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
            <form action="{{route('delivery.claim.insert')}}" enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Part number</label> <br>
                            <select name="part_number" id="part_number" style="width:100%" class="select2_part_number form-control" required>
                                <option value="-">-</option>
                                @foreach ($part_nos as $part_no)
                                <option value="{{$part_no->part_no_customer}}">{{$part_no->part_no_customer}}</option>
                                @endforeach
                            </select>
                            @error('part_number') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Part Name</label>  
                            <input type="text" id="part_name" placeholder="part name" name="part_name" class="form-control" value="{{old('part_name')}}" readonly>
                            @error('part_name') 
                            <div class="text-danger">
                                {{$message}}    
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Customer</label> <br>
                            <input type="text" name="customer_pickup_id" id="customer_pickup_id" placeholder="customer" class="form-control" readonly >
                            @error('customer_pickup_id') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Part Number Actual</label>  
                            <input type="text" id="part_number_actual" placeholder="part number actual" name="part_number_actual" class="form-control" value="{{old('part_number_actual')}}" required>
                            @error('part_number_actual') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Part Name Actual</label>  
                            <input type="text" id="part_name_actual" placeholder="part name actual" name="part_name_actual" class="form-control" value="{{old('part_name_actual')}}" required >
                            @error('part_name_actual') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Claim date</label>
                            <input type="date" class="form-control" name="claim_date" id="" value="{{old('claim_date') ?? date('Y-m-d')}}" required>
                            @error('claim_date') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Problem</label>  
                            <input type="text" id="problem" placeholder="problem" name="problem" class="form-control" value="{{old('problem')}}" required>
                            @error('problem') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label> <br>
                            <select name="category" id="category" style="width:100%" class="select2_category form-control" required>
                                <option value="SHORTAGE">SHORTAGE</option>
                                <option value="DETAIL MISS">DETAIL MISS</option>
                                <option value="SERVICE PART">SERVICE PART</option>
                            </select>
                            @error('category') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Qty</label>  
                            <input type="number" id="qty" placeholder="qty" name="qty" class="form-control" value="{{old('qty')}}" required >
                            @error('qty') 
                                <div class="text-danger">
                                    {{$message}}    
                                </div>
                            @enderror
                        </div>
                        <div class="form-group increment">
                            <label for="photo" class="text-left">Evidence</label>
                            <div class="input-group-btn mb-2 text-right ">
                                <button type="button" class="btn btn-danger min"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-primary add"><i class="fa fa-plus"></i></button>
                            </div>
                            <div class="custom-file ">
                                <input  name="photo[]" type="file" class="custom-file-input" required>
                                <label for="photo" class="custom-file-label">Choose file...</label>
                            </div>
                            <div class="clone">
                                <div class="custom-file mt-2 ">
                                    <input  name="photo[]" type="file" class="custom-file-input">
                                    <label for="photo" class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
                            @error('photo') 
                            <div class="text-danger">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Corrective Action</label>  
                            <textarea name="corrective_action" id="corrective_action" cols="30" rows="3" class="form-control" value="{{old('corrective_action')}}" required></textarea>
                            @error('corrective_action') 
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
    });

    
</script>
@endpush




















