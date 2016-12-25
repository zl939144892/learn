/**
 * 添加按钮操作
 */
$("#button-add").click(function(){
	var url = SCOPE.add_url;
	window.location.href=url;
});

/**
 * 提交form表单的操作
 */
$("#singcms-button-submit").click(function(){
	var data = $("#singcms-form").serializeArray();
	postData = {};
	$(data).each(function(i){//循环把#singcms-form里的值赋值给postData数组
		postData[this.name] = this.value;
	});
	console.log(postData);//在Console里显示信息
	url = SCOPE.save_url;//获取url地址
	jump_url = SCOPE.jump_url;
	$.post(url, postData, function(result){
		if(result.status == 1){
			//成功
			return dialog.success(result.message, jump_url);
		}else if(result.status == 0){
			//失败
			return dialog.error(result.message);
		}
	},"JSON"); //将获取到的数据post给服务器
});
/**
 * 编辑模型
 */
$(".singcms-table #singcms-edit").on("click", function(){
	var id = $(this).attr("attr-id");
	var url = SCOPE.edit_url + '&id=' + id;
	window.location.href=url;
});
