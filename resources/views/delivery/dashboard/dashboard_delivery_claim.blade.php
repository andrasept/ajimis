{{-- {{dd($data)}} --}}

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

    <div class="ibox">
        <div class="ibox-title">
            <h4>Claim Summary</h4>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-5"></div>
                <div class="col-lg-3">
                    <form action="{{route('delivery.claim.graph')}}" method="GET">
                        @csrf
                    <div class="form-group">
                        <input type="date" class="form-control" name="start" id="start" value="{{date('Y-m-d')}}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="end" id="end" value="{{date('Y-m-d')}}">
                    </div>
                </div>
                <div class="col-lg-1">
                    <button class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="ibox-content">
            <canvas id="chart" height="100"></canvas>
        </div>
        <div class="ibox-footer">

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
    <!-- ChartJS-->
    <script src="{{asset('js/plugins/chartJs/Chart.min.js')}}"></script>
    <script src="{{asset('js/demo/chartjs-demo.js')}}"></script>

    <script>
        var cData = JSON.parse('<?php echo $arr_jenis_count; ?>');
        var cLabel= JSON.parse('<?php echo $arr_jenis; ?>');
        var cColor= JSON.parse('<?php echo $arr_color; ?>');
        
        
        var barData = {
            labels:cLabel,
            datasets: [{
                label: "Freq Claim",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: cData
            },] 
        };

        var barOptions = {
            responsive: true
        };
        console.log(barData);

        var ctx2 = document.getElementById("chart").getContext("2d");
        new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
    </script>
@endpush












  