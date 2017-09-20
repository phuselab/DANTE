<?php 
    session_start();

    if($_SESSION['loggedin']){
        if(isset($_POST['data'])){

            include 'model.php';

            $data = json_decode(stripslashes($_POST['data']));

            $name = $data->name;
            $surname = $data->surname;
            $email = $data->email;
            $group = $data->group;
            $idUser = $data->idUser;
            model::addUser($name, $surname, $email, $idUser, $group);
        }
    }
    
?>