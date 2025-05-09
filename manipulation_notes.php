<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "marks_system_db");
if (!$conn) {
    die("Échec de la connexion." . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $note = $_POST['note'] ?? null;
    $etudiant = $_POST['etudiant'] ?? null;
    $module = $_POST['module'] ?? null;

    if ($note != null) {
        $check_etudiant_a_note = "SELECT id_module,id_etudiant FROM note WHERE id_module = '{$module}' AND id_etudiant = '{$etudiant}'";
        $result_existance = mysqli_query($conn, $check_etudiant_a_note);
        if (mysqli_num_rows($result_existance)) {
            $_SESSION['note_existe_deja'] =  "Cet étudiant a déjà une note pour ce module.";
            header("Location: profpage.php");
            exit();
        } 
        else {
            $ajouter_note = "INSERT INTO note(id_module,id_etudiant,note) VALUES('{$module}','{$etudiant}','{$note}')";
            $result = mysqli_query($conn, $ajouter_note);
            if ($result) {
                $_SESSION['succes'] = "Ajout de la note réussi.";
                header("Location: profpage.php");
                exit();
            }  
            else {
                echo "erreur :" . mysqli_error($conn);
            }
        }
    } 
    else {
        $_SESSION['manque_note'] = "Note requise, merci de la saisir.";
        header("Location: profpage.php");
        exit();
    }
}
mysqli_close($conn);
?>