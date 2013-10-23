<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title><?php echo ($sysConfig["site_name"]); ?> </title>
<link id="mastercss" rel="stylesheet" href="__PUBLIC__/Admin/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="__PUBLIC__/Js/colorpicker/colorpicker.css" type="text/css">

<script type="text/javascript">
<!--
//指定当前组模块URL地址
var URL = '__URL__';
var APP	 =	 'admin.php';
var PUBLIC = '__PUBLIC__';
var ROOT = '__ROOT__';
//-->
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/Js/Jquery/jquery.js"></script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/Js/Jquery/jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/Js/Jquery/cmxforms.js"></script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/Js/script_common.js"></script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/Js/colorpicker/colorpicker.js"/></script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/Js/My97DatePicker/WdatePicker.js"/></script>
     <script charset="utf-8" src="__PUBLIC__/Js/editor/kindeditor-min.js"></script>
<script charset="utf-8" src="__PUBLIC__/Js/editor/lang/zh_CN.js"></script>
<script charset="utf-8" src="__PUBLIC__/Js/editor/plugins.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	  $("div.block>h2").click(function(){
		  
		   $(this).next().slideToggle(300);
		  
		  });
	});
</script>
<style>
.ke-container-default{ width:760px;}
</style>
</head>
<body>
<div id='loader' style='color:#ffffff;font-size:12px;background-color: #0099CC; width:140px; padding:2px 4px; height:20px; position: fixed;right:0px;top:2px; display:none'>提交中，请稍后...</div>
	<div id="wrap">
		<div id="header">
			<h2><a href="__APP__" title="YIGECMS"><img src="__PUBLIC__/Admin/logo.gif" alt="YIGECMS" /></a></h2>
			
			<div id="topmenu" class="gray">
			<span style="font-weight:bold">当前用户：<img src="__PUBLIC__/Admin/user.gif" alt="YIGECMS" align="absmiddle"/><?php echo ($username); ?></span> 　 
				<a href="<?php echo U('Admin/modify',array('id'=>$adminId, 'jumpUri'=>'run' ));?>"><img src="__PUBLIC__/Admin/user_modify.gif" alt="YIGECMS" align="absmiddle"/>我的帐户</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo U('Public/logout');?>"><img src="__PUBLIC__/Admin/logout.gif" alt="YIGECMS" align="absmiddle"/>退出系统</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo ($frontUrl); ?>" target="_blank"><img src="__PUBLIC__/Admin/home_25.gif" alt="YIGECMS" align="absmiddle"/>前台首页</a>
			</div>
			<ul id="menu" style="display:none">
				<li><a href="Admin.php">管理平台</a></li>
				<li><a href="Admin.php?ac=$value"><?php echo ($_TPL[menunames][$value]); ?></a></li>
			</ul><div id="later" style="position:fixed"></div>
		</div>
		<div id="content">
<div class="mainarea">
<div class="maininner">
<div class="block style4">
		<table cellspacing="3" cellpadding="3">
		<tr>
		 <th style="width:50px; text-align:center"><a href="http://www.YIGECMS.cn/manual.php?app=shuguangCorp&module=<?php echo ($moduleName); ?>" target="_blank"><img src="__PUBLIC__/Admin/help_1.gif" alt="" align="absmiddle" /><br />
帮助</a></th>
		  <td>1.禁用：暂时未启用模块，暂时不能管理，可重新启用<br />
2.卸载：彻底从系统中删除文件，包括(模板，控制器，模型，数据表)。此操作不可恢复</td>
		  </tr>
		</table>
	</div>

	<form method="post" action="Admin.php?ac=profilefield">
	<div class="body_content">

		<div class="top_action"><a href="<?php echo U("Module/index");?>">浏览模块</a> | <a href="<?php echo U("Module/install");?>">安装模块</a></div>
		<table cellspacing="0" cellpadding="0" id="maintable" class="formtable">
		
        <tr>
		<th>模块名称</th>
		<th>控制器</th>
		<th>版本</th>
		<th width="80">操作</th>
		</tr>
         <?php if(is_array($install)): $i = 0; $__LIST__ = $install;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td><?php echo ($vo["module_title"]); ?>(<strong><?php echo ($vo["module_name"]); ?></strong>) <?php if(($vo['system_module']) == "1"): ?><img src="__PUBLIC__/Admin/lock.gif" alt="内置模块锁定状态" align="absmiddle" /><?php endif; ?></td>
		<td><?php echo ($vo["module_name"]); ?>Action.class.php</td>
		<td><?php echo ($vo["build_version"]); ?></td>
		<td>
		  <a href="<?php echo U("Module/modify",array('id'=>$vo['id']));?>">编辑</a> <a href="<?php echo U("Module/uninstall",array('id'=>$vo['id']));?>" >卸载</a>
		  
		  </td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <tr>
		  <th colspan="4" class="style1" style="font-size:14px">系统内置</th>
		  </tr>
         
          <?php if(is_array($system)): $i = 0; $__LIST__ = $system;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td><?php echo ($vo["module_title"]); ?>(<strong><?php echo ($vo["module_name"]); ?></strong>) <?php if(($vo['system_module']) == "1"): ?><img src="__PUBLIC__/Admin/lock.gif" alt="内置模块锁定状态" align="absmiddle" /><?php endif; ?></td>
              <td><?php echo ($vo["module_name"]); ?>Action.class.php</td>
              <td><?php echo ($vo["build_version"]); ?></td>
              <td><a href="<?php echo U("Module/modify",array('id'=>$vo['id']));?>">查看</a> 
              </td>
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
           <tr>
		  <th colspan="4" class="style1" style="font-size:14px">禁用模块</th>
		  </tr>
         
          <?php if(is_array($disble)): $i = 0; $__LIST__ = $disble;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td><?php echo ($vo["module_title"]); ?>(<strong><?php echo ($vo["module_name"]); ?></strong>) <?php if(($vo['system_module']) == "1"): ?><img src="__PUBLIC__/Admin/lock.gif" alt="内置模块锁定状态" align="absmiddle" /><?php endif; ?></td>
              <td><?php echo ($vo["module_name"]); ?>Action.class.php</td>
              <td><?php echo ($vo["build_version"]); ?></td>
              <td>
		  <a href="<?php echo U("Module/modify",array('id'=>$vo['id']));?>">编辑</a> <a href="<?php echo U("Module/uninstall",array('id'=>$vo['id']));?>" >卸载</a>
		  
		  </td>
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
	
	<div class="foot_action">
		<div class="pages">共有模块：<?php echo ($count); ?> 个</div>
	</div>
	
	</form>
	
<!--{else}-->
</div>
</div>

<div class="side">
	<div class="block style1">

		<h2><div class="set">常规设置</div></h2>

		<ul class="folder">

        <li class="Index"> <a href="<?php echo U('Index/index');?>">后台首页</a></li>

		<li class="Config"><a href="<?php echo U("Config/index");?>">系统配置</a></li>

       

        <li class="Theme"><a href="<?php echo U("Theme/index");?>">风格模板</a></li>

        <li class="Admin"><a href="<?php echo U("Admin/index");?>">管理员管理</a></li>

        <li class="AdminRole"><a href="<?php echo U("AdminRole/index");?>">角色管理</a></li>

		</ul>

	</div>



	<div class="block style1">

		<h2><div class="mod">模块管理</div></h2>

		<ul class="folder">

          <?php if(is_array($leftBar)): $i = 0; $__LIST__ = $leftBar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lb): $mod = ($i % 2 );++$i;?><li class="<?php echo ($lb['module_name']); ?>"><a href='<?php echo U($lb['module_name']."/index");?>'><?php echo ($lb["module_title"]); ?></a>

                

                </li><?php endforeach; endif; else: echo "" ;endif; ?>

		</ul>

	</div>

	



	<div class="block style1">

		<h2><div class="gaoji">高级应用</div></h2>

		<ul class="folder">

        <li class="Tools"><a href="<?php echo U("Tools/index");?>">工具箱</a></li>

        <li class="Label"><a href="<?php echo U("Label/index");?>">数据调用</a></li>

        

   <?php if($jingtai==1){ ?>

        <li class="Html"><a href="<?php echo U("Html/index");?>">生成静态</a></li>

        

        <?php } ?>

     

		<li class="Database"><a href="<?php echo U("Database/index");?>">数据库管理</a></li>

		<li class="AdminLog"><a href="<?php echo U("AdminLog/index");?>">操作日志</a></li>

        <li><a href="http://www.YIGECMS.cn/manual.php" target="_blank">帮助中心</a></li>

		</ul>

	</div>


</div>
</div>
<div id="footer">
	<p> Copyright 2008-2010 <a href="#" target="_blank"></a>
</p>
</div>
</div>
<script type="text/javascript">
$(function(){ 
    $(".<?php echo ($moduleName); ?>").addClass("active");
    $(".confirmSubmit").click(function() {
        return confirm('本操作不可恢复，确定继续？');
    });
}); 
</script>
</body>
</html>