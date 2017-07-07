<!DOCTYPE HTML>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" id="viewport" name="viewport">
    <title>print css test by mtness</title>
    <style type="text/css">
	.C1{
		background-color: #ced790;
	}
	.C1-1{
		background-color: #ebeed6;
	}
	.C2{
		background-color: #90c5d7;
	}
	.C2-1{
		background-color: #d7e8ee;
	}
	.C3{
		background-color: #d79b90;
	}
	.C3-1{
		background-color: #f2e4e1;
	}
	.C4{
		background-color: #d490d7;
	}
	.C4-1{
		background-color: #e9d9ea;
	}
	table {
    	border-spacing: 0;
    	border-collapse: collapse;
	}




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
    	h3{
    		margin-top: 0.4em;
    		margin-bottom: 0.15em;
    		font-size: 1em;
    	}
    	.MT{
    		font-size: 1.3em;
    	}
		html, body {
			margin: 0mm;
			-webkit-print-color-adjust: exact;
			font-family: DFKai-sb !important;
			/*height: calc(100vh);*/
		}
		
        #watermark { 
			font-family: 標楷體;
			top:50%;
			left: 10%;
			margin-top:-12em;
            position:absolute;
            z-index: 5;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
			  /* IE 5-7 */
			  filter: alpha(opacity=50);

			  /* Netscape */
			  -moz-opacity: 0.5;

			  /* Safari 1.x */
			  -khtml-opacity: 0.5;

			  /* other intelligent browsers */
			  opacity: 0.5;
			color:gray;
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
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
			  /* IE 5-7 */
			  filter: alpha(opacity=50);

			  /* Netscape */
			  -moz-opacity: 0.5;

			  /* Safari 1.x */
			  -khtml-opacity: 0.5;

			  /* other intelligent browsers */
			  opacity: 0.5;
			color:gray;
			font-size:1.3em; 
			text-align:center;
			-webkit-transform: rotate(45deg);
			-moz-transform: rotate(45deg);
			-webkit-transform: rotate(45deg);
			-o-transform: rotate(45deg);
			-ms-transform: rotate(45deg);
        }

        div { 
			/*text-align:right;*/
            position: relative;
            top: 0em;
			left: 0em;
            display: block;
			overflow: hidden;
            /*page-break-after: always;*/
            z-index: 0;
			
			/*width:209mm;
			height:297mm;
			max-width:209mm important!
			max-height:297mm important!*/
        }
        #paper_s{
        	margin-top: 1em;
        	/*background-color: gray;*/
        	width:calc(99.95vw);
			height:calc(99.95vh - 2em) !important;
        }
		p{
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
    <script src="/0MS/js/jquery-3.1.0.min.js"></script>
    <script language="javascript">
 var scrollFunc=function(e){ 
  e=e || window.event; 
  if(e.wheelDelta && event.ctrlKey){//IE/Opera/Chrome 
   event.returnValue=false;
  }else if(e.detail){//Firefox 
   event.returnValue=false; 
  } 
 }  
 if(document.addEventListener){ 
 document.addEventListener('DOMMouseScroll',scrollFunc,false); 
 }//W3C 
 window.onmousewheel=document.onmousewheel=scrollFunc;//IE/Opera/Chrome/Safari 
</script>
</head>


<!--onfocus="window.close()" onmousemove="window.close()"-->
<body style="zoom:1.0;">
	<!--<div style="width: 100%;height: 100%;background-color: green;">
		
	</div>-->

    <div id="paper_s">
    	<label><h3 class="MT" style="width: 100%;text-align: center;margin-top:0;margin-bottom:0.7em; ">服兵役役男家屬生活扶助案件---<?php echo $file_info->作業類別名稱; ?>案件</h3></label>
    	<table id="boy_info" border="1" style="text-align: center;width: 95%;margin:auto;/*margin-top: 0.5em;*/">
			<tbody>
			<tr>
				<td class="C1-1" style="width:10%;">役男姓名</td><td style="width:27.5%;"><?php echo $file_info->役男姓名; ?></td>
				<td class="C2-1" style="width:10%;">身分證號</td><td style="width:27.5%;"><?php echo $file_info->身分證字號; ?></td>
				<td class="C3-1" style="width:10%;">役男生日</td><td style="width:15%;"><?php $date = new DateTime($file_info->役男生日); $date->modify("-1911 year"); echo ltrim($date->format('Y年m月d日'),"0");?></td>
			</tr>
			<tr>
				<td class="C1-1">入伍日期</td><td><?php $date = new DateTime($file_info->入伍日期); $date->modify("-1911 year"); echo ltrim($date->format('Y年m月d日'),"0");?></td>
				<td class="C2-1">服役軍種</td><td><?php echo $file_info->服役軍種; ?></td>
				<td class="C3-1">服役狀態</td><td><?php echo $file_info->服役狀態; ?></td>
			</tr>
			<tr>
				<td class="C1-1">戶籍地址</td><td  colspan="3" style="/*font-size:0.95em; vertical-align: bottom;*/"><?php echo $file_info->County_name.$file_info->Town_name.$file_info->Village_name.$file_info->戶籍地址; ?></td>
				<td class="C1-1">申請日期</td><td><?php $date = new DateTime($file_info->建案日期); $date->modify("-1911 year"); echo ltrim($date->format('Y年m月d日'),"0");?></td>
			</tr>
			</tbody>
		</table><br>
		<table id="file_info_table" border="1" style="text-align: center;width: 95%;margin:auto; font-size:0.9em; ">
		<tbody><tr>
			<td class="C1-1" colspan="2">動產</td>
			<td class="C2-1" colspan="4">不動產</td>
			<td class="C3-1" colspan="3">所得</td>
			<td class="C4-1" >全戶</td>
			</tr>
			<tr>
			<td class="C1-1">存款</td>
			<td class="C1-1">投資</td>
			<td class="C2-1">房屋棟數</td>
			<td class="C2-1">房屋總價</td>
			<td class="C2-1">列計棟數</td>
			<td class="C2-1">列計價值</td>
			<td class="C3-1">薪資</td>
			<td class="C3-1">營利</td>
			<td class="C3-1">財產</td>
			<td class="C4-1">列計人口</td>
			</tr>
			<tr>
			<td>$<span id="PH-Deposits"><?php echo number_format($file_info->存款本金總額); ?></span></td>
			<td>$<span id="PH-Investment"><?php echo number_format($file_info->投資總額); ?></span></td>
			<td><span id="PH-Houses"><?php echo number_format($file_info->房屋棟數); ?></span>棟</td>
			<td>$<span id="PH-Houses-total"><?php echo number_format($file_info->房屋總價); ?></span></td>
			<td><span id="PH-Houses-num"><?php echo number_format($file_info->房屋列計棟數); ?></span>棟</td>
			<td>$<span id="PH-Houses-listtotal"><?php echo number_format($file_info->房屋列計總價); ?></span></td>
			<td>$<span id="PH-Salary"><?php echo number_format($file_info->薪資月所得); ?></span></td>
			<td>$<span id="PH-Profit"><?php echo number_format($file_info->營利月所得); ?></span></td>
			<td>$<span id="PH-Property-int"><?php echo number_format($file_info->財產月所得); ?></span></td>
			<td><span id="PH-members"><?php echo number_format($file_info->總列計人口); ?></span>人</td>
			</tr>
			<tr>
			<td class="C1-1">證券</td>
			<td class="C1-1">其他</td>
			<td class="C2-1">土地筆數</td>
			<td class="C2-1">土地總值</td>
			<td class="C2-1">列計筆數</td>
			<td class="C2-1">列計價值</td>
			<td class="C3-1">利息</td>
			<td class="C3-1">股利</td>
			<td class="C3-1">其他</td>
			<td class="C4-1">生活所需</td>
			</tr>
			<tr>
			<td>$<span id="PH-Securities"><?php echo number_format($file_info->有價證券總額); ?></span></td>
			<td>$<span id="PH-others-Pro"><?php echo number_format($file_info->其他動產總額); ?></span></td>
			<td><span id="PH-Land"><?php echo number_format($file_info->土地筆數); ?></span>筆</td>
			<td>$<span id="PH-Land-total"><?php echo number_format($file_info->土地總價); ?></span></td>
			<td><span id="PH-Land-num"><?php echo number_format($file_info->土地列計筆數); ?></span>筆</td>
			<td>$<span id="PH-Land-listtotal"><?php echo number_format($file_info->土地列計總價); ?></span></td>
			<td>$<span id="PH-Bank-int"><?php echo number_format($file_info->利息月所得); ?></span></td>
			<td>$<span id="PH-Stock-int"><?php echo number_format($file_info->股利月所得); ?></span></td>
			<td>$<span id="PH-others-int"><?php echo number_format($file_info->其他月所得); ?></span></td>
			<td>$<span id="PH-need"><?php echo number_format($file_info->月所需); ?></span></td>
			</tr>
			<tr>
			<td class="C1-1" colspan="2">動產列計總額</td>
			<td class="C2-1" colspan="4">不動產列計總額</td>
			<td class="C3-1" colspan="3">月均所得總額</td>
			<td class="C4-1">扶助等級</td>
			</tr>
			<tr>
			<td colspan="2">$<span id="PH-total-pro"><?php echo number_format($file_info->總動產); ?></span></td>
			<td colspan="4">$<span id="PH-total-imm"><?php echo number_format($file_info->不動產列計總額); ?></span></td>
			<td colspan="3">$<span id="PH-total-inc"><?php echo number_format($file_info->月總所得); ?></span></td>
			<td><span id="PH-level"><?php echo $file_info->扶助級別; ?></span></td></tr>
		</tbody></table>
			<label><h3 style="margin-left: 2.5%;">區公所初審記事</h3></label>
			<textarea style="margin-left: 2.5%; width: 94%;height: 11em;resize:none;border: 1px solid black;" id="PH-file_comm_1"><?php echo $file_info->{'整體家況敘述-公所'}; ?></textarea>
			<label><h3 style="margin-left: 2.5%;">區公所核章</h3></label>
			<table id="seal_town" border="1" style="text-align: center;width: 95%;margin:auto;/*margin-top: 0.5em;*/">
			<tbody><tr>
			<td class="C4-1" style="width: 20%">里幹事</td>
			<td class="C1-1" style="width: 20%">承辦人</td>
			<td class="C2-1" style="width: 25%">課長</td>
			<td class="C3-1" style="width: 35%">區長</td>
			</tr>
			<tr>
			<td style="height: 5em;"><span style="color:#cfcfcf;">簽章</span></td>
			<td><span style="color:#cfcfcf;">簽章</span></td>
			<td><span style="color:#cfcfcf;">簽章</span></td>
			<td><span style="color:#cfcfcf;">簽章</span></td>
			</tr>
			</tbody>
			</table>
			
			<label><h3 style="margin-left: 2.5%;">市政府複審記事</h3></label>
			<textarea style="margin-left: 2.5%; width: 94%;height: 11em; resize:none;border: 1px solid black;" id="PH-file_comm_2"><?php echo $file_info->{'整體家況敘述-局處'}; ?></textarea>
			<label><h3 style="margin-left: 2.5%;">市政府核章</h3></label>
			<table id="seal_county" border="1" style="text-align: center;width: 95%;margin:auto;/*margin-top: 0.5em;*/">
			<tbody>
			<tr>
				<td class="C4-1" style="width: 25%">承辦人</td>
				<td class="C1-1" style="width: 25%">科長</td>
				<td class="C2-1" style="width: 50%">複查核列等級</td>
			</tr>
			<tr>
				<td style="height: 5.5em;"><span style="color:#cfcfcf;">簽章</span></td>
				<td><span style="color:#cfcfcf;">簽章</span></td>
				<td rowspan="3"><span style="color:#a0a0a0;"></span></td>
			</tr>
			<tr>
				<td class="C2-1">局長</td>
				<td class="C3-1">市長</td>
			</tr>
			<tr>
				<td style="height: 5.5em;"><span style="color:#cfcfcf;">簽章</span></td>
				<td><span style="color:#cfcfcf;">簽章</span></td>
			</tr>
			</tbody>
			</table>


			<p id="watermark">
				<?=$OrganizationName?>　<?=$Department?>列印　<?=date('Y/m/d', time())?><br>依個人資料保護法，此文件未經許可<br>不得轉載或擅作他用。
			</p>
			<p id="watermark2">
				<?=$OrganizationName?>　<?=$Department?>列印　<?=date('Y/m/d', time())?><br>依個人資料保護法，此文件未經許可<br>不得轉載或擅作他用。
			</p>
	</div>

</body>
<script type="text/javascript">
	//numberWithCommas  轉換成有千分號的數字字串
	function numberWithCommas(x){  
	    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(document).ready(function() {
		window.print();
	});
	
</script>
</html>