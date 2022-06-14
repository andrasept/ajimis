@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')


{{-- datatable library css --}}
<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">

{{-- datatble template css--}}
{{-- <link href="{{asset('css\plugins\dataTables\datatables.min.css')}}" rel="stylesheet"> --}}
<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

<div class="ibox" >
  <div class="ibox-title">
      <h4>Schedule Preparation</h4>
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
        <label for="">Status :</label>
        <select name="select_status" class="form-control" id="select_status">
            <option value="all">All</option>
            <option value="0">NOT STARTED</option>
            <option value="1">ON PROGRESS</option>
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
    <div class="row">
      <div class="form-group col-lg-3">
        <label>Customer :</label> <br>
        <select name="help_column" id="help_column" style="width:100%" class="select2_help_column form-control">
            <option value="-">all</option>
            @foreach ($customers as $column)
                <option value="{{$column->help_column}}" >{{$column->help_column}}</option>
            @endforeach
        </select>
        @error('help_column') 
            <div class="text-danger">
                {{$message}}
            </div>
        @enderror
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
      <div class="col-lg-12 text-right">
        <a class="btn btn-primary  m-4 text-center" href="{{route('delivery.preparation.create')}}">Create</a>
      </div>
    </div>
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Status</th>
            {{-- <th class="text-center">Date Delivery</th> --}}
            <th class="text-center">Customer</th>
            {{-- <th class="text-center">Help Column</th> --}}
            <th class="text-center">Cycle</th>
            <th class="text-center">Cycle Time</th>
            <th class="text-center">Plan Date </th>
            <th class="text-center">Plan Time </th>
            <th class="text-center">Start </th>
            <th class="text-center">End </th>
            <th class="text-center">Date </th>
            <th class="text-center">PIC</th>
            <th class="text-center">Shift</th>
            <th class="text-center">Time Hour</th>
            <th class="text-center">Action</th>
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
                          // d.partcard = $('#select_partcard').val();
                          // d.line = $('#select_line').val();
                          // d.packaging_code = $('#select_packaging_code').val();
                          // d.category = $('#select_category').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  { data: "status", className: 'dt-body-center', 
                  'render' : function(data, type, row)
                  {
                    var waktu_selesai_prepare = moment(row['end_preparation']);
                    var waktu_plan_prepare = moment(row['plan_date_preparation']);

                    var waktu_plan_prepare_min_20 =waktu_plan_prepare.subtract({minutes:20}).format('DD/MM/YYYY HH:mm:ss');

                    if (data == '1') {
                      return '<label class="label label-warning ">on Progress</label>';
                    } else  if (data == '3') {
                      // cek status delay, ontime, adavance
                      return '<label class="label label-info">Advanced</label>';
                     
                    } else  if (data == '4') {
                      // cek status delay, ontime, adavance
                      return '<label class="label label-primary">On time</label>';
                     
                    }else  if (data == '5') {
                      // cek status delay, ontime, adavance
                      return '<label class="label label-danger">Delayed</label>';
                     
                    }else{
                      return'';
                    }
                  }
                },
                // { data: "help_column", className: 'dt-body-center'},
                // { data: "date_delivery", className: 'dt-body-center',
                //      "render" :function(data,type, row)
                //         {
                //           if (data === null) {
                //             return '';
                //           } else {
                //             return moment(data).format('DD/MM/YYYY');
                //           }
                //         }
                // },
                { data: "help_column", className: 'dt-body-center'},
                { data: "cycle", className: 'dt-body-center'},
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
                { data: "id", className: 'dt-body-center',
                    "render": function ( data, type, row ) {
                          return "<div class='btn-group'><a href='/delivery/preparation/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='preparation/"+data+"/delete' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
                      },
                },
                { data: "start_by", className: 'dt-body-center'},
                { data: "end_by", className: 'dt-body-center'},
                { data: "time_preparation", className: 'dt-body-center',  
                    'render': function(data, type, row)
                    {
                        var persen = (data / Number(row['cycle_time_preparation']))*100;
                        return Number(data).toFixed(2).toString()+" minutes ("+Number(persen).toFixed(2).toString()+ "%)" ;
                    }
                },

                ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [[ 1, 'asc' ],[ 5, 'asc' ],[ 6, 'asc' ]]
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

      } );
    </script>
@endpush

