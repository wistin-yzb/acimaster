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
			key_field1: {
				message: '中间key_field1字段不能为空',
				validators: {
					notEmpty: {
						message: '中间key_field1字段不能为空'
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
			key_field2: {
				message: '中间key_field2字段不能为空',
				validators: {
					notEmpty: {
						message: '中间key_field2字段不能为空'
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
			key_field3: {
				message: '中间key_field3字段不能为空',
				validators: {
					notEmpty: {
						message: '中间key_field3字段不能为空'
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
				key_field1: {
					validators: {
						notEmpty: {
							message: '请输入中间key_field1内容'
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
				key_field2: {
					validators: {
						notEmpty: {
							message: '请输入中间key_field2内容'
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
				key_field3: {
					validators: {
						notEmpty: {
							message: '请输入中间key_field3内容'
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
				  //console.log('----------------------log===');
				  //console.log(result);
				  if(result=='-1'){
					  html+='无效参数';
					  $('#template_number').html(html); 
					  return false;
				   }else{
					      if(result=='-2'){
					    	  html+='暂无模板列表,请先添加对应公众号消息模板以及设置公众号ip白名单,当前服务器ip:119.23.201.162';
					      }else if(result=='null'){
					    	  html+='请将当前服务器ip:119.23.201.162添加到对应公众号的ip白名单中';
					      }else{
							  $.each(result,function(index,item){
								  html+='<span class="tps"><input  type="radio" name="temp_id" style="width:16px ;height:16px;" value="'+item.template_id+'"/>prid=>'+item.template_id+'</span>';
								  html+='<span class="tps">title=>【'+item.title+'】</span>';
								  html+='<span class="tps">content=>'+item.content+'</span>';
								  html+='<span class="tps">example=>'+item.example+'</span>';
							  });	    
					      }
					   $('#template_number').html(html); 
				   }
		    }});//===End
		   $('#account_name').val($.trim(text)); 		   
	  })   
});
//测试发送单个用户
function testSend(){
	var service_id = $.trim($('#service_id').val());
	var temp_id  = $.trim($("input[name='temp_id']:checked").val());
	var first = $.trim($('#first').val());
	
	var key_field1 = $.trim($('#key_field1').val());
	var keyword1 = $.trim($('#keyword1').val());
	
	var key_field2 = $.trim($('#key_field2').val());
	var keyword2 = $.trim($('#keyword2').val());
	
	var key_field3 = $.trim($('#key_field3').val());
	var keyword3 = $.trim($('#keyword3').val());
	
	var account_name = $.trim($('#account_name').val());
	var key_field4 = $.trim($('#key_field4').val());
	var keyword4 = $.trim($('#keyword4').val());	
	var key_field5 = $.trim($('#key_field5').val());
	var keyword5 = $.trim($('#keyword5').val());
	var invest_style = $.trim($('#invest_style').val());
	var invest_profit = $.trim($('#invest_profit').val());
	var remark = $.trim($('#remark').val());
	var url = $.trim($('#url').val());
	
	var test_openid = $.trim($('#test_openid').val());
	var params = {"test_openid":test_openid,"service_id":service_id,"temp_id":temp_id,"first":first,
			                       "key_field1":key_field1,"keyword1":keyword1,"key_field2":key_field2,"keyword2":keyword2,"key_field3":key_field3,
			                       "keyword3":keyword3,"account_name":account_name,"key_field4":key_field4,"keyword4":keyword4,"key_field5":key_field5,
			                       "keyword5":keyword5,"invest_style":invest_style,"invest_profit":invest_profit,"remark":remark,"url":url
			                       };	
	console.log(params);
	  $.ajax({
		  url:"/adminpanel/send/test_send",
		  type:"POST",
		  dataType: "JSON",
		  data:params,
		  success:function(result){
			   console.log(result);
			   if(result.status=='true'){
				   alert(result.tips);
			   }else{
				   alert(result.tips);
			   }
		  }
	  });	
}
function checksiteurl(){
	 var url=document.getElementById("url").value;
	 var reg=/^[a-zA-z]+:\/\/[^\s]*$/;
	 if(!reg.test(url)){
		 $('#link_error_msg').html("<font color='red'>链接格式错误</font>");
		 $('#url').focus();
	 }
	 else{
		 $('#link_error_msg').html("<font color='green'>格式正确</font>");			 
	 }
	}