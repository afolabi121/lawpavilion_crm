<?php
session_start(); 
if(!$_SESSION['Login']){
    header("location:index.php");
    die;
}
else {
    include_once ('config.php');
    $role = $_POST['role'];

    $query = "SELECT id, name FROM tbl_user WHERE role_id ='{$role}'";
    $result = mysqli_query($connect, $query);
    echo ("<option selected=\"selected\" value=\"Personnel\" disabled hidden>--Select Personnel--</option>");
    while ($names = mysqli_fetch_assoc($result)){
        echo("<option value='".$names['id']."'>".$names['name']."</option>");
    }
}?>