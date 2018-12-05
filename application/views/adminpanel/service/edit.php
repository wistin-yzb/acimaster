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
		<?php echo $is_edit?"修改":"新增"?>公众号配置信息<br/><font color="red"><strong>强烈提醒</strong></font>：务必在微信平台设置当前<font color="red"><b>公众号ip白名单</b></font>，当前服务器ip：119.23.201.162，以及<font color="red"><b>添加该公众号对应的消息模板</b></font>，否则你将无法发送该公众号模板消息
		<div class='panel-tools'>

			<div class='btn-group'>
				<?php aci_ui_a($folder_name,'service','index','',' class="btn  btn-sm "','<span class="glyphicon glyphicon-arrow-left"></span> 返回')?>
			</div>
		</div>
	</div>
	<div class='panel-body'>
		<fieldset>			
					<div class="form-group">
						<label class="col-sm-2 control-label">微信账号<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="wx_number" type="text" class="form-control validate[required]" id="wx_number" placeholder="(必填)" value="<?php echo $data_info['wx_number']?>" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label  class="col-sm-2 control-label">应用appId<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="app_id" type="text" class="form-control" id="app_id" placeholder="(必填)" value="<?php echo $data_info['app_id']?>" size="120" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">应用appSecret<font color="red">*</font></label>
						<div class="col-sm-4">
						  <input name="app_secret" type="text" class="form-control" value="<?php echo $data_info['app_secret']?>" id="app_secret" placeholder="(必填)" size="120" />
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-2 control-label">账号名称</label>
						<div class="col-sm-4">
						  <input name="account_name" type="text" class="form-control" value="<?php echo $data_info['account_name']?>" id="account_name" placeholder="" size="120" />
						</div>
					</div> 
					 <div class="form-group">
						<label class="col-sm-2 control-label">启用状态</label>
						<div class="col-sm-1">
						  <select class="form-control"  name="status" id="status">					           
					  			<option value=1  <?php if($data_info['status']==1):?>selected<?php endif;?>>启用</option>
					  			<option value=2 <?php if($data_info['status']==2):?>selected<?php endif;?>>禁用</option>
						  </select>
						</div>
					</div> 
                   <div class="form-group">
						<label class="col-sm-2 control-label">备注</label>
						<div class="col-sm-4">
						  <textarea name="remark"  id="remark" class="form-control"   placeholder=""/><?php echo $data_info['remark']?></textarea>
						</div>						
					</div>           																		
			</fieldset>
            <input type="hidden" name="id" id="id" value="<?php echo $data_info['id']?>"/>
		<div class='form-actions'>
		  <?php aci_ui_button($folder_name,'service','edit',' type="submit" id="dosubmit" class="btn btn-primary" ','保存')?>
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
	});
</script>
<link rel="stylesheet" href="<?php echo SITE_URL?>scripts/jedate-6.5.0/skin/jedate.css">