@extends('layout')
@section('content')
    <script type="text/html" id="operate">
        <a class="layui-btn layui-btn-xs" lay-event="trigger">触发</a>
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <table class="layui-hide" id="test" lay-filter="test"></table>

    <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->


    <script>
        layui.use('table', function () {
            var table = layui.table;

            table.render({
                elem: '#test'
                , url: '/api/task_record'
                , cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
                , cols: [[
                    {field: 'task_name', title: '任务名称'}
                    , {
                        field: 'task_type', title: '任务计算类型', templet: function (d) {

                            switch (d.task_type) {
                                case 0:
                                    return '普通任务';
                                    break;
                                case 1:
                                    return '时间段任务';
                                    break;
                                case 2:
                                    return '定时统计任务';
                                    break;
                                default:
                                    return '';
                            }
                        }
                    },
                    {
                        field: 'status', title: '状态', templet: function (d) {
                            switch (d.status) {
                                case 0:
                                    return '进行中';
                                    break;
                                case 1:
                                    return '待确认';
                                    break;
                                case 2:
                                    return '已成功';
                                    break;
                                case 3:
                                    return '未完成';
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },
                    {
                        field: 'updated_at', title: '完成时间'
                    },
                    {
                        fixed: 'right', title: '操作', templet: function (d) {
                            switch (d.status) {
                                case 0:
                                    return '进行中'
                                    break;
                                case 1:
                                    return '<a class="layui-btn layui-btn-xs" onclick="confirmStatus('+d.id+',2)">已完成</a>\n' +
                                        '<a class="layui-btn layui-btn-xs" onclick="confirmStatus('+d.id+',3)">未完成</a>'
                                    break;
                                case 2:
                                    return '已完成';
                                    break;
                                case 3:
                                    return '未完成';
                                    break;
                                default:
                                    return ''
                            }
                        }
                    },


                ]],
                page: true,
            });
        });


        function formatSeconds(value) {

            var theTime = parseInt(value);// 秒
            var middle = 0;// 分
            var hour = 0;// 小时

            if (theTime > 60) {
                middle = parseInt(theTime / 60);
                theTime = parseInt(theTime % 60);
                if (middle > 60) {
                    hour = parseInt(middle / 60);
                    middle = parseInt(middle % 60);
                }
            }
            var result = "" + parseInt(theTime) + "秒";
            if (middle > 0) {
                result = "" + parseInt(middle) + "分" + result;
            }
            if (hour > 0) {
                result = "" + parseInt(hour) + "小时" + result;
            }
            return result;
        }

        function del(id) {
            layui.jquery.ajax({
                    type: "DELETE",
                    url: "/api/task_record/" + id,
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

        function edit(id) {
            window.location.href = '/task/' + id;
        }

        function confirmStatus(id,status) {
            layui.jquery.ajax({
                    type: "PUT",
                    url: "/api/task_record/" + id,
                    data:{status:status},
                    success: function (res) {
                        if (res.code == 0) {
                            alert('成功');
                        } else {
                            alert(res.msg);
                        }

                        window.location.reload();

                    },
                    error: function (res, t) {
                        console.log(res)
                        alert('失败')
                    }
                }
            )
        }
    </script>

@endsection