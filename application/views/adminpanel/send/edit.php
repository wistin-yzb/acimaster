<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo SITE_URL?>css/public.css" rel="stylesheet" >
<link href="<?php echo SITE_URL?>css/spc.css" rel="stylesheet" media="only screen and (min-width:769px) and (max-width:1200px)">
<link href="<?php echo SITE_URL?>css/bpc.css" rel="stylesheet" media="only screen and (min-width:1201px)">
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
				  <legend class="send-notice">
				  【重要通知】<br/>
				  模板消息仅用于公众号向用户发送重要的服务通知，只能用于符合其要求的服务场景中，如信用卡刷卡通知，商品购买成功通知等。不支持广告等营销类消息以及其它所有可能对用户造成骚扰的消息。<br/>
                  关于使用规则，请注意：<br/>
				  1、所有服务号都可以在功能->添加功能插件处看到申请模板消息功能的入口，但只有认证后的服务号才可以申请模板消息的使用权限并获得该权限；<br/>
                  2、需要选择公众账号服务所处的2个行业，每月可更改1次所选行业；<br/>
                  3、在所选择行业的模板库中选用已有的模板进行调用；<br/>
                  4、每个账号可以同时使用25个模板。<br/>
                  5、<font color="red">当前每个账号的模板消息的日调用上限为10万次</font>，单个模板没有特殊限制。【2014年11月18日将接口调用频率从默认的日1万次提升为日10万次，可在MP登录后的开发者中心查看】。当账号粉丝数超过10W/100W/1000W时，模板消息的日调用上限会相应提升，以公众号MP后台开发者中心页面中标明的数字为准。
                          <a href="https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433751277" target="_blank"><font color="#0071ce">文档详情</font>&nbsp;<i class="fa fa-angle-double-right"></i></a>  
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
						    <span class="line-s" style="font-size:12px;"><font color="red">立即推送</font>：当前公众号下关注的所有用户<br/><font color="red">测试发送</font>：仅发送单个指定的测试openid用户</span><br/>
						    <i class="fa fa-volume-up"></i>&nbsp;<span style="font-size:12px;color:#337ab7;">强烈建议推送给所有用户之前务必要做测试发送预览</span>						    
						</div>
					</div>
					<div  class="form-group tmpcont" >			         
					       <div class="col-sm-4"><i class="fa fa-file-text"></i> 模板内容</div>					       
					 </div>
					 <div class="form-group">
					        <div class="col-sm-2" style="text-align: right;">模板示例&nbsp;<i class="fa fa-hand-o-right"></i></div>		
					           <a href="<?php echo SITE_URL?>images/templateexample.png" class="test-popup-link">
					           <img src="<?php echo SITE_URL?>images/templateexample.png" title="点击查看大图" class="templateexample"/>
					       </a>
					 </div>
					 <div class="form-group">
						<label class="col-sm-2 control-label">自动提取用户名显示位置</label>
						<div class="col-sm-2">
						  <select name="auto_getnum" id="auto_getnum" class="form-control" >
						         <option value=0 <?php if($data_info['auto_getnum']==0):?>selected<?php endif;?>>0--默认不需要提取</option>						        
						         <option value=1 <?php if($data_info['auto_getnum']==1):?>selected<?php endif;?>>1--开头first所在位置</option>
						         <option value=2 <?php if($data_info['auto_getnum']==2):?>selected<?php endif;?>>2--中间keyword1所在位置</option>
						         <option value=3 <?php if($data_info['auto_getnum']==3):?>selected<?php endif;?>>3--中间keyword2所在位置</option>
						         <option value=4 <?php if($data_info['auto_getnum']==4):?>selected<?php endif;?>>4--中间keyword3所在位置</option>
						         <option value=5 <?php if($data_info['auto_getnum']==5):?>selected<?php endif;?>>5--中间keyword4所在位置</option>
						         <option value=6 <?php if($data_info['auto_getnum']==6):?>selected<?php endif;?>>6--中间keyword5所在位置</option>
						  </select>
						</div>
					</div>
					<div class="form-group">
						<label  class="col-sm-2 control-label">定时发送时间<font color="red">*</font></label>
						<div class="col-sm-2">
						   <input name="send_time" type="text" class="form-control" id="send_time" placeholder="请选择发送时间" value="<?php echo $data_info['send_time']?>" size="400" /> 						 
						</div>
					</div>
					<div class="form-group">
						<label  class="col-sm-2 control-label">开头first<font color="red">*</font></label>
						<div class="col-sm-4">
						  <!-- <input name="first" type="text" class="form-control" id="first" placeholder="(必填)" value="<?php echo $data_info['first']?>" size="400" /> -->
						  <textarea name="first"  id="first" class="form-control" style="height: 75px;" placeholder="(必填),涉及用户名请使用#号代替"><?php echo $data_info['first']?></textarea>
						  <input type="text"  id="first_color" class="form-control keycolor" name="first_color" placeholder="字体颜色值" value="<?php echo $data_info['first_color']?>">
						   <input type="color" class="form-control keycolorbtn" title="点击设置字体颜色" style="cursor:pointer;padding-right:10px;" id="first_color_btn" value="<?php echo $data_info['first_color']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间keyword1<font color="red">*</font></label>
						<div class="col-sm-4">
						 <input name="key_field1" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field1']?>" id="key_field1" placeholder="关键词英文字段1(必填)" size="120" />
						  <input name="keyword1" type="text" class="form-control keycon" value="<?php echo $data_info['keyword1']?>" id="keyword1" placeholder="关键词内容1(必填)" size="400" />
						  <input type="text"  id="keyword1_color" class="form-control keycolormid" name="keyword1_color" placeholder="字体颜色值" value="<?php echo $data_info['keyword1_color']?>">
						   <input type="color" class="form-control keycolorbtnmid" title="点击设置字体颜色" style="cursor:pointer;padding-right:10px;" id="keyword1_color_btn" value="<?php echo $data_info['keyword1_color']?>">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-2 control-label">中间keyword2<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="key_field2" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field2']?>" id="key_field2" placeholder="关键词英文字段2(必填)" size="120" />
						  <input name="keyword2" type="text" class="form-control keycon" value="<?php echo $data_info['keyword2']?>" id="keyword2" placeholder="关键词内容2(必填)" size="400" />
						   <input type="text"  id="keyword2_color" class="form-control keycolormid" name="keyword2_color" placeholder="字体颜色值" value="<?php echo $data_info['keyword2_color']?>">
						   <input type="color" class="form-control keycolorbtnmid" title="点击设置字体颜色" style="cursor:pointer;padding-right:10px;" id="keyword2_color_btn" value="<?php echo $data_info['keyword2_color']?>">
						</div>
					</div> 
                   <div class="form-group">
						<label class="col-sm-2 control-label">中间keyword3<font color="red">*</font></label>
						<div class="col-sm-4">
						 <input name="key_field3" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field3']?>" id="key_field3" placeholder="关键词英文字段3(必填)" size="120" />
						  <input name="keyword3" type="text" class="form-control keycon" value="<?php echo $data_info['keyword3']?>" id="keyword3" placeholder="关键词内容3(必填)" size="400" />
						  <input type="text"  id="keyword3_color" class="form-control keycolormid" name="keyword3_color" placeholder="字体颜色值" value="<?php echo $data_info['keyword3_color']?>">
						   <input type="color" class="form-control keycolorbtnmid"  title="点击设置字体颜色" style="cursor:pointer;padding-right:10px;" id="keyword3_color_btn" value="<?php echo $data_info['keyword3_color']?>">
						</div>
					</div>           
					<div class="form-group">
						<label class="col-sm-2 control-label">中间keyword4</label>
						<div class="col-sm-4">
						  <input name="key_field4" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field4']?>" id="key_field4" placeholder="关键词英文字段4" size="120" />
						  <input name="keyword4" type="text" class="form-control keycon" value="<?php echo $data_info['keyword4']?>" id="keyword4" placeholder="关键词内容4" size="400" />
						  <input type="text"  id="keyword4_color" class="form-control keycolormid" name="keyword4_color" placeholder="字体颜色值" value="<?php echo $data_info['keyword4_color']?>">
						   <input type="color" class="form-control keycolorbtnmid" title="点击设置字体颜色" style="cursor:pointer;padding-right:10px;" id="keyword4_color_btn" value="<?php echo $data_info['keyword4_color']?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">中间keyword5</label>
						<div class="col-sm-4">
						 <input name="key_field5" type="text" onkeyup="value=value.replace(/[\u4E00-\u9FA5]/g,'')" class="form-control w174" value="<?php echo $data_info['key_field5']?>" id="key_field5" placeholder="关键词英文字段5" size="120" />
						 <input name="keyword5" type="text" class="form-control keycon" value="<?php echo $data_info['keyword5']?>" id="keyword5" placeholder="关键词内容5" size="400" />
						 <input type="text"  id="keyword5_color" class="form-control keycolormid" name="keyword5_color" placeholder="字体颜色值" value="<?php echo $data_info['keyword5_color']?>">
						   <input type="color" class="form-control keycolorbtnmid" title="点击设置字体颜色" style="cursor:pointer;padding-right:10px;" id="keyword5_color_btn" value="<?php echo $data_info['keyword5_color']?>">
						</div>
					</div>				
					<div class="form-group">
						<label class="col-sm-2 control-label">结尾remark</label>
						<div class="col-sm-4">
						  <textarea name="remark"  id="remark" class="form-control" style="height: 75px;" placeholder="非必填"><?php echo $data_info['remark']?></textarea>
						  <input type="text"  id="remark_color" class="form-control keycolorfoot" name="remark_color" placeholder="字体颜色值" value="<?php echo $data_info['remark_color']?>">
						   <input type="color" class="form-control keycolorbtnfoot"  title="点击设置字体颜色"  style="cursor:pointer;padding-right:10px;" id="remark_color_btn" value="<?php echo $data_info['remark_color']?>">
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
             <input type="hidden" name="invest_style"  id="invest_style"  value="<?php echo $data_info['invest_style']?>"/>
             <input type="hidden" name="invest_profit"  id="invest_profit"  value="<?php echo $data_info['invest_profit']?>"/>             
		<div class='form-actions'>
		         <?php aci_ui_button($folder_name,'send','edit',' type="submit" id="dosubmit" class="btn btn-primary " ','立即推送')?>
		         <span class="testsend"><input type="text" id="test_openid" placeholder="请输入测试用户openid"></span>
		         <span style="cursor:pointer;"><a class="btn btn-info btn-xs" onclick="testSend()"><i class="fa fa-star-half">&nbsp;测试发送</i></a>		         
		         </span><br/>
		        <span class="footremark"><a href="javascript:;" class="btn btn-link  btn-xs" onclick="openwindow('/adminpanel/service/index','搜索openid',1200,450)">
		         <i class="fa fa-hand-o-right"></i> &nbsp;搜索openid</a></span><br/>
		         <span class="footremark">操作提示:测试用户openid请到<font color="red">配置公众号</font>栏目<i class="fa fa-angle-double-right"></i><font color="red">查看用户列表</font>,自己搜索获取即可.如遇无法操作问题,请联系系统管理人员</span>		          		           
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
		require(['<?php echo SITE_URL?>scripts//jedate-6.5.0/dist/jedate.min.js'],function(jeDate) {
		        jeDate("#send_time",{
		        	theme:{ bgcolor:"#00A1CB",color:"#ffffff", pnColor:"#00CCFF"},
		            format:"YYYY-MM-DD hh:mm:ss",
		            isTime:true,
		            isToday:true, 
		            isClear:true, 
		            minDate:"2014-09-19 00:00:00",
		            donefun:function(obj) {
                             //$('#send_time').parent().parent().removeClass('has-error').addClass('has-success');
			       },   
	            }) 
		    });
	});	
</script>
<link rel="stylesheet" href="<?php echo SITE_URL?>scripts/jedate-6.5.0/skin/jedate.css">