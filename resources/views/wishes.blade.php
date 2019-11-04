@extends('layout')
@section('content')
    <ul class="layui-nav">
        <li class="layui-nav-item layui-this" lay-event="getRunning"><a href="javascript:;">进行中</a></li>
        <li class="layui-nav-item" lay-event="getFinished"><a href="javascript:;">已完成</a></li>
        <li class="layui-nav-item" lay-event="getGiveup"><a href="javascript:;">已放弃</a></li>
    </ul>
    <script type="text/html" id="operate">
        <a class="layui-btn layui-btn-xs" lay-event="finish">完成</a>
        <a class="layui-btn layui-btn-xs" lay-event="giveup">放弃</a>
        <a class="layui-btn layui-btn-xs" lay-event="del">删除</a>
    </script>
    <table class="layui-hide" id="test" lay-filter="test"></table>

    <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->


    <script>
        layui.use('table', function () {
            var table = layui.table;

            table.render({
                elem: '#test'
                , url: '/api/wish?status=0',
                toolbar: '#operate'
                , cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
                , cols: [[
                    {field: 'wish', title: '消费项目'},
                    {field: 'price', title: '消耗金币'},
                    {fixed: 'right', title: '操作', toolbar: '#operate'}


                ]],
                id:'wishes',
                page: true,
            });

            function reloadData(status)
            {
                table.reload('wishes',{
                    url:'/api/status',
                    where:{
                        key:{
                            status:status
                        }
                    }
                })
            }

            table.on('tool(test)', function (obj) {
                var data = obj.data;
                switch (obj.event) {
                    case 'finish':
                        dealWish(data.id,2);
                        break;
                    case 'giveup':
                        dealWish(data.id,1);
                        break;
                    case 'del':
                        del(data.id);
                        break;
                    case 'getRunning':
                        reloadData(0);
                        break;
                    case 'getFinished':
                        reloadData(1);
                        break;
                    case 'getGiveUp':
                        reloadData(2);
                        break;
                }
            });
        });

        function dealWish(id, status) {
            layui.jquery.ajax(
                {
                    type: "PUT",
                    url: "/api/wish/complete/"+id,
                    data:{status:status},
                    success: function (res) {
                        if (res.code == 0) {
                            alert('更新成功');
                        } else {
                            alert('更新失败');
                        }

                        window.location.reload();

                    }
            });
        }

        function del(id) {
            layui.jquery.ajax({
                    type: "DELETE",
                    url: "/api/wish/" + id,
                    success: function (res) {
                        if (res.code == 0) {
                            alert('删除成功');
                        } else {
                            alert('删除失败');
                        }

                        window.location.reload();

                    }
                }
            )
        }
    </script>

@endsection