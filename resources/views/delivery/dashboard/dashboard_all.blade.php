{{-- {{dd($data)}} --}}

@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')

{{-- {{var_dump($data_achievment_persen);  }}
<br/>
{{var_dump($data_achievment_date);}} --}}
{{-- datatable library css --}}
    <link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">
<!-- Sweet Alert -->
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <style>
        .overlay{
            /* background:rgba(0,0,0,0.5); */
            position:absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            color: white;
            opacity: 1;
            -webkit-transition: opacity 0.5s;
            transition: opacity 0.5s;
            z-index: 999; 
        }
        
        .img_user{
          width: 50px;
          height: 50px;
          border:1px solid green;
        }
        
        img {
          /* display: block;  */
          
        }
        .layout_bg {
            position: relative;
            display: inline-block;
            z-index: 0  ;
        }
        
        .layout_bg:hover > .overlay {
            opacity: 1;
        }
    </style>
    <div class="ibox">
        <div class="ibox-title text-center">
            <h4>Henkaten Today</h4>
        </div>
        <div class="ibox-content">
            <div class="col-lg-5">
                <select name="select_shift" id="select_shift" class="form-control">
                    <option value="SHIFT 1">SHIFT 1</option>
                    <option value="SHIFT 2">SHIFT 2</option>
                </select>
            </div>
        </div>
        <div class="ibox-content">
            <div class="p-w-md m-t-sm ">
                <div class="layout_bg shift_1" style="width:100%">
                {{-- finish goods --}}
                <div class='overlay' style="padding-left: 650px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_preparation_pulling_1']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_preparation_pulling_1'], " ")}}</label></div>
                @if ($data['henkaten_preparation_pulling_1'] !='')
                    <div class='overlay' style="padding-left: 650px; padding-top:70px">
                    <img class="img_user" src="{{$data['henkaten_preparation_pulling_1']}}" alt="">
                    </div>
                @endif
                <div class='overlay' style="padding-left: 710px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_preparation_pulling_2']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_preparation_pulling_2']," ")}}</label></div>
                @if ($data['henkaten_preparation_pulling_2'] !='')
                    <div class='overlay' style="padding-left: 710px; padding-top:70px">
                    <img class="img_user" src="{{$data['henkaten_preparation_pulling_2']}}" alt="">
                    </div>
                @endif
                {{-- spare part --}}
                <div class='overlay' style="padding-left: 320px; padding-top:20px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_sparepart']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_sparepart']," ")}}</label></div>
                @if ($data['henkaten_sparepart'] !='')
                    <div class='overlay' style="padding-left: 320px; padding-top:20px">
                    <img class="img_user" src="{{$data['henkaten_sparepart']}}" alt="">
                    </div>
                @endif
                {{-- pulling sparepart --}}
                <div class='overlay' style="padding-left: 320px; padding-top:100px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_pulling_oem_1']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_pulling_oem_1']," ")}}</label></div>
                @if ($data['henkaten_pulling_oem_1'] !='')
                    <div class='overlay' style="padding-left: 320px; padding-top:100px">
                    <img class="img_user" src="{{$data['henkaten_pulling_oem_1']}}" alt="">
                    </div>
                @endif
                {{-- preparation --}}
                <div class='overlay' style="padding-left: 600px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_preparation']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_preparation']," ")}}</label></div>
                @if ($data['henkaten_preparation'] !='')
                    <div class='overlay' style="padding-left: 600px; padding-top:70px">
                    <img class="img_user" src="{{$data['henkaten_preparation']}}" alt="">
                    </div>
                @endif
                <div class='overlay' style="padding-left: 510px; padding-top:0px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_packaging_2']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_packaging_2'], " ")}}</label></div>
                @if ($data['henkaten_packaging_2'] !='')
                    <div class='overlay'  style="padding-left: 510px; padding-top:0px">
                    <img class="img_user" src="{{$data['henkaten_packaging_2']}}" alt="">
                    </div>
                @endif
                <div class='overlay' style="padding-left: 440px; padding-top:100px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_pulling_oem_2']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_pulling_oem_2']," ")}}</label></div>
                @if ($data['henkaten_pulling_oem_2'] !='')
                    <div class='overlay' style="padding-left: 440px; padding-top:100px">
                    <img class="img_user" src="{{$data['henkaten_pulling_oem_2']}}" alt="">
                    </div>
                @endif
                {{-- packaging --}}
                <div class='overlay' style="padding-left: 450px; padding-top:0px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_packaging_1']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_packaging_1'], " ");}}</label></div>
                @if ($data['henkaten_packaging_1'] !='')
                    <div class='overlay' style="padding-left: 450px; padding-top:0px">
                    <img class="img_user" src="{{$data['henkaten_packaging_1']}}" alt="">
                    </div>
                @endif
                {{-- admin delivery --}}
                <div class='overlay' style="padding-left: 770px; padding-top:85px">
                    <img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data['photo_delivery_control']}}" alt="">
                    <br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data['nama_delivery_control'], " ")}}</label>
                </div>
                @if ($data['henkaten_delivery_control'] !='')
                    <div class='overlay' style="padding-left: 770px; padding-top:85px">
                    <img class="img_user" src="{{$data['henkaten_delivery_control']}}" alt="">
                    </div>
                @endif
                </div>
                <div class="layout_bg shift_2 d-none" style="width:100%">
                {{-- finish goods --}}
                <div class='overlay' style="padding-left: 650px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data2['photo_preparation_pulling_1']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data2['nama_preparation_pulling_1'], " ")}}</label></div>
                @if ($data2['henkaten_preparation_pulling_1'] !='')
                    <div class='overlay' style="padding-left: 650px; padding-top:70px">
                    <img class="img_user" src="{{$data2['henkaten_preparation_pulling_1']}}" alt="">
                    </div>
                @endif
                <div class='overlay' style="padding-left: 710px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data2['photo_preparation_pulling_2']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data2['nama_preparation_pulling_2']," ")}}</label></div>
                @if ($data2['henkaten_preparation_pulling_2'] !='')
                    <div class='overlay' style="padding-left: 710px; padding-top:70px">
                    <img class="img_user" src="{{$data2['henkaten_preparation_pulling_2']}}" alt="">
                    </div>
                @endif
                {{-- spare part --}}
                <div class='overlay' style="padding-left: 320px; padding-top:20px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data2['photo_sparepart']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data2['nama_sparepart']," ")}}</label></div>
                @if ($data2['henkaten_sparepart'] !='')
                    <div class='overlay' style="padding-left: 320px; padding-top:20px">
                    <img class="img_user" src="{{$data2['henkaten_sparepart']}}" alt="">
                    </div>
                @endif
                {{-- pulling sparepart --}}
                <div class='overlay' style="padding-left: 320px; padding-top:100px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data2['photo_pulling_oem_1']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data2['nama_pulling_oem_1']," ")}}</label></div>
                @if ($data2['henkaten_pulling_oem_1'] !='')
                    <div class='overlay' style="padding-left: 320px; padding-top:100px">
                    <img class="img_user" src="{{$data2['henkaten_pulling_oem_1']}}" alt="">
                    </div>
                @endif
                {{-- preparation --}}
                <div class='overlay' style="padding-left: 600px; padding-top:70px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data2['photo_preparation']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data2['nama_preparation']," ")}}</label></div>
                @if ($data2['henkaten_preparation'] !='')
                    <div class='overlay' style="padding-left: 600px; padding-top:70px">
                    <img class="img_user" src="{{$data2['henkaten_preparation']}}" alt="">
                    </div>
                @endif
                <div class='overlay' style="padding-left: 510px; padding-top:0px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data2['photo_packaging_2']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data2['nama_packaging_2'], " ")}}</label></div>
                @if ($data2['henkaten_packaging_2'] !='')
                    <div class='overlay'  style="padding-left: 510px; padding-top:0px">
                    <img class="img_user" src="{{$data2['henkaten_packaging_2']}}" alt="">
                    </div>
                @endif
                <div class='overlay' style="padding-left: 440px; padding-top:100px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data2['photo_pulling_oem_2']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data2['nama_pulling_oem_2']," ")}}</label></div>
                @if ($data2['henkaten_pulling_oem_2'] !='')
                    <div class='overlay' style="padding-left: 440px; padding-top:100px">
                    <img class="img_user" src="{{$data2['henkaten_pulling_oem_2']}}" alt="">
                    </div>
                @endif
                {{-- packaging --}}
                <div class='overlay' style="padding-left: 450px; padding-top:0px"><img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data2['photo_packaging_1']}}" alt=""><br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data2['nama_packaging_1'], " ");}}</label></div>
                @if ($data2['henkaten_packaging_1'] !='')
                    <div class='overlay' style="padding-left: 450px; padding-top:0px">
                    <img class="img_user" src="{{$data2['henkaten_packaging_1']}}" alt="">
                    </div>
                @endif
                {{-- admin delivery --}}
                <div class='overlay' style="padding-left: 770px; padding-top:85px">
                    <img class="img_user" onerror="this.onerror=null;this.src='{{asset('/image/nouser.png')}}';"  src="{{$data2['photo_delivery_control']}}" alt="">
                    <br><label for="" style="color: black;font-weight:bold;font-size:10;">{{strtok($data2['nama_delivery_control'], " ")}}</label>
                </div>
                @if ($data2['henkaten_delivery_control'] !='')
                    <div class='overlay' style="padding-left: 770px; padding-top:85px">
                    <img class="img_user" src="{{$data2['henkaten_delivery_control']}}" alt="">
                    </div>
                @endif
                </div>
                <img  src="{{asset('/image/layout.png')}}" width="800px" height="200px" alt="thumb">
            <div>
        </div>
    </div>
</div>
    


    <div class="row mt-3 ">
        <div class="ibox  col-lg-6">
            <div class="ibox-title text-center">
                <h4>Preparation Today</h4>
            </div>
            <div class="ibox-content">
                <table id="master" class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Result Preparation</th>
                        <th class="text-center">Plan Preparation </th>
                        <th class="text-center">PIC Preparation</th>
                        <th class="text-center">Shift</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_preparation_dari_table as $item)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{$item->help_column}}</td>
                                <td class="text-center">
                                    @if ($item->status == '1')
                                        <label class="label label-warning ">on Progress</label>
                                    @elseif($item->status == '3')
                                        <label class="label label-info">Advanced</label>
                                    @elseif($item->status == '4')
                                        <label class="label label-primary">On time</label>
                                    @elseif($item->status == '5')
                                        <label class="label label-danger">Delayed</label>
                                    @else
    
                                    @endif
                                </td>
                                <td class="text-center">{{$item->plan}}</td>
                                <td class="text-center">{{$item->pic}}</td>
                                <td class="text-center">{{$item->shift}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="col-lg-1"></div> --}}
        <div class="ibox col-lg-6">
            <div class="ibox-title text-center">
                <h4>Delivery Today</h4>
            </div>
            <div class="ibox-content">
                <table id="master" class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Plan Arrival </th>
                        <th class="text-center">Plan Departure </th>
                        <th class="text-center">Result Arrival</th>
                        <th class="text-center">Result Departure</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_preparation_dari_table as $item)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{$item->help_column}}</td>
                                <td class="text-center">{{$item->arrival_plan}}</td>
                                <td class="text-center">{{$item->departure_plan}}</td>
                                <td class="text-center">
                                    @if ($item->arrival_status == '4')
                                        <label class="label label-primary">On Time</label>
                                    @elseif($item->arrival_status == '3')
                                        <label class="label label-info">Advanced</label>
                                    @elseif($item->arrival_status == '8')
                                        <label class="label label-info">Advanced Return</label>
                                    @elseif($item->arrival_status == '9')
                                        <label class="label label-primary">On Time Return</label>
                                    @elseif($item->arrival_status == '10')
                                        <label class="label label-danger">Delay Return</label>
                                    @elseif($item->arrival_status == null)
    
                                    @else
                                        <label class="label label-danger">Delayed</label>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->departure_status == '4')
                                        <label class="label label-primary">On Time</label>
                                    @elseif($item->departure_status == '3')
                                        <label class="label label-info">Advanced</label>
                                    @elseif($item->departure_status == '6')
                                        <label class="label label-warning">Pending</label>
                                    @elseif($item->departure_status == '7')
                                        <label class="label label-warning">Pending Milkrun Ready</label>
                                    @elseif($item->departure_status == null)
    
                                    @else
                                        <label class="label label-danger">Delayed</label>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="ibox">
        <div class="ibox-title text-center">
            <h4>Delivery Achievement per {{date('F')}}</h4>
        </div>
        <div class="ibox-content">
            <canvas id="chart" height="100"></canvas>
        </div>
    </div>
    <div class="ibox">
        <div class="ibox-title text-center">
            <h4>Claim Customer</h4>
        </div>
        <div class="ibox-content">
            <canvas id="chart2" height="100"></canvas>
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
       $(document).ready(function(){
         // huruf kecil table
            $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
            $("select").css({fontSize:12});
        $("#select_shift").change(function(){
            if (this.value == "SHIFT 1") {
            $('.shift_1').removeClass('d-none');
            $('.shift_2').addClass('d-none');
            } else {
            $('.shift_2').removeClass('d-none');
            $('.shift_1').addClass('d-none');
            }
        });
        // chart delivery achievement
            var cData = JSON.parse('<?php echo $data_achievment_persen; ?>');
            var cLabel= JSON.parse('<?php echo $data_achievment_date; ?>');
            
            
            var barData = {
                labels:cLabel,
                datasets: [{
                    label: "Percentage(%)",
                    backgroundColor: 'rgba(26,179,148,0.5)',
                    borderColor: "rgba(26,179,148,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: cData
                },] ,
                scales: {
                    y: { 
                        grid: { borderDash: [3, 5] },
                        ticks: {stepSize: 10, max : 100,    
                        min : 0},
                    }
                }
            };

            var barOptions = {
                responsive: true
            };

            var ctx2 = document.getElementById("chart").getContext("2d");
            new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});

        // chart delivery claim
            var claim_date = JSON.parse('<?php echo $claim_date; ?>');
            var miss_part = JSON.parse('<?php echo $miss_part; ?>');
            var mix_part = JSON.parse('<?php echo $mix_part; ?>');
            var miss_label = JSON.parse('<?php echo $miss_label; ?>');
            var miss_quantity = JSON.parse('<?php echo $miss_quantity; ?>');
            
            
            var barData2 = {
                labels:claim_date,
                datasets: [
                    {
                        label: "miss part",
                        backgroundColor: 'rgba(26,179,148,0.5)',
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: miss_part
                    },
                    {
                        label: "mix part",
                        backgroundColor: 'rgba(220, 220, 220, 0.5)',
                        pointBorderColor: "#fff",
                        data: mix_part
                    },
                    {
                        label: "miss label",
                        backgroundColor: 'rgba(73, 67, 70, 0.5)',
                        pointBorderColor: "#fff",
                        data: miss_label
                    },
                    {
                        label: "miss quantity",
                        backgroundColor: 'rgba(223, 102, 27, 0.5)',
                        pointBorderColor: "#fff",
                        data: miss_quantity
                    },
                ] ,
                scales: {
                    y: { 
                        grid: { borderDash: [3, 5] },
                        ticks: {stepSize: 10, max : 10,    
                        min : 0},
                    }
                }
            };

            var ctx2 = document.getElementById("chart2").getContext("2d");
            new Chart(ctx2, {type: 'bar', data: barData2, options:barOptions});
        
       
      
        });
    </script>
    <!-- ChartJS-->
    <script src="{{asset('js/plugins/chartJs/Chart.min.js')}}"></script>
    <script src="{{asset('js/demo/chartjs-demo.js')}}"></script>

       
@endpush












  