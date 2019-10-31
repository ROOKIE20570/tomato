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
                , url: '/api/task',
                toolbar: '#operate'
                , cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
                , cols: [[
                    {field: 'name', title: '任务名称'}
                    , {field: 'price', title: '任务赏金'}
                    , {
                        field: 'type', title: '任务计算类型', templet: function (d) {
                            switch (d.type) {
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
                        field: 'duration', title: '任务持续时长(限时间段任务)', templet: function (d) {
                            if (d.type == 1) {
                                return formatSeconds(d.duration);
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        field: 'remind_time', title: '提醒时间(限定时统计任务)', templet: function (d) {
                            if (d.type == 2) {
                                return '每天 ' + d.remind_time
                            } else {
                                return '';
                            }
                        }
                    },
                    {fixed: 'right', title: '操作', toolbar: '#operate'}


                ]],
                page: true,
            });

            table.on('tool(test)', function (obj) {
                var data = obj.data;
                switch (obj.event) {
                    case 'trigger':
                        taskTrigger(data.id)
                        break;
                    case 'del':
                        layer.confirm('确定删除该行吗', function (index) {
                            del(data.id);
                            layer.close(index)
                        })
                        break;
                    case 'edit':
                        edit(data.id);
                        break
                }
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
                    url: "/api/task/" + id,
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

        function taskTrigger(id){
            layui.jquery.ajax({
                    type: "PUT",
                    url: "/api/task/trigger/" + id,
                    success: function (res) {
                        if (res.code == 0) {
                            alert('触发成功');
                        } else {
                            alert(res.msg);
                        }

                        window.location.reload();

                    },
                    error:function (res,t) {
                        console.log(res)
                        alert('该种任务无需触发')
                    }
                }
            )
        }
    </script>

@endsection