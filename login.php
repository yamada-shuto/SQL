<?php
  session_start();
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>LOGIN</title>
<link rel="stylesheet" href="login.css">
</head>
<body>
<h1>ログイン</h1><hr>
<?php
function form_output()
{
    echo <<< EOFORM
<form action="" method="POST">
    ID：<input type="text" name="id" size="10"><br>
    Password：<input type="password" name="password" size="10"><br>
    <input type="submit" name="cmd" value="LOGIN">
</form>

EOFORM;
}

function menu_output()
{
    echo <<< EOMENU
    <p><a href="login_ok.php">秘密のページ</a></p>
EOMENU;
}
// main
require "../../pass.php";
try{
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$username,$password);

    if (isset($_SESSION['login_id'])) {
        echo '<p>ログインしています。</p>';
        menu_output();
        exit;
    }

    switch ($_POST['cmd']) {
    case 'LOGIN':
        $sql = "select * from user where id=? and pass=?";
        $result = $pdo->prepare($sql);
        $result->execute(array($_POST['id'],$_POST['password']));
        $row = $result->fetch();
        if (isset($row['id'])) {
            $_SESSION['login_id'] = $row['id'];
            $_SESSION['name']=$row['name'];
        } else {
            unset($_SESSION['login_id']);
            // $_SESSION['login_id']=null; という手もある
        }
        header('Location:login.php');
        break;
      default:
        form_output();
        break;
    }
}catch(PDOException $e){
    print("Error:" . $e->getMessage());
    die();
}
$result = null;
$pdo = null;
?>
</body>
</html>
