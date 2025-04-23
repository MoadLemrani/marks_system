<?php
session_start();
$conn = mysqli_connect("localhost","root","","marks_system_db");
if(!$conn){
    die("Connection failed".mysqli_connect_error());
}
if($_SERVER['REQUEST_METHOD'] === "POST"){
    $note = $_POST['note'] ?? null;
    $etudiant = $_POST['etudiant'] ?? null;
    $module = $_POST['module'] ?? null;

    if($note == null){
        $_SESSION['error_no_note'] = "cet etudiant n'a pas une note pour la supprimer";
        header("Location: profpage.php");
        exit();
    }
    $sql_delete = "DELETE FROM note WHERE id_module = '{$module}' AND id_etudiant = '{$etudiant}'";
    $result = mysqli_query($conn,$sql_delete);
    if($result){
        $_SESSION['deletion_succes'] = "la note a ete supprimee avec succes";
        header("Location: profpage.php");
        exit();
    }
    else{
        echo"Erreur :".mysqli_error($conn);
    }
}
?>