@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')


{{-- datatable library css --}}
<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">

<link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">

{{-- datatble template css--}}
{{-- <link href="{{asset('css\plugins\dataTables\datatables.min.css')}}" rel="stylesheet"> --}}
<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

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
    <div class="row mb-3">
      <div class="col-lg-12 text-right">
        <a class="btn btn-primary  m-4 text-center" href="{{route('delivery.preparation.create')}}">Create</a>
      </div>
    </div>
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Action</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Date Delivery</th>
            <th class="text-center">Help Column</th>
            <th class="text-center">Cycle</th>
            <th class="text-center">Cycle Time</th>
            <th class="text-center">Time Pickup</th>
            <th class="text-center">Date preparation</th>
            <th class="text-center">Start Preparation</th>
            <th class="text-center">End Preparation</th>
            <th class="text-center">PIC</th>
            <th class="text-center">Shift</th>
            <th class="text-center">Time Hour</th>
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
                          // d.min = $('#min').val();
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
                  { data: "id", className: 'dt-body-center',
                      "render": function ( data, type, row ) {
                            return "<div class='btn-group'><a href='/delivery/pickupcustomer/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='pickupcustomer/"+data+"/delete' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
                        },
                  },
                  { data: "help_column", className: 'dt-body-center'},
                  { data: "date_delivery", className: 'dt-body-center'},
                  { data: "customer_pickup_id", className: 'dt-body-center'},
                  { data: "cycle", className: 'dt-body-center'},
                  { data: "cycle_time_preparation", className: 'dt-body-center'},
                  { data: "time_pickup", className: 'dt-body-center'},
                  { data: "date_preparation", className: 'dt-body-center'},
                  { data: "start_preparation", className: 'dt-body-center'},
                  { data: "end_preparation", className: 'dt-body-center'},
                  { data: "pic", className: 'dt-body-center'},
                  { data: "shift", className: 'dt-body-center'},
                  { data: "time_hour", className: 'dt-body-center'},
                ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [[ 3, 'asc' ]]
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

