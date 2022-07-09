@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')



@section('content')
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Matrix Skills</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <div class="form-group">
                <label>Man Power</label>  <br/>
                <select name="user_id" class="form-control" id="user_id" required readonly>
                    @foreach ($mps as $mp)
                        <option value="{{$mp->npk}}" {{$mp->npk == $npk ? "selected" : ""}}>{{$mp->npk}} </option>
                    @endforeach
                </select>
                @error('user_id') 
                    <div class="text-danger">
                        {{$message}}    
                    </div>
                @enderror
            </div>
            @foreach ($diff_skills as $diff_skill)
                <form action="{{route('delivery.skillmatrix.update')}}"  enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    {{method_field("PUT")}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="bg-danger">New Skill from category {{$diff_skill->category}}</label> 
                                    <input type="text" name="skill_id" value="{{$diff_skill->skill_code}}" class="form-control" autocomplete="off" readonly >
                                    <input type="hidden" name="category" value="{{$diff_skill->category}}" class="form-control" autocomplete="off" readonly >
                                    @error('skill_id') 
                                        <div class="text-danger">
                                            {{$message}}    
                                        </div>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Skill Value</label> 
                                <select name="value" class="form-control" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                @error('value') 
                                    <div class="text-danger">
                                        {{$message}}    
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm submit_form d-none" >Save</button>
                </form>
            @endforeach
            @foreach ($list_skill_each_category as $category)
                <label for="Category"><b>{{$list_categories[ $loop->index ]}}</b></label>
                @foreach ($category as $skill)
                    <form action="{{route('delivery.skillmatrix.update')}}" id="form_{{$loop->iteration}}" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        {{method_field("PUT")}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                        <input type="hidden" name="category" value="{{$skill->category}}" class="form-control" autocomplete="off" readonly >
                                        <input type="text" name="skill_id" value="{{$skill->skill_id}}" class="form-control" autocomplete="off" readonly >
                                        @error('skill_id') 
                                            <div class="text-danger">
                                                {{$message}}    
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="value" class="form-control" required>
                                        <option value="1" {{"1" == $skill->value ? "selected" : ""}}>1</option>
                                        <option value="2" {{"2" == $skill->value ? "selected" : ""}}>2</option>
                                        <option value="3" {{"3" == $skill->value ? "selected" : ""}}>3</option>
                                        <option value="4" {{"4" == $skill->value ? "selected" : ""}}>4</option>
                                    </select>
                                    @error('value') 
                                        <div class="text-danger">
                                            {{$message}}    
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm submit_form d-none" >Save</button>
                    </form>
                @endforeach
            @endforeach
          </div>
        </div>
        <div class="ibox-footer text-right">
                <button class="btn btn-primary btn-sm submit_all_form" >Save</button>
        
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
        $(".submit_all_form").click(function(){
            $(this).attr("disabled", "disabled");
            var data = [];
            $('.ibox-content form').each(function(i, obj) {
                data.push({
                    skill_id: obj.skill_id.value, 
                    category: obj.category.value, 
                    user_id: $('#user_id').val(), 
                    value:  obj.value.value
                });

            });
            $.ajax({
                url: "{{route('delivery.skillmatrix.insert')}}",
                method: "put",
                data:{
                    "data" : data,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(result){
                    console.log(result);
                    if (result == '1') {
                        alert("Skill Matrix added!");
                    }else if (result == '2') {
                        alert("Skill Matrix updated!");
                    } else {
                        alert("Failed Insert Skill Matrix!");
                    }

                    window.location = "{{route('delivery.skillmatrix')}}" 
                }
            });
        });
       
    });

    
</script>
@endpush




















