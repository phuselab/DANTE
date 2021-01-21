<?php 
    session_start();

    if($_SESSION['loggedin']){
        if (isset($_POST['data'])) {
            $data = filter_input(INPUT_POST, 'data'); 
            
            include 'model.php';

            $data = json_decode(stripslashes($data));

            $name = $data->name;
            $surname = $data->surname;
            $email = $data->email;
            $group = $data->group;
            $idUser = $data->idUser;
            model::addUser($name, $surname, $email, $idUser, $group);
        }
    }
    
?>