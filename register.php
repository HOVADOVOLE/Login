<?php
    include 'config.php';

    $_SESSION["jmeno"] = $_POST["jmeno"];
    $_SESSION["prijmeni"] = $_POST["prijmeni"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["heslo"] = $_POST["heslo"];
    
    if(isset($_SESSION["jmeno"]) && isset($_SESSION["prijmeni"]) && isset($_SESSION["email"]) && isset($_SESSION["heslo"]))
    {
        //Jistota, že input není 'null'
        if(strlen($_SESSION["jmeno"]) > 0 && strlen($_SESSION["prijmeni"]) > 0 && strlen($_SESSION["email"]) && strlen($_SESSION["heslo"]) > 5)
        {
            $sql = "SELECT email FROM users";
            $result = $conn->query($sql);
            $inDatabaze = false;

            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()){
                    if(!strcmp($_SESSION["email"], $row["email"])){
                        //Je v databázy
                        echo "Uživatel je již zaregistrován";
                        $inDatabaze = true;
                        break;
                    }
                }
            }
            if($inDatabaze == false){
                $hash = password_hash($_SESSION["heslo"], PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (Name, Surname, email, password) VALUES ('$_SESSION[jmeno]', '$_SESSION[prijmeni]', '$_SESSION[email]', '$hash')";
                $conn->query($sql);
            }
            
            $conn->close();
            header("Location: index.html");
        }
        else{
            echo "Error, najdi si kde :)";
        }
    }
    else{
        echo "Error";
    }
?>