var ajaxCaller = function(callUrl, postData = {}, successFunc = undefined, errorFunc = undefined)
{
	$.ajax({
		type : 'post', //post提交
		url : callUrl,
		dataType : "json", //json格式
		data : postData, //如果需要提交附加参数，视情况添加
		clearForm : false, //成功提交后，清除所有表单元素的值7777777777
		resetForm : false, //成功提交后，重置所有表单元素的值
		cache : false,
		async : false, //同步返回
		success : function(data) {
			if(successFunc)
				successFunc(data);
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status +" "+ XMLHttpRequest.readyState + " " + textStatus);		
		}
	});
};


var myValidator = function($rules,$msg ){
	
	
	
};