<?php
include_once ("config.php");
if(isset($_POST['id'])){
    $newID = $_POST['id'];
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];
    $newNumber = $_POST['newNumber'];
    $newAddress = $_POST['newAddress'];
    $newState = $_POST['newState'];


    $save_query="UPDATE tbl_contact SET `name` = '{$newName}', `email` = '{$newEmail}', `phones` = '{$newNumber}', `address` = '{$newAddress}', `state` = '{$newState}' WHERE `id` = '{$newID}'";
    $save_run= mysqli_query($connect,$save_query);
    if($save_run){
        echo("true");
    }
    else
        echo("false");

}
