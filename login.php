<?php
session_start();//katbda wa7d session li katkhli PHP yb9a mtacki data d l user ila bghiti tst3mlha f xi page okhra 
$conn = mysqli_connect("localhost", "root", "", "marks_system_db");
if (!$conn) {
    die("Connection failed : " . mysqli_connect_error());
}




if ($_SERVER['REQUEST_METHOD'] === "POST") {//REMARQUE: 9bl ma dir hadxi khask checki wax luser 3mr lformulaire


    $email = $_POST['email'] ?? null;//b "?? null" ila luser khla lfield khawi PHP maghadix ysif undefiened warnins ms ay3amlo ka null
    $_SESSION['email'] = $_POST['email'] ?? null;//matsrori l email ila bghiti tkhdem bih f pages akhrin
    $password = $_POST['password'] ?? null;

    if ($email && $password) {//taydhl luser lfields bjoj 3Ad khdem

        //check wax lcompte kayn w dyal axmn type d l user 

        //using prepared statemen to avoid sql injection
        $sqletudiant = "SELECT * FROM etudiant WHERE email = ? AND pwd = ?";
        $stmt = mysqli_prepare($conn, $sqletudiant);//prepare
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);//replace the placeholders"?"
        mysqli_stmt_execute($stmt);//execute
        $resultetudiant = mysqli_stmt_get_result($stmt);//getting result

        if (mysqli_num_rows($resultetudiant) === 1) {//used "=== 1" instead of "> 0" cuz the email is unique so it cant exist in more than 1 row
            header("Location: studentpage.php");//la kan luser etudiant atsifto lpage lmkhssa lihom
            exit();//this stops the script
        } else {
            $sqlprof = "SELECT * FROM prof WHERE email = ? AND pwd = ?";
            $stmt = mysqli_prepare($conn, $sqlprof);
            mysqli_stmt_bind_param($stmt, "ss", $email, $password);
            mysqli_stmt_execute($stmt);
            $resultprof = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($resultprof) === 1) {
                header("Location: profpage.php");
                exit();
            } else {
                $_SESSION['login_error'] = '⚠️ Adresse e-mail ou mot de passe incorrect. Veuillez réessayer ⚠️';
                header('Location: login_form.php');
                exit();
            }
        }
    } else {
        $_SESSION['manque_id'] = "⚠️ Adresse e-mail et mot de passe requis. ⚠️";
        header('Location: login_form.php');
        exit();
    }
}
mysqli_close($conn);
?>