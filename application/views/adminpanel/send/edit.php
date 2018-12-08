<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<style>
	.line-s{height:30px;line-height:30px !important;}
	.tgl{text-align:left !important;}
	.tipmsg{font-size:12px;height:33px;line-height:33px;background-color:whitesmoke;}
	.edit_send_time{position:relative;top:.6rem;}
	#template_number>.tps{padding: 0 20px 0 0;font-size: 14px;position: relative;top: 5px;height: 33px;line-height: 33px;}
	.w174{width:200px;}
	.keycon{position: relative;margin-top:-34px;margin-left: 210px;}
	.keycolor{position: relative;margin-top:-34px;margin-left: 500px;width:170px;}
	.keycolorbtn{position: relative;margin-top:-34px;margin-left: 680px;width:50px;}
	.keycolormid{position: relative;margin-top:-34px;margin-left: 710px;width:200px;}
	.keycolorbtnmid{position: relative;margin-top:-34px;margin-left: 918px;width:50px;}
	.keycolorfoot{position: relative;margin-top:-34px;margin-left: 500px;width:110px;}
	.keycolorbtnfoot{position: relative;margin-top:-34px;margin-left: 620px;width:50px;}
</style>
<form class="form-horizontal" role="form" id="validateform" name="validateform" action="<?php echo current_url()?>" >
<div class='panel panel-default' style="margin-bottom:130px;">
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
				<legend class="tipmsg">&nbsp;<i class="fa fa-volume-up"></i>&nbsp;提示：要求账号为服务号并认证，对所有用户发送时需准守微信公众平台行为规范。PRID：sUroer1rqkwvMVL4pQK2GYk4itRb_qLacN_FzAZ5i5E</legend>
				  <!--/.diy style-->
				  <legend style="font-size:12px;padding-bottom:20px;">
				  模板消息仅用于公众号向用户发送重要的服务通知，只能用于符合其要求的服务场景中，如信用卡刷卡通知，商品购买成功通知等。不支持广告等营销类消息以及其它所有可能对用户造成骚扰的消息。<br/>
                 <br/>
                  关于使用规则，请注意：<br/>
				  1、所有服务号都可以在功能->添加功能插件处看到申请模板消息功能的入口，但只有认证后的服务号才可以申请模板消息的使用权限并获得该权限；<br/>
                  2、需要选择公众账号服务所处的2个行业，每月可更改1次所选行业；<br/>
                  3、在所选择行业的模板库中选用已有的模板进行调用；<br/>
                  4、每个账号可以同时使用25个模板。<br/>
                  5、<font color="red">当前每个账号的模板消息的日调用上限为10万次</font>，单个模板没有特殊限制。【2014年11月18日将接口调用频率从默认的日1万次提升为日10万次，可在MP登录后的开发者中心查看】。当账号粉丝数超过10W/100W/1000W时，模板消息的日调用上限会相应提升，以公众号MP后台开发者中心页面中标明的数字为准。
                          <a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433751277" target="_blank"><font color="blue">文档详情</font>&nbsp;<i class="fa fa-angle-double-right"></i></a>  
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
						    <span class="line-s" style="font-size:12px;"><font color="red">立即推送</font>：当前公众号下关注的所有用户 <font color="red">测试发送</font>：仅发送单个指定的测试openid用户</span><br/>
						    <font color="red"><i class="fa fa-volume-up"></i>&nbsp;</font><span style="font-size:12px;color:blue;">强烈建议推送给所有用户之前务必要做测试发送预览</span>						    
						</div>
					</div>
					<div  class="form-group" style="font-size:16px;width:50%;height:33px;line-height:33px;background-color:honeydew;border:1px solid #eee;">
					         <label  class="col-sm-2 control-label"></label>					         
					       <div class="col-sm-4">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-text"></i> 模板内容</div>					       
					 </div>
					 <div class="form-group">
					        <div class="col-sm-3" style="text-align: right;"> 模板示例&nbsp;<i class="fa fa-hand-o-right"></i></div>		
					           <a href="<?php echo SITE_URL?>images/templateexample.png" class="test-popup-link">
					           <img src="<?php echo SITE_URL?>images/templateexample.png" title="点击查看大图" style="width:375px;height:120px;border:1px solid #eee;padding:4px;"/>
					       </a>
					 </div>
					<div class="form-group">
						<label  class="col-sm-2 control-label">开头first<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="first" type="text" class="form-control" id="first" placeholder="(必填)" value="<?php echo $data_info['first']?>" size="400" />
						  <input type="text"  id="first_color" class="form-control keycolor" name="first_color" placeholder="开头first字体颜色" value="<?php echo $data_info['first_color']?>">
						   <input type="color" class="form-control keycolorbtn" style="padding-right:10px;" id="first_color_btn" value="<?php echo $data_info['first_color']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间keyword1<font color="red">*</font></label>
						<div class="col-sm-4">
						 <input name="key_field1" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field1']?>" id="key_field1" placeholder="关键词英文字段1(必填)" size="120" />
						  <input name="keyword1" type="text" class="form-control keycon" value="<?php echo $data_info['keyword1']?>" id="keyword1" placeholder="关键词内容1(必填)" size="400" />
						  <input type="text"  id="keyword1_color" class="form-control keycolormid" name="keyword1_color" placeholder="中间keyword1字体颜色" value="<?php echo $data_info['keyword1_color']?>">
						   <input type="color" class="form-control keycolorbtnmid" style="padding-right:10px;" id="keyword1_color_btn" value="<?php echo $data_info['keyword1_color']?>">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-2 control-label">中间keyword2<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="key_field2" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field2']?>" id="key_field2" placeholder="关键词英文字段2(必填)" size="120" />
						  <input name="keyword2" type="text" class="form-control keycon" value="<?php echo $data_info['keyword2']?>" id="keyword2" placeholder="关键词内容2(必填)" size="400" />
						   <input type="text"  id="keyword2_color" class="form-control keycolormid" name="keyword2_color" placeholder="中间keyword2字体颜色" value="<?php echo $data_info['keyword2_color']?>">
						   <input type="color" class="form-control keycolorbtnmid" style="padding-right:10px;" id="keyword2_color_btn" value="<?php echo $data_info['keyword2_color']?>">
						</div>
					</div> 
                   <div class="form-group">
						<label class="col-sm-2 control-label">中间keyword3<font color="red">*</font></label>
						<div class="col-sm-4">
						 <input name="key_field3" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field3']?>" id="key_field3" placeholder="关键词英文字段3(必填)" size="120" />
						  <input name="keyword3" type="text" class="form-control keycon" value="<?php echo $data_info['keyword3']?>" id="keyword3" placeholder="关键词内容3(必填)" size="400" />
						  <input type="text"  id="keyword3_color" class="form-control keycolormid" name="keyword3_color" placeholder="中间keyword3字体颜色" value="<?php echo $data_info['keyword3_color']?>">
						   <input type="color" class="form-control keycolorbtnmid" style="padding-right:10px;" id="keyword3_color_btn" value="<?php echo $data_info['keyword3_color']?>">
						</div>
					</div>           
					<div class="form-group">
						<label class="col-sm-2 control-label">中间keyword4</label>
						<div class="col-sm-4">
						  <input name="key_field4" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field4']?>" id="key_field4" placeholder="关键词英文字段4" size="120" />
						  <input name="keyword4" type="text" class="form-control keycon" value="<?php echo $data_info['keyword4']?>" id="keyword4" placeholder="关键词内容4" size="400" />
						  <input type="text"  id="keyword4_color" class="form-control keycolormid" name="keyword4_color" placeholder="中间keyword4字体颜色" value="<?php echo $data_info['keyword4_color']?>">
						   <input type="color" class="form-control keycolorbtnmid" style="padding-right:10px;" id="keyword4_color_btn" value="<?php echo $data_info['keyword4_color']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间keyword5</label>
						<div class="col-sm-4">
						 <input name="key_field5" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field5']?>" id="key_field5" placeholder="关键词英文字段5" size="120" />
						 <input name="keyword5" type="text" class="form-control keycon" value="<?php echo $data_info['keyword5']?>" id="keyword5" placeholder="关键词内容5" size="400" />
						 <input type="text"  id="keyword5_color" class="form-control keycolormid" name="keyword5_color" placeholder="中间keyword5字体颜色" value="<?php echo $data_info['keyword5_color']?>">
						   <input type="color" class="form-control keycolorbtnmid" style="padding-right:10px;" id="keyword5_color_btn" value="<?php echo $data_info['keyword5_color']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间invest_style</label>
						<div class="col-sm-4">
						  <input name="invest_style" type="text" class="form-control"  value="<?php echo $data_info['invest_style']?>" id="invest_style" placeholder="" size="400" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间invest_profit</label>
						<div class="col-sm-4">
						  <input name="invest_profit" type="text" class="form-control" value="<?php echo $data_info['invest_profit']?>" id="invest_profit" placeholder="" size="400" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">结尾remark</label>
						<div class="col-sm-4">
						  <textarea name="remark"  id="remark" class="form-control"><?php echo $data_info['remark']?></textarea>
						  <input type="text"  id="remark_color" class="form-control keycolorfoot" name="remark_color" placeholder="备注字体颜色" value="<?php echo $data_info['remark_color']?>">
						   <input type="color" class="form-control keycolorbtnfoot" style="padding-right:10px;" id="remark_color_btn" value="<?php echo $data_info['remark_color']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">跳转链接url</label>
						<div class="col-sm-4">
						  <input name="url" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" onblur="checksiteurl()" class="form-control" value="<?php echo $data_info['url']?>" id="url" placeholder="请以http|https://开头" size="400" />
						  <span id="link_error_msg"></span>
						</div>
					</div>
			</fieldset>
            <input type="hidden" name="id" id="id" value="<?php echo $data_info['id']?>"/>
            <input type="hidden" name="push_status" id="push_status" value="<?php echo $data_info['push_status']?>"/>
            <input type="hidden" name="account_name" id="account_name" value="<?php echo $data_info['account_name']?>"/>
		<div class='form-actions'>
		         <?php aci_ui_button($folder_name,'send','edit',' type="submit" id="dosubmit" class="btn btn-primary " ','立即推送')?>
		         <span style="margin-left:178px;padding-right:10px;"><input type="text" id="test_openid" style="width:380px;" placeholder="请输入测试用户openid"></span>
		         <span style="cursor:pointer;"><a class="btn btn-info btn-xs" onclick="testSend()"><i class="fa fa-star-half">&nbsp;测试发送</i></a></span><br/>
		         <span style="margin-left:262px;font-size:9px;">测试用户openid请到<font color="red">配置公众号</font>栏目&gt;<font color="red">查看用户列表</font>,自己搜索获取即可.如遇无法操作问题,请联系系统管理人员</span>		          		           
		</div>
     </div>
  </div>
</form>
<link rel="stylesheet" href="<?php echo SITE_URL?>scripts/Magnific-Popup-master/dist/magnific-popup.css"/>
<script language="javascript" type="text/javascript">
	var id = <?php echo $data_info['id']?>;
	var edit= <?php echo $is_edit?"true":"false"?>;	
	var folder_name = "<?php echo $folder_name?>";
	require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {	
	require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/edit.js']);		
	 require(['<?php echo SITE_URL?>scripts/Magnific-Popup-master/dist/jquery.magnific-popup.min.js']);
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