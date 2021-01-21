<?php 
    session_start();

    if($_SESSION['loggedin']){
        if (isset($_POST['password'])) {
            include 'model.php';

            $password = json_decode($_POST['password']);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            model::updateAdmin($hash);

            $_SESSION['loggedin'] = false;
            header("Location: login.php");                    
        }
    }
    
?>