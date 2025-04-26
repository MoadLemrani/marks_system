<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width , initial-scale=1">
    <link rel="icon" href="images/GI_logo.png">
    <link rel="stylesheet" href="login_form_style.css">
    <title>Connexion</title>
</head>

<body>
    <div class="login_container"><!--njm"kolxi f container bax nstylih-->
        <div class="logo">
            <img src="images/GI_logo.png">
        </div>
           
        <h1>Connexion</h1>
        <?php
        session_start();

        $error_messages = [];//jm3 ga3 l errors f array bax n affichihom d9a w7da
        
        if (isset($_SESSION['login_error'])) {
            $error_messages[] = $_SESSION['login_error'];//push f array using []
            unset($_SESSION['login_error']);
        }
        if (isset($_SESSION['manque_id'])) {
            $error_messages[] = $_SESSION['manque_id'];
            unset($_SESSION['manque_id']);
        }
        if (isset($_SESSION['error_auth_prof'])) {
            $error_messages[] = $_SESSION['error_auth_prof'];
            unset($_SESSION['error_auth_prof']);
        }
        if (isset($_SESSION['error_auth_student'])) {
            $error_messages[] = $_SESSION['error_auth_student'];
            unset($_SESSION['error_auth_student']);
        }

        if (!empty($error_messages)) {
            echo '<div class="error_messages">';//anjm3o l errors f container bax nstylihom b CSS
            echo implode("<br>", array_unique($error_messages));//afiche ga3 l errors li kaynin
            echo '</div>';
        }


        ?>
        <form action="login.php" method="post">
            <div class="form_group">
                <label for="email">E-mail académique</label>
                <input type="email" id="email" name="email" placeholder="prenom.nom@ump.ac.ma" required autofocus>
            </div>
            <div class="form_group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>

</html>