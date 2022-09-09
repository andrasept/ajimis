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

<div class="ibox" >
  <div class="ibox-title">
      <h4>Schedule </h4>
  </div>
  <div class="ibox-content" >
    <div class="row">
      <div class="col-lg-3 form-group">
        <form action="{{route('delivery.preparation.export')}}" target="_blank" method="post">
        <label for="">From :</label>
        <input type="text" class="form-control" id="min" name="min" placeholder="from">
      </div>
      <div class="col-lg-3 form-group">
        <label for="">To :</label>
        <input type="text" class="form-control" id="max" name="max" placeholder="to" >
      </div>
      <div class="col-lg-3 form-group">
        <label for=""> Prepare :</label>
        <select name="select_status" class="form-control" id="select_status">
            <option value="all">All</option>
            <option value="0">NOT STARTED</option>
            <option value="1">ON PROGRESS</option>
            <option value="3">ADVANCED</option>
            <option value="4">ONTIME</option>
            <option value="5">DELAYED</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-3">
        <label>Customer :</label> <br>
        <select name="help_column" id="help_column" style="width:100%" class="select2_help_column form-control">
            <option value="-">all</option>
            @foreach ($customers as $column)
                <option value="{{$column->customer_pickup_code}}" >{{$column->customer_pickup_code}}</option>
            @endforeach
        </select>
        @error('help_column') 
            <div class="text-danger">
                {{$message}}
            </div>
        @enderror
      </div>
      <div class="col-lg-3 form-group">
        <label for=""> Arrival :</label>
        <select name="select_status_arrival" class="form-control" id="select_status_arrival">
            <option value="all">All</option>
            <option value="-">NOT STARTED</option>
            <option value="3">ADVANCED</option>
            <option value="4">ONTIME</option>
            <option value="5">DELAYED</option>
        </select>
      </div>
      <div class="col-lg-3 ">
        <label for=""> Departure :</label>
        <select name="select_status_departure" class="form-control" id="select_status_departure">
            <option value="all">All</option>
            <option value="-">NOT STARTED</option>
            <option value="3">ADVANCED</option>
            <option value="4">ONTIME</option>
            <option value="5">DELAYED</option>
        </select>
      </div>
      <div class="col-lg-3 text-right">
        @csrf
        <button type="submit" class="btn btn-primary  m-4 text-center">EXPORT</button>
      </form>
      </div>
    </div>
   
    <hr>
    <div>
      @if(session()->has('success'))
          <div class="alert alert-primary">{{session('success')}}</div>
      @endif
      @if(session()->has('fail'))
          <div class="alert alert-danger">{{session('fail')}}</div>
      @endif
    </div>
    <div class="row mb-3">
      <div class="col-lg-9">
        <form action="{{route('delivery.preparation.import')}}"  method="POST"  enctype="multipart/form-data">
            @csrf
            <label>Import Schedule :</label> <br>
            <div class="custom-file">
                <input id="logo" type="file" name="file" class="custom-file-input" required>
                <label for="logo" class="custom-file-label">Choose file...</label>
              </div>
              <div class="form-group mt-2">
                <p class="text-danger "><b>*CSV Only</b></p>
              </div>
      </div>
      <div class="col-lg-1">
        <button class="btn btn-primary mt-4">IMPORT</button>
      </form> 
      </div>
      <div class="col-lg-2 text-right">
        <a class="btn btn-primary  mr-4 mt-4 text-center" href="{{route('delivery.preparation.create')}}">Create</a>
      </div>
    </div>
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Result Preparation</th>
            <th class="text-center">Result Arrival</th>
            <th class="text-center">Result Departure</th>
            <th class="text-center">Cycle Time (minutes)</th>
            <th class="text-center">Plan Preparation Date </th>
            <th class="text-center">Plan Preparation Time </th>
            <th class="text-center">Start Preparation</th>
            <th class="text-center">End Preparation</th>
            <th class="text-center">Date Preparation</th>
            <th class="text-center">PIC Preparation</th>
            <th class="text-center">Shift</th>
            <th class="text-center">Time Hour Preparation</th>
            <th class="text-center">Started Preparation by</th>
            <th class="text-center">Finished Preparation by</th>
            <th class="text-center">Prepare Time</th>
            <th class="text-center">Problem Preparation</th>
            <th class="text-center">Remark Preparation</th>
            <th class="text-center">Vendor</th>
            <th class="text-center" >Plan Arrival</th>
            <th class="text-center">Actual Arrival</th>
            <th class="text-center">Gap Arrival</th>
            <th class="text-center">Arrival Trigger by</th>
            <th class="text-center">Plan Departure</th>
            <th class="text-center">Actual Departure</th>
            <th class="text-center">Gap Departure</th>
            <th class="text-center">Departure Trigger by</th>
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

      var minDate, maxDate, select_role;

      // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});

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

          // select2
          $(".select2_help_column").select2();

          // check input
          $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            var ext = fileName.split('.').pop();
            if ( ext == "csv" ) {
              $(this).next('.custom-file-label').addClass("selected").html(fileName);
            } else {
              $(this).html("");
              swal("Oops!", "Only CSV file!", "error");
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
                  { responsivePriority: 1, targets: 10 },
                  { responsivePriority: 2, targets: 9 },
                  { responsivePriority: 3, targets: 8 },
                  { responsivePriority: 3, targets: 8 },
                  { responsivePriority: 4, targets: 6 }
              ],
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('delivery.preparation')}}",
                          "data":function (d) {
                          d.min = $('#min').val();
                          d.max = $('#max').val();
                          d.status = $('#select_status').val();
                          d.help_column = $('#help_column').val();
                          d.status_departure = $('#select_status_departure').val();
                          d.status_arrival = $('#select_status_arrival').val();
                          d.customer_pickup_code = $('#customer_pickup_code').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  { data: "help_column", className: 'dt-body-center'},
                  { data: "status", className: 'dt-body-center', 
                    'render' : function(data, type, row)
                    {
                      var waktu_selesai_prepare = moment(row['end_preparation']);
                      var waktu_plan_prepare = moment(row['plan_date_preparation']);
                      var waktu_start= null;
                      if (row['start_preparation'] !== null) {
                        waktu_start = moment(row['start_preparation']);
                      }
                      var waktu_sekarang = moment().format("DD/MM/YYYY HH:mm:ss");
                      var waktu_progress = moment(waktu_sekarang,"DD/MM/YYYY HH:mm:ss").diff(moment(waktu_start,"DD/MM/YYYY HH:mm:ss"), 'minutes');

                      var waktu_plan_prepare_min_20 =waktu_plan_prepare.subtract({minutes:20}).format('DD/MM/YYYY HH:mm:ss');

                      if (data == '1') {
                        return '<label class="label label-warning ">on Progress</label><br/>'+waktu_progress+" minutes";
                      } else  if (data == '3') {
                        // cek status delay, ontime, adavance
                        return '<label class="label label-info">Advanced</label><br/>';
                      
                      } else  if (data == '4') {
                        // cek status delay, ontime, adavance
                        return '<label class="label label-primary">On time</label><br/>';
                      
                      }else  if (data == '5') {
                        // cek status delay, ontime, adavance
                        return '<label class="label label-danger">Delayed</label><br/>';
                      
                      }else{
                        return'';
                      }
                    }
                  },
                  { data: 'arrival_status', className: 'dt-body-center',
                  'render' : function(data, row, type){
                    if (data == '4') {
                      return '<label class="label label-primary">On Time</label>';
                    } else if(data == '3') {
                      return '<label class="label label-info">Advanced</label>';
                    }else if(data == '8') {
                      return '<label class="label label-info">Advanced Return</label>';
                    }else if(data == '9') {
                      return '<label class="label label-primary">On Time Return</label>';
                    }else if(data == '10') {
                      return '<label class="label label-danger">Delay Return</label>';
                    }  else if(data === null) {
                      return '';
                    }else{
                      return '<label class="label label-danger">Delayed</label>';
                    }
                  }
                },
                { data: 'departure_status', className: 'dt-body-center',
                  'render' : function(data, row, type){
                    if (data == '4') {
                      return '<label class="label label-primary">On Time</label>';
                    } else if(data == '3') {
                      return '<label class="label label-info">Advanced</label>';
                    } else if(data === null) {
                      return '';
                    }else if(data == '6') {
                      return '<label class="label label-warning">Pending</label>';
                    }else if(data == '7') {
                      return '<label class="label label-warning">Pending Milkrun Ready</label>';
                    }else{
                      return '<label class="label label-danger">Delayed</label>';
                    }
                  }
                },
                { data: "cycle_time_preparation", className: 'dt-body-center'},
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
                { data: "plan_time_preparation", className: 'dt-body-center'},
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
                { data: "time_hour", className: 'dt-body-center',

                    'render': function(data, type, row)
                        {
                            return data.toFixed(2).toString()+ " hours";
                        }

                },
                { data: "start_by", className: 'dt-body-center'},
                { data: "end_by", className: 'dt-body-center'},
                { data: "time_preparation", className: 'dt-body-center',  
                    'render': function(data, type, row)
                    {
                        var persen = ( Number(row['cycle_time_preparation']-data)/row['cycle_time_preparation'])*100;
                        return Number(data).toFixed(2).toString()+" minutes ("+Number(persen).toFixed(2).toString()+ "%)" ;
                    }
                },
                { data: "problem", className: 'dt-body-center'},
                { data: "remark", className: 'dt-body-center'},
                { data: 'vendor', className: 'dt-body-center'},
                { data: 'arrival_plan', className: 'dt-body-center',
                
                  "render" :function(data,type, row)
                        {
                          if (data === null) {
                            return '';
                          } else {
                            return moment(data).format('DD/MM/YYYY HH:mm:ss');
                          }
                        }

                },
                { data: 'arrival_actual', className: 'dt-body-center',
                
                  "render" :function(data,type, row)
                          {
                            if (data === null) {
                              return '';
                            } else {
                              return moment(data).format('DD/MM/YYYY HH:mm:ss');
                            }
                          }
                
                },
                { data: 'arrival_gap', className: 'dt-body-center'},
                { data: 'security_name_arrival', className: 'dt-body-center'},
                { data: 'departure_plan', className: 'dt-body-center',
                
                  "render" :function(data,type, row)
                          {
                            if (data === null) {
                              return '';
                            } else {
                              return moment(data).format('DD/MM/YYYY HH:mm:ss');
                            }
                          }
                
                },
                { data: 'departure_actual', className: 'dt-body-center',
              
                  "render" :function(data,type, row)
                          {
                            if (data === null) {
                              return '';
                            } else {
                              return moment(data).format('DD/MM/YYYY HH:mm:ss');
                            }
                          }
                
                },
                { data: 'departure_gap', className: 'dt-body-center'},
                { data: 'security_name_departure', className: 'dt-body-center'},
                { data: "id", className: 'dt-body-center',
                  "render": function ( data, type, row ) {
                        return "<div class='btn-group'><a href='{{URL::to('/')}}/delivery/preparation/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='{{URL::to('/')}}/delivery/preparation/"+data+"/delete' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
                    },
                },
              ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [[ 2, 'asc' ],[ 6, 'asc' ],[ 7, 'asc' ]]
          } );

          // number
          table.on('draw.dt', function () {
              var info = table.page.info();
              table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                  cell.innerHTML = i + 1 + info.start;
              });
          });

          // Refilter the table
          $('#min, #max').on('change', function () {
              table.draw();
          });

          $("#select_status").change(function(){
                table.ajax.reload(null,true)
          });

          $("#select_partcard").change(function(){
                table.ajax.reload(null,true)
          });

          $("#select_line").change(function(){
                table.ajax.reload(null,true)
          });

          $("#help_column").change(function(){
                table.ajax.reload(null,true)
          });

          $("#select_packaging_code").change(function(){
                table.ajax.reload(null,true)
          });

          $("#select_category").change(function(){
                table.ajax.reload(null,true)
          });

          $("#select_status_arrival").change(function(){
              table.ajax.reload(null,true)
          });

          $("#select_status_departure").change(function(){
              table.ajax.reload(null,true)
          });

      } );
    </script>
@endpush

