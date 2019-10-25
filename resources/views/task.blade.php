@extends('layout')
@section('content')
    <div class="layui-row" style="margin-top: 30px">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">任务名称</label>
                <div class="layui-input-block">
                    <input type="text" name="name" id="name" lay-verify="required" autocomplete="off"
                           placeholder="请输入标题"
                           value="{{$currentTask['name']??''}}" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">任务奖金</label>
                <div class="layui-input-block">
                    <input type="text" name="price" id="price" lay-verify="required" placeholder="请输入"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">任务类型</label>
                <div class="layui-input-block">
                    <input type="radio" name="type" value="0" title="普通任务" checked lay-filter="type">
                    <input type="radio" name="type"  id="type1" value="1" title="时间段任务" lay-filter="type">
                    <input type="radio" name="type"  value="2" title="定时统计任务" lay-filter="type">
                </div>
            </div>
            <div class="layui-form-item" id="remind">
                <div class="layui-inline">
                    <label class="layui-form-label">持续时间(选填)</label>
                    <div class="layui-input-inline">
                        <input type="text" name="duration" lay-verify="duration" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>


            <div class="layui-inline" id="check">
                <label class="layui-form-label">检查日期(选填)</label>
                <div class="layui-input-inline">
                    <input type="text" name="remind_time" id="remind_time" lay-verify="remind" placeholder="HH:mm:ss"
                           autocomplete="off" class="layui-input">
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

            //监听指定开关
            form.on('switch(switchTest)', function (data) {
                layer.msg('开关checked：' + (this.checked ? 'true' : 'false'), {
                    offset: '6px'
                });
                layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
            });

            //监听提交

            form.on('submit(demo1)', function (data) {
                var res = layui.jquery("#type1").attr('checked',true)
                console.log(res)
                alert(11);
                return false;
                var formData = data.field
                if (formData.type == 1) {
                    delete formData.remind_time
                } else if (formData.type == 2) {
                    delete formData.duration
                } else {
                    delete formData.duration
                    delete formData.remind_time
                }


                layui.jquery.post('/api/task', data.field, function (res) {
                    if (res.code == 0) {
                        alert("添加成功");
                        window.location.href = "/tasks";
                    } else {
                        alert(res.msg);
                    }
                })
            });

            form.on('radio(type)', function (data) {
                switchType(data.value)
            })

            function switchType(type) {
                if (type == 0) {
                    layui.jquery('#remind').hide()
                    layui.jquery('#check').hide()
                } else if (type == 1) {
                    layui.jquery('#remind').show()
                    layui.jquery('#check').hide()
                } else {
                    layui.jquery('#remind').hide()
                    layui.jquery('#check').show()
                }
            }

            @if($currentTask)
                var type = "{{$currentTask['type']}}";
                type = parseInt(type)
            switchType(type)
            @endif
        });



    </script>
@endsection
