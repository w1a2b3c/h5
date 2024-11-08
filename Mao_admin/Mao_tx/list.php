<?php
require '../../Mao/common.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='login.php';</script>");
if( $_SERVER['HTTP_REFERER'] == "" ){
    exit('404');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $mao['title']?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../css/admin.css" media="all">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md2"></div>
        <div class="layui-col-md8">
            <div class="layui-card">
                <div class="layui-card-header">
                    <fieldset class="layui-elem-field layui-field-title">
                        <legend>申请提现</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">提现金额</label>
                            <div class="layui-input-block">
                                <input type="number" id="price" autocomplete="off" placeholder="请输入提现金额" class="layui-input">
                            </div>
                        </div>
                    </form>
                    <button class="layui-btn site-demo-layedit" onclick="tx()"><i class="layui-icon">&#xe61f;</i> 申 请 提 现</button>
                </div>
            </div>
            <div class="layui-card">
                <div class="layui-card-header">
                    <fieldset class="layui-elem-field layui-field-title">
                        <legend>提现记录</legend>
                    </fieldset>
                </div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="list" lay-filter="list"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../layui/layui.js"></script>
<script>
    layui.config({
        base: '../' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','table'], function(){
        var table = layui.table;
        table.render({
            elem: '#list'
            ,url:'/Mao_admin/api.php?mod=list_tx'
            ,page:true
            ,cols: [[
                {field:'id',title: 'ID', width:80}
                ,{field:'price', title: '提现金额', width:330}
                ,{field:'time', title: '提现时间', width:330}
                ,{field:'zt', title: '提现状态', width:333}
            ]]
        });
    });
    function tx() {
        var loading = layer.load();
        $.ajax({
            url: '/Mao_admin/api.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mod: "add_tx",
                price: $('#price').val()
            },
            success: function (a) {
                layer.close(loading);
                if (a.code == 0) {
                    layer.msg(a.msg, function() {
                        location.reload();
                    });
                }else {
                    layer.msg(a.msg);
                }
            },
            error: function() {
                layer.close(loading);
                layer.msg('~连接服务器失败！', {icon: 5});
            }
        });
    }
</script>
</body>
</html>