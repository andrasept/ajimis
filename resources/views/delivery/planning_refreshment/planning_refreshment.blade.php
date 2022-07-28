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
      <h4>Planning Refreshment</h4>
  </div>
 
  <div class="ibox-content" >
    <div class="row mb-3">
      <div class="col-lg-12 ">
       <a class="btn btn-primary  m-4 text-center  float-right" href="{{route('delivery.planning_refreshment.create')}}">Create</a>
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
    <div style="overflow-x: auto">
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">training</th>
            <th class="text-center">man power</th>
            <th class="text-center">plan date Training</th>
            <th class="text-center">actual date Training</th>
            <th class="text-center">status</th>
            <th class="text-center">action</th>
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
    <script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>
    <script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/js_agil/dataTables.responsive.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>

          $(document).ready(function() {
                // huruf kecil table
                $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
                $("select").css({fontSize:12});

              // datatable
              var table = $('#master').DataTable( {
                  "responsive" : true,
                  "processing": true,
                  "serverSide": true,
                  "filter":true,
                  "ajax": {
                              "url": "{{route('delivery.planning_refreshment')}}",
                              "data":function (d) {
                          },
                  },
                  "columns": [
                      { data: null, className: 'dt-body-center'},
                      { data: 'training', className: 'dt-body-center'},
                      { data: 'user_id', className: 'dt-body-center'},
                      { data: 'plan_date_time', className: 'dt-body-center'},
                      { data: 'actual_date_time', className: 'dt-body-center'},
                      { data: 'status', className: 'dt-body-center',
                    
                        'render' : function(data, type, row){
                          if (data == '1') {
                            return "<label class='label label-primary'>Done</label>"
                          } else {
                            return '';
                          }
                        }
                    
                      },
                      { data: 'id', className: 'dt-body-center',
                    
                        'render': function(data, type, row){
                          console.log(row['status']);
                            var html = "";
                            if ( row['status'] === null) {
                              
                              html = "<a href='planning_refreshment/"+data+"/update_status' class='btn btn-primary btn-xs'><i class='fa fa-check'></i></a>";
                              
                            } else {
                              
                            }
                           return "<div class='btn-group'>"+html+"<a href='planning_refreshment/"+data+"/edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='planning_refreshment/"+data+"/delete' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></a></div>";

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

              } );
    </script>
@endpush

