<?php
include_once ("config.php");
if(isset($_POST['id'])){
    $newID = $_POST['id'];
    $can_activate = $_POST['can_activate'];
    $activation_code = $_POST['activation_code'];
    $serial = $_POST['serial'];
    $machine_id = $_POST['machine_id'];
    $product_version = $_POST['product_version'];
    $amount = $_POST['amount'];

    $save_query="UPDATE tbl_subscription SET `can_activate` = '{$can_activate}', `activation_code` = '{$activation_code}', `serial` = '{$serial}', `machine_id` = '{$machine_id}', `product_version` = '{$product_version}', `amount` = '{$amount}'
                WHERE tbl_subscription.id='{$newID}'";
    $save_run=mysqli_query($connect,$save_query);
    if($save_run){
        echo("true");
    }
    else
        echo("false");

}