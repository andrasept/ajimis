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
    </div>
    <div class="row">
      <div class="col-lg-3 text-right">
        @csrf
        {{-- <button type="submit" class="btn btn-primary  m-4 text-center">EXPORT</button> --}}
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
    {{-- <div class="row mb-3">
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
    </div> --}}
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Vendor</th>
            <th class="text-center">Actual Arrival</th>
            <th class="text-center">Actual Departure</th>
            <th class="text-center">Arrival / Departure</th>

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


{{-- modal --}}
<div class="modal inmodal" id="modalForm"  tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content animated flipInY">
          <div class="modal-header">
              <h4 class="modal-title judul">Driver Name</h4>
          </div>
          <div class="modal-body">
            <form action="{{route('delivery.preparation.arrival')}}" method="post">
              @csrf
            <input type="hidden" name="id" id="id_preparation" value="">
            <input type="text" class="form-control" name="driver_name" id="driver_name" value="">
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
                          d.member = '2';
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
                { data: 'vendor', className: 'dt-body-center'},
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
                { data: 'departure_status', className: 'dt-body-center', 
                    'render': function(data, type, row){
                        var driver = table.$('#driver_'+row['id']).val();
              
                        var kumpul_btn="<div class='btn-group'>";
                        var tutup_btn="</div>";

                        if (row['arrival_status'] === null) {
                          kumpul_btn= kumpul_btn+"<button data-id='"+row['id']+"' class='btn btn-md btn-success arrive_btn'>ARRIVE</button>";
                          // kumpul_btn= kumpul_btn+"<a href='/delivery/preparation/"+row['id']+"/"+driver+"/arrival' class='btn btn-md btn-success'>Arrive</a>";
                        }
                        else if (data === null  && row['arrival_status'] !==null) {
                          // kumpul_btn= kumpul_btn+"<button data-id='"+row['id']+"' class='btn btn-md btn-primary departure_btn'>DEPARTURE</button>";
                          kumpul_btn= kumpul_btn+"<a href='/delivery/preparation/"+row['id']+"/hold' class='btn btn-md btn-warning'>Hold</a>"+"<a href='/delivery/preparation/"+row['id']+"/departure' class='btn btn-md btn-primary'>Done</a>";
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
              "order": []
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

