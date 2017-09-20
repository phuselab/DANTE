<?php 
    session_start();
    
    if(!$_SESSION['loggedin']){
        header('location: login.php');
    }else{
        include 'model.php';

        $users = model::getUsers();
        $groups = model::getGroups();
        $newUserId = model::getNewUserId();
        
        $newLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['PHP_SELF']) . 'index.php?id=' . $newUserId ;

    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>DANTE - Administration</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/login.css" rel="stylesheet">    

</head>
<body>


    <div class="container">
        <h2>DANTE - Administration</h2>


        <h3>Sync database</h3>
        <div id="doing-sync" class="alert alert-info" style="display: none">
            <strong>Synchronization</strong> Please wait...
        </div>

        <div id="success-sync" class="alert alert-success alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden=true>&times;</span>
            </button>
            Synchronization done! <br>
        </div>

        <div id="error-sync" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden=true>&times;</span>
            </button>                        
            <strong>Error</strong> An error has occured during synchronization.
        </div>    
        <p>    
            Annotators can be organized in annotation groups, where each group is allowed to annotate a specific subset of videos.<br>
            Such functionality is realized by placing the videos in the following hierarchy <code>/video/xxx/</code>, where
            <code>xxx</code> is the name of an annotation group.
        </p>
        <p>
            <strong>Example</strong><br>
            To create two annotation groups, <em>alpha</em> and <em>beta</em>:
            <ol>
                <li>create the following directories <code>/video/alpha/</code> and <code>/video/beta/</code></li>
                <li>place the videos to be annotated in the relative directories</li>
                <li>press <strong>Sync now</strong> button</li>
                <li>reload the page and add a new annotator, assigning the corresponding group</li>
            </ol>
        </p>
        <div id="sycngroup">
            <button type="submit" id="btnSync" class="btn btn-default btn-primary">Sync now</button>
        </div>
    </div>

    <hr>

 	<div class="container">
        <h3>Annotators</h3>

        <div id="doing-delete" class="alert alert-info" style="display: none">
            <strong>Deletion</strong> Please wait...
        </div>

        <div id="success-delete" class="alert alert-success alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden=true>&times;</span>
            </button>
            Annotator correctly deleted! <br>
        </div>

        <div id="error-delete" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden=true>&times;</span>
            </button>                        
            <strong>Error</strong> An error has occured during deletion.
        </div>

        <p>List of current annotators. The deletion of an annotator does not delete relative annotations already done.</p>


		<table class="table table-condensed">
		<thead>
		  <tr>
		    <th>ID</th>		  
		    <th>Firstname</th>
		    <th>Lastname</th>
		    <th>Email</th>
		    <th>Group id</th>
		    <th>Action</th>
		  </tr>
		</thead>
		<tbody>
			<?php
            while($riga = mysqli_fetch_array($users)){
            	echo '<tr>';
            	echo '<td>' . $riga['id'] . '</td>';
            	echo '<td>' . $riga['name'] . '</td>';
            	echo '<td>' . $riga['surname'] . '</td>';
            	echo '<td>' . $riga['email'] . '</td>';
            	echo '<td>' . $riga['fk_idgroup'] . '</td>';
            	echo '<td><button data-id="' . $riga['id'] . '" class="btn btn-xs btn-danger deleteUser">Delete</button></td>';
            	echo '</tr>';
            }
            ?>
		    
		</tbody>
		</table>

    </div>

    <hr>

    <div class="container">
        <h3>Add new annotator</h3>
        
        <div id="doing-add" class="alert alert-info" style="display: none">
            <strong>Creating</strong> Please wait...
        </div>

        <div id="success-add" class="alert alert-success alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden=true>&times;</span>
            </button>
            New annotator added, please copy and send the following personal URL: <br>
            <strong><?php echo $newLink ?></strong>
        </div>

        <div id="error-add" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden=true>&times;</span>
            </button>                        
            <strong>Error</strong> An error has occured, please contact the mantainer.
        </div>

        <p>Add a new annotator by inserting the required information.</p>

        <form id="formNewUser" onsubmit="" action="" class="form-inline">
            <div class="form-group">
                <div for="name">Name</div>
                <input type="text" class="form-control" name="name" placeholder="Jane" required="">
            </div>
            <div class="form-group">
                <div for="surname">Surname</div>
                <input type="text" class="form-control" name="surname" placeholder="Doe" required="">
            </div>          
            <div class="form-group">
                <div for="email">Email</div>
                <input type="email" class="form-control" name="email" placeholder="jane.doe@example.com" required="">
            </div>
            <div class="form-group">
                <div for="group">Group</div>
                <select name="group" class="form-control">
                    <?php
                    while($riga = mysqli_fetch_array($groups)){
                        echo '<option value="'.$riga['name'].'">'.$riga['name'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <div for="idUser">Id</div>
                <input name="idUser" class="form-control" value="<?php echo $newUserId ?>" size="4px" readonly></input>
            </div>
            <div class="form-group">
                <div> &nbsp; </div>
                <button type="submit" id="btnAdd" class="btn btn-default btn-primary">Add</button>
            </div>
        </form>

        <button type="submit" id="btnNew" class="btn btn-default btn-primary" style="display:none">Add new</button>

    </div>
    
    <hr>

    <div class="container">
        <h3>Change admin password</h3>

        <div id="doing-update" class="alert alert-info" style="display: none">
            <strong>Updating</strong> Please wait...
        </div>

        <div id="success-update" class="alert alert-success alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden=true>&times;</span>
            </button>
            Administrator password updated correctly!
        </div>

        <div id="error-update" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden=true>&times;</span>
            </button>                        
            <strong>Error</strong> An error has occured, please contact the mantainer.
        </div>
        <p>For security reasons, please remember to update the default admin password as soon as possible.</p>
        <form id="formNewPass" onsubmit="" action="" class="form-inline">
            <div class="form-group">
                <div for="pwd">New password</div>
                <input id="adminPass" pattern=".{5,}" title="5 characters minimum" name="pwd" type="password" class="form-control" size="20px"></input>
            </div>
            <div class="form-group">
                <div> &nbsp; </div>
                <button type="submit" id="btnUpdate" class="btn btn-default btn-primary">Update</button>
            </div>
        </form>
    </div>

    <!-- jQuery -->
    <script type="text/javascript" src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <script>

        $("#formNewUser").submit(function(e) {
            e.preventDefault();

            $('#doing-add').fadeIn();
            
            var userData = objectifyForm($("#formNewUser").serializeArray());

            $.ajax({
                type: "POST",
                url: "addUser.php",
                data: {data : JSON.stringify(userData)}, 
                cache: false,
                success: function (response) {
                    $('#doing-add').fadeOut(function() {$('#success-add').fadeIn()});
                    $("#formNewUser").fadeOut();
                    $("#btnNew").fadeIn();                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#doing-add').fadeOut(function() {$('#error-add').fadeIn()});
                    console.log(xhr.responseText);
                }
            });
            return false;
        });

        $('#btnNew').click(function(e) {
            window.location.reload();            
        });

        $('#btnSync').click(function(e) {
            $('#doing-sync').fadeIn();

            $.ajax({
                type: "GET",
                url: "syncgroup.php",
                cache: false,
                success: function (response) {
                    $('#doing-sync').fadeOut(function() {$('#success-sync').fadeIn()});                 
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#doing-sync').fadeOut(function() {$('#error-sync').fadeIn()});
                    console.log(xhr.responseText);
                }
            });
            return false;
        });

        $("#formNewPass").submit(function(e) {
            e.preventDefault();

            $('#doing-update').fadeIn();

            var userData = $("#adminPass").val();

            $.ajax({
                type: "POST",
                url: "updateAdmin.php",
                data: {password : JSON.stringify(userData)}, 
                cache: false,
                success: function (response) {
                    $('#doing-update').fadeOut(function() {$('#success-update').fadeIn()});                  
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#doing-update').fadeOut(function() {$('#error-update').fadeIn()});
                    console.log(xhr.responseText);
                }
            });
            return false;
        });

        $('.deleteUser').click(function(e) {
            $('#doing-delete').fadeIn();
			var annoId = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "deleteUser.php",
                data: {annoId: annoId},
                cache: false,
                success: function (response) {
                    $('#doing-delete').fadeOut(function() {$('#success-delete').fadeIn()});
                    window.location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#doing-delete').fadeOut(function() {$('#error-delete').fadeIn()});
                    console.log(xhr.responseText);
                }
            });
            return false;
        });

        function objectifyForm(formArray) {//serialize data function

          var returnArray = {};
          for (var i = 0; i < formArray.length; i++){
            returnArray[formArray[i]['name']] = formArray[i]['value'];
          }
          return returnArray;
        }
    </script>

</body>
</html>
