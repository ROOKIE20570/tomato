@extends('layout')
@section('content')
    <div class="layui-row" style="margin-top: 30px">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">任务名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" id="name" lay-verify="title" autocomplete="off" placeholder="请输入标题"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">任务奖金</label>
            <div class="layui-input-block">
                <input type="text" name="price" id="price" lay-verify="required" lay-reqtext="用户名是必填项，岂能为空？" placeholder="请输入"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">任务类型</label>
            <div class="layui-input-block">
                <input type="radio" id="type" value="男" title="男" checked="">
                <input type="radio" id="type" value="女" title="女">
                <input type="radio" id="type" value="禁" title="禁用" disabled="">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">持续时间(选填)</label>
                <div class="layui-input-inline">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>


        <div class="layui-inline">
            <label class="layui-form-label">检查日期(选填)</label>
            <div class="layui-input-inline">
                <input type="text" name="date" id="remind_time" lay-verify="date" placeholder="HH:mm:ss"
                       autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">普通文本域</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>
        <!--<div class="layui-form-item layui-form-text">
          <label class="layui-form-label">编辑器</label>
          <div class="layui-input-block">
            <textarea class="layui-textarea layui-hide" name="content" lay-verify="content" id="LAY_demo_editor"></textarea>
          </div>
        </div>-->
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
        layui.use(['form', 'layedit', 'laydate'], function(){
            var form = layui.form
                ,layer = layui.layer
                ,layedit = layui.layedit
                ,laydate = layui.laydate;

            //日期
            laydate.render({
                elem: '#remind_time',
                type:'time'
            });

            //创建一个编辑器
            var editIndex = layedit.build('LAY_demo_editor');

            //自定义验证规则
            form.verify({
                title: function(value){
                    if(value.length < 5){
                        return '标题至少得5个字符啊';
                    }
                }
                ,pass: [
                    /^[\S]{6,12}$/
                    ,'密码必须6到12位，且不能出现空格'
                ]
                ,content: function(value){
                    layedit.sync(editIndex);
                }
            });

            //监听指定开关
            form.on('switch(switchTest)', function(data){
                layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
                    offset: '6px'
                });
                layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
            });

            //监听提交
            form.on('submit(demo1)', function(data){
                layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                })
                return false;
            });

            //表单赋值
            layui.$('#LAY-component-form-setval').on('click', function(){
                form.val('example', {
                    "username": "贤心" // "name": "value"
                    ,"password": "123456"
                    ,"interest": 1
                    ,"like[write]": true //复选框选中状态
                    ,"close": true //开关状态
                    ,"sex": "女"
                    ,"desc": "我爱 layui"
                });
            });

            //表单取值
            layui.$('#LAY-component-form-getval').on('click', function(){
                var data = form.val('example');
                alert(JSON.stringify(data));
            });

        });
    </script>
@endsection
