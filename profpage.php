<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Prof page</title>
    </head>
    <body>
        <?php
        session_start();
        $conn = mysqli_connect('localhost','root','','marks_system_db');
        if(!$conn){
            die("Connection failed".mysqli_connect_error());
        }
        $nomprofquery = "SELECT nom FROM prof WHERE email = '{$_SESSION['email']}'";
        $nomprofresult = mysqli_query($conn,$nomprofquery);
        $row = mysqli_fetch_assoc($nomprofresult);
        echo"<h1>Welcome, Professor {$row['nom']}</h1>";
        ?>
    </body>
</html>