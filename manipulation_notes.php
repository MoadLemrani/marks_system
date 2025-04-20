<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "marks_system_db");
if (!$conn) {
    die("Connection failed" . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $note = $_POST['note'] ?? null;
    $etudiant = $_POST['etudiant'] ?? null;
    $module = $_POST['module'] ?? null;

    if ($note != null) {
        $check_etudiant_a_note = "SELECT id_module,id_etudiant FROM note WHERE id_module = '{$module}' AND id_etudiant = '{$etudiant}'";
        $result_existance = mysqli_query($conn, $check_etudiant_a_note);
        if (mysqli_num_rows($result_existance)) {
            echo "vouz avez deja donne ce etudiant une note en ce module";
        } else {
            $ajouter_note = "INSERT INTO note(id_module,id_etudiant,note) VALUES('{$module}','{$etudiant}','{$note}')";
            $result = mysqli_query($conn, $ajouter_note);
            if ($result) {
                echo "note ajoutee en succes";
            } else {
                echo "erreur :" . mysqli_error($conn);
            }
        }
    } else {
        echo "entrez la note svp";
    }
}
mysqli_close($conn);
?>