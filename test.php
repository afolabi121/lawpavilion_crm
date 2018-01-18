<html>
<head>

    <title>
        Details
    </title>
    <!-- INCLUDES -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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


    <!-- JS: Libraries -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">


    <script>
        $(document).ready(function (){
            $('#customerDetails').on('click', function () {
                $('#myModal').modal('show');
            });

            function validateEmail(email) {
                var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
                if (filter.test(email)) {
                    return true;
                }
                else {
                    return false;
                }
            }
//            $("#newNumber").mask("9999 999 9999");
            $('#contact_details').on('submit', function(e) {
                e.preventDefault();
                var id = $('#id').val();
                var values = $(this).serialize();
                            $.ajax({
                                type: "POST",
                                url: "edit.php",
                                data: values,
                                cache: false,
                                success: function (response) {
                                    if(response == "true"){
                                        swal({title:"Success", text:"Details updated", type: "success"},
                                            function(){
                                                window.location.href="test.php?uniqueId="+id;
                                            });
                                    }
                                    else {
                                        swal("Oops...", "Something went wrong!", "error");
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
if($_GET['uniqueId']) {
    $id = $_GET['uniqueId'];
    $name = "";
    $email = "";
    $number = "";
    $address = "";
    $state = "";
    $g_query = "SELECT name, email, phones, address, state FROM tbl_contact WHERE id={$id}";
    $g_result = mysqli_query($connect, $g_query);

    while ($row = mysqli_fetch_assoc($g_result)) {
        $name = $row['name'];
        $email = $row['email'];
        $number = $row['phones'];
        $address = $row['address'];
        $state = $row['state'];
    }
    $query = "SELECT * from tbl_contact WHERE id='{$id}' AND is_client=1";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        $g_query = "SELECT name, email, phones, address, state FROM tbl_contact WHERE id={$id}";
        $g_result = mysqli_query($connect, $g_query);

        while ($row = mysqli_fetch_assoc($g_result)) {
            $name = $row['name'];
            $email = $row['email'];
            $number = $row['phones'];
            $address = $row['address'];
            $state = $row['state'];
        }?>
<div class="container table-responsive">
    <table style="align-content: center; box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12) !important; margin-top: 20px;" class="table table-bordered table-hover" >
        <caption>CUSTOMER DETAILS</caption>
    <tbody>
    <tr>
        <th>Name</th>
        <td><?php echo($name);?></td>
    </tr>
    <tr>
    <th>Email</th>
    <td><?php echo($email);?></td>
    </tr>
    <tr>
    <th>Phone Number</th>
    <td><?php echo($number);?></td>
    </tr>
    <tr>
    <th>Address</th>
    <td><?php echo($address);?></td>
    </tr>
    <tr>
    <th>State</th>
    <td><?php echo($state);?></td>
    </tr>
    </tbody>
        </table>
    <button type="button" id="customerDetails" class="btn btn-info" style="color: #0c0c0c; float: right;"><b>Edit Details</b></button>

        <?php
            $product_id= array();
            $product = array();
            $subDate = array();

        $product_query = "SELECT tbl_subscription.id as p_identity, tbl_product.name  as names, tbl_subscription.purchase_date as purchaseDate
                        FROM tbl_subscription
                        INNER JOIN tbl_product ON tbl_subscription.product_id=tbl_product.id
                        INNER JOIN tbl_contact ON tbl_subscription.contact_id=tbl_contact.id
                        WHERE tbl_subscription.contact_id = '{$id}'";
        $sql_product = mysqli_query($connect, $product_query);
        $res_length = mysqli_num_rows($sql_product);
        while($productDetails = mysqli_fetch_assoc($sql_product)){
            $product_id[] = $productDetails['p_identity'];
            $product[] = $productDetails['names'];
            $subDate[] = $productDetails['purchaseDate'];
        }
        ?>
        <table style="align-content: center; box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12) !important; margin-top: 20px;" class="table table-bordered table-hover">
        <caption>PRODUCT DETAILS</caption>
            <tbody>
            <tr>
                <th>Product(s) Bought</th>
                <th>Date Purchased</th>
            </tr>
            <?php
    foreach($product as $index=> $product){
    echo(
    "
    <tr>
    <td><a href='sub_details.php?SID=$product_id[$index]'>" .$product."</a></td>
    <td>".$subDate[$index]."<br></td>
    </tr>
    </tbody>");}?>

    </table><?php
    } else echo("{$name} is not a Subscribed Client");

}?>
    <button type="button" id="backButton" class="btn" style="background-color: #D50000; color: white;" onclick="history.go(-1); return true;"><i class="fa fa-arrow-left" aria-hidden="true"></i><b>Back</b></button>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="container-fluid modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Customer's Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="contact_details">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="newName">Name:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="newName" value="<?php echo $name ?>" name="newName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="newEmail">Email:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="newEmail" value="<?php echo $email ?>" name="newEmail" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="newNumber">Phone Number:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="newNumber" value="<?php echo $number ?>" name="newNumber" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="newAddress">Address:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="newAddress" value="<?php echo $address ?>" name="newAddress" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="newState">State:</label>
                            <div class="col-sm-8">
                                <select  class="form-control" id="newState"  name="newState" >
                                    <option selected="selected" disabled="disabled" hidden value="<?php echo $state ?>"><?php echo $state ?></option>
                                    <option value="Abia">Abia</option>
                                    <option value="Abuja">Abuja</option>
                                    <option value="Adamawa">Adamawa</option>
                                    <option value="Anambra">Anambra</option>
                                    <option value="Akwa Ibom">Akwa Ibom</option>
                                    <option value="Bauchi">Bauchi</option>
                                    <option value="Bayelsa">Bayelsa</option>
                                    <option value="Benue">Benue</option>
                                    <option value="Borno">Borno</option>
                                    <option value="Cross River">Cross River</option>
                                    <option value="Delta">Delta</option>
                                    <option value="Ebonyi">Ebonyi</option>
                                    <option value="Enugu">Enugu</option>
                                    <option value="Edo">Edo</option>
                                    <option value="Ekiti">Ekiti</option>
                                    <option value="Gombe">Gombe</option>
                                    <option value="Imo">Imo</option>
                                    <option value="Jigawa">Jigawa</option>
                                    <option value="Kaduna">Kaduna</option>
                                    <option value="Kano">Kano</option>
                                    <option value="Katsina">Katsina</option>
                                    <option value="Kebbi">Kebbi</option>
                                    <option value="Kogi">Kogi</option>
                                    <option value="Kwara">Kwara</option>
                                    <option value="Lagos">Lagos</option>
                                    <option value="Nassarawa">Nassarawa</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Ogun">Ogun</option>
                                    <option value="Ondo">Ondo</option>
                                    <option value="Osun">Osun</option>
                                    <option value="Oyo">Oyo</option>
                                    <option value="Plateau">Plateau</option>
                                    <option value="Rivers">Rivers</option>
                                    <option value="Sokoto">Sokoto</option>
                                    <option value="Taraba">Taraba</option>
                                    <option value="Yobe">Yobe</option>
                                    <option value="Zamfara">Zamfara</option>
                                </select>
                                <input hidden value="<?= $id ?>" name="id" id="id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="saveCustomer" name="save_submit" type="submit" class="btn btn-success" style="color: #0c0c0c;">Save</button>
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



