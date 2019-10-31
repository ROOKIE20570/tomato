@extends('layout')
@section('content')
    <div class="layui-row" style="margin-top: 30px">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">消费项目</label>
                <div class="layui-input-block">
                    <input type="text" name="name" id="name" lay-verify="required" autocomplete="off"
                           placeholder="请输入标题"
                           value="{{$currentCost['name']??''}}" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">消耗金币</label>
                <div class="layui-input-block">
                    <input type="text" name="price" id="price" lay-verify="required" placeholder="请输入"
                           autocomplete="off" class="layui-input" value="{{$currentCost['price']??''}}">
                </div>
            </div>





            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>


        </form>

        <!-- 示例-970 -->
        <ins class="adsbygoogle" style="display:inline-block;width:970px;height:90px"
             data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>


    </div>
    <script>
        layui.use(['form', 'layedit', 'laydate'], function () {
            var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;

            //日期
            laydate.render({
                elem: '#remind_time',
                type: 'time'
            });

            //创建一个编辑器
            var editIndex = layedit.build('LAY_demo_editor');

            //自定义验证规则
            form.verify({
            });

            //监听指定开关
            form.on('switch(switchTest)', function (data) {
                layer.msg('开关checked：' + (this.checked ? 'true' : 'false'), {
                    offset: '6px'
                });
                layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
            });

            //监听提交

            form.on('submit(demo1)', function (data) {
                @if($currentCost)
                layui.jquery.ajax(
                    {
                        type: "PUT",
                        url: "/api/cost/{{$currentCost['id']}}",
                        data:data.field,
                        success: function (res) {
                            if (res.code == 0) {
                                alert('更新成功');
                            } else {
                                alert('更新失败');
                            }

                            window.location.reload();

                        }
                    }
                );
                @else
                layui.jquery.post('/api/cost', data.field, function (res) {
                    if (res.code == 0) {
                        alert("添加成功");
                        window.location.href = "/costs";
                    } else {
                        alert(res.msg);
                    }
                })

                @endif
            });
        });



    </script>
@endsection
