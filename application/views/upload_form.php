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
<hr>
<p>AJAX upload example: </p>
		<!-- ajax upload testing code-->
 		<p id="msg"></p>
        <input type="file" id="file" name="file" />
        <button id="upload">Upload</button>

</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var file_data = $('#file').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    $.ajax({
                        url: '/index.php/upload/upload_file', // point to server-side controller method
                        dataType: 'text', // what to expect back from the server
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                            $('#msg').html(response); // display success response from the server
                        },
                        error: function (response) {
                            $('#msg').html(response); // display error response from the server
                        }
                    });
                });
            });
        </script>
</html>