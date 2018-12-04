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
			first: {
				message: '开头first不能为空',
				validators: {
					notEmpty: {
						message: '开头first不能为空'
					},	
				}
			},
			keyword1: {
				message: '中间keyword1不能为空',
				validators: {
					notEmpty: {
						message: '中间keyword1不能为空'
					},	
				}
			},	
			keyword2: {
				message: '中间keyword2不能为空',
				validators: {
					notEmpty: {
						message: '中间keyword2不能为空'
					},	
				}
			},	
			keyword3: {
				message: '中间keyword3不能为空',
				validators: {
					notEmpty: {
						message: '中间keyword3不能为空'
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
				first: {
					validators: {
						notEmpty: {
							message: '请输入开头first内容'
						}
					}
				},
				keyword1: {
					validators: {
						notEmpty: {
							message: '请输入中间keyword1内容'
						}
					}
				},
				keyword2: {
					validators: {
						notEmpty: {
							message: '请输入中间keyword2内容'
						}
					}
				},	
				keyword3: {
					validators: {
						notEmpty: {
							message: '请输入中间keyword3内容'
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
			url: edit?SITE_URL+folder_name+"/send/edit/"+id:SITE_URL+folder_name+"/send/add/",
			data:  $("#validateform").serialize(),
			success:function(response){
				var dataObj=jQuery.parseJSON(response);
				if(dataObj.status)
				{
					$.scojs_message('操作成功,3秒后将返回列表页...', $.scojs_message.TYPE_OK);
					aci.GoUrl(SITE_URL+folder_name+'/send/index/',1);
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
     //获取公众号模板列表 
	  $("#service_id").change(function(){	   
		 //获取选中的项	
		  var options =$("#service_id option:selected"); 	  
		  var val = options.val(); 
		  var text = options.text();
		  var appid = options.attr('data-appid');
		  var appsecret = options.attr('data-appsecret');
		  var params = {"public_id":val,"appid":appid,"appsecret":appsecret};
		  var html = '';
		  $.ajax({
			  url:"/adminpanel/send/get_template_list",
			  type:"POST",
			  dataType: "JSON",
			  data:params,
			  success:function(result){		  
				  console.log('----------------------log===');
				  console.log(result);
				  if(result.length<0)return false;
				  $.each(result,function(index,item){
					  html+='<span class="tps"><input  type="radio" name="temp_id" style="width:16px ;height:16px;" value="'+item.template_id+'"/>prid=>'+item.template_id+'</span>';
					  html+='<span class="tps">title=>【'+item.title+'】</span>';
					  html+='<span class="tps">content=>'+item.content+'</span>';
					  html+='<span class="tps">example=>'+item.example+'</span>';
				  });	              
				  $('#template_number').html(html); 
		    }});//===End
		   $('#account_name').val($.trim(text)); 
		   
	  })   
});
