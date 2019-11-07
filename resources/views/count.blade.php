@extends('layout')
@section('content')
    <script src="{{URL::asset('echarts.js')}}"></script>

    <div id="main" style="width: 600px;height:400px;"></div>


    <script>
        layui.use('layer',function () {
            layui.jquery.get('/api/wallet/recent?length=120',function (res) {
                console.log(res.data.amount)
                console.log(res.data.trigger)
                var myChart = echarts.init(document.getElementById('main'));

                var option = {

                    title: {

                        text: '最近金币统计'

                    },

                    tooltip: {},

                    legend: {

                        data: ['统计']

                    },

                    xAxis: {

                        data: res.data.trigger

                    },

                    yAxis: {},

                    series: [{

                        name: '金币',

                        type: 'line',

                        data: res.data.amount.reverse()

                    }]

                };

                myChart.setOption(option);
            })

        })

    </script>
@endsection
