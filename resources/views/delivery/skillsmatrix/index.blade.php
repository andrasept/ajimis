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
  .row > div {
  background: white;
  border: 1px solid lightgrey;
}
</style>
{{-- modal --}}
<div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg ">
      <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              {{-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> --}}
              <h4 class="modal-title">Skill Matrix</h4>
              <small class="judul"></small>
          </div>
          <div class="modal-body text-center">
            <div class=" text-center mb-1"><img id="photo_mp" width="70px" height="70px" src="" alt="mp_photo"><h3 id="mp"></h3></div>
            <div class="row mb-1">
                <div class="col-lg-6  bg_canvas" style="pointer-events: none;">
                  <canvas id="radarChart"></canvas>
                </div>
                <div class="col-lg-6  bg_canvas" style="pointer-events: none;">
                  <canvas id="radarChart2"></canvas>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-lg-6 text-right" style="pointer-events: none;">
                  <canvas id="radarChart3"></canvas>
                </div>
                <div class="col-lg-6 text-right" style="pointer-events: none;">
                  <canvas id="radarChart4"></canvas>
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-6  bg_canvas" style="pointer-events: none;">
                <canvas id="radarChart5"></canvas>
              </div>
              <div class="col-lg-6  bg_canvas" style="pointer-events: none;">
                <canvas id="radarChart6"></canvas>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
          </div>  
      </div>
  </div>
</div>
{{-- akhir modal --}}

<div class="ibox" >
  <div class="ibox-title">
      <h4> Skills Matrix</h4>
      <div class="ibox-tools">
        <a class="btn btn-primary   text-center" href="{{route('delivery.skillmatrix.create')}}">Add</a>
      </div>
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
    
    <table id="master" class="table table-bordered">
      <thead>
        <tr>
          <th class="text-center">No</th>
          <th class="text-center">Name</th>
          <th class="text-center">NPK</th>
          <th class="text-center">Photo</th>
          <th class="text-center">Position  </th>
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
    <script src="{{asset('js/plugins/chartJs/Chart.min.js')}}"></script>
    <script>
      // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});

      $(document).ready(function(){

        // datatable
        var table = $('#master').DataTable( {
        "responsive" : true,
        "processing": true,
        "serverSide": true,
        "filter":true,
        "ajax": {
                    "url": "{{route('delivery.skillmatrix')}}",
                    "data":function (d) {
                },
        },
        "columns": [
            { data: null, className: 'dt-body-center'},
            { data: 'name', className: 'dt-body-center'},
            { data: 'npk', className: 'dt-body-center'},
            { data: "photo", className: 'dt-body-center',  "render": function ( data, type, row ) {
                var url = '/storage/delivery-manpower-photo/'+data;
                  return "<img src='"+url+"' width='40' height='40'>";
                },
            },
            { data: 'position', className: 'dt-body-center'},
            { data: 'npk', className: 'dt-body-center',
              'render' : function(data, type, row){
                return "<div class='btn btn-group'><button class='btn btn-secondary detail' data-photo='"+row['photo']+"' data-name='"+row['name']+"' data-npk='"+data+"'><i class='fa fa-eye'></i></button><a href='/delivery/skillmatrix/"+data+"/edit' class='btn  btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='/delivery/skillmatrix/"+data+"/delete' class='btn  btn-danger'><i class='fa fa-trash'></i></a></div>";
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

        $("#master tbody").on('click', '.detail', function () {
              var npk = $(this).attr('data-npk');
              var name = $(this).attr('data-name');
              var photo = '/storage/delivery-manpower-photo/'+$(this).attr('data-photo');
              $("#mp").empty().html(name);
              $('#photo_mp').attr('src', photo);

              // ajax detail
              $.ajax({
                url: "{{route('delivery.skillmatrix.get_data_skillmatrix')}}",
                method: "post",
                data:{
                    "npk" : npk,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(result){
                  $('#myModal2').modal('show');
                  let canvas1 = document.getElementById('radarChart');
                  let canvas2 = document.getElementById('radarChart2');
                  let canvas3 = document.getElementById('radarChart3');
                  let canvas4 = document.getElementById('radarChart4');
                  let canvas5 = document.getElementById('radarChart5');
                  let canvas6 = document.getElementById('radarChart6');
                  var ctx5 = document.getElementById("radarChart").getContext("2d");
                  var ctx6 = document.getElementById("radarChart2").getContext("2d");
                  var ctx7 = document.getElementById("radarChart3").getContext("2d");
                  var ctx8 = document.getElementById("radarChart4").getContext("2d");
                  var ctx9 = document.getElementById("radarChart5").getContext("2d");
                  var ctx10 = document.getElementById("radarChart6").getContext("2d");
                  ctx5.clearRect(0, 0, canvas1.width, canvas1.height);
                  ctx6.clearRect(0, 0, canvas2.width, canvas2.height);
                  ctx7.clearRect(0, 0, canvas3.width, canvas3.height);
                  ctx8.clearRect(0, 0, canvas4.width, canvas4.height);
                  ctx9.clearRect(0, 0, canvas5.width, canvas5.height);
                  ctx10.clearRect(0, 0, canvas6.width, canvas6.height);

                  $("#radarChart").empty();
                  $("#radarChart2").empty();
                  $("#radarChart3").empty();
                  $("#radarChart4").empty();
                  $("#radarChart5").empty();
                  $("#radarChart6").empty();
                  console.log(result);

                  var data_label_1 = [];
                  var data_angka_1 = [];
                  var data_label_2 = [];
                  var data_angka_2 = [];
                  var data_label_3 = [];
                  var data_angka_3 = [];
                  var data_label_4 = [];
                  var data_angka_4 = [];
                  var data_label_5 = [];
                  var data_angka_5 = [];
                  var data_label_6 = [];
                  var data_angka_6 = [];
                
                // kesatu
                  result[0].sort(function(a, b) {
                    return a.skill_id.localeCompare(b.skill_id);
                  });
                  result[0].forEach(function(obj){
                    data_label_1.push(obj.skill_id);
                    data_angka_1.push(obj.value);
                  });

                  var radarData = {
                      labels: data_label_1,
                      datasets: [
                          {
                              label: "PPC",
                              backgroundColor: "rgba(26,179,148,0.2)",
                              borderColor: "rgba(26,179,148,1)",
                              data: data_angka_1
                          }
                      ]
                  };

                  var radarOptions = {
                      responsive: true,
                      showTooltips: false,
                      hover: {mode: null},
                      scale: {
                      ticks: {
                              beginAtZero: true,
                              max: 4,
                              min: 0,
                              stepSize: 1
                          }
                      },
                  };
                    
                    
                    new Chart(ctx5, {type: 'radar', data: radarData, options:radarOptions});


                // kedua
                  result[1].sort(function(a, b) {
                    return a.skill_id.localeCompare(b.skill_id);
                  });
                  result[1].forEach(function(obj){
                    data_label_2.push(obj.skill_id);
                    data_angka_2.push(obj.value);
                  });

                  var radarData2 = {
                      labels: data_label_2,
                      datasets: [
                          {
                              label: "Pulling FG OEM",
                              backgroundColor: "rgba(50, 48, 196, 0.2)",
                              borderColor: "rgba(50, 48, 196, 1)",
                              data: data_angka_2
                          }
                      ]
                  };
                  new Chart(ctx6, {type: 'radar', data: radarData2, options:radarOptions});

                // ketiga
                  result[2].sort(function(a, b) {
                    return a.skill_id.localeCompare(b.skill_id);
                  });
                  result[2].forEach(function(obj){
                    data_label_3.push(obj.skill_id);
                    data_angka_3.push(obj.value);
                  });

                  var radarData3 = {
                      labels: data_label_3,
                      datasets: [
                          {
                              label: "Delivery Control",
                              backgroundColor: "rgba(226, 241, 42, 0.2)",
                              borderColor: "rgba(226, 241, 42, 1)",
                              data: data_angka_3
                          }
                      ]
                  };
                  new Chart(ctx7, {type: 'radar', data: radarData3, options:radarOptions});

                // keempat
                  result[3].sort(function(a, b) {
                    return a.skill_id.localeCompare(b.skill_id);
                  });
                  result[3].forEach(function(obj){
                    data_label_4.push(obj.skill_id);
                    data_angka_4.push(obj.value);
                  });

                  var radarData4 = {
                      labels: data_label_4,
                      datasets: [
                          {
                              label: "Preparation Delivery OEM",
                              backgroundColor: "rgba(250, 5, 84, 0.2)",
                              borderColor: "rgba(250, 5, 84, 1)",
                              data: data_angka_4
                          }
                      ]
                  };
                  new Chart(ctx8, {type: 'radar', data: radarData4, options:radarOptions});

                // kelima
                  result[4].sort(function(a, b) {
                    return a.skill_id.localeCompare(b.skill_id);
                  });
                  result[4].forEach(function(obj){
                    data_label_5.push(obj.skill_id);
                    data_angka_5.push(obj.value);
                  });

                  var radarData5 = {
                      labels: data_label_5,
                      datasets: [
                          {
                              label: "Sparepart",
                              backgroundColor: "rgba(155, 5, 250, 0.2)",
                              borderColor: "rgba(155, 5, 250, 1)",
                              data: data_angka_5
                          }
                      ]
                  };
                  new Chart(ctx9, {type: 'radar', data: radarData5, options:radarOptions});


                // keenam
                  result[5].sort(function(a, b) {
                    return a.skill_id.localeCompare(b.skill_id);
                  });
                  result[5].forEach(function(obj){
                    data_label_6.push(obj.skill_id);
                    data_angka_6.push(obj.value);
                  });

                  var radarData6 = {
                      labels: data_label_6,
                      datasets: [
                          {
                              label: "Packaging Control",
                              backgroundColor: "rgba(5, 186, 250, 0.2)",
                              borderColor: "rgba(5, 186, 250, 1)",
                              data: data_angka_6
                          }
                      ]
                  };
                  new Chart(ctx10, {type: 'radar', data: radarData6, options:radarOptions});



                }});
        });

        
      });

      
    </script>
@endpush

