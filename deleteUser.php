<?php 
    session_start();

    if($_SESSION['loggedin']){
        if(isset($_POST['annoId'])){

            include 'model.php';

            model::deleteUser($_POST['annoId']);
        }
    }
    
?>