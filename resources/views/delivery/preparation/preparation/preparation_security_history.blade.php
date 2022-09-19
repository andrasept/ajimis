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
      <h4>History </h4>
  </div>
  <div class="ibox-content" >
    <div class="row">
      <div class="col-lg-3 text-right">
        @csrf
        {{-- <button type="submit" class="btn btn-primary  m-4 text-center">EXPORT</button> --}}
      </form>
      </div>
    </div>
   
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
            <th class="text-center">Customer</th>
            <th class="text-center">Vendor</th>
            <th class="text-center">Type</th>
            <th class="text-center">Security Name</th>
            <th class="text-center">Driver Name</th>
            <th class="text-center">Date Time</th>

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

      
      $(document).ready(function() {


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
              ],
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('delivery.preparation.security.history')}}",
                          "data":function (d) {
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  { data: "customer_pickup_id", className: 'dt-body-center'},
                  { data: "vendor", className: 'dt-body-center'},
                  { data: "jenis", className: 'dt-body-center'},
                  { data: "security_name", className: 'dt-body-center'},
                  { data: "driver_name", className: 'dt-body-center'},
                  { data: "created_at", className: 'dt-body-center'},
              ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [6, 'desc']
          } );

          // number
          table.on('draw.dt', function () {
              var info = table.page.info();
              table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                  cell.innerHTML = i + 1 + info.start;
              });

              // trigger modal driver name
              $('#master tbody').on('click','.arrive_btn', function(){
                  var id = $(this).attr('data-id');

                  $('#modalForm').modal('show');
                  $('#id_preparation').val(id);
                  
              })

              
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

