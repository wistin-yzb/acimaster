define(function (require) {
	var $ = require('jquery');
	var aci = require('aci');
	require('bootstrap');
	require('jquery-ui-dialog-extend');
	require('bootstrapValidator');
	require('message');

	var validator_config = {
		message: '输入框不能为空',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			wx_number: {
				message: '微信账号不能为空',
				validators: {
					notEmpty: {
						message: '微信账号不能为空'
					},	
				}
			},
			app_id: {
				message: 'appId不能为空',
				validators: {
					notEmpty: {
						message: 'appId不能为空'
					},	
				}
			},	
			app_secret: {
				message: 'appSecret不能为空',
				validators: {
					notEmpty: {
						message: 'appSecret不能为空'
					},	
				}
			},		
		}
	};

	if(edit){
		var validator_config = {
			message: '输入框不能为空',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				wx_number: {
					validators: {
						notEmpty: {
							message: '请输入微信账号'
						}
					}
				},
				app_id: {
					validators: {
						notEmpty: {
							message: '请输入appId'
						}
					}
				},
				app_secret: {
					validators: {
						notEmpty: {
							message: '请输入appSecret'
						}
					}
				},	
			}
		};
	}
	$('#validateform').bootstrapValidator(validator_config).on('success.form.bv', function(e) {
		e.preventDefault();
		$("#dosubmit").attr("disabled","disabled");
		$.scojs_message('请稍候...', $.scojs_message.TYPE_WAIT);
		$.ajax({
			type: "POST",
			url: edit?SITE_URL+folder_name+"/service/edit/"+id:SITE_URL+folder_name+"/service/add/",
			data:  $("#validateform").serialize(),
			success:function(response){
				var dataObj=jQuery.parseJSON(response);
				if(dataObj.status)
				{
					$.scojs_message('操作成功,3秒后将返回列表页...', $.scojs_message.TYPE_OK);
					aci.GoUrl(SITE_URL+folder_name+'/service/index/',1);
				}else
				{
					$.scojs_message(dataObj.tips, $.scojs_message.TYPE_ERROR);
					$("#dosubmit").removeAttr("disabled");
				}
			},
			error: function (request, status, error) {
				$.scojs_message(request.responseText, $.scojs_message.TYPE_ERROR);
				$("#dosubmit").removeAttr("disabled");
			}
		});

	}).on('error.form.bv',function(e){ $.scojs_message('带*号不能为空', $.scojs_message.TYPE_ERROR);$("#dosubmit").removeAttr("disabled");});

});
