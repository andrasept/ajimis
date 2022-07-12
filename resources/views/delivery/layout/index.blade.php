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

.img_user{
  width: 50px;
  width: 50px;
}

img {
  /* display: block;  */
  
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
    <div class="col-md-12 text-left">
      <h3>Layout Area PPIC</h3>
    </div>
  </div>
  <div class="layout_bg" style="width:100%">
    {{-- finish goods --}}
    <div class='overlay' style="padding-left: 650px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_finish_goods_1']}}" alt=""></div>
    <div class='overlay' style="padding-left: 690px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_finish_goods_2']}}" alt=""></div>
    
    
    
    {{-- spare part --}}
    <div class='overlay' style="padding-left: 105px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_sparepart']}}" alt=""></div>
    {{-- pulling sparepart --}}
    <div class='overlay' style="padding-left: 320px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_pulling_sparepart']}}" alt=""></div>
    {{-- preparation --}}
    <div class='overlay' style="padding-left: 540px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_preparation_3']}}" alt=""></div>
    <div class='overlay' style="padding-left: 500px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_preparation_2']}}" alt=""></div>
    <div class='overlay' style="padding-left: 460px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_preparation_1']}}" alt=""></div>
    {{-- packaging --}}
    <div class='overlay' style="padding-left: 450px; padding-top:0px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_packaging']}}" alt=""></div>
    {{-- admin delivery --}}
    <div class='overlay' style="padding-left: 750px; padding-top:85px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_admin_delivery']}}" alt=""></div>
  </div>
  <img  src="{{asset('/image/layout.png')}}" width="800px" height="200px" alt="thumb">
<div>


  <div class="ibox mt-3" >
    <div class="ibox-title">
        <h4>Man Power Position </h4>
    </div>
    <div class="ibox-content" >
      <div>
        @if(session()->has('success'))
            <div class="alert alert-primary">{{session('success')}}</div>
        @endif
        @if(session()->has('fail'))
            <div class="alert alert-danger">{{session('fail')}}</div>
        @endif
      </div>
      
      <div class="row mb-3">
        <div class="col-lg-12 text-right">
          <a class="btn btn-primary  mr-4 mt-4 text-center" href="{{route('delivery.layout_area.create')}}">Create</a>
        </div>
      </div>
        <table id="master" class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Position</th>
              <th class="text-center">Man Power</th>
              <th class="text-center">Photo</th>
              <th class="text-center">Henkaten Status</th>
              <th class="text-center">Date Henkaten</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
  
          </tbody>
        </table>
    </div>
    <div class="ibox-footer">
      <button class="btn  btn-default " onClick="history.back()">Back</button>
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

      $(document).ready(function() {
            // huruf kecil table
            $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
            $("select").css({fontSize:12});
      
          // datatable
          var table = $('#master').DataTable( {
              "responsive" : true,
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('delivery.layout_area')}}",
                          "data":function (d) {
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  { data: 'position', className: 'dt-body-center',

                    'render' : function(data, type, row){
                      return "<b>"+data+"</b>";
                    }

                  },
                  { data: 'user_id', className: 'dt-body-center'},
                  { data: "photo", className: 'dt-body-center text-center',  "render": function ( data, type, row ) {
                    var url = '/storage/delivery-manpower-photo/'+data;
                      return "<img src='"+url+"' width='40' height='40'>";
                    },
                  },
                  { data: 'henkaten_status', className: 'dt-body-center',
                  
                    'render' : function(data, type , row){
                      if (data == '1') {
                        return '<label class="label label-danger">Henkaten</label>';
                      }else{
                        return '';  
                      }
                    }
                
                  },
                  { data: 'date_henkaten', className: 'dt-body-center'},
                  { data: 'id', className: 'dt-body-center',
                      'render' : function(data,row,type){
                          return "<div class='btn-group'><div class='btn-group'><a href='/delivery/layout_area/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a></div>";
                      }
                  },
              ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [[ 1, 'asc' ]]
              } );
      
              // number
              table.on('draw.dt', function () {
                  var info = table.page.info();
                  table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                      cell.innerHTML = i + 1 + info.start;
                  });
              });
      
          } );
      </script>
@endpush

