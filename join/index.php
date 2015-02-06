<?php
require('../dbconnect.php');

session_start();

if (!empty($_POST)) {

	if ($_POST['name'] == '') {
		$error['name'] = 'blank';
	}

	if ($_POST['email'] == '') {
		$error['email'] = 'blank';
	}

	if (strlen($_POST['password']) < 4) {
		$error['password'] = 'length';
	}

	if ($_POST['password'] == '') {
		$error['password'] = 'blank';
	}

	$fileName = $_FILES['image']['name'];
	if (!empty($fileName)) {
		$ext = substr($fileName, -4);
		if ($ext != '.jpg' && $ext != '.gif' && $ext != 'jpeg' && $ext != '.png') {
			$error['image'] = 'type';
		}
	}

	if (empty($error)) {
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM members WHERE email="%s"',
			mysqli_real_escape_string($db, $_POST['email'])
			);
		$record = mysqli_query($db, $sql) or die(mysqli_error($db));
		$table = mysqli_fetch_assoc($record);
		if ($table['cnt'] > 0) {
			$error['email'] = 'duplicate';
		}
	}

	if (empty($error)) {
		//type=fileのところのname属性をimageにしたから$_FILES['image']['name']？
		$image = date('YmdHis') . $_FILES['image']['name'];
		move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $image);
		$_SESSION['join'] = $_POST;
		$_SESSION['join']['image'] = $image;
		header('Location: check.php');
		exit();
		// var_dump($_FILES['image']);
	}
	
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'rewrite') {
			$_POST = $_SESSION['join'];
			$error['rewrite'] = true;
		}
	}
	$judge = array_filter($error);	
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Sign in</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<p>次のフォームに必要事項をご記入ください。</p>
<form method="post" enctype="multipart/form-data">
	<dl>
		<dt>ニックネーム<span class="required" >必須</span></dt>
		<dd>
<!-- 連想配列は絶対にキーを指定しなくてはいけない？それともissetの仕様？ -->
			<?php if (!isset($_POST['name'])): ?>
				<input type="text" name="name" size="35" maxlength="255" />
			<?php  endif; ?>

			<?php if (isset($_POST['name'])): ?>
				<input type="text" name="name" size="35" maxlength="255"
				value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'); ?>" />
				<?php if (isset($error['name'])) : ?> 
					<?php if ($error['name'] == 'blank') : ?>
						<p class="error"> * ニックネームを入力してください</p>
					<?php  endif; ?>
				<?php  endif; ?>
			<?php endif; ?>
		</dd>
		<dt>メールアドレス<span class="required">必須</span></dt>
		<dd>
			<?php if (!isset($_POST['email'])): ?>
				<input type="text" name="email" size="35" maxlength="255" />
			<?php  endif; ?>
			<?php if (isset($_POST['email'])): ?>
				<input type="text" name="email" size="35" maxlength="255" 
				value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>" />
				<?php if (isset($error['email'])) : ?> 
					<?php if ($error['email'] == 'blank') : ?>
						<p class="error"> * メールアドレスを入力してください</p>
					<?php  endif; ?>
					<?php if ($error['email'] == 'duplicate') : ?>
						<p class="error"> * 指定されたメールアドレスはすでに登録されています</p>
					<?php  endif; ?>	
				<?php  endif; ?>
			<?php endif; ?>
		</dd>
		<dt>パスワード<span class="required">必須</span></dt>
		<dd>
			<?php if (!isset($_POST['password'])): ?>
				<input type="password" name="password" size="10" maxlength="20" />
			<?php  endif; ?>
			<?php if (isset($_POST['password'])): ?>
				<input type="password" name="password" size="10" maxlength="20" 
				value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'); ?>" />
				<?php if (isset($error['password'])) : ?> 
					<?php if ($error['password'] == 'blank') : ?>
						<p class="error"> * パスワードを入力してください</p>
					<?php  endif; ?>
					<?php if ($error['password'] == 'length') : ?>
						<p class="error"> * パスワードは４文字以上で入力してください</p>
					<?php  endif; ?>	
				<?php  endif; ?>
			<?php  endif; ?>
		</dd>
		<dt>写真など</dt>
		<dd>
				<input type="file" name="image" size="35" />
		</dd>
			<?php if (isset($error['image'])) : ?> 
				<?php if (!$error['image'] == 'type'): ?>
					<p class="error">* 写真などは「.gif」、「.jpg」、「.png」、「jpeg」の画像をしてください</p>
				<?php endif; ?>
			<?php  endif; ?>
			<?php if (!empty($error)): ?>
				<p class="error">* 恐れ入りますが、画像を改めて指定してください</p>
			<?php endif; ?>	
	</dl>
	<div><input type="submit" value="入力内容を確認する" /></div>
</form>
</body>
</html>