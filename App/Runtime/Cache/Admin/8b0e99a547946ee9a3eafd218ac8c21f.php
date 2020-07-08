<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>小票</title>
<style>
body {
margin: 0px;
padding: 0px;
font-size: 22px;
}
hr{width: 100%; border: 1px dashed black;}
/*****************
小票
*****************/
.table .title{
font-size:14px;
}
.table{
width:100%;
}
.table .left{
text-align:right;
}
</style>
</head>
<body>
<table class="table">
<tr>
<td align="center" class="title">ABC学校</td>
</tr>
<tr>
<td align="center">小票</td>
</tr>
<tr>
<td><hr size="1" /></td>
</tr>
</table>
<table class="table">
<caption>
<col style="width:40%">
<col style="width:60%">
</caption>
<tbody>
<tr>
<td class="left">签到时间：</td>
<td class="right">2015年10月19日 15：30</td>
</tr>
<tr>
<td class="left">学员姓名：</td>
<td class="right">周深</td>
</tr>
<tr>
<td class="left">班级：</td>
<td class="right">少儿班</td>
</tr>
<tr>
<td class="left">学校名称：</td>
<td class="right">ABC学院</td>
</tr>
<tr>
<td colspan="2"><hr size="1" /></td>
</tr>
</tbody>
</table>
<table class="table">
<caption>
<col style="width:40%">
<col style="width:60%">
</caption>
<tbody>
<tr>
<td class="left">卡信息：</td>
<td class="right">季卡/60次</td>
</tr>
<tr>
<td class="left">卡余额：</td>
<td class="right">32次</td>
</tr>
<tr>
<td class="left">到期日期：</td>
<td class="right">无限期</td>
</tr>
<tr>
<td class="left">激活日期：</td>
<td class="right">2015-09-08</td>
</tr>
<tr>
<td colspan="2"><hr size="1" /></td>
</tr>
</tbody>
</table>
<table class="table">
<tr>
<td align="center">感谢您的惠顾！<br/>请保管好小票，如有问题，请出示，谢谢！</td>
</tr>
<tr>
<td align="center"><img src="code.png" class="code"/><br/>扫码查详情</td>
</tr>

</table>
</body>
</html>