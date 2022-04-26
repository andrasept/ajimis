@extends('layouts.app-master')

@section('title', 'AJI MIS | HOME')

@section('content')
  @guest
  <div class="ibox-content">
    <div class="row">
      <div class="col-md-3">
        <div class="ibox">
          <div class="ibox-content product-box">
            <a href="{{ route('login.show')}}" class="btn btn-xs btn-outline btn-danger" style="">
            <div class="product-imitation">
              <img src="{{asset('image/award.png')}}" alt="" width="40%" height="40%">
            </div>
            </a>
            <div class="product-desc">
              <span class="product-price bg-danger">
                QUALITY
              </span>
              <div class="small m-t-xs">
                Quality Portal
              </div>
              <div class="m-t text-righ">
                @role('quality')
                <a href="{{ route('login.show')}}" class="btn btn-xs btn-outline btn-primary">Go <i class="fa fa-long-arrow-right"></i> </a>
                @else
                <!-- <a href="{{ route('login.show')}}" class="btn btn-xs btn-outline btn-danger" style="cursor: not-allowed;pointer-events: none;">Not Allowed</a> -->
                <a href="{{ route('login.show')}}" class="btn btn-xs btn-outline btn-danger" style="">Not Allowed</a>
                @endrole
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="ibox">
          <div class="ibox-content product-box">
            <a href="{{ route('login.show')}}" class="btn btn-xs btn-outline btn-danger" style="">
            <div class="product-imitation">
              <img src="{{asset('image/analytics.png')}}" alt="" width="40%" height="40%">
            </div>
            </a>
            <div class="product-desc">
              <span class="product-price " style="background-color:black">
                DMS
              </span>
              <div class="small m-t-xs">
                Document Management System
              </div>
              <div class="m-t text-righ">
                @role('npd')
                <a href="#" class="btn btn-xs btn-outline btn-primary">Go <i class="fa fa-long-arrow-right"></i> </a>
                @else
                <a href="#" class="btn btn-xs btn-outline btn-danger" style="cursor: not-allowed;pointer-events: none;">Not Allowed</a>
                @endrole
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endguest
@endsection

@push('scripts')

@endpush

