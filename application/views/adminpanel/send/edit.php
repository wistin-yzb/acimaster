<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<style>
	.line-s{height:30px;line-height:30px !important;}
	.tgl{text-align:left !important;}
	.tipmsg{font-size:12px;height:33px;line-height:33px;background-color:whitesmoke;}
	.edit_send_time{position:relative;top:.6rem;}
	#template_number>.tps{padding: 0 20px 0 0;font-size: 14px;position: relative;top: 5px;height: 33px;line-height: 33px;}
</style>
<form class="form-horizontal" role="form" id="validateform" name="validateform" action="<?php echo current_url()?>" >
<div class='panel panel-default'>
	<div class='panel-heading'>
		<i class='icon-edit icon-large'></i>
		<?php echo $is_edit?"修改":"新增"?>群发模板消息
		<div class='panel-tools'>

			<div class='btn-group'>
				<?php aci_ui_a($folder_name,'send','index','',' class="btn  btn-sm "','<span class="glyphicon glyphicon-arrow-left"></span> 返回')?>
			</div>
		</div>
	</div>
	<div class='panel-body'>
		<fieldset>
				<legend class="tipmsg">提示：要求账号为服务号并认证，对所有用户发送时需准守微信公众平台行为规范。PRID：sUroer1rqkwvMVL4pQK2GYk4itRb_qLacN_FzAZ5i5E</legend>
				  <!--/.diy style-->
				  <legend style="font-size:12px;">
				  模板消息仅用于公众号向用户发送重要的服务通知，只能用于符合其要求的服务场景中，如信用卡刷卡通知，商品购买成功通知等。不支持广告等营销类消息以及其它所有可能对用户造成骚扰的消息。<br/>
                 <br/>
                  关于使用规则，请注意：<br/>
				  1、所有服务号都可以在功能->添加功能插件处看到申请模板消息功能的入口，但只有认证后的服务号才可以申请模板消息的使用权限并获得该权限；<br/>
                  2、需要选择公众账号服务所处的2个行业，每月可更改1次所选行业；<br/>
                  3、在所选择行业的模板库中选用已有的模板进行调用；<br/>
                  4、每个账号可以同时使用25个模板。<br/>
                  5、<font color="red">当前每个账号的模板消息的日调用上限为10万次</font>，单个模板没有特殊限制。【2014年11月18日将接口调用频率从默认的日1万次提升为日10万次，可在MP登录后的开发者中心查看】。当账号粉丝数超过10W/100W/1000W时，模板消息的日调用上限会相应提升，以公众号MP后台开发者中心页面中标明的数字为准。
                          <a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433751277" target="_blank"><font color="blue">文档详情</font>&gt;&gt;</a>  
                  </legend>                        
                     <div class="form-group">
						<label class="col-sm-2 control-label">公众号<font color="red">*</font></label>
						<div class="col-sm-2">
						  <select name="service_id" id="service_id" class="form-control" >
						         <option value=0 data-appid="0" data-appsecret="0">===请选择===</option>
						         <?php foreach ($service_list as $k => $v): ?>
						        <option value=<?php echo $v['service_id']?> data-appid="<?php echo $v['app_id']?>" data-appsecret="<?php echo $v['app_secret']?>"><?php echo $v['account_name'] ?></option>
						        <?php endforeach; ?>
						  </select>
						</div>
					</div>  
					<div class="form-group">
						<label class="col-sm-2 control-label">模板编号<font color="red">*</font></label>
						<div class="col-sm-8" id="template_number"></div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">发送对象</label>
						<div class="col-sm-4">
						    <span class="line-s" style="font-size:9px;">当前公众号下关注的所有用户</span>
						</div>
					</div>
					<div  class="form-group" style="font-size:16px;width:50%;height:33px;line-height:33px;background-color:honeydew;border:1px solid #eee;">
					         <label  class="col-sm-2 control-label"></label>					         
					       <div class="col-sm-4"> 模板内容</div>
					 </div>
					<div class="form-group">
						<label  class="col-sm-2 control-label">开头first<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="first" type="text" class="form-control" id="first" placeholder="(必填)" value="<?php echo $data_info['first']?>" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间keyword1<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="keyword1" type="text" class="form-control" value="<?php echo $data_info['keyword1']?>" id="keyword1" placeholder="(必填)" size="120" />
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-2 control-label">中间keyword2<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="keyword2" type="text" class="form-control" value="<?php echo $data_info['keyword2']?>" id="keyword2" placeholder="(必填)" size="120" />
						</div>
					</div> 
                   <div class="form-group">
						<label class="col-sm-2 control-label">中间keyword3<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="keyword3" type="text" class="form-control" value="<?php echo $data_info['keyword3']?>" id="keyword3" placeholder="(必填)" size="120" />
						</div>
					</div>           
					<div class="form-group">
						<label class="col-sm-2 control-label">中间keyword4</label>
						<div class="col-sm-4">
						  <input name="keyword4" type="text" class="form-control" value="<?php echo $data_info['keyword4']?>" id="keyword4" placeholder="" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间keyword5</label>
						<div class="col-sm-4">
						  <input name="keyword5" type="text" class="form-control" value="<?php echo $data_info['keyword5']?>" id="keyword5" placeholder="" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间invest_style</label>
						<div class="col-sm-4">
						  <input name="invest_style" type="text" class="form-control"  value="<?php echo $data_info['invest_style']?>" id="invest_style" placeholder="" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间invest_profit</label>
						<div class="col-sm-4">
						  <input name="invest_profit" type="text" class="form-control" value="<?php echo $data_info['invest_profit']?>" id="invest_profit" placeholder="" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">结尾remark</label>
						<div class="col-sm-4">
						  <textarea name="remark"  id="remark" class="form-control"><?php echo $data_info['remark']?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">跳转链接url</label>
						<div class="col-sm-4">
						  <input name="url" type="text" class="form-control" value="<?php echo $data_info['url']?>" id="url" placeholder="" size="120" />
						</div>
					</div>
			</fieldset>
            <input type="hidden" name="id" id="id" value="<?php echo $data_info['id']?>"/>
            <input type="hidden" name="push_status" id="push_status" value="<?php echo $data_info['push_status']?>"/>
            <input type="hidden" name="account_name" id="account_name" value="<?php echo $data_info['account_name']?>"/>
		<div class='form-actions'>
		<?php aci_ui_button($folder_name,'send','edit',' type="submit" id="dosubmit" class="btn btn-primary " ','立即推送')?>
		</div>
     </div>
  </div>
</form>
<script language="javascript" type="text/javascript">
	var id = <?php echo $data_info['id']?>;
	var edit= <?php echo $is_edit?"true":"false"?>;	
	var folder_name = "<?php echo $folder_name?>";
	require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {	
	require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/edit.js']);		
		 //require(['<?php echo SITE_URL?>scripts//jedate-6.5.0/dist/jedate.min.js'],function(jeDate) {
		 //       jeDate("#send_time",{
		 //       	theme:{ bgcolor:"#00A1CB",color:"#ffffff", pnColor:"#00CCFF"},
		 //           format:"YYYY-MM-DD hh:mm:ss",
		 //           isTime:true,
		 //           isToday:true, 
		 //           isClear:true, 
		 //           minDate:"2014-09-19 00:00:00",
		  //          donefun:function(obj) {
          //                   $('#send_time').parent().parent().removeClass('has-error').addClass('has-success');
		//	       },   
	     //       }) 
		//    });
	});	
</script>
<link rel="stylesheet" href="<?php echo SITE_URL?>scripts/jedate-6.5.0/skin/jedate.css">