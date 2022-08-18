@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')

<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('css\plugins\dataTables\datatables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<div class="ibox" >
  <div class="ibox-title">
      <h4>Schedule Delivery</h4>
  </div>
  <div class="ibox-content" >
    <h5>Import Data</h5>
    <form action="{{route('delivery.delivery.import')}}"  method="POST"  enctype="multipart/form-data">
        @csrf
        <div class="custom-file">
            <input id="logo" type="file" name="file" class="custom-file-input" required>
            <label for="logo" class="custom-file-label">Choose file...</label>
        </div>
        <p class="mt-1 text-danger"><b>* CSV Only</b></p>
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
    <div class="row">
      <div class="col-lg-3 form-group">
        <form action="#" target="_blank" method="post">
        <label for="">From :</label>
        <input type="text" class="form-control" id="min" name="min" placeholder="from">
      </div>
      <div class="col-lg-3 form-group">
        <label for="">To :</label>
        <input type="text" class="form-control" id="max" name="max" placeholder="to" >
      </div>
      <div class="col-lg-3 form-group">
        <label for="">Status Arrival :</label>
        <select name="select_status_arrival" class="form-control" id="select_status_arrival">
            <option value="all">All</option>
            <option value="-">NOT STARTED</option>
            <option value="3">ADVANCED</option>
            <option value="4">ONTIME</option>
            <option value="5">DELAYED</option>
        </select>
      </div>
      <div class="col-lg-3 ">
        @csrf
        <label for="">Status Departure :</label>
        <select name="select_status_departure" class="form-control" id="select_status_departure">
            <option value="all">All</option>
            <option value="-">NOT STARTED</option>
            <option value="3">ADVANCED</option>
            <option value="4">ONTIME</option>
            <option value="5">DELAYED</option>
        </select>
      </form>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-3">
        <label>Customer :</label> <br>
        <select name="customer_pickup_code" id="customer_pickup_code" style="width:100%" class="select2_customer_pickup_code form-control">
            <option value="-">all</option>
            @foreach ($customers as $column)
                <option value="{{$column->customer_pickup_code}}" >{{$column->customer_pickup_code}}</option>
            @endforeach
        </select>
        @error('customer_pickup_code') 
            <div class="text-danger">
                {{$message}}
            </div>
        @enderror
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-lg-12 text-right">
        <a class="btn btn-primary  m-4 text-center" href="{{route('delivery.delivery.create')}}">Create</a>
      </div>
    </div>
    <div style="overflow-x: auto">
      <table id="master" class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Action</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Cycle</th>
            <th class="text-center">Vendor</th>
            <th class="text-center">Plan Arrival</th>
            <th class="text-center">Actual Arrival</th>
            <th class="text-center">Result Arrival</th>
            <th class="text-center">Gap Arrival</th>
            <th class="text-center">Plan Departure</th>
            <th class="text-center">Actual Departure</th>
            <th class="text-center">Result Departure</th>
            <th class="text-center">Gap Departure</th>
            <th class="text-center">Arrival / Departure</th>
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
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>


    <script>

        $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
        $("button").css({fontSize:9, textTransform:'Uppercase'});

        // select2
        $(".select2_customer_pickup_code").select2();

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
                          "url": "{{route('delivery.delivery')}}",
                          "data":function (d) {
                          d.min = $('#min').val();
                          d.max = $('#max').val();
                          d.status_departure = $('#select_status_departure').val();
                          d.status_arrival = $('#select_status_arrival').val();
                          d.customer_pickup_code = $('#customer_pickup_code').val();
                          // d.partcard = $('#select_partcard').val();
                          // d.line = $('#select_line').val();
                          // d.packaging_code = $('#select_packaging_code').val();
                          // d.category = $('#select_category').val();
                      },
              },
              "columns": [
                  { data: null, className: 'dt-body-center'},
                  { data: 'id', className: 'dt-body-center',
                    'render' : function(data, row, type){
                      return "<div class='btn-group'><a href='/delivery/delivery/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='delivery/"+data+"/delete' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
                    }
                
                  },
                  { data: 'customer_pickup_id', className: 'dt-body-center'},
                  { data: 'cycle', className: 'dt-body-center'},
                  { data: 'vendor', className: 'dt-body-center'},
                  { data: 'arrival_plan', className: 'dt-body-center'},
                  { data: 'arrival_actual', className: 'dt-body-center'},
                  { data: 'arrival_status', className: 'dt-body-center',
                    'render' : function(data, row, type){
                      if (data == '4') {
                        return '<label class="label label-primary">On Time</label>';
                      } else if(data == '3') {
                        return '<label class="label label-info">Advanced</label>';
                      } else if(data === null) {
                        return '';
                      }else{
                        return '<label class="label label-danger">Delayed</label>';
                      }
                    }
                  },
                  { data: 'arrival_gap', className: 'dt-body-center'},
                  { data: 'departure_plan', className: 'dt-body-center'},
                  { data: 'departure_actual', className: 'dt-body-center'},
                  { data: 'departure_status', className: 'dt-body-center',
                    'render' : function(data, row, type){
                      if (data == '4') {
                        return '<label class="label label-primary">On Time</label>';
                      } else if(data == '3') {
                        return '<label class="label label-info">Advanced</label>';
                      } else if(data === null) {
                        return '';
                      }else{
                        return '<label class="label label-danger">Delayed</label>';
                      }
                    }
                  },
                  { data: 'departure_gap', className: 'dt-body-center'},
                  { data: 'departure_status', className: 'dt-body-center', 
                      'render': function(data, type, row){
                      
                          var kumpul_btn="<div class='btn-group'>";
                          var tutup_btn="</div>";

                          if (row['arrival_status'] === null) {
                            kumpul_btn= kumpul_btn+"<a href='{{URL::to('/')}}/delivery/delivery/"+row['id']+"/arrival' class='btn btn-md btn-success'>Arrive</a>";
                          }
                          else if (data === null  && row['arrival_status'] !==null) {

                            kumpul_btn= kumpul_btn+"<a href='{{URL::to('/')}}/delivery/delivery/"+row['id']+"/departure' class='btn btn-md btn-primary'>Departure</a>";
                          }else{  
                            
                          }      
                          return kumpul_btn+tutup_btn;
                  }},
                ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [[ 4, 'asc' ]]
          } );

          // number
          table.on('draw.dt', function () {
            var info = table.page.info();
            table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
              cell.innerHTML = i + 1 + info.start;
            });
          });

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

          // Create date inputs
          minDate = new DateTime($('#min'), {
              format: 'YYYY-MM-DD'
          });
          maxDate = new DateTime($('#max'), {
              format: 'YYYY-MM-DD '
          });

          // Refilter the table

           $('#min, #max').on('change', function () {
              table.draw();
          });
          
          $("#select_status_arrival").change(function(){
              table.ajax.reload(null,true)
          });
          $("#select_status_departure").change(function(){
              table.ajax.reload(null,true)
          });
          $("#customer_pickup_code").change(function(){
                table.ajax.reload(null,true)
          });

    </script>
@endpush

