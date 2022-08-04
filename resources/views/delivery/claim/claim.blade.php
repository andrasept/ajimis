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
      <h4>Claim Delivery </h4>
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
        <a class="btn btn-primary  mr-4 mt-4 text-center" href="{{route('delivery.claim.create')}}">Create</a>
      </div>
    </div>
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Claim Date</th>
            <th class="text-center">Problem Identification</th>
            <th class="text-center">Part Number</th>
            <th class="text-center">Part Number Actual</th>
            <th class="text-center">Part Name</th>
            <th class="text-center">Part Name Actual</th>
            <th class="text-center">Category</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Evidence</th>
            <th class="text-center">Corrective Action</th>
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
                    "url": "{{route('delivery.claim.claim')}}",
                    "data":function (d) {
                },
        },
        "columns": [
            { data: null, className: 'dt-body-center'},
            { data: 'customer_pickup_id', className: 'dt-body-center'},
            { data: 'claim_date', className: 'dt-body-center',
            
              'render': function(data){
                return moment(data).format('DD/MM/YYYY');
              }

            },
            { data: 'problem', className: 'dt-body-center'},
            { data: 'part_number', className: 'dt-body-center'},
            { data: 'part_number_actual', className: 'dt-body-center'},
            { data: 'part_name', className: 'dt-body-center'},
            { data: 'part_name_actual', className: 'dt-body-center'},
            { data: 'category', className: 'dt-body-center'},
            { data: 'qty', className: 'dt-body-center'},
            { data: 'evidence', className: 'dt-body-center',
                  'render' : function(data,type,row) {
                        var element= "<div class='d-flex flex-row'>";
                        var url= "";
                        var problem= row['problem'];
                        var customer= row['customer_pickup_id'];
                        var date= row['claim_date'];
                        var array_img = data.split(",");

                        array_img.forEach(
                          function(value){
                            url = '{{asset("/storage/delivery-claim-photo")}}/'+value;
                            element +="<img src='"+url+"' class='photo m-1' id-problem='"+problem+"' id-date='"+ moment(date).format('DD/MM/YYYY')+"' id-customer='"+customer+"' id-photo='"+url+"' width='40' height='40'>";
                          }
                        );
                        element +="</div>";
                        return element;
                    },
            },
            { data: 'corrective_action', className: 'dt-body-center'},
            { data: 'id', className: 'dt-body-center',
                'render' : function(data,row,type){
                    return "<div class='btn-group'><div class='btn-group'><a href='/delivery/claim/"+data+"/edit' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a><a onClick='return confirm("+'"are you sure  ?"'+")' href='claim/"+data+"/delete' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></div>";
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

