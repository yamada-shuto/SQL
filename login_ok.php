<?php
  session_start();
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>秘密のページ</title>
<link rel="stylesheet" href="login.css">
</head>
<body>
<h1>ログイン状況</h1><hr>
<?php

// main
if ($_POST['cmd'] == 'LOGOFF') {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    session_destroy();
    echo '<p>Logoffしました</p>';
    echo "<a href='login.php'>→login画面へ</a>";
    exit;
}

if (!isset($_SESSION['login_id']) or $_SESSION['login_id'] == '') {
    echo "<p>ログインしていません</p>\n";
    echo "<p>勝手に見ないで！</p>\n";
    echo "<a href='login.php'>→login画面へ</a>";
} else {
    $id = $_SESSION['login_id'];
    $name = $_SESSION['name'];
    echo "<p>現在ログイン中です</p>\n";
    echo "id:$id name:$name";

    echo <<< EOFORM
    <form action="" method="POST">
      <input type="hidden" name="cmd" value="LOGOFF">
      <input type="submit" value="LOGOFF">
    </form>
EOFORM;
}

?>
</body>
</html>
