@extends('layout')
@section('content')

    <script type="text/html" id="operate">
        <a class="layui-btn layui-btn-xs" lay-event="finish">完成</a>
        <a class="layui-btn layui-btn-xs" lay-event="giveup">放弃</a>
        <a class="layui-btn layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script type="text/html" id="filter">
        <a class="layui-btn layui-btn-xs" lay-event="getRunning">进行中</a>
        <a class="layui-btn layui-btn-xs" lay-event="getFinished">已完成</a>
        <a class="layui-btn layui-btn-xs" lay-event="getGiveup">已放弃</a>
    </script>
    <table class="layui-hide" id="test" lay-filter="test"></table>

    <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->


    <script>
        layui.use('table', function () {
            var table = layui.table;

            table.render({
                elem: '#test'
                , url: '/api/wish?status=0',
                toolbar:'#filter'
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
                console.log(111);
                table.reload('wishes',{
                    url:'/api/wish',
                    where:{
                        status:status
                    }
                })
            }

            table.on('tool(test)', function (obj) {
                console.log(111);
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
                }
            });
            table.on('toolbar(test)', function (obj) {
                console.log(111);
                var data = obj.data;
                switch (obj.event) {
                    case 'getRunning':
                        reloadData(0);
                        break;
                    case 'getFinished':
                        reloadData(2);
                        break;
                    case 'getGiveup':
                        reloadData(1);
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