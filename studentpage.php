<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
</head>

<body>
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
        echo "<h4>Il n'y a pas de nouveautés pour le moment.</h4>";
    } else {
        echo "<h2>Your marks table</h2>";
        echo "<table style='border: 2px solid;'>";
        echo "<tr>
        <th style='border: 2px solid;'>Module</th>
        <th style='border: 2px solid;'>Note</th>
        <th style='border: 2px solid;'>Resultat</th>
        </tr>";
        while ($rows_tableau = mysqli_fetch_assoc($result_tableau)) {
            echo " <tr>
                    <td style='border: 2px solid;'>{$rows_tableau['id_module']}</td>
                    <td style='border: 2px solid;'>{$rows_tableau['note']}</td>";

            $resultat_note = null;
            if ($rows_tableau['note'] >= 12) {
                $resultat_note = 'V';
            } else if ($rows_tableau['note'] == null) {
                $resultat_note = null;
            } else {
                $resultat_note = 'RAT';
            }

            echo "<td style='border: 2px solid;'>{$resultat_note}</td>
                </tr>";
        }
        echo "</table>";
    }
    mysqli_close($conn);
    ?>
</body>

</html>