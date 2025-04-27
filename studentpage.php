<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <link rel="stylesheet" href="student_page_styles.css">
    <link rel="icon" href="images/GI_logo.png">
    <title>Tableau de Bord Étudiant</title>
</head>

<body>
    <div class="page_container">
        <?php
        session_start();
        $conn = mysqli_connect('localhost', 'root', '', 'marks_system_db');
        if (!$conn) {
            die("Échec de la connexion." . mysqli_connect_error());
        }

        if ($_SESSION['email'] === null) {
            $_SESSION['error_auth_student'] = "Vous ne pouvez pas accéder à cette page sans vous connecter à votre compte.";
            header("Location: login_form.php");
            exit();
        }


        //dynamic greeting for users
        $sql_username = "SELECT prenom FROM etudiant WHERE email = ?";
        $stmt_username = mysqli_prepare($conn, $sql_username);
        mysqli_stmt_bind_param($stmt_username, "s", $_SESSION['email']);
        mysqli_stmt_execute($stmt_username);
        $username_result = mysqli_stmt_get_result($stmt_username);
        $row_username = mysqli_fetch_assoc($username_result);
        echo "<h1>Bienvenue, {$row_username['prenom']}</h1>";


        //marks table
        $sql_tableau = "SELECT id_module,note FROM note WHERE id_etudiant = ? ";
        $stmt_tableau = mysqli_prepare($conn, $sql_tableau);
        mysqli_stmt_bind_param($stmt_tableau, "s", $_SESSION['email']);
        mysqli_stmt_execute($stmt_tableau);
        $result_tableau = mysqli_stmt_get_result($stmt_tableau);



        if (!mysqli_num_rows($result_tableau)) {
            echo"<div class='waiting'>";
                echo"<img src='images\waiting.gif' alt='en attente'>";
                echo "<h4>Il n'y a pas de nouveautés pour le moment.</h4>";
            echo"</div>";
        }
        else {
            echo "<h2>Vos résultats académiques</h2>";
            echo "<table>";
            echo "<tr>
                <th>Module</th>
                <th>Note</th>
                <th>Resultat</th>
            </tr>";

            while ($rows_tableau = mysqli_fetch_assoc($result_tableau)) {
                

                $resultat_note = null;
                $resultat_class='';//class dyal lresultat(v ou rat) bax nstylihom
                if ($rows_tableau['note'] >= 12) {
                    $resultat_note = 'Validé';
                    $resultat_class = 'valide';
                } else if ($rows_tableau['note'] == null) {//had str kant 3ndo fa2ida mni knt n affichi swa kant n9ta wla la
                    $resultat_note = null;
                } else {
                    $resultat_note = 'Rattrapage';
                    $resultat_class = 'ratt';
                }
                echo "<tr>
                    <td>{$rows_tableau['id_module']}</td>
                    <td>{$rows_tableau['note']}</td>
                    <td class='{$resultat_class}'>{$resultat_note}</td> 
                </tr>";//zdt lclass f data d resultt bax yshal styling
            }
            echo "</table>";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>