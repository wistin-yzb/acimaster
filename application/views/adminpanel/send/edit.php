<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?>
<style>
	.line-s{height:30px;line-height:30px !important;}
	.tgl{text-align:left !important;}
	.tipmsg{font-size:12px;height:33px;line-height:33px;background-color:whitesmoke;}
	.edit_send_time{position:relative;top:.6rem;}
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
<?php if(!$is_edit):?>
					<div class="form-group">
						<label class="col-sm-2 control-label">时间<font color="red">*</font></label>
						<div class="col-sm-2">
							<input type="text" name="send_time"  id="send_time"  class="form-control"  placeholder="" >
						</div>
					</div>
<?php else:?>
					<div class="form-group">
						<label class="col-sm-2 control-label">时间</label>
						<div class="col-sm-4"><span id="send_time" class="edit_send_time"><?php echo $data_info['send_time']?></span></div>
					</div>
<?php endif;?>
					<div class="form-group">
						<label class="col-sm-2 control-label">模板ID<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="temp_id" type="text" class="form-control validate[required]" id="temp_id" placeholder="(必填)" value="<?php echo $data_info['temp_id']?>" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label  class="col-sm-2 control-label"><font color="red">开头first</font></label>
						<div class="col-sm-4">
						  <input name="first" type="text" class="form-control" id="first" placeholder="" value="<?php echo $data_info['first']?>" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><font color="blue">中间keyword1</font></label>
						<div class="col-sm-4">
						  <input name="keyword1" type="text" class="form-control" value="<?php echo $data_info['keyword1']?>" id="keyword1" placeholder="" size="120" />
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-2 control-label"><font color="blue">中间keyword2</font></label>
						<div class="col-sm-4">
						  <input name="keyword2" type="text" class="form-control" value="<?php echo $data_info['keyword2']?>" id="keyword2" placeholder="" size="120" />
						</div>
					</div> 
                   <div class="form-group">
						<label class="col-sm-2 control-label"><font color="blue">中间keyword3</font></label>
						<div class="col-sm-4">
						  <input name="keyword3" type="text" class="form-control" value="<?php echo $data_info['keyword3']?>" id="keyword3" placeholder="" size="120" />
						</div>
					</div>           
					<div class="form-group">
						<label class="col-sm-2 control-label"><font color="blue">中间keyword4</font></label>
						<div class="col-sm-4">
						  <input name="keyword4" type="text" class="form-control" value="<?php echo $data_info['keyword4']?>" id="keyword4" placeholder="" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><font color="blue">中间keyword5</font></label>
						<div class="col-sm-4">
						  <input name="keyword5" type="text" class="form-control" value="<?php echo $data_info['keyword5']?>" id="keyword5" placeholder="" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><font color="blue">中间invest_style</font></label>
						<div class="col-sm-4">
						  <input name="invest_style" type="text" class="form-control"  value="<?php echo $data_info['invest_style']?>" id="invest_style" placeholder="" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><font color="blue">中间invest_profit</font></label>
						<div class="col-sm-4">
						  <input name="invest_profit" type="text" class="form-control" value="<?php echo $data_info['invest_profit']?>" id="invest_profit" placeholder="" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><font color="red">结尾remark</font></label>
						<div class="col-sm-4">
						  <input name="remark" type="text" class="form-control" value="<?php echo $data_info['remark']?>" id="remark" placeholder="" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><font color="blue">链接url</font></label>
						<div class="col-sm-4">
						  <input name="url" type="text" class="form-control" value="<?php echo $data_info['url']?>" id="url" placeholder="" size="120" />
						</div>
					</div>
			</fieldset>
            <input type="hidden" name="id" id="id" value="<?php echo $data_info['id']?>"/>
            <input type="hidden" name="push_status" id="push_status" value="<?php echo $data_info['push_status']?>"/>
		<div class='form-actions'>
		<?php aci_ui_button($folder_name,'send','edit',' type="submit" id="dosubmit" class="btn btn-primary " ','立即推送')?>
		</div>
     </div>

</form>
<script language="javascript" type="text/javascript">
	var id = <?php echo $data_info['id']?>;
	var edit= <?php echo $is_edit?"true":"false"?>;
	var folder_name = "<?php echo $folder_name?>";
	require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {	
		require(['<?php echo SITE_URL?>scripts/<?php echo $folder_name?>/<?php echo $controller_name?>/edit.js']);		
		 require(['<?php echo SITE_URL?>scripts//jedate-6.5.0/dist/jedate.min.js'],function(jeDate) {
		        jeDate("#send_time",{
		        	theme:{ bgcolor:"#00A1CB",color:"#ffffff", pnColor:"#00CCFF"},
		            format:"YYYY-MM-DD hh:mm:ss",
		            isTime:true,
		            isToday:true, 
		            isClear:true, 
		            minDate:"2014-09-19 00:00:00",
		            donefun:function(obj) {
                             $('#send_time').parent().parent().removeClass('has-error').addClass('has-success');
			       },   
		        }) 
		    });
	});
</script>
<link rel="stylesheet" href="<?php echo SITE_URL?>scripts/jedate-6.5.0/skin/jedate.css">