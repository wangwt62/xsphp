<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
	<title>简单的基于文本的网络留言板V0.1</title>
</head>
<body>
<?php
	$filename = "./files/notebook.txt";
	/**
	 * 如果提交留言信息，将留言信息写入文本文件
	 */
	if(isset($_POST['submit'])) {
		$username = trim($_POST['username']);
		$title = trim($_POST['title']);
		$message = trim($_POST['message']);
		$content = $username."||".$title."||".$message."<|>";
		writeMessage($content, $filename);
	}
	/**
	 * 如果存在留言本文件，读取文件内容并输出
	 */
	if(file_exists($filename)) {
		readMessage($filename);
	}
	/**
	 * writeMessage函数，将留言信息写入文本文件
	 * @param string $msg 写入文件的信息
	 * @param string $file 存储留言信息的文本文件
	 * @return boolean     是否成功写入信息
	 */
	function writeMessage($msg, $file) {
		$fh = fopen($file, 'a');
		if(flock($fh, LOCK_EX)) {
			fwrite($fh, $msg);
			flock($fh, LOCK_UN);
		} else {
			return 1;
		}
		fclose($fh);
		return 0;
	}
	/**
	 * readMessage函数，读取留言信息
	 * @param string $file 存储留言信息的文本文件
	 */
	function readMessage($file) {
		$fh = fopen($file, 'r');
		flock($fh, LOCK_SH);
		$buffer = "";
		while(!feof($fh)) {
			$buffer .= fread($fh, 1024);
		}
		$messages = explode("<|>", $buffer);
		foreach($messages as $message) {
			list($username, $title, $msg) = explode("||", $message);
			echo "{$username}说：{$title}, {$msg}<hr/>";
		}
		flock($fh, LOCK_UN);
		fclose($fh);
	}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
	用户名 <input type='text' name='username' size='10'/><br/>
	标&nbsp;&nbsp;题 <input type='text' name='title' size='30'/><br/>
	<textarea name='message' rows='3' cols='38'>请在这里输入留言</textarea>
	<input type='submit' name='submit' value='留言'/>
</form>
</body>
</html>