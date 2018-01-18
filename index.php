<?php

include_once ("config.php");
session_start();
$error="";
$msg="";
if(isset($_POST['username'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password_encrypt = md5($password)  ;

  #  if( $username =="" ){
       # $error="input your username number";
    #} else{

        $query = "SELECT * FROM tbl_user WHERE username = '$username' AND password = '$password_encrypt'";

        $results = mysqli_query($connect,$query) or die(mysqli_error($connect));
        while($user = mysqli_fetch_assoc($results)){
            $_SESSION['id']=$user['id'];
            $_SESSION['name']=$user['name'];
            $_SESSION['department']=$user['department'];
            $_SESSION['role_id']=$user['role_id'];
        };
        $length = mysqli_num_rows($results);

        if($length > 0) {
            $_SESSION['Login']= true;
            header("location: customer_service.php");

            //include("president.php");                                                                                                  x
        } else {
            $error = '<p style=" color:red; text-align: center;">Username or Password is incorrect!!</p>';
        }
    
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    
</head>
<body>
<!--login modal-->
        <div class="modal-dialog modal-content modal-show" tabindex="-1" role="dialog" aria-hidden="rue">
            <div class="modal-header" style="text-align: center;">
                <h2 class="modal-title">CRM LawPavilion</h2>
            </div>
            <?php
            echo $error;
            echo $msg;

            ?>
            <div class="modal-body" style="color: #0c0c0c">
                <form class="form-horizontal" action="" method="POST">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="newName">Username:</label>
                        <div class="col-sm-6">
                        <input class="form-control input-lg"  type="text" name="username" autocomplete="off" required >
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="newName">Password:</label>
                        <div class="col-sm-6">
                        <input class="form-control input-lg"  type="password" name="password" autocomplete="off" required >
                            </div>
                    </div>



                     <div class="modal-footer">
                     <div class="form-group">
                    <input name="Login" type="submit"  value="Login" class="btn btn-primary btn-lg btn-block" style="background-color: #0c0c0c" />
                     </div>
            </div>
            </form>
            </div>
        </div>

</body>
</html>