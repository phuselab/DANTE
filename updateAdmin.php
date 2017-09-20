<?php 
    session_start();

    if($_SESSION['loggedin']){
        if(isset($_POST['password'])){

            include 'model.php';

            $password = json_decode(stripslashes($_POST['password']));

            model::updateAdmin($password);
        }
    }
    
?>