<html>
<head>
<title>Upload Form</title>
</head>
<body>
<form method="post" action="/index.php/upload/do_upload" enctype="multipart/form-data">

	<label for="filetype">檔案類別</label>
	<select name="filetype" id="filetype">
		<option value="1">戶口名簿</option>
		<option value="2">所得</option>
		<option value="3">財產</option>
		<option value="4">學生證/醫療證明</option>
		<option value="5">其他</option>		
	</select>
	<br/>

	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="上傳" />
	<?php echo $msg;?>
</form>

</body>
</html>