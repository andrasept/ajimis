@extends('layouts.app-master')
 
@section('title', 'AJI MIS | LINE')
 
 
@section('content')

{{-- datatable library css --}}
<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
{{-- datatble template css--}}
<link href="{{asset('css\plugins\dataTables\datatables.min.css')}}" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

<div class="ibox" >
  <div class="ibox-title">
      <h4>Data Line</h4>
  </div>
  <div class="ibox-content" >
      <h5>Import Data</h5>
    <form action="{{route('delivery.master.master_line.import')}}"  method="POST"  enctype="multipart/form-data">
        @csrf
        <div class="custom-file">
            <input id="logo" type="file" name="file" class="custom-file-input" required>
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
    <div class="row mb-3">
          {{-- <div class="col-2 form-group">
            <label for="">From :</label>
            <input type="text" class="form-control" id="min" name="min" placeholder="from">
          </div>
          <div class="col-2 form-group">
            <label for="">To :</label>
            <input type="text" class="form-control" id="max" name="max" placeholder="to">
          </div> --}}
          {{-- <div class="col-lg-2 form-group">
            <label for="">Customer :</label>
            <select name="select_customer" class="form-control" id="select_customer">
                <option value="all">All</option>
                @foreach ($customers as $customer)
                <option value="{{$customer->customer_code}}"}}>{{$customer->customer_name}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-lg-2 form-group">
            <label for="">Part Card :</label>
            <select name="select_partcard" class="form-control" id="select_partcard">
                <option value="all">All</option>
                @foreach ($partcards as $partcard)
                <option value="{{$partcard->color_code}}"}}>{{$partcard->description}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-lg-2 form-group">
            <label for="">Line :</label>
            <select name="select_line" class="form-control" id="select_line">
                <option value="all">All</option>
                @foreach ($lines as $line)
                <option value="{{$line->line_code}}"}}>{{$line->line_name}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-lg-2 form-group">
            <label for="">Packaging Code :</label>
            <select name="select_packaging_code" class="form-control" id="select_packaging_code">
                <option value="all">All</option>
                @foreach ($packagings as $packaging)
                <option value="{{$packaging->packaging_code}}"}}>{{$packaging->packaging_code}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-lg-2 form-group">
            <label for="">Category :</label>
            <select name="select_category" class="form-control" id="select_category">
                <option value="all">All</option>
                <option value="FG">FG</option>
                <option value="SFG">SFG</option>
            </select>
          </div> --}}
          {{-- <div class="col-lg-12"></div> --}}
          <div class="col-lg-12 text-right">
           <a class="btn btn-primary  m-4 text-center" href="{{route('delivery.master.master_line.create')}}">Create</a>
          </div>
    </div>
    <div style="overflow-x: auto">
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Action</th>
            <th class="text-center">Line Code</th>
            <th class="text-center">Line Name</th>
            <th class="text-center">Line Category</th>
            <th class="text-center">Tonase</th>
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

      // mini nav bar
      $("body").addClass("body-small mini-navbar");
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
              "processing": true,
              "serverSide": true,
              "filter":true,
              "ajax": {
                          "url": "{{route('delivery.master.master_line')}}",
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
                            return "<div class='btn-group'><a href='{{URL::to('/')}}/delivery/master-line/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='{{URL::to('/')}}/delivery/master-line/"+data+"/delete' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
                        },
                  },
                  { data: "line_code", className: 'dt-body-center'},
                  { data: "line_name", className: 'dt-body-center'},
                  { data: "line_category", className: 'dt-body-center'},
                  { data: "tonase", className: 'dt-body-center'},
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

