<script type="text/javascript">
	$(document).ready(function () {
		$("a[href='#personnel']").trigger('click');
		$("body > div:nth-child(3) > div:nth-child(1) > nav").css('display','none');
		$("#personnel > div > div:nth-child(1) > form > h1").text("密碼已過期-請修改");	
	    setTimeout(function(){
	        $("#preloader").fadeOut();
	    },2000);
	});
</script>