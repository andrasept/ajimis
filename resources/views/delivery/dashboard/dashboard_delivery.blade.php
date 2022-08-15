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
<!-- Styles -->
<style>
    #chartdiv {
      width: 100%;
      height: 400px;
    }
</style>

<div class="ibox" >
  <div class="ibox-title">
      <h4>Delivery Achievement Today</h4>
  </div>
  <div class="ibox-content">
    <div class="row">
        <div class="col-lg-5"></div>
        <div class="col-lg-3">
            <form action="{{route('delivery.dashboard')}}" method="GET">
                @csrf
            <div class="form-group">
                <input type="date" class="form-control" name="start" id="start" value="">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input type="date" class="form-control" name="end" id="end" value="">
            </div>
        </div>
        <div class="col-lg-1">
            <button class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</div>
  <div class="ibox-content" >
    
    <!-- HTML -->
    <div id="chartdiv"></div>

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

    {{-- amchartjs --}}
    
            <!-- Resources -->
            <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
            <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
            <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                
            <!-- Chart code -->
            <script>
                am5.ready(function() {
                
                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("chartdiv");
                root.dateFormatter.setAll({
                dateFormat: "yyyy-MM-dd",
                dateFields: ["valueX", "openValueX"]
                });
                
                
                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                am5themes_Animated.new(root)
                ]);
                
                
                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "panX",
                wheelY: "zoomX",
                layout: root.verticalLayout
                }));
                
                
                // Add legend
                // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                var legend = chart.children.push(am5.Legend.new(root, {
                centerX: am5.p50,
                x: am5.p50
                }))
                
                var colors = chart.get("colors");
                
                // Data
                var data = [
                
                ];
                
                var data_json = '<?= $data?>';
                var data_decode = JSON.parse(data_json);
                var data_decode = data_decode.reverse();
                var date_arrival = '';
                var time_arrival = '';
                var date_departurel = '';
                var time_departurel = '';
                var color = null;
                var status_delivery = "";
                var status_preparation = "";
                
                data_decode.forEach(element => {
                    
                    // spit date & time
                    date_arrival = element.arrival_plan.split(' ')[0].split('-');
                    time_arrival = element.arrival_plan.split(' ')[1].split(':');
                    date_departure = element.departure_plan.split(' ')[0].split('-');
                    time_departure = element.departure_plan.split(' ')[1].split(':');
                    
console.log(element.departure_plan);
console.log(element.departure_plan.split(' ')[1].split(':')[1]-2);
                    //color status delivery
                    if (element.departure_status === null) {
                        color = am5.color(0x80b3e0);
                        status_delivery = "On Progress";
                    }else if (element.departure_status == '3') {
                        color = am5.color(0x30c4c9);
                        status_delivery = "Advanced";
                    } else if (element.departure_status == '5') {
                        color = am5.Color.brighten(colors.getIndex(9), 0);
                        status_delivery = "Delay";
                    } else if (element.departure_status == '4') {
                        status_delivery = "On Time";
                        color = am5.color(0x53a346);
                    } else if (element.departure_status == '6') {
                        status_delivery = "Pending";
                        color = am5.color(0xedea21);
                    } else if (element.departure_status == '7') {
                        status_delivery = "Pending Return";
                        color = am5.color(0xf5b642);
                    }else{
                        status_delivery = "On Progress";
                        color = am5.color(0x80b3e0);
                    }

                    //status preparation
                    if (element.status === null) {
                        status_preparation = "On Progress";
                    } else if (element.status == '3') {
                        status_preparation = "Advanced";
                    } else if (element.status == '4') {
                        status_preparation = "On Time";
                    } else if (element.status == '5') {
                        status_preparation = "Delay";
                    } else{
                        status_preparation = "On Progress";
                    }


                    data.push({
                        category: element.help_column,
                        start: new Date(date_arrival[0], parseInt(date_arrival[1]-1), date_arrival[2], time_arrival[0], parseInt(time_arrival[1]), time_arrival[2]).getTime(),
                        end: new Date(date_departure[0], parseInt(date_departure[1]-1), date_departure[2], time_departure[0],parseInt(time_departure[1]), time_departure[2]).getTime(),
                        columnSettings: {
                            fill: color
                        },
                        task: "[bold]Cycle "+element.cycle+"[/]\nDelivery : [bold]"+status_delivery+"[/], \nPreparation : [bold]"+status_preparation+"[/], ",
                    });
                });

                    console.log(data);
                
                
                
                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var yAxis = chart.yAxes.push(
                am5xy.CategoryAxis.new(root, {
                    categoryField: "category",
                    renderer: am5xy.AxisRendererY.new(root, {}),
                    tooltip: am5.Tooltip.new(root, {})
                })
                );
                
                yAxis.data.setAll(data);
                
                var xAxis = chart.xAxes.push(
                am5xy.DateAxis.new(root, {
                    baseInterval: { timeUnit: "minute", count: 1 },
                    renderer: am5xy.AxisRendererX.new(root, {})
                })
                );
                
                
                // Add series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                xAxis: xAxis,
                yAxis: yAxis,
                openValueXField: "start",
                valueXField: "end",
                categoryYField: "category",
                sequencedInterpolation: true
                }));
                
                series.columns.template.setAll({
                templateField: "columnSettings",
                strokeOpacity: 0,
                tooltipText: "{task}\n[bold]{openValueX}[/]"
                });
                
                series.data.setAll(data);
                
                // Add scrollbars
                chart.set("scrollbarX", am5.Scrollbar.new(root, { orientation: "horizontal" }));
                
                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear();
                chart.appear(1000, 100);
                
                }); // end am5.ready()
            </script>
    {{-- amchartjs --}}
@endpush












  