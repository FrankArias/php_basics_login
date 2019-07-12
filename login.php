<?php

session_start();

if (isset($_SESSION['user_id'])){
header('Location:  /php_login');
}

require 'database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])){
 $records = $conn->prepare('SELECT id, email, password FROM users WHERE email=:email');
 $records->bindParam(':email', $_POST['email']);
 $records->execute();
 $results = $records->fetch(PDO::FETCH_ASSOC);


 $message = '';

 if(count($results) > 0 && password_verify($_POST['password'], $results['password'])){
    $_SESSION['user_id'] = $results['id'];
    header('Location: /php_login');
 } else{
     $message = 'Sorry, those credential do not match';
 }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php require 'partials/header.php' ?>   

    <h1>Login</h1>
    <span>or <a href="signup.php">SignUp</a></span>

    <?php if (!empty($message)) : ?>
        <p> <?= $message ?> </P>
    <?php endif ?>

    <form action="login.php" method="post">
      <input type="text" name="email" placeholder="Enter your email">
      <input type="password" name="password" placeholder="Enter your password">
      <input type="submit" value="send">
    </form>
</body>
</html>