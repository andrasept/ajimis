@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')
<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<div class="ibox" >
  <div class="ibox-title">
      <h4>Data Part</h4>
  </div>
  <div class="ibox-content" >
      <h5>Import Data</h5>
    <form action="{{route('delivery.master.master_part.import')}}"  method="POST"  enctype="multipart/form-data">
        @csrf
        <div class="custom-file">
            <input id="logo" type="file" name="file" class="custom-file-input">
            <label for="logo" class="custom-file-label">Choose file...</label>
        </div>
        <div class="form-group mt-2">
          <button class="btn btn-primary">Import</button>
        </div>
    </form> 
    <div>
      @if(session()->has('success'))
          <div class="alert alert-primary">{{session('success')}}</div>
      @endif
      @if(session()->has('fail'))
          <div class="alert alert-danger">{{session('fail')}}</div>
      @endif
    </div>
    <hr>
    <div style="overflow-x: auto">
      <div class="row mb-3">
            {{-- <div class="col-2 form-group">
              <label for="">From :</label>
              <input type="text" class="form-control" id="min" name="min" placeholder="from">
            </div>
            <div class="col-2 form-group">
              <label for="">To :</label>
              <input type="text" class="form-control" id="max" name="max" placeholder="to">
            </div> --}}
            {{-- <div class="col-2 form-group">
              <label for="">Role :</label>
              <select name="select_role" class="form-control" id="select_role">
                  <option value="all">all</option>
                  <option value="user">user</option>
                  <option value="superuser">superuser</option>
                  <option value="admin">admin</option>
              </select>
            </div> --}}
      </div>
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Sku</th>
            <th class="text-center">Part Name</th>
            <th class="text-center">Part Number Customer</th>
            <th class="text-center">Part Number AJI</th>
            <th class="text-center">Model</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Category</th>
            <th class="text-center">Cycle Time</th>
            <th class="text-center">Addresing</th>
            <th class="text-center">Part Card</th>
            <th class="text-center">Line</th>
            <th class="text-center">Qty/pallet</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
  <div class="ibox-footer">
    <button class="btn  btn-default " onClick="history.back()">Back</button>
  </div>
</div>
@endsection

@push('scripts')
    {{-- <script src="{{asset('js/jquery-3.5.1.js')}}"></script>     --}}
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>
    <!-- Sweet alert -->
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>

      var minDate, maxDate, select_role;

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
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('delivery.master.master_part')}}",
                          "data":function (d) {
                          d.min = $('#min').val();
                          d.max = $('#max').val();
                        //   d.role = $('#select_role').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  { data: "sku", className: 'dt-body-center'},
                  { data: "part_name", className: 'dt-body-center'},
                  { data: "part_no_customer", className: 'dt-body-center'},
                  { data: "part_no_aji", className: 'dt-body-center'},
                  { data: "model", className: 'dt-body-center'},
                  { data: "customer_name", className: 'dt-body-center'},
                  { data: "category", className: 'dt-body-center'},
                  { data: "cycle_time", className: 'dt-body-center'},
                  { data: "addresing", className: 'dt-body-center'},
                  { data: "description", className: 'dt-body-center'},
                  { data: "line_name", className: 'dt-body-center'},
                  { data: "qty_per_pallet", className: 'dt-body-center'},
                  { data: "id", className: 'dt-body-center',
                      "render": function ( data, type, row ) {
                            return "<div class='btn-group'><a href='/delivery-master-part/"+data+"/edit' class='btn btn-sm btn-default'><i class='fa fa-pencil'></i></a><a href='/delivery-master-part/"+data+"/delete' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a></div>";
                        },
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

          // Refilter the table
          $('#min, #max').on('change', function () {
              table.draw();
          });

          // $("#select_role").change(function(){
          //       table.ajax.reload(null,false)
          // });

      } );
    </script>
@endpush

