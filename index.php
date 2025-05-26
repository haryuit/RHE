<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="style.css">
	<title>お問い合わせフォーム</title>
</head>
<body>
<h1>お問い合わせフォーム</h1>

<?php
// 変数（フラグ）の初期化
$flag = 0;

// エスケープ処理後のデータを格納するための変数
$esc = array();

// エスケープ処理
if(!empty($_POST)) {
	foreach($_POST as $key => $value) {
		$esc[$key] = htmlspecialchars($value, ENT_QUOTES);
	}
}

// バリデーションエラーを格納するための変数
$error = array();

// バリデーション関数
function validation($data) {
	$error = array();

	if(empty($data['username'])) {
		$error[] = "「お名前」をご入力ください";
	}

	if(empty($data['email'])) {
		$error[] = "「メールアドレス」をご入力してください";
	} elseif(!preg_match('/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email'])) {
		$error[] = "「メールアドレス」は正しい形式でご入力ください";
	}

	if(empty($data['message'])) {
		$error[] = "「お問い合わせ内容」をご入力ください";
	}

	return $error;
}


// 状況に応じてフラグの切り替え
if(!empty($esc['confirm'])) {
	// 「確認画面へ」ボタンが押された時の処理

	//バリデーション
	$error = validation($esc);
	if(empty($error)) {
		$flag = 1;

		// セッション開始
		session_start();
		$_SESSION['page'] = true;
	}

} elseif(!empty($esc['submit'])) {
	session_start();
	if(!empty($_SESSION['page']) && $_SESSION['page'] === true) {
		// セッション削除
		unset($_SESSION['page']);

		// 「送信」ボタンが押された時の処理
		$flag = 2;

		// タイムゾーンの設定
		date_default_timezone_set('Asia/Tokyo');

		// 使用言語（日本語）の設定
		mb_language("ja");
		mb_internal_encoding("UTF-8");

		// 自動返信メール件名
		$reply_subject = "お問い合わせいただきありがとうございます";

		// 自動返信メール本文
		$reply_text = "下記の内容でお問い合わせを受け付けました。"."\n\n";
		$reply_text .= "お問い合わせ受付日時：".date('Y-m-d H:i')."\n";
		$reply_text .= "お名前：".$esc['username']."\n";
		$reply_text .= "メールアドレス：".$esc['email']."\n";
		$reply_text .= "電話番号：".$esc['tel']."\n";
		$reply_text .= "お問い合わせ内容：".$esc['message']."\n\n";
		$reply_text .= "Color Piece管理人";

		// 自動返信メールヘッダー情報
		$header = "MIME-Version: 1.0\n";
		$header .= "From: RHE <XXX@gmail.com>\n";
		$header .= "Reply-To: RHE <XXX@gmail.com>\n";

		// 自動返信メールの送信
		mb_send_mail($esc['email'], $reply_subject, $reply_text, $header);


		// 管理者通知メールの件名
		$notice_subject = "ホームページからメッセージがありました";

		// 管理者通知メールの本文
		$notice_text = "下記の内容でお問い合わせを受け付けました。"."\n\n";
		$notice_text .= "お問い合わせ受付日時：".date('Y-m-d H:i')."\n";
		$notice_text .= "お名前：".$esc['username']."\n";
		$notice_text .= "メールアドレス：".$esc['email']."\n";
		$notice_text .= "電話番号：".$esc['tel']."\n";
		$notice_text .= "お問い合わせ内容：".$esc['message']."\n";

		// 管理者通知メールの送信
		mb_send_mail('mori8ru8715@gmail.com', $notice_subject, $notice_text, $header);

	} else {
		$flag = 0;
	}
} else {
	$flag = 0;
}


// フラグに応じて表示する画面を切り替え
if($flag === 1) {
// 確認画面のHTMLコード
?>
<form method="post" action="" class="post">
	<label>お名前<span>*</span></label>
	<p><?php echo $esc['username'] ?></p>
	<label>メールアドレス<span>*</span></label>
	<p><?php echo $esc['email'] ?></p>
	<label>電話番号</label>
	<p><?php echo $esc['tel'] ?></p>
	<label>お問い合わせ内容<span>*</span></label>
	<p><?php echo $esc['message'] ?></p>
	<input type="submit" name="back" value="戻る">
	<input type="submit" name="submit" value="送信">

	<!-- データを受け渡すために一時的に保存 -->
	<input type="hidden" name="username" value="<?php echo $esc['username'] ?>">
	<input type="hidden" name="email" value="<?php echo $esc['email'] ?>">
	<input type="hidden" name="tel" value="<?php echo $esc['tel'] ?>">
	<input type="hidden" name="message" value="<?php echo $esc['message'] ?>">
</form>
<?php

} elseif($flag === 2) {
// 送信完了画面のHTMLコード
?>
<p class="complete">送信が完了しました。</p>
<?php

} else {
// お問い合わせフォームのHTMLコード
	if(!empty($error)) {
?>
	<ul class="error">
	<?php foreach($error as $value) { ?>
		<li><?php echo $value; ?></li>
	<?php } ?>
	</ul>
<?php
	}
?>

<form method="post" action="" class="post">
	<label>お名前<span>*</span></label>
	<input type="text" name="username" value="<?php if(!empty($esc['username'])) {echo $esc['username'];} ?>">
	<label>メールアドレス<span>*</span></label>
	<input type="email" name="email" value="<?php if(!empty($esc['email'])) {echo $esc['email'];} ?>">
	<label>電話番号</label>
	<input type="tel" name="tel" value="<?php if(!empty($esc['tel'])) {echo $esc['tel'];} ?>">
	<label>お問い合わせ内容<span>*</span></label>
	<textarea rows="7" name="message"><?php if(!empty($esc['message'])) {echo $esc['message'];} ?></textarea>
	<input type="submit" name="confirm" value="確認画面へ">
</form>
<?php
}
?>

</body>
</html>