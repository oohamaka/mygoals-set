<?php
session_start();
$_SESSION = array();

if(isset($_COOKIE["PHPSESSID"])){
    setcookie("PHPSESSID", '' ,time()-18000, '/');
}

session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Gothic&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- font-family: 'Sawarabi Gothic', sans-serif; -->
    <title>MyGoals-ログイン-</title>
        <!-- BootstrapのCSS読み込み -->
        <!-- jQuery読み込み -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- BootstrapのJS読み込み -->
        <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <h3 text="text-center">ログアウトしました</h3>
    <button onclick="document.location.href='index.php'"  class="btn btn-info m-3">前のページに戻る</button>
    
</body>
</html>