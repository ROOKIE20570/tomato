@extends('layout')
@section('content')
    <script type="text/html" id="operate">
        <a class="layui-btn layui-btn-xs" lay-event="view">查看</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <table class="layui-hide" id="test" lay-filter="test"></table>

    <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->


    <script>
        layui.use('table', function () {
            var table = layui.table;

            table.render({
                elem: '#test'
                , url: '/api/diary',
                toolbar: '#operate'
                , cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
                , cols: [[
                    {
                        field: 'created_at', title: '日志日期', templet: function (d) {
                            console.log(d.created_at);
                            return d.created_at.substring(0,10);
                        }
                    },
                    {
                        field: 'content', title: '内容', templet: function (d) {
                            var content = d.content;
                            var length = content.length;
                            content = content.substring(0, 50);
                            if (length > 30) {
                                content = content + "..."
                            }

                            return content
                        }
                    },
                    {fixed: 'right', title: '操作', toolbar: '#operate'}


                ]],
                page: true,
            });

            table.on('tool(test)', function (obj) {
                var data = obj.data;
                switch (obj.event) {
                    case 'view':
                        view(data.id)
                        break;
                    case 'del':
                        layer.confirm('确定删除该行吗', function (index) {
                            del(data.id);
                            layer.close(index)
                        })
                        break;
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
                    url: "/api/diary/" + id,
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

        function view(id) {
            window.location.href = '/diary/' + id;
        }
    </script>

@endsection