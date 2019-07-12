<?php
require 'database.php';

$message = '';
$msgErr = '';
if (isset($_POST['submit_form'])) {
    if ($_POST['password'] === $_POST['confirm_password']) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {

            $sqlEmail = "SELECT email FROM users WHERE email=:email";
            $sqlEmail = $conn->prepare($sqlEmail);
            $sqlEmail->bindParam(':email', $_POST['email']);
            try {
                $sqlEmail->execute();
                $emailRecord = $sqlEmail->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                $msgErr = 'Error DB: ' . $e->getMessage();
            }
            if (!$emailRecord) {
                $sql = "INSERT INTO users (email, password) VALUES (:email , :password)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $_POST['email']);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password);

                if ($stmt->execute()) {
                    $message = 'Succesfully created new user';
                } else {
                    $message = 'Sorry there must have been an issue creating your account';
                }
            } else {
                $message = 'Oe cheka el email ya existe';
            }
            // $message = 'Oe cheka el email y password';
        } else {
            $message = 'Oe no estas enviando email y password';
        }
    } else {

        $message = 'La cagastes con tu contra';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>SignUp</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <?php require 'partials/header.php' ?>

  <?php if (!empty($message)) : ?>
  <p><?= $message ?></p>
  <p><?= $msgErr ?></p>
  <?php endif; ?>

  <h1>SignUp</h1>
  <span>or <a href="login.php">Login</a></span>

  <form action="signup.php" method="post">
    <input type="text" name="email" placeholder="Enter your email">
    <input type="password" name="password" placeholder="Enter your password">
    <input type="password" name="confirm_password" placeholder="Confirm your password">
    <input type="submit" value="send" name="submit_form">
  </form>
</body>

</html>