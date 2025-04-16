<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Student Dashboard</title>
    </head>
    <body>
        <?php
        session_start();
        $conn = mysqli_connect('localhost','root','','marks_system_db');
        if(!$conn){
            die("Connection failed".mysqli_connect_error());
        }

        $sqlusername = "SELECT prenom FROM etudiant WHERE email = '{$_SESSION['email']}'";
        $usernameresult = mysqli_query($conn,$sqlusername);
        $row = mysqli_fetch_assoc($usernameresult);

        echo "<h1>Welcome, {$row['prenom']}</h1>";
        ?>
    </body>
</html>