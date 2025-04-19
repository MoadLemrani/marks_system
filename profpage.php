<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prof page</title>
</head>

<body>
    <?php
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'marks_system_db');
    if (!$conn) {
        die("Connection failed" . mysqli_connect_error());
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

        $sql_etudiant_info = "SELECT num,nom,prenom FROM etudiant ORDER BY num ASC";
        $resultat_etudiant_info = mysqli_query($conn, $sql_etudiant_info);

        while ($rows_etudiant_info = mysqli_fetch_assoc($resultat_etudiant_info)) {
            echo "<form action='manipulation_notes.php' method='post'>
            <tr>
                <td style='border: 2px solid;'>{$rows_etudiant_info['num']}</td>
                <td style='border: 2px solid;'>{$rows_etudiant_info['nom']}</td>
                <td style='border: 2px solid;'>{$rows_etudiant_info['prenom']}</td>
                <td style='border: 2px solid;'><label for='note'></label><input type='number' id='note' name='note'></td>
                <td style='border: 2px solid;'><input type='submit' id='add' value='confirmer'><input type='reset' id ='mod' value='modifier'><input type='submit' id='supp' value='supprimer'></td>
            </tr>
            </form>";
        }
        echo "</table>";
    }



    ?>
</body>

</html>