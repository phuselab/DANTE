<?php 
    session_start();

    if($_SESSION['loggedin']){
        if (isset($_POST['annoId'])) {
            $annoId = filter_input(INPUT_POST, 'annoId', FILTER_SANITIZE_SPECIAL_CHARS); 
            
            include 'model.php';

            model::deleteUser($annoId);
        }
    }
    
?>