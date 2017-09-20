<?php
    session_start();

    $_SESSION['loggedin'] = false;
    $error = false;

    if(isset($_POST['btnAccedi'])){
        include 'model.php';
        $admin = model::getAdmin();
        
        while ($row = mysqli_fetch_array($admin)){
            if($_POST['user'] == $row['username'] && $_POST['psw'] == $row['password']){
                $_SESSION['loggedin'] = true;
                header("Location: panelControl.php");
            }
        }

        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>DANTE - Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/login.css" rel="stylesheet">    

</head>
<body>

    <div class="container">
      <form method="POST" action="" class="form-signin">
        <div class="form-signin-heading">
            <img class="img-responsive center-block" src="img/logo.png"/>
        </div>

        <div id="error-alert" class="alert alert-danger alert-dismissible fade in" role="alert" 
             style="display: <?php if($error == true) echo 'block'; else echo 'none' ?>">

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden=true>&times;</span>
            </button>                        
            <strong>Error</strong> Username or password is not correct.
        </div>

        <label for="inputEmail" class="sr-only">Username</label>
        <input name="user" type="text" type="email" class="form-control" placeholder="Username" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="psw" type="password" class="form-control" placeholder="Password" required="">

        <button name="btnAccedi" value="Accedi" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div>

</body>

</html> 