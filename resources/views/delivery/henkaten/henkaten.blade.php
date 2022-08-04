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
      <h4>History Henkaten </h4>
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
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Area</th>
            <th class="text-center">Reason</th>
            <th class="text-center">MP Before</th>
            <th class="text-center">MP After</th>
            <th class="text-center">Default Area MP After</th>
            <th class="text-center">Type</th>
            <th class="text-center">Date </th>
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
<div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg ">
      <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              {{-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> --}}
              <h4 class="modal-title">Evidence</h4>
              <small class="judul"></small>
          </div>
          <div class="modal-body text-center">
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
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
                    "url": "{{route('delivery.henkaten_detail')}}",
                    "data":function (d) {
                },
        },
        "columns": [
            { data: null, className: 'dt-body-center'},
            { data: 'area', className: 'dt-body-center'},
            { data: 'reason_henkaten', className: 'dt-body-center'},
            { data: 'mp_before', className: 'dt-body-center'},
            { data: 'mp_after', className: 'dt-body-center'},
            { data: 'default_area_mp_after', className: 'dt-body-center'},
            { data: 'type', className: 'dt-body-center',
          
              'render' : function(data, type, row){
                if (data == 'henkaten') {
                  return '<label class="label label-danger"> Henkaten </label>';
                } else if (data == 'cancel') {
                  return '<label class="label label-info"> Cancel </label>';
                }else{
                  return '<label class="label label-warning"> Substitute </label>';
                }
              }

            },
            { data: 'date_henkaten', className: 'dt-body-center'},
        ],
        "columnDefs": [ {
            "searchable": true,
            "orderable": true,
            "targets": 0
        } ],
        "order": [[ 7, 'desc' ]]
        } );

        // number
        table.on('draw.dt', function () {
            var info = table.page.info();
            table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
            $("#master tbody").on('click', '.photo', function () {
              var photo = $(this).attr('id-photo');
              var problem = $(this).attr('id-problem');
              var customer = $(this).attr('id-customer');
              var date = $(this).attr('id-date');
              var element= "<img src='"+photo+"' width='100%' height='100%'>";


              $('#myModal2').modal('show');
              $(".judul").html("Problem: "+problem+" <br/> Customer: "+customer+"<br/> Claim Date: "+date);
              $(".modal-body").html(element);
            });
        });

    } );
    </script>
@endpush

