<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // フォームからの入力データを取得
  $name = htmlspecialchars(trim($_POST['name']));
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $message = htmlspecialchars(trim($_POST['message']));

  // 入力チェック
  if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "すべての項目を正しく入力してください。";
    exit;
  }

  // メール設定
  $to = "info@narsist.org"; // Cloudflare Email Routingで作成したアドレス
  $subject = "お問い合わせ from $name";
  $body = "名前: $name\nメールアドレス: $email\n\nメッセージ:\n$message";
  $headers = "From: no-reply@narsist.org\r\n";
  $headers .= "Reply-To: $email\r\n";

  // メール送信
  if (mail($to, $subject, $body, $headers)) {
    echo "お問い合わせありがとうございます！";
  } else {
    echo "送信に失敗しました。もう一度お試しください。";
  }
} else {
  echo "不正なアクセスです。";
}
?>
