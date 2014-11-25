<?php
$allowtype = array('gif', 'png', 'jpg');
$size = 1000000;
$path = './uploads';

// 判断文件是否可以成功上传到服务器，$_FILES['myfile']['error']为0表示上传成功
if($_FILES['myfile']['error'] > 0) {
	echo '上传错误：';
	switch($_FILES['myfile']['error']) {
		case 1:
			die('上传文件的大小超出了PHP配置文件中的约定值：upload_max_filesize');
		case 2:
			die('上传文件的大小超出了表单中的约定值：MAX_FILE_SIZE');
		case 3:
			die('文件只被部分上传');
		case 4:
			die('没有任何上传文件');
		default:
			die('未知错误');
	}
}

// 判断上传文件是否为允许的文件类型，通过文件的后缀名
$hz = array_pop(explode('.', $_FILES['myfile']['name']));
// 通过上传文件的后缀名来判断文件是否是允许的文件类型
if(!in_array($hz, $allowtype)) {
	die('文件后缀为<b>'.$hz.'</b>，不是允许的文件类型！');
}
// 也可以通过获取上传文件的MIME类型中的主类型和子类型，来限制文件上传的类型
list($maintype, $subtype) = explode('/', $_FILES['myfile']['type']);
if($maintype == 'text') {
	die('不能上传文本文件!');
}
// 判断上传文件的大小是否允许
if($_FILES['myfile']['size'] > $size) {
	die('超过了允许的'.$size.'字节大小！');
}
// 为上传文件命名
$filename = date('YmdHis').rand(100, 999).'.'.$hz;
// 判断是否为上传文件
if(is_uploaded_file($_FILES['myfile']['tmp_name'])) {
	if(!move_uploaded_file($_FILES['myfile']['tmp_name'], $path.'/'.$filename)) {
		die('不能移动上传文件到指定目录！');
	}
} else {
	die('上传文件'.$_FILES['myfile']['name'].'不是一个合法的文件！');
}
// 上传成功
echo '文件'.$_FILES['myfile']['name'].'上传成功，保存在'.$path.'目录中，文件大小为'.$_FILES['myfile']['size'].'<br/>';