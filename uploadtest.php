<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
	<title>上传文件测试</title>
</head>
<body>
	<form action='upload.php' method='post' enctype='multipart/form-data'>
		<input type='hidden' name='MAX_FILE_SIZE' value='1000000'/>
		选择文件: <input type='file' name='myfile'/><input type='submit' value='上传文件' name='submit'/>
	</form>
</body>
</html>