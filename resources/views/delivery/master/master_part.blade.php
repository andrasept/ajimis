@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')
<div class="ibox" >
  <div class="ibox-title">
      <h4>Data Part</h4>
  </div>
  <div class="ibox-content" >
      <h5>Import Data</h5>
    <form action=""  method="POST"  enctype="multipart/form-data">
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
            <th class="text-center">Model</th>
            <th class="text-center">Customer</th>
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
@endpush

