<!DOCTYPE HTML>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>print css test by mtness</title>
    <style type="text/css">
	@media screen{
	    #watermark { 
			font-family: 標楷體;
			top:30%;
			left: 10%;
			margin-top:-12px;
            position:absolute;
            z-index: 5;
			opacity:0.25;
			font-size:40px; 
			text-align:center;
			-webkit-transform: rotate(45deg);
			-moz-transform: rotate(45deg);
			-webkit-transform: rotate(45deg);
			-o-transform: rotate(45deg);
			-ms-transform: rotate(45deg);
        }
		
		#watermark2 { 
			font-family: 標楷體;
			top:70%;
			left: 50%;
			margin-top:-12px;
            position:absolute;
            z-index: 5;
			opacity:0.25;
			font-size:40px; 
			text-align:center;
			-webkit-transform: rotate(45deg);
			-moz-transform: rotate(45deg);
			-webkit-transform: rotate(45deg);
			-o-transform: rotate(45deg);
			-ms-transform: rotate(45deg);
        }

        div { 
            position: relative;
            top: 0em;
			left: 0em;
            display: block;
			overflow: hidden;
            /*page-break-after: always;*/
            z-index: 0;
        }
	}
	
	@page {
		margin: 0mm;
		
	}
		
    @media print{
		html, body {
			margin: 0mm;
			/*height: calc(100vh);*/
		}
		
        #watermark { 
			font-family: 標楷體;
			top:50%;
			left: 10%;
			margin-top:-12em;
            position:absolute;
            z-index: 5;
			opacity:0.3;
			font-size:1.3em; 
			text-align:center;
			-webkit-transform: rotate(45deg);
			-moz-transform: rotate(45deg);
			-webkit-transform: rotate(45deg);
			-o-transform: rotate(45deg);
			-ms-transform: rotate(45deg);
        }
		
		#watermark2 { 
			font-family: 標楷體;
			top:50%;
			right: 10%;
			margin-top:7em;
            position:absolute;
            z-index: 5;
			opacity:0.3;
			font-size:1.3em; 
			text-align:center;
			-webkit-transform: rotate(45deg);
			-moz-transform: rotate(45deg);
			-webkit-transform: rotate(45deg);
			-o-transform: rotate(45deg);
			-ms-transform: rotate(45deg);
        }

        div { 
			text-align:right;
            position: relative;
            top: 0em;
			left: 0em;
            display: block;
			overflow: hidden;
            /*page-break-after: always;*/
            z-index: 0;
			width:calc(99.95vw);
			height:calc(99.95vh) !important;
			/*width:209mm;
			height:297mm;
			max-width:209mm important!
			max-height:297mm important!*/
        }
		p {
			display: block;
			margin: 0em;
			-webkit-margin-before: 0em important!;
			-webkit-margin-after: 0em important!;
			-webkit-margin-start: 0px;
			-webkit-margin-end: 0px;
		}
		img{
			
			padding:0; margin:0;
			width:calc(99.9%);
			height:calc(99.9%);		
			/*max-height:99% important!; 
			
			width:208mm; height:296mm;*/
		}

    }
    </style>
</head>
<script>
/*
	var isNS = (navigator.appName == "Netscape") ? 1 : 0;
	
	if(navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
	
	function mischandler(){
		return false;
	}
	
	function mousehandler(e){
		var myevent = (isNS) ? e : event;
		var eventbutton = (isNS) ? myevent.which : myevent.button;
		if((eventbutton==2)||(eventbutton==3)) return false;
	}
	
	document.oncontextmenu = mischandler;
	document.onmousedown = mousehandler;
	document.onmouseup = mousehandler;
	var isCtrl = false;
	document.onkeyup=function(e){
		if(e.which == 17)
		isCtrl=false;
	}
		
	document.onkeydown=function(e){
		if(e.which == 17)
		isCtrl=true;
		if(((e.which == 85) || (e.which == 117) || (e.which == 65) || (e.which == 97) || (e.which == 67) || (e.which == 99)) && isCtrl == true){
			// alert(‘Keyboard shortcuts are cool!’);
			return false;
		}
	}	
	*/
</script>

<!--onfocus="window.close()" onmousemove="window.close()"-->
<body onload="window.print()" >
<?php for($i=0;$i<count($print_images_array);$i++){?>  

    <div>
		<p><img src="<?=$print_images_array[$i]?>"></p>
		<?php if($water_mark_check==1){?>
		<p id="watermark">
			<?=$OrganizationName?>　<?=$Department?>　<?=date('Y/m/d', mktime())?><br>依個人資料保護法，此文件未經許可<br>不得轉載或擅作他用。
		</p>
		<p id="watermark2">
			<?=$OrganizationName?>　<?=$Department?>　<?=date('Y/m/d', mktime())?><br>依個人資料保護法，此文件未經許可<br>不得轉載或擅作他用。
		</p>
		<?php }?>
	</div>
<?php }?>	
</body>
</html>