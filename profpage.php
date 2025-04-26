<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Prof page</title>
</head>

<body>
    <?php
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'marks_system_db');
    if (!$conn) {
        die("Échec de la connexion." . mysqli_connect_error());
    }


    if ($_SESSION['email'] === null) {
        $_SESSION['error_auth_prof'] = "Vous ne pouvez pas accéder à cette page sans vous connecter à votre compte.";
        header("Location: login_form.php");
        exit();
    }

    //dynamic greeting
    $sql_username = "SELECT nom FROM prof WHERE email = ?";
    $stmt_username = mysqli_prepare($conn, $sql_username);
    mysqli_stmt_bind_param($stmt_username, "s", $_SESSION['email']);
    mysqli_stmt_execute($stmt_username);
    $username_result = mysqli_stmt_get_result($stmt_username);
    $row_username = mysqli_fetch_assoc($username_result);
    echo "<h1>Bienvenue, Professeur {$row_username['nom']}</h1>";

    //page prof
    
    if (isset($_SESSION['manque_note'])) {
        echo "<p style='color : red'>{$_SESSION['manque_note']}</p>";
        unset($_SESSION['manque_note']);
    }
    if (isset($_SESSION['note_existe_deja'])) {
        echo "<p style='color : orange'>{$_SESSION['note_existe_deja']}</p>";
        unset($_SESSION['note_existe_deja']);
    }
    if (isset($_SESSION['succes'])) {
        echo "<p style='color : green'>{$_SESSION['succes']}</p>";
        unset($_SESSION['succes']);
    }
    if (isset($_SESSION['error_no_note'])){
        echo "<p style ='color : orange;'>{$_SESSION['error_no_note']}</p>";
        unset($_SESSION['error_no_note']);
    }
    if (isset($_SESSION['deletion_succes'])) {
        echo "<p style='color : green'>{$_SESSION['deletion_succes']}</p>";
        unset($_SESSION['deletion_succes']);
    }

    $sql_module_prof = "SELECT nom FROM module WHERE id_prof = ?";
    $stmt_module_prof = mysqli_prepare($conn, $sql_module_prof);
    mysqli_stmt_bind_param($stmt_module_prof, "s", $_SESSION['email']);
    mysqli_stmt_execute($stmt_module_prof);
    $resultat_module_prof = mysqli_stmt_get_result($stmt_module_prof);

    while ($row_module_prof = mysqli_fetch_assoc($resultat_module_prof)) {
        echo "<h2>Module: {$row_module_prof['nom']}</h2>";
        echo "<h3>votre etudiants : </h3>";
        echo "<table style='border: 2px solid;'>";
        echo "<tr>
        <th style='border: 2px solid;'>N°</th>
        <th style='border: 2px solid;'>Nom</th>
        <th style='border: 2px solid;'>Prenom</th>
        <th style='border: 2px solid;'>Note</th>
        <th style='border: 2px solid;'>action</th>
        </tr>";

        $sql_etudiant_info = "SELECT num,nom,prenom,email FROM etudiant ORDER BY num ASC";
        $resultat_etudiant_info = mysqli_query($conn, $sql_etudiant_info);

        while ($rows_etudiant_info = mysqli_fetch_assoc($resultat_etudiant_info)) {
            echo "
            <tr>
                <td style='border: 2px solid;'>{$rows_etudiant_info['num']}</td>
                <td style='border: 2px solid;'>{$rows_etudiant_info['nom']}</td>
                <td style='border: 2px solid;'>{$rows_etudiant_info['prenom']}</td>
                <td style='border: 2px solid;'>
                    <form action='manipulation_notes.php' method='post'>
                        <input type='hidden' name='etudiant' value='{$rows_etudiant_info['email']}'>
                        <input type='hidden' name='module' value='{$row_module_prof['nom']}'>
                        <label for='note'></label>";

            //bax kol mra ydkhl lprof yxof la note li 3ta l etudiant            
            $sql_affiche_note_tjrs = "SELECT note FROM note WHERE id_etudiant = '{$rows_etudiant_info['email']}' AND id_module = '{$row_module_prof['nom']}'";
            $resultat_note_tjrs = mysqli_query($conn, $sql_affiche_note_tjrs);
            $row_note = mysqli_fetch_assoc($resultat_note_tjrs);
            $note_affiche = $row_note['note'] ?? null;// bax maytl3xliya warning dyal null
    
            echo "
                        <input type='number' id='note' name='note' min='0' max='20' value='{$note_affiche}'>        
                </td>
                <td style='border: 2px solid;'>
                        <input type='submit' title='attribuer' value='✅'>    
                    </form>
                    <form action='delete.php' method='post'>
                        <input type='hidden' name='etudiant' value='{$rows_etudiant_info['email']}'>
                        <input type='hidden' name='module' value='{$row_module_prof['nom']}'>
                        <input type='hidden' name='note' value='{$note_affiche}'>
                        <input type='submit' id='supp' title='supprimer 'value='🗑️'>
                    </form>
                </td>
            </tr>
            ";
        }
        echo "</table>";
    }


    mysqli_close($conn);
    ?>
</body>

</html>