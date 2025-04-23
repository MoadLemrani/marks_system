<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>LOGIN</title>
</head>

<body>
    <h1><b>LOGIN</b></h1>
    <?php
    session_start();
    if (isset($_SESSION['login_error'])) {
        echo "<p style='color : red;'>{$_SESSION['login_error']}</p>";
        unset($_SESSION['login_error']);
    }
    if (isset($_SESSION['manque_id'])) {
        echo "<p style='color : red;'>{$_SESSION['manque_id']}</p>";
        unset($_SESSION['manque_id']);
    }
    if(isset($_SESSION['error_auth_prof'])){
        echo"<p style='color : red;'>{$_SESSION['error_auth_prof']}</p>";
        unset($_SESSION['error_auth_prof']);
    }
    if(isset($_SESSION['error_auth_student'])){
        echo"<p style='color : red;'>{$_SESSION['error_auth_student']}</p>";
        unset($_SESSION['error_auth_student']);
    }


    ?>
    <form action="login.php" method="post">
        <label for="email">E-mail académique :</label><br>
        <input type="email" id="email" name="email" autofocus placeholder="E-mail académique" required><br>
        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" placeholder="Mot de passe" required><br><br>
        <button type="submit">Se connecter</button>
    </form>
</body>

</html>