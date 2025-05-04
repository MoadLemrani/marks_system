<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width , initial-scale=1.0">
        <link rel="icon" href="images/GI_logo.png">
        <link rel="stylesheet" href="forgot_password_styles.css">
        <title>Réinitialisation du mot de passe</title>
    </head>
    <body>
        <div class="container">
            <h1>Réinitialisation du mot de passe</h1>
            <p>Vous avez oublié votre mot de passe ? Entrez votre adresse e-mail ci-dessous et nous vous enverrons un e-mail vous permettant de le réinitialiser.</p>
            <form action="password_script.php" method="post">
                <input type="email" id="email" name="email" placeholder="Adresse e-mail" required autofocus>
                <input type="submit" value="Réinitialiser">
            </form>
        </div>
    </body>
</html>