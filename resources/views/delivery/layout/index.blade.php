@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')


{{-- datatable library css --}}
<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">

<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

<style>
.overlay{
    /* background:rgba(0,0,0,0.5); */
    position:absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    color: white;
    opacity: 1;
    -webkit-transition: opacity 0.5s;
    transition: opacity 0.5s;
    z-index: 999; 
}

img {
  display: block; 
  
}
.layout_bg {
    position: relative;
    display: inline-block;
    z-index: 0  ;
}

.layout_bg:hover > .overlay {
    opacity: 1;
}
</style>

<div class="p-w-md m-t-sm">
  <div class="row " >
    <div class="col-md-12 text-center">
      <h3>Layout Area PPIC</h3>
    </div>
  </div>
  <div class="layout_bg" style="width:100%">
    <div class='overlay' style="padding-left: 145px; padding-top:100px"><img data-npk="{{$data[0]['npk']}}" style="width: 60px;height: 60px;" src="{{$data[0]['photo']}}" alt=""></div>
    <div class='overlay' style="padding-left: 420px; padding-top:100px"><img data-npk="{{$data[1]['npk']}}" style="width: 60px;height: 60px;" src="{{$data[1]['photo']}}" alt=""></div>
    <div class='overlay' style="padding-left: 620px; padding-top:100px"><img data-npk="{{$data[2]['npk']}}" style="width: 60px;height: 60px;" src="{{$data[2]['photo']}}" alt=""></div>
    <div class='overlay' style="padding-left: 600px; padding-top:0px"><img data-npk="{{$data[3]['npk']}}" style="width: 60px;height: 60px;" src="{{$data[3]['photo']}}" alt=""></div>
    <div class='overlay' style="padding-left: 910px; padding-top:100px"><img data-npk="{{$data[4]['npk']}}" style="width: 60px;height: 60px;" src="{{$data[4]['photo']}}" alt=""></div>
    <div class='overlay' style="padding-left: 1000px; padding-top:115px"><img data-npk="{{$data[5]['npk']}}" style="width: 60px;height: 60px;" src="{{$data[5]['photo']}}" alt=""></div>
  </div>
  <img  src="{{asset('/image/layout.png')}}" width="1050px" height="250px" alt="thumb">
<div>
@endsection

@push('scripts')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>
    <script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/js_agil/dataTables.responsive.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>
      $(document).ready(function(){ 
        $('.layout_bg .overlay img').click(function(){
          var npk = $(this).attr('data-npk');
          alert(npk);
        });
      });
    </script>
@endpush

