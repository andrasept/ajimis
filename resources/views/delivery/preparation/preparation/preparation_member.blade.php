@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')

{{-- datatable library css --}}
<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">

<link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
@if ($data_delay->isEmpty() )
<div id="cek_delay" class="d-none">ada</div>    

<div class="ibox" >
  <div class="ibox-title">
      <h4>Data Preparation</h4>
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
            <th class="text-center">Action</th>
            {{-- <th class="text-center">Help Column</th> --}}
            <th class="text-center">Plan Preparation Date</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Cycle</th>
            <th class="text-center">Cycle Time</th>
            <th class="text-center">plan_time_preparation</th>
            <th class="text-center">Plan Date preparation</th>
            <th class="text-center">Start Preparation</th>
            <th class="text-center">End Preparation</th>
            <th class="text-center">Date preparation</th>
            <th class="text-center">PIC</th>
            <th class="text-center">Shift</th>
            <th class="text-center">Time Hour</th>
            <th class="text-center">Status</th>
            <th class="text-center">Started by</th>
            <th class="text-center">Finished by</th>
            <th class="text-center">Prepare Time</th>
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

@else
  {{-- {{dd($data_delay);}} --}}
  @foreach ($data_delay as $item)
  <div id="id_delay" class="d-none">{{$item->id}}</div>
  <div id="help_column_delay" class="d-none">{{$item->help_column}}</div>
  @endforeach 

@endif

{{-- modal --}}
  <div class="modal inmodal" id="myModal2" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <h4 class="modal-title judul"></h4>
            </div>
            <div class="modal-body">
              <form action="{{route('delivery.preparation.update_delay')}}" method="post">
                @csrf
              <input type="hidden" name="id" id="id" value="">
              <label for="">Problem Identification</label>
              <input type="text" name="problem" class="form-control" id="problem" required>
              <label for="">Corrective Action</label>
              <textarea type="text" name="remark" class="form-control" id="corrective_action" required> </textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Send</button>
              </form>
            </div>
        </div>
    </div>
  </div>
{{-- akhir modal --}}
@endsection

@push('scripts')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>

    <script src="{{asset('js/js_agil/dataTables.responsive.js')}}"></script>

    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>

      var minDate, maxDate, select_role;

      // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      if ($(window).width() > 700)
      {
        $("select").css({fontSize:12});
      }

      // search by range date
      $.fn.dataTable.ext.search.push(
          function( settings, data, dataIndex ) {
              var min = minDate.val();
              var max = maxDate.val();
              var date = new Date( data[4] );
 
              if (
                  ( min === null && max === null ) ||
                  ( min === null && date <= max ) ||
                  ( min <= date   && max === null ) ||
                  ( min <= date   && date <= max )
              ) {
                  return true;
              }
              return false;
          }
      );
      
      $(document).ready(function() {
        // muncul pop up ketika ada yg delay belumada alasan
          if ($("#cek_delay").html() == "ada") {
          
          } else {
            var id_delay = $("#id_delay").html();
            var help_column_delay = $("#help_column_delay").html();
            $('#myModal2').modal('show');
            $('#myModal2').modal({backdrop: 'static', keyboard: false})  
            // isi id
            $("#id").val(id_delay);
            // isi title
            $(".modal-title").html("Preparation "+help_column_delay+" Delayed");
          }
        
          // check input
          $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            var ext = fileName.split('.')[1];
            if (ext == "xlsx" || ext == "xls"|| ext == "csv" ) {
              $(this).next('.custom-file-label').addClass("selected").html(fileName);
            } else {
              $(this).html("");
              swal("Oops!", "Only Excel or CSV file!", "error");
            }
          }); 
          // Create date inputs
          minDate = new DateTime($('#min'), {
              format: 'YYYY-MM-DD'
          });
          maxDate = new DateTime($('#max'), {
              format: 'YYYY-MM-DD '
          });


          // datatable
          var table = $('#master').DataTable( {
              'responsive': true,
              'columnDefs': [
                  { responsivePriority: 1, targets: 0 },
                  { responsivePriority: 2, targets: -1 }
              ],
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('delivery.preparation')}}",
                          "data":function (d) {
                          d.member = '1';
                          // d.max = $('#max').val();
                          // d.customer = $('#select_customer').val();
                          // d.partcard = $('#select_partcard').val();
                          // d.line = $('#select_line').val();
                          // d.packaging_code = $('#select_packaging_code').val();
                          // d.category = $('#select_category').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  // { data: 'id', className: 'dt-body-center'},
                  { data: "status", className: 'dt-body-center',
                      "render": function ( data, type, row ) {
                          if (data == '3') {
                            // cek status delay, ontime, adavance
                            return '<label class="label label-info">Advanced</label>';
                            // return "<a href='/delivery/preparation/"+row['id']+"/start' class='btn btn-lg btn-primary'>Start</a>";
                          }else  if (data == '4') {
                            // cek status delay, ontime, adavance
                            return '<label class="label label-primary">On time</label>';
                          
                          }else  if (data == '5') {
                            // cek status delay, ontime, adavance
                            return '<label class="label label-danger">Delayed</label>';
                          
                          } else {
                            
                            if (data == null) {
                              var display_end = 'd-none';
                              var display_start = 'd-start';
                            } else if(data == '1') {
                              var display_start = 'd-none';
                              var display_end = 'd-start';
                            }
                            return "<div class='btn-group'><button data-id='"+row['id']+"' data-help-column='"+row['help_column']+"' data-plan-time-preparation='"+row['plan_time_preparation']+"' data-plan-date-preparation='"+row['plan_date_preparation']+"' class='btn btn-lg btn-primary start "+display_start+"' id='start_"+row['id']+"'>Start</a><button data-id='"+row['id']+"' data-help-column='"+row['help_column']+"' data-plan-time-preparation='"+row['plan_time_preparation']+"' data-plan-date-preparation='"+row['plan_date_preparation']+"' class='btn btn-lg btn-danger "+display_end+" end' id='end_"+row['id']+"'>End</a></div>";
                          } 

                          // if (data == '1') {
                          //   return "<button data-id='"+row['id']+"' data-help-column='"+row['help_column']+"' data-plan-time-preparation='"+row['plan_time_preparation']+"' data-plan-date-preparation='"+row['plan_date_preparation']+"' class='btn btn-lg btn-danger end'>End</a>";
                          //     // return "<a href='/delivery/preparation/"+row['id']+"/end' class='btn btn-lg btn-danger'>End</a>";
                          //   } else if(data === null) {
                          //   return "<button data-id='"+row['id']+"' data-help-column='"+row['help_column']+"' data-plan-time-preparation='"+row['plan_time_preparation']+"' data-plan-date-preparation='"+row['plan_date_preparation']+"' class='btn btn-lg btn-primary start'>Start</a>";
                          //   // return "<a href='/delivery/preparation/"+row['id']+"/start' class='btn btn-lg btn-primary'>Start</a>";
                          // }else if(data == '3') {
                          //   return"<label class='label label-info'>Finished</label>";
                          // }else{
                          //   return '';
                          // }
                        },
                  },
                  // { data: "help_column", className: 'dt-body-center'},
                  { data: "plan_date_preparation", className: 'dt-body-center',
                      "render" :function(data,type, row)
                      {
                        if (data === null) {
                          return '';
                        } else {
                          return moment(data).format('DD/MM/YYYY');
                        }
                      }
                  },
                  { data: "help_column", className: 'dt-body-center'},
                  { data: "cycle", className: 'dt-body-center'},
                  { data: "cycle_time_preparation", className: 'dt-body-center'},
                  { data: "plan_time_preparation", className: 'dt-body-center'},
                  { data: "plan_date_preparation", className: 'dt-body-center',
                      "render" :function(data,type, row)
                      {
                        if (data === null) {
                          return '';
                        } else {
                          return moment(data).format('DD/MM/YYYY');
                        }
                      }
                  },
                  { data: "start_preparation", className: 'dt-body-center',
                    "render" :function(data,type, row)
                        {
                          if (data === null) {
                            return '';
                          } else {
                            return moment(data).format('DD/MM/YYYY HH:mm:ss');
                          }
                        }
                  },
                  { data: "end_preparation", className: 'dt-body-center',
                     "render" :function(data,type, row)
                        {
                          if (data === null) {
                            return '';
                          } else {
                            return moment(data).format('DD/MM/YYYY HH:mm:ss');
                          }
                        }
                  },
                  { data: "date_preparation", className: 'dt-body-center',
                      "render" :function(data,type, row)
                      {
                        if (data === null) {
                          return '';
                        } else {
                          return moment(data).format('DD/MM/YYYY');
                        }
                      }
                  },
                  { data: "pic", className: 'dt-body-center'},
                  { data: "shift", className: 'dt-body-center'},
                  { data: "time_hour", className: 'dt-body-center'},
                  { data: "status", className: 'dt-body-center',
                      'render' : function(data, type, row)
                              {
                                if (data == '1') {
                                  return '<label class="label label-default">on Progress</label>';
                                } else  if (data == '3') {
                                  return '<label class="label label-info">Finished</label>';
                                }else{
                                  return'';
                                }
                              }
                  },
                  { data: "start_by", className: 'dt-body-center'},
                  { data: "end_by", className: 'dt-body-center'},
                  { data: "time_preparation", className: 'dt-body-center',
                    'render': function(data, type, row)
                    {
                        return Number(data).toFixed(2).toString()+ " minutes";
                    }
                  },
                ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [[ 1, 'asc' ],[ 2, 'asc' ],[6, 'asc']]
          } );

          // number
          table.on('draw.dt', function () {
            
              var info = table.page.info();
              table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                  cell.innerHTML = i + 1 + info.start;
              });
              // start preparation
              $(".start").click(function(){
                var id = $(this).attr("data-id");
                var time = $(this).attr("data-plan-time-preparation");
                var date = $(this).attr("data-plan-date-preparation");
                var help_column = $(this).attr("data-help-column");
                var btn = $(this);
                $.ajax({
                          url: "/delivery/preparation/"+id+"/start",
                          method: "get",
                          data:{
                              "_token": "{{ csrf_token() }}",
                          },
                          success: function(result){
                              if (result == '404'  ) {
                                  alert("failed");
                              } else {
                                btn.removeClass("btn-primary").addClass("btn-warning").html("On Progress");
                                // rubah button
                                $("#end_"+id).removeClass('d-none');
                                $("#start_"+id).addClass('d-none');  
                                 var plan = moment(date+" "+time);
                                 var now = moment(result );
                                //  gap ditambah 1/2 menit
                                 var gap = (plan.diff(now , 'minutes')*60000)+60000; 

                                setTimeout(() => {
                                  
                                  // tampil modal
                                  $('#myModal2').modal('show');
                                  $('#myModal2').modal({backdrop: 'static', keyboard: false})  
                                  // isi id
                                  $("#id").val(id);
                                  // isi title
                                  $(".modal-title").html("Preparation "+help_column+" Delayed");
                                  // update status
                                  $.ajax({
                                    url: "/delivery/preparation/"+id+"/end",
                                    method: "get",
                                    data:{
                                        "_token": "{{ csrf_token() }}",
                                    },
                                    success:function(){}

                                    });
                                }, gap);
                              }
                      }});
              });
              $(".end").click(function(){
                var id = $(this).attr("data-id");
                var time = $(this).attr("data-plan-time-preparation");
                var date = $(this).attr("data-plan-date-preparation");
                var help_column = $(this).attr("data-help-column");
                // update status
                $.ajax({
                        url: "/delivery/preparation/"+id+"/end",
                        method: "get",
                        data:{
                            "_token": "{{ csrf_token() }}",
                        },
                        success:function(result){
                          // alert(result);
                          if (result == "404") {
                            alert("failed");
                          } else {
                            console.log(result);
                            if (result == "delayed") {
                               // tampil modal
                               $('#myModal2').modal('show');
                                  $('#myModal2').modal({backdrop: 'static', keyboard: false})  
                                  // isi id
                                  $("#id").val(id);
                                  // isi title
                                  $(".modal-title").html("Preparation "+help_column+" Delayed");
                            } else {
                              location.reload(true);
                            }
                          }
                        }

                      });
              });
          });


          // Refilter the table
          $('#min, #max').on('change', function () {
              table.draw();
          });

          $("#select_customer").change(function(){
                table.ajax.reload(null,true)
          });
          $("#select_partcard").change(function(){
                table.ajax.reload(null,true)
          });
          $("#select_line").change(function(){
                table.ajax.reload(null,true)
          });
          $("#select_packaging_code").change(function(){
                table.ajax.reload(null,true)
          });
          $("#select_category").change(function(){
                table.ajax.reload(null,true)
          });
         

      } );
    </script>
@endpush

