@extends('layout')
@section('content')
    <div class="layui-row" style="margin-top: 30px">
        <form class="layui-form" action="">
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">日志内容</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" name="content" class="layui-textarea">{{$diary['content']??''}}</textarea>
                </div>
            </div>
            @if(!$diary)
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
            @endif

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
                title: function (value) {
                    if (value.length < 5) {
                        return '标题至少得5个字符啊';
                    }
                }
                , pass: [
                    /^[\S]{6,12}$/
                    , '密码必须6到12位，且不能出现空格'
                ]
                , content: function (value) {
                    layedit.sync(editIndex);
                },
                duration: function (value) {
                    var type = layui.jquery("#").val();
                    switch (type) {
                        case "1":
                            console.log(parseInt(value));
                            if (isNaN(parseInt(value))) {
                                return '当选择时间段任务时 持续时间不能为空'
                            }
                            break;
                        default:
                            break;
                    }
                },
                remind_time: function (value) {
                    var type = layui.jquery("input[name='type']:checked").val();
                    if (type == 2) {
                        if ($('#remind_time').val() == '') {
                            return '当选择定时统计任务 提醒时间不能为空'
                        }
                    }
                }
            });
            //监听提交

            form.on('submit(demo1)', function (data) {

                layui.jquery.post('/api/diary', data.field, function (res) {
                    if (res.code == 0) {
                        alert("添加成功");
                        window.location.href = "/diarys";
                    } else {
                        alert(res.msg);
                    }
                })

            });


        });



    </script>
@endsection
