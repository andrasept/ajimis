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
      <h4>Skills </h4>
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
        <a class="btn btn-primary  mr-4 mt-4 text-center" href="{{route('delivery.skills.export')}}">Export</a>
        <a class="btn btn-primary  mr-4 mt-4 text-center" href="{{route('delivery.skills.create')}}">Create</a>
      </div>
    </div>
    <table id="master" class="table table-bordered">
      <thead>
        <tr>
          <th class="text-center">No</th>
          <th class="text-center">Skill</th>
          <th class="text-center">Skill Description</th>
          <th class="text-center">Category</th>
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
      // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});

      $(document).ready(function(){

        // datatable
    var table = $('#master').DataTable( {
        "responsive" : true,
        "processing": true,
        "serverSide": true,
        "filter":true,
        "ajax": {
                    "url": "{{route('delivery.skills')}}",
                    "data":function (d) {
                },
        },
        "columns": [
            { data: null, className: 'dt-body-center'},
            { data: 'skill_code', className: 'dt-body-center'},
            { data: 'skill', className: 'dt-body-center'},
            { data: 'category', className: 'dt-body-center'},
            { data: 'id', className: 'dt-body-center',
          
              'render' : function(data, type, row){
                return "<div class='btn-group'><div class='btn-group'><a href='{{URL::to('/')}}/delivery/skills/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='{{URL::to('/')}}/skills/"+data+"/delete' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
              }
            },
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

        
      });

      
    </script>
@endpush

