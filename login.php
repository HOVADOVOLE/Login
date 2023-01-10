<?php
    include 'config.php';
    session_start();
    $email = $_POST["email"];
    $heslo = $_POST["heslo"];

    if(isset($email) && isset($heslo))
    {
        $sql = "SELECT password FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $hash = mysqli_fetch_assoc($result)['password'];
        
        if (password_verify($heslo, $hash)) 
        {
            $_SESSION["email"] = $_POST["email"];
            echo "Uživatel úspěšně přihlášen " . $_SESSION["email"];
        } 
        else {
            echo "Chybně zadaný email nebo heslo";
        }
    }
    session_abort();
?>