<?php
session_start();
    if (isset($_POST['id']))
    {
    include_once ('config.php');
    $id = $_POST['id'];
    $query = "UPDATE tbl_ticket SET complete_acknowledge = '1' WHERE tbl_ticket.id='{$id}'";
    $result = mysqli_query($connect, $query);
    if ($result){
        echo ("true");
    }
    else {
        echo ("false");
    }
    }