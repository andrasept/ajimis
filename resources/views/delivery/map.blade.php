

@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | CREATE LINE')
 
 
@section('content')
<img src="{{asset('image/ajilogo.png')}}" alt="Workplace" usemap="#workmap" width="400" height="379">

    <map name="workmap">
        <area shape="circle" style="background-color:azure" coords="408,198,100" alt="Computer" href="computer.htm">
        {{-- <area shape="rect" coords="290,172,333,250" alt="Phone" href="phone.htm">
        <area shape="circle" coords="337,300,44" alt="Cup of coffee" href="coffee.htm"> --}}
    </map>
    <div class="hasilcord">

    </div>
@endsection

@push('scripts')
<script>
  $("img").on("click", function(event) {
        var x = event.pageX - this.offsetLeft;
        var y = event.pageY - this.offsetTop;
        $('.hasilcord').html(x+','+y);
    });
</script>
@endpush




















