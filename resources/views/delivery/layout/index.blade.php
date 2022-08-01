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
  <div class="layout_bg" style="width:100%">
    {{-- finish goods --}}
    <div class='overlay' style="padding-left: 650px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_preparation_pulling_1']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_preparation_pulling_1'], " ")}}</label></div>
    @if ($data['henkaten_preparation_pulling_1'] !='')
      <div class='overlay' style="padding-left: 650px; padding-top:70px">
        <img class="img_user" src="{{$data['henkaten_preparation_pulling_1']}}" alt="">
      </div>
    @endif
    <div class='overlay' style="padding-left: 710px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_preparation_pulling_2']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_preparation_pulling_2']," ")}}</label></div>
    @if ($data['henkaten_preparation_pulling_2'] !='')
      <div class='overlay' style="padding-left: 710px; padding-top:70px">
        <img class="img_user" src="{{$data['hekaten_preparation_pulling_2']}}" alt="">
      </div>
    @endif
    {{-- spare part --}}
    <div class='overlay' style="padding-left: 320px; padding-top:20px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_sparepart']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_sparepart']," ")}}</label></div>
    @if ($data['henkaten_sparepart'] !='')
      <div class='overlay' style="padding-left: 320px; padding-top:20px">
        <img class="img_user" src="{{$data['henkaten_sparepart']}}" alt="">
      </div>
    @endif
    {{-- pulling sparepart --}}
    <div class='overlay' style="padding-left: 320px; padding-top:100px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_pulling_oem_1']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_pulling_oem_1']," ")}}</label></div>
    @if ($data['henkaten_pulling_oem_1'] !='')
      <div class='overlay' style="padding-left: 320px; padding-top:80px">
        <img class="img_user" src="{{$data['henkaten_pulling_oem_1']}}" alt="">
      </div>
    @endif
    {{-- preparation --}}
    <div class='overlay' style="padding-left: 600px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_preparation']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_preparation']," ")}}</label></div>
    @if ($data['henkaten_preparation'] !='')
      <div class='overlay' style="padding-left: 600px; padding-top:70px">
        <img class="img_user" src="{{$data['henkaten_preparation']}}" alt="">
      </div>
    @endif
    <div class='overlay' style="padding-left: 510px; padding-top:0px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_packaging_2']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_packaging_2'], " ")}}</label></div>
    @if ($data['henkaten_packaging_2'] !='')
      <div class='overlay'  style="padding-left: 510px; padding-top:0px">
        <img class="img_user" src="{{$data['henkaten_packaging_2']}}" alt="">
      </div>
    @endif
    <div class='overlay' style="padding-left: 440px; padding-top:100px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_pulling_oem_2']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_pulling_oem_2']," ")}}</label></div>
    @if ($data['henkaten_pulling_oem_2'] !='')
      <div class='overlay' style="padding-left: 440px; padding-top:100px">
        <img class="img_user" src="{{$data['henkaten_pulling_oem_2']}}" alt="">
      </div>
    @endif
    {{-- packaging --}}
    <div class='overlay' style="padding-left: 450px; padding-top:0px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_packaging_1']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_packaging_1'], " ");}}</label></div>
    @if ($data['henkaten_packaging_1'] !='')
      <div class='overlay' style="padding-left: 450px; padding-top:0px">
        <img class="img_user" src="{{$data['henkaten_packaging_1']}}" alt="">
      </div>
    @endif
    {{-- admin delivery --}}
    <div class='overlay' style="padding-left: 770px; padding-top:85px">
      <img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_delivery_control']}}" alt="">
      <br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_delivery_control'], " ")}}</label>
    </div>
    @if ($data['henkaten_delivery_control'] !='')
      <div class='overlay' style="padding-left: 770px; padding-top:85px">
        <img class="img_user" src="{{$data['henkaten_delivery_control']}}" alt="">
      </div>
    @endif
  </div>
  <img  src="{{asset('/image/layout.png')}}" width="800px" height="200px" alt="thumb">
<div>


  <div class="ibox mt-3" >
    <div class="ibox-title">
        <h4>Layout Area </h4>
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
              <th class="text-center">Area</th>
              <th class="text-center">NPK</th>
              <th class="text-center">Name</th>
              <th class="text-center">Photo</th>
              <th class="text-center">Position</th>
              <th class="text-center">Reason</th>
              <th class="text-center">Substitute 1</th>
              <th class="text-center">Substitute 2</th>
              {{-- <th class="text-center">Henkaten Status</th>
              <th class="text-center"> Henkaten Date</th> --}}
              <th class="text-center">Action</th>
              <th class="text-center">Default Area</th>
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
            $("label").css({fontSize:10, textTransform:'Uppercase'});
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
                  { data: 'area_position', className: 'dt-body-center',

                    'render' : function(data, type, row){
                      return "<b id='keyword_area_"+row['npk']+"'>"+data+"</b>";
                    }

                  },
                  { data: 'user_id', className: 'dt-body-center'},
                  { data: 'name', className: 'dt-body-center',
                
                      'render' : function(data, type, row){
                        return "<b id='nama_diganti_"+row['npk']+"'>"+data+"</b>";
                      }
                
                  },
                  { data: "photo", className: 'dt-body-center text-center',  "render": function ( data, type, row ) {
                    var url = '/storage/delivery-manpower-photo/'+data;
                      return "<img src='"+url+"' width='40' height='40'>";
                    },
                  },
                  { data: 'real_position', className: 'dt-body-center',

                    'render' : function(data, type, row){
                      return "<b>"+data+"</b>";
                    }

                  },
                 
                  { data: "npk", className: 'dt-body-center text-center',
                    "render": function ( data, type, row ) {
                      return "<select data-id='"+data+"'  id='alasan_"+data+"' class='form-control alasan_henkaten'><option value='-' selected>-</option><option value='Sick Leave'>Sick Leave</option><option value='Permit'>Permit</option><option value='Absence'>Absence</option><option value='On Leave'>On Leave</option></select>";
                    },
                  },
                  { data: 'npk', className: 'dt-body-center',
                
                    'render' : function(data, type,row){
                        return '<select class="form-control d-none" id="alter_1_'+data+'"></select>';
                    }

                  },
                  { data: 'npk', className: 'dt-body-center',
                
                    'render' : function(data, type, row){
                      return '<select class="form-control d-none" id="alter_2_'+data+'"></select>';
                    }
                
                  },
                  // { data: 'henkaten_status', className: 'dt-body-center',
                  
                  //   'render' : function(data, type , row){
                  //     if (data == '1') {
                  //       return '<label class="label label-danger">Henkaten</label>';
                  //     }else{
                  //       return '';  
                  //     }
                  //   }
                
                  // },
                  // { data: 'date_henkaten', className: 'dt-body-center'},
                  { data: 'id', className: 'dt-body-center',
                      'render' : function(data,type,row){
                        return "<div class='btn-group'><div class='btn-group'><button data-id='"+data+"' data-npk='"+row["npk"]+"' id='save_"+row["npk"]+"' class='btn btn-primary simpan_henkaten d-none'>SAVE</button><a onClick='return confirm("+'"are you sure  ?"'+")' href='/delivery/layout_area/"+data+"/delete' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
                        // return "<div class='btn-grx`oup'><div class='btn-group'><a href='/delivery/layout_area/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='/delivery/layout_area/"+data+"/delete' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
                      }
                  },
                  { data: 'area', className: 'dt-body-center',

                    'render' : function(data, type, row){
                      return "<b id='default_area_diganti_"+row['npk']+"'>"+data+"</b>";
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

                  // henkaten logic
                  $("#master tbody").on('click','.simpan_henkaten', function(){
                      var npk = $(this).attr('data-npk');
                      var id = $(this).attr('data-id');
                      var alasan = $('#alasan_'+npk).val();
                      var alter_1 = $('#alter_1_'+npk).val();
                      var alter_2 = $('#alter_2_'+npk).val();
                      var nama_diganti = $('#nama_diganti_'+npk).html();
                      var default_area_diganti = $('#default_area_diganti_'+npk).html();
                      var nama_pengganti = $('#alter_2_'+npk+' option:selected').text();


                      if(alter_1 != '-' && alter_2 != '-'){
                        alert("Choose only one substitute!");
                      }
                      else if (alter_1 != '-' || alter_2 !='-') {
                        if (alter_1 !='-') {
                          // update henkaten
                          $.ajax({
                                  url: "{{route('delivery.layout_area.update')}}",
                                  method: "put",
                                  data:{
                                      "npk" : npk,
                                      "id" : id,
                                      "pengganti" : alter_1,
                                      "alasan" : alasan,
                                      "henkaten" : null,
                                      "_token": "{{ csrf_token() }}",
                                  },
                                  success: function(result){
                                    if (result == '1') {
                                      location.reload();
                                    } else {
                                      alert('failed update!');
                                    }
                                  }
                          });
                        } else {
                          // update henkaten
                          $.ajax({
                                  url: "{{route('delivery.layout_area.update')}}",
                                  method: "put",
                                  data:{
                                      "npk" : npk,
                                      "id" : id,
                                      "pengganti" : alter_2,
                                      "nama_pengganti" : nama_pengganti,
                                      "nama_diganti" : nama_diganti,
                                      "default_area_diganti" : default_area_diganti,
                                      "henkaten" : '1',
                                      "alasan" : alasan,
                                      "_token": "{{ csrf_token() }}",
                                  },
                                  success: function(result){
                                    if (result == '1') {
                                      location.reload();
                                    } else {
                                      alert('failed update!');
                                    }
                                  }
                          });
                        }
                      } else {
                        alert("substitute cannot empty!");
                      }

                  });
                  $(".alasan_henkaten").change( function(){
                      var id = $(this).attr('data-id');
                      var alasan = $('#alasan_'+id);
                      var alter_1 = $('#alter_1_'+id);
                      var alter_2 = $('#alter_2_'+id);
                      var btn_save = $('#save_'+id);
                      var keyword_area = $('#keyword_area_'+id).html().split("_")[0];
                      
                      // ambil option untuk alter 1 dari ajax
                        $.ajax({
                                url: "{{route('delivery.layout_area.get_mp_with_same_position')}}",
                                method: "post",
                                data:{
                                    "jenis" : keyword_area,
                                    "npk" : id,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function(result){
                                  // populate
                                  alter_1.empty().append('<option value="-" selected>-</option>');
                                  $.each(JSON.parse(result)['get'], function(key, value) {
                                    alter_1.append(`<option value="${value.npk}">${value.name}</option>`);
                                  });
                                  // populate
                                  alter_2.empty().append('<option value="-" selected>-</option>');
                                  $.each(JSON.parse(result)['all'], function(key, value) {
                                    alter_2.append(`<option value="${value.npk}">${value.name}</option>`);
                                  });
                                }
                              });
                      // menampilkan BTN SAVE & ALTER
                        if ($(this).val() =='-') {
                          alter_1.addClass('d-none');
                          alter_2.addClass('d-none');
                          btn_save.addClass('d-none');
                         
                        } else {
                          alter_1.removeClass('d-none');
                          alter_2.removeClass('d-none');
                          btn_save.removeClass('d-none');
                        }
                  });

                  // option huruf kecil
                  $(" option").css('font-size', 9);
                  $("select ").css('font-size', 9);
              });
      
          } );
      </script>
@endpush

