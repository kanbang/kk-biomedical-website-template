<div id="success_dialog" class="show_error" style="opacity: 1;height: 60px;z-index: 300;background-color: rgba(200,200,200,0.95);">
	<div style="width: 100%;height: 65px;text-align: center;direction: rtl;border:none;color: #eeeeee;font-size: 15px;font-weight: bold;">
	<img alt="wrong" src="../images/wrong.png" style="float: left;position: relative;height: 60px;"/>
	<span style="position: absolute;top:15px;right:5px;width: 200px;">حد اکثر تعداد فیلد برای جستجو 9 عدد است!</span>
	</div>
	<script type="text/javascript">
	$(".show_error").click(function(){
			$(this).remove();
		});
	setTimeout(function () {
		$(".show_error").animate({'opacity':'0.0'},300,function(){
			$(".show_error").remove();
		});
	},3000);
	</script>
</div>