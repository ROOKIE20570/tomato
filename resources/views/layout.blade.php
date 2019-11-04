<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TOMATO</title>
    <link rel="stylesheet" href="{{URL::asset('layui/css/layui.css')}}">
    <script src="{{URL::asset('layui/layui.js')}}"></script>

</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">Tamato</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">消费项目</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/costs">消费项目</a></dd>
                        <dd><a href="/cost">新增消费项目</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">任务</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/tasks">任务列表</a></dd>
                        <dd><a href="/task">新增任务</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">日报</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/diarys">日报列表</a></dd>
                        <dd><a href="/diary">新增日报</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">任务记录</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/records">任务记录</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        @yield('content')
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © Tamato
    </div>
</div>

</body>
<script>
    layui.use('layer', function () {
        layui.jquery('body').on('keyup', function (e) {
            //我这里是监控空格和回车键
            if (e.keyCode == 13) {
                layui.jquery.get('/api/wallet',function (res) {
                    layer.msg("钱包总额为 -- "+res.data)
                })

            }
            //do something

        });
    });
    layui.use('element', function () {
        var element = layui.element;
    });
</script>
</html>