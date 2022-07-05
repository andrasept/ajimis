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
      <h4>Delivery Note </h4>
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
      <div class="col-lg-9">
        <form action="{{route('delivery.delivery_note.import')}}"  method="POST"  enctype="multipart/form-data">
            @csrf
            <label>Import Delivery Note :</label> <br>
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
        <a class="btn btn-primary  mr-4 mt-4 text-center" href="{{route('delivery.delivery_note.create')}}">CREATE</a>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-lg-12">
        <input type="text" placeholder="delivery note" class="form-control" name="delivery_note" id="delivery_note" autofocus autocomplete="off">
      </div>
    </div>
      <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Customer</th>
            <th class="text-center">Delivery Note</th>
            <th class="text-center">Out</th>
            <th class="text-center">In</th>
            <th class="text-center">Days</th>
            <th class="text-center">Status</th>
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
      // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});

      $(document).ready(function(){
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

        $("#master").dataTable(
            {
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
                          "url": "{{route('delivery.delivery_note')}}",
                          "data":function (d) {
                        },
              },
              "columns" : [
                { data: 'id', className: 'dt-body-center'},
                { data: 'customer', className: 'dt-body-center'},
                { data: 'delivery_note', className: 'dt-body-center'},
                { data: 'out', className: 'dt-body-center',
              
                  'render': function(data, type, row){
                    if (data === null) {
                      return'';
                    } else {
                      return moment(data).format('DD/MM/YYYY HH:mm:ss');
                    }
                  }
                },
                { data: 'in', className: 'dt-body-center',
                  'render': function(data, type, row){
                      if (data === null) {
                        return'';
                      } else {
                        return moment(data).format('DD/MM/YYYY HH:mm:ss');
                      }
                    }
              
                },
                { data: 'days', className: 'dt-body-center',
              
                  'render': function(data, type, row){
                    var date_out;
                    var date_now;
                    var gap;

                    if (data === null) {
                      if (row['out'] === null) {
                        gap ="";
                      } else {
                       date_out = moment(row['out']);
                       date_now = moment(new Date());
                       gap = (date_now.diff(date_out , 'days'));
                      }
                      return gap;
                    } else {
                      return data;
                    }
                  }

                },
                { data: 'status', className: 'dt-body-center',
              
                  'render': function(data, type, row){

                      var date_out;
                      var date_now;
                      var gap;

                       date_out = moment(row['out']);
                       date_now = moment(new Date());
                       gap = (date_now.diff(date_out , 'days'));

                      if(data === null){
                        return '';
                      } else if(data == '1' && gap >3) {
                        return '<label class="label label-danger">delayed</label>';
                      }else if(data == '1'){
                        return '<label class="label label-warning">on progress</label>';
                      }else if(data == '2'){
                        return '<label class="label label-primary">closed</label>';
                      }else{
                        return '<label class="label label-secondary">close delayed</label>';
                      }
                  }
                
                }
              ],
              "columnDefs": [ {
                  "searchable": true,
                  "orderable": true,
                  "targets": 0
              } ],
              "order": [[6, 'asc']]
            }
        );


        var timer;
        $("#delivery_note").keyup(function(){
           
              clearTimeout(timer);  //clear any running timeout on key up
              timer = setTimeout(function() { 
                  //do .post ajax request //then do the ajax call
                   // ambil data dn
                   var dn = $("#delivery_note").val();
                  $.ajax({
                    url: "{{route('delivery.delivery_note.check')}}",
                    method: "post",
                    data:{
                        "dn" : dn,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(result){
                        if (result == "404") {
                          alert("Delivery Note is not match in our records");
                        } else {
                          alert("Delivery Note Updated");
                          location.reload(true);
                        }
                    }
                  });
              }, 1000);
              
          });
      });
    </script>
@endpush

