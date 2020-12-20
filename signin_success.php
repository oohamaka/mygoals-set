<?php
ini_set('display_errors',"on");
include 'header.php';

echo '新しいユーザーID登録に成功しました！！';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Gothic&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- font-family: 'Sawarabi Gothic', sans-serif; -->
    <title>mygoals</title>
        <!-- BootstrapのCSS読み込み -->
        <!-- jQuery読み込み -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- BootstrapのJS読み込み -->
        <script src="js/bootstrap.min.js"></script>
</head>
<!--<header>
    <?php include 'header.php'; ?>
</header>-->
<body>
    <div class = "row col-sm-12">
      <!--<button class="btn btn-info ml-5" onclick="location.href='http://localhost:8888/mygoals/bootstrap-4.5.1-dist/login.php'">ログインする</button>-->
      <button class="btn btn-info ml-5" onclick="location.href='login.php'">ログインする</button>
    </div>
</body>
</html>