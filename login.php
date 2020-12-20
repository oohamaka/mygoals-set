<?php
session_start();
require_once("database.php");

function findUserbyId($dbh,$auth_id){
    $sql = "select * from users where auth_id = ?";
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $auth_id;
    $stmt->execute($data);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$errors = [];
if(!empty($_POST)){
    $user = findUserbyId($dbh,$_POST["auth_id"],$_POST['password']);

    if(password_verify($_POST['password'],$user['password'])){
        //ログイン状態にする
        $_SESSION["login"] = true;
        //$user['password'] = null;これでも良いが、unsetが一般的
        unset($user['password']);
        $_SESSION["user"] = $user;
        //var_dump($user);
        header('Location: r-index.php');
        exit;
    }else{
        $errors[] = "IDまたはパスワードが違います。";
    }
}
//var_dump($_POST);

//var_dump($errors);

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
<header>
    <?php include 'header.php';?>
</header>
<body>
    <h3 class="text-center">-ログイン-</h3>

    <?php if(!empty($errors)):?>
        <ul>
        <?php foreach($errors as $error):?>
            <li><php echo $error ;?></li>
        <?php endforeach ?>
        </ul>
    <?php endif ?>

    <form action="login.php" method="post">
      <p class="text-center">※あなたのID,パスワードを入力してください。</p>
      <label for="exampleInputName" class="col-sm-5 text-center">ユーザーID</label>
      <input class="col-sm-5 "type="text" name="auth_id" id="exampleInputName" placeholder="名前" required>
      <label for="exampleInputPassword" class="col-sm-5 text-center">パスワード</label>
      <input class="col-sm-5" type="password" name="password" id="exampleInputPassword" placeholder="パスワード" required>
      <div class="row">
        <div class="col-sm-4"></div>
        <button type="submit" class="col-sm-4 btn btn-info mt-5">ログイン</button>
        <div class="col-sm-4"></div>
      </div>
    </form>

</body>
</html>
