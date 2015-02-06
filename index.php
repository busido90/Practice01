<?php
// require('../dbconnect.php');

// session_start();

// if (!empty($_POST)) {

// 	if ($_POST['name'] == '') {
// 		$error['name'] = 'blank';
// 	}

// 	if ($_POST['email'] == '') {
// 		$error['email'] = 'blank';
// 	}

// 	if (strlen($_POST['password']) < 4) {
// 		$error['password'] = 'length';
// 	}

// 	if ($_POST['password'] == '') {
// 		$error['password'] = 'blank';
// 	}

// 	$fileName = $_FILES['image']['name'];
// 	if (!empty($fileName)) {
// 		$ext = substr($fileName, -4);
// 		if ($ext != '.jpg' && $ext != '.gif' && $ext != 'jpeg' && $ext != '.png') {
// 			$error['image'] = 'type';
// 		}
// 	}

// 	if (empty($error)) {
// 		$sql = sprintf('SELECT COUNT(*) AS cnt FROM members WHERE email="%s"',
// 			mysqli_real_escape_string($db, $_POST['email'])
// 			);
// 		$record = mysqli_query($db, $sql) or die(mysqli_error($db));
// 		$table = mysqli_fetch_assoc($record);
// 		if ($table['cnt'] > 0) {
// 			$error['email'] = 'duplicate';
// 		}
// 	}

// 	if (empty($error)) {
// 		//type=fileのところのname属性をimageにしたから$_FILES['image']['name']？
// 		$image = date('YmdHis') . $_FILES['image']['name'];
// 		move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $image);
// 		$_SESSION['join'] = $_POST;
// 		$_SESSION['join']['image'] = $image;
// 		header('Location: check.php');
// 		exit();
// 		// var_dump($_FILES['image']);
// 	}
	
// 	if (isset($_GET['action'])) {
// 		if ($_GET['action'] == 'rewrite') {
// 			$_POST = $_SESSION['join'];
// 			$error['rewrite'] = true;
// 		}
// 	}
// 	$judge = array_filter($error);	
// }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ひとこと掲示板</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div id="wrap">
	<div id="head">
		<h1>ひとこと掲示板</h1>
	</div>
	<div id="content">
		<form action="" method="post">
			<dl>
				<dt>メッセージをどうぞ</dt>
				<dd>
					<textarea name="message" cols="50" rows="5"></textarea>
				</dd>
			</dl>
			<div>
				<input type="submit" value="投稿する" />
			</div>
		</form>
	</div>
	<div id="foot">
<!-- 		<p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H20 SPACE, Mynavi" /></p> -->
	</div>
</body>
</html>