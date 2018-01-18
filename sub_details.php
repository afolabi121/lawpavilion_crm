<html>
<head>

    <title>
Subscription Details
    </title>
    <!-- INCLUDES -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <!-- Base styles: Libraries -->
    <!--        <link rel="stylesheet" href="css/lib/bootstrap.css" />-->
    <!--        <link rel="stylesheet" href="css/lib/bootstrap-responsive.css" />-->
    <link rel="stylesheet" href="css/lib/font-awesome-4.2.0.css" />
    <link rel="stylesheet" href="css/lib/jquery.dataTables.min.css" />


    <!-- Base styles -->
    <link rel="stylesheet" href="css/base.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/base-datatable.css" />
<!--            <link rel="stylesheet" href="css/bootstrap.css" />-->
    <link rel="stylesheet" href="css/logo-nav.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>


    <!-- JS: Libraries -->

<!--    <script src="js/jquery.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            var date_input=$('input[name="newActivation_date"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            var options={
                format: 'yyyy-mm-dd',
                container: container,
                todayHighlight: true,
                autoclose: true,
                clearBtn: true
            };
            $('#newActivation_date').datepicker(options);
            $('#newPurchase_date').datepicker(options);
            $('#newExpiry_date').datepicker(options);
        })
    </script>
    <script>
        $(document).ready(function (){
            $('#customerDetails').on('click', function () {
                $('#myModal').modal('show');
            });

            $('#saveDetails').on('click', function() {
                var can_activate = $("#newCan_activate").val();
                var activation_code = $("#newActivation_code").val();
                var serial = $("#newSerial").val();
                var machine_id = $("#newMachine_id").val();
                var product_version = $("#newProduct_version").val();
                var amount = $("#newAmount").val();
                var id = $("#id").val();
                        var values = {can_activate: can_activate, activation_code: activation_code, serial: serial, machine_id: machine_id, product_version: product_version,amount: amount, id: id};
                        $.ajax({
                            type: "POST",
                            url: "product_details.php",
                            data: values,
                            cache: false,
                            success: function (response) {
                            if(response == "true"){
                            alert("Save Successful");
                            window.location.href="sub_details.php?SID="+ id  ;
                                }
                            }
                        });

            });
        });
    </script>


</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="-webkit-box-shadow: 0 8px 6px -6px #999;-moz-box-shadow: 0 8px 6px -6px #999;box-shadow: 0 8px 6px -6px #999;">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img style="height: 50px" src="imgs/official-logo.png" alt="">
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="home.php" >Home</a>
                </li>
                <li>
                    <a href="#">Sales</a>
                </li>
                <li>
                    <a href="#">Report</a>
                </li>
                <li>
                    <a href="ticket.php">Tickets</a>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Account <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Change Password</a></li>
                        <li><a href="logout.php">Logout <span class="glyphicon glyphicon-log-in"></span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<?php
include_once ("config.php");
if($_GET['SID']) {
    $id = $_GET['SID'];
    $query = "SELECT tbl_product.name as product_name, tbl_user.name as marketer_id, tbl_subscription.activation_date as activation_date, tbl_subscription.can_activate as can_activate, tbl_subscription.purchase_date as purchase_date,
              tbl_subscription.activation_code as activation_code, tbl_subscription.serial as serial, tbl_subscription.machine_id as machine_id, tbl_subscription.product_version as product_version,
              tbl_subscription.amount as amount, tbl_subscription.expiry_date as expiry_date 
              FROM `tbl_subscription`
              INNER JOIN tbl_product ON tbl_subscription.product_id=tbl_product.id
              INNER JOIN tbl_user ON tbl_subscription.marketer_id=tbl_user.id
              WHERE tbl_subscription.id='{$id}'";
    $result = mysqli_query($connect, $query);
    while($sub_details = mysqli_fetch_assoc($result)){
        $product_name = $sub_details['product_name'];
        $marketer_id = $sub_details['marketer_id'];
        $activation_date = $sub_details['activation_date'];
        if($sub_details['can_activate']= 0){
            $can_activate = "NO";
        }
        else $can_activate = "YES";
        $purchase_date = $sub_details['purchase_date'];
        $activation_code = $sub_details['activation_code'];
        $serial = $sub_details['serial'];
        $machine_id = $sub_details['machine_id'];
        $product_version = $sub_details['product_version'];
        $amount = $sub_details['amount'];
        $expiry_date = $sub_details['expiry_date'];
       } }?>
<div class="container table-responsive">
    <table style="align-content: center; box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12) !important; margin-top: 20px;" class="table table-bordered table-hover" >
        <caption>PRODUCT SUBSCRIPTION DETAILS</caption>
        <tbody>
        <tr>
            <th>Product Name</th>
            <td><?php echo($product_name);?></td>
        </tr>
        <tr>
            <th>Marketer's Name</th>
            <td><?php echo($marketer_id);?></td>
        </tr>
        <tr>
            <th>Activation Date</th>
            <td><?php echo($activation_date);?></td>
        </tr>
        <tr>
            <th>Can Activate?</th>
            <td><?php echo($can_activate);?></td>
        </tr>
        <tr>
            <th>Purchase Date</th>
            <td><?php echo($purchase_date);?></td>
        </tr>
        <tr>
            <th>Activation Code</th>
            <td><?php echo($activation_code);?></td>
        </tr>
        <tr>
            <th>Serial</th>
            <td><?php echo($serial);?></td>
        </tr>
        <tr>
            <th>Machine ID</th>
            <td><?php echo($machine_id);?></td>
        </tr>
        <tr>
            <th>Product Version</th>
            <td><?php echo($product_version);?></td>
        </tr>
        <tr>
            <th>Amount</th>
            <td><?php echo($amount);?></td>
        </tr>
        <tr>
            <th>Expiry Date</th>
            <td><?php echo($expiry_date);?></td>
        </tr>
        </tbody>
    </table>
    <button type="button" id="customerDetails" class="btn btn-info" style="color: #0c0c0c; float: right;"><b>Edit Details</b></button>
    <button type="button" id="backButton" class="btn" style="background-color: #D50000; color: white;" onclick="history.go(-1); return true;"><i class="fa fa-arrow-left" aria-hidden="true"></i><b>Back</b></button>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="container-fluid modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Subscription Details</h4>
                </div>
                <div class=" modal-body">
                    <form class="bootstrap-iso form-group" >
                        <div class="form-group">
                            <label for="newProduct_name">Product Name:</label>
                                <input  class="form-control" id="newProduct_name" value="<?php echo $product_name ?>" name="newProduct_name" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="newMarketer_id">Marketer's Name:</label>
                                <input  class="form-control" id="newMarketer_id" value="<?php echo $marketer_id ?>" name="newMarketer_id" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="newActivation_date">Activation Date:</label>
<!--                            <div class="input-group date" id="newActivation_date">-->
                                <input  class="form-control" placeholder="YYYY/MM/DD" type="text"  value="<?php echo $activation_date ?>" name="newActivation_date" readonly="readonly">
<!--                                <span class="input-group-addon">-->
<!--                        <span class="glyphicon glyphicon-calendar"></span>-->
<!--                                    </span>-->
<!--                            </div>-->
                        </div>
                        <div class="form-group">
                            <label for="newCan_activate">Can Activate?:</label>
                            <select id="newCan_activate" class="form-control" >
                                <option selected="selected" disabled="disabled" hidden><?php echo $can_activate ?></option>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="newPurchase_date">Purchase Date:</label>
<!--                            <div class="input-group date" id="newPurchase_date">-->
                                <input  class="form-control" placeholder="YYYY/MM/DD" id="newPurchase_date" value="<?php echo $purchase_date ?>" name="newPurchase_date" readonly="readonly">
                                <input hidden value="<?= $id ?>" name="id" id="id">
<!--                             <span class="input-group-addon">-->
<!--                        <span class="glyphicon glyphicon-calendar"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
                        </div>
                        <div class="form-group">
                            <label for="newActivation_code">Activation Code:</label>
                            <input  class="form-control" id="newActivation_code" value="<?php echo $activation_code ?>" name="newActivation_code" required>
                        </div>
                        <div class="form-group">
                            <label for="newSerial">Serial:</label>
                            <input  class="form-control" id="newSerial" value="<?php echo $serial ?>" name="newSerial" required>
                        </div>
                        <div class="form-group">
                            <label for="newMachine_id">Machine ID:</label>
                            <input  class="form-control" id="newMachine_id" value="<?php echo $machine_id ?>" name="newMachine_id" required>
                        </div>
                        <div class="form-group">
                            <label for="newProduct_version">Product Version:</label>
                            <input  class="form-control" id="newProduct_version" value="<?php echo $product_version ?>" name="newProduct_version" required>
                        </div>
                        <div class="form-group">
                            <label for="newAmount">Amount:</label>
                            <input  class="form-control" id="newAmount" value="<?php echo $amount ?>" name="newAmount" required>
                        </div>
                        <div class="form-group">
                            <label for="newExpiry_date">Expiry Date:</label>
<!--                            <div class="input-group date" id="newExpiry_date">-->
                            <input  class="form-control" placeholder="YYYY/MM/DD" id="newExpiry_date" value="<?php echo $expiry_date ?>" name="newExpiry_Date" readonly="readonly">
<!--                                <span class="input-group-addon">-->
<!--                        <span class="glyphicon glyphicon-calendar"></span>-->
<!--                                    </span>-->
<!--                            </div>-->
                        </div>
                        <div class="modal-footer">
                            <input id="saveDetails" name="save_submit" type="submit" class="btn btn-success" style="color: #0c0c0c;" value="Save" />
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="color: #0c0c0c;">Close</button>
                        </div>

                    </form>
                </div>
                <!--                <div class="modal-footer">-->
                <!--                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="color: #0c0c0c;"><b>Close</b></button>-->
                <!--                    <input id="saveCustomer" name="save_submit" type="submit" class="btn btn-danger" style="color: #0c0c0c;" value="Save" />-->
                <!--                </div>-->

            </div>

        </div>
    </div>

</div>
</body>
</html>
