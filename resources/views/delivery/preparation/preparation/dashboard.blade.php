
@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT USER')
 
 
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Plan </h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$data['total']}}</h1>
                    <div class="stat-percent font-bold text-primary"><i class="fa fa-calendar"></i></div>
                    <small>Total Plan Prepare Today</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Prepared</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$data['finished']}}</h1>
                    <div class="stat-percent font-bold text-primary"><i class="fa fa-bolt"></i></div>
                    <small>Total Prepared Today</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Not Started</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$data['not_started']}}</h1>
                    <div class="stat-percent font-bold text-primary"><i class="fa fa-exclamation-triangle"></i></div>
                    <small>Total Not Started Today</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>On Progress</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$data['on_progress']}}</h1>
                    <div class="stat-percent font-bold text-primary"><i class="fa fa-plane"></i></div>
                    <small>Total On Progress Today</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row  ">
        <div class="ibox-content col-lg-12 text-center">
            <p id="time" class="h4" ></p>
        </div>
    </div>
    <div class="row  border-bottom white-bg dashboard-header ">
        <div class="col-md-6">
            <h2>Welcome {{Auth::user()->name}}</h2>
            <small>We have <b>{{$data['total']}}</b> Plan Preparation Today, <b>{{$data['on_progress']}}</b> on Progress,  <b>{{$data['finished']}}</b> Prepared and <b>{{$data['not_started']}}</b> not started.</small>
            <ul class="list-group clear-list m-t">
                @foreach ($data['lists'] as $list)
                <li class="list-group-item fist-item">
                    <span class="float-right">
                        {{$list->time_pickup}}
                    </span>
                    @if ($list->status == NULL)
                        <span class="label label-default">{{ $loop->iteration }}</span>  {{$list->help_column}}
                    @elseif($list->status == '3')
                        <span class="label label-info">{{ $loop->iteration }}</span>  {{$list->help_column}}
                    @elseif($list->status == '4')
                        <span class="label label-primary">{{ $loop->iteration }}</span>  {{$list->help_column}}
                    @elseif($list->status == '5')
                        <span class="label label-danger">{{ $loop->iteration }}</span>  {{$list->help_column}}
                    @else
                        <span class="label label-warning">{{ $loop->iteration }}</span>  {{$list->help_column}}
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <canvas id="barChart" height="140"></canvas>
        </div>
        
    </div>
    <div class="row mb-4">
        <div class="ibox-content text-center col-lg-12">
            <span class="label label-default" ></span> &nbsp; not started &nbsp;
            <span class="label label-warning" ></span> &nbsp; on progress &nbsp;
            <span class="label label-info" ></span> &nbsp; prepared and advanced &nbsp;
            <span class="label label-primary" ></span> &nbsp; prepared and ontime &nbsp;
            <span class="label label-danger" ></span> &nbsp; prepared but delayed &nbsp;
        </div>
    </div>
@endsection

@push('scripts')
<!-- ChartJS-->
<script src="{{asset('js/plugins/chartJs/Chart.min.js')}}"></script>
<script src="{{asset('js/demo/chartjs-demo.js')}}"></script>
<script src="{{asset('js/moment.min.js')}}"></script>

<script>
   $(document).ready(function(){

    // time
    var timestamp = '<? echo time();?>';
    function updateTime(){
    $('#time').html(moment(Date(timestamp)).format('DD/MM/YYYY HH:mm:ss'));
    timestamp++;
    }
    $(function(){
    setInterval(updateTime, 1000);
    });
       
    var cData = JSON.parse('<?php echo $data["chart"]; ?>');
    var barData = {
        labels: cData.label,
        datasets: [
            {
                label: "Preparation Ontime",
                backgroundColor: 'rgba(26,179,148,255)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: cData.ontime
            },
            {
                label: "Preparation Delay",
                backgroundColor: 'rgba(234, 13, 56, 0.8)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: cData.delay
            },
            {
                label: "Preparation Advanced",
                backgroundColor: 'rgba(35,198,200,255)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: cData.advanced
            },
            {
                label: "Preparation On Progress",
                backgroundColor: 'rgba(247, 167, 13, 0.8)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: cData.on_progress
            },
            {
                label: "Preparation Not Started",
                backgroundColor: 'rgba(209,218,222,255)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: cData.not_started
            },
        ]
    };

    var barOptions = {
        responsive: true
    };


    var ctx2 = document.getElementById("barChart").getContext("2d");
    new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
   });
</script>
@endpush




















