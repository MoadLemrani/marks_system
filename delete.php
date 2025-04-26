<?php
session_start();
$conn = mysqli_connect("localhost","root","","marks_system_db");
if(!$conn){
    die("Échec de la connexion.".mysqli_connect_error());
}
if($_SERVER['REQUEST_METHOD'] === "POST"){
    $note = $_POST['note'] ?? null;
    $etudiant = $_POST['etudiant'] ?? null;
    $module = $_POST['module'] ?? null;

    if($note == null){
        $_SESSION['error_no_note'] = "Cet étudiant n'a pas de note à supprimer.";
        header("Location: profpage.php");
        exit();
    }
    $sql_delete = "DELETE FROM note WHERE id_module = '{$module}' AND id_etudiant = '{$etudiant}'";
    $result = mysqli_query($conn,$sql_delete);
    if($result){
        $_SESSION['deletion_succes'] = "La note a été supprimée avec succès.";
        header("Location: profpage.php");
        exit();
    }
    else{
        echo"Erreur :".mysqli_error($conn);
    }
}
?>