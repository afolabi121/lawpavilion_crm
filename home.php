<?php
session_start();
if(!$_SESSION['Login']){
    header("location:index.php");
    die;
}
else
{
?>
<html>
    <head>
        <title>
            Home
        </title>
        <!-- INCLUDES -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Base styles: Libraries -->
<!--        <link rel="stylesheet" href="css/bootstrap.css" />-->
<!--        <link rel="stylesheet" href="css/lib/bootstrap.css" />-->
<!--        <link rel="stylesheet" href="css/lib/bootstrap-responsive.css" />-->
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="css/lib/font-awesome-4.2.0.css" />
        <link rel="stylesheet" href="css/lib/jquery.dataTables.min.css" />


        <!-- Base styles -->
        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/base-datatable.css" />
        <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
        <link rel="stylesheet" href="css/logo-nav.css" />


        <!-- JS: Libraries -->
<!--        <script src="js/jquery.min.js"></script>-->
        <script src="js/bootstrap.min.js"></script>

        <script src="js/lib/jquery.dataTables.min.js"></script>
        <script src="js/lib/tabletop.js"></script>
        <script src="js/lib/underscore.js"></script>
        <script src="dist/sweetalert.min.js"></script>
<!--        <script src="js/jquery.js"></script>-->
<!--        <script src="js/bootstrap.js"></script>-->

        <!-- End Google Analytics Javascript -->

        <script src="js/base.js"></script>
<!--        <script src="js/datatable-tabletop-load.js"></script>-->


        <script>
            function click(){
                var data = dataTable.row($(this).parents('tr')).data();
                var client = data[0];
                console.log (client);
            }
            $(document).ready(function() {
                var dataTable = $('#searchable-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "ajax":{
                        url :"DataTB.php", // json datasource
                        type: "POST",  // method  , by default get
                        error: function(){  // error handling
                            $(".employee-grid-error").html("");
                            $("#searchable-table").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#employee-grid_processing").css("display","none");
                        }
                    },
                    "columnDefs": [ {"className": "dt-center", "targets": "_all"},

                        { "targets": -2,
                                     "data": null,
                                     "defaultContent":
                                         "<input type='button' id='btnDetails' class='btn btn-info' width='10px' value='Get Details' style='margin: 5px' />"
                                    },
                    { "targets": -1,
                        "data": null,
                        "defaultContent":
                        "<button id='create_ticket' class='btn btn-primary' width='10px' >Create Ticket</button>"
                    },
                        {
                            'targets': -3,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function (data, type, full, meta) {
                                return '<input id="checkbox" type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                            }
                        }]

                });

                $('#searchable-table tbody').on('click', '#create_ticket', function(){

                    var data = dataTable.row($(this).parents('tr')).data();
                    var client = data[0];
                    var Id = data[5];
                    $('#clientID').val(Id);
                    $('#client').val(client);
                    $('#myModal').modal('show');
                });
                
                $('#searchable-table tbody').on('click', '#btnDetails', function () {
                    var data = dataTable.row($(this).parents('tr')).data();
                    var contactName = data[0];
                    var email = data[1];
                    var phoneNumber = data[2];
                    var address = data[3];
                    var state = data[4];
                    var uniqueId = data[5];
//                    val.html('new val');
//                    val.text('new val');
                    window.location.href="test.php?uniqueId="+ uniqueId  ;
                });
                var num = 0;
                /*$('#merge_contacts').on('click', function (){
                    $('#checkbox').each(function () {
                        if($(this).prop('checked', true)){
                            console.log($(':checked').length);
                        }
                    });
                });*/


                $("#merge_contacts").click(function(){
                    var myarray = [];
                    if($("input:checkbox:checked").length >= 2) {
////                        swal({title: "Merge these contacts?",
////                            text: "Merging is irreversible!",
////                            type: "warning",
////                                confirmButtonColor: "#DD6B55",
////                                confirmButtonText: "Yes, Proceed",
////                                showCancelButton: true,
////                                cancelButtonText: "No"},
//
//                                console.log($("input:checkbox:checked").length);
//                                $('input[type=checkbox]').each(function () {
//                                    if (this.checked) {
//                                        //console.log($(this).val());
//                                        myarray.push($(this).val());
//                                    }
//                                });
//                                console.log(myarray.join());
//                                $('#myModal').modal('show');
//                                $("#myModal").on('show.bs.modal', function () {
//                                    $('#create_ticket_form').on('submit', function(e) {
//                                        e.preventDefault();
//                                        var values = $(this).serialize();
//                                        $.ajax({
//                                            type: "POST",
//                                            url: "new_ticket.php",
//                                            data: values,
//                                            cache: false,
//                                            success: function (success) {
//                                                if(success = "true"){
//                                                    swal({title:"Success", text:"Ticket Created", type: "success"},
//                                                        function(){
//                                                            window.location.href="customer_service.php";
//                                                        });
//                                                }
//                                                else swal("Oops...", "Something went wrong!", "error");
//                                            }
//                                        });
//                                    });
//                                });

                    }
                    else {
                        swal("Denied!", "A minimum of 2 contacts has to be selected for merging", "error");
                    }
                });


            });

            $(document).ready(function(){
                var date_input=$('input[name="due_date"]'); //our date input has the name "date"
                var container=$('.modal-body form').length>0 ? $('.modal-body form').parent() : "body";
                var options={
                    format: 'yyyy-mm-dd',
                    container: container,
                    todayHighlight: true,
                    autoclose: true
                };
                date_input.datepicker(options);
            });

            $(document).ready(function () {
                $('#category').on('change', function() {
                    var role = $(this).val() ;
                    var values = {role:role};
                    $.ajax({
                        type: "POST",
                        url: "ticket.php",
                        data: values,
                        cache: false,
                        success: function (response) {
                            $('#user').html(response);
                        }
                    });
                });
            });

            $(document).ready(function () {
                $('#create_ticket_form').on('submit', function(e) {
                    e.preventDefault();
                    var values = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "new_ticket.php",
                        data: values,
                        cache: false,
                        success: function (success) {
                            if(success = "true"){
                                swal({title:"Success", text:"Ticket Created", type: "success"},
                                    function(){
                                        window.location.href="customer_service.php";
                                    });
                            }
                            else swal("Oops...", "Something went wrong!", "error");
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
                    <li class="active">
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


    <div class="container">
        <!-- Header-->

        <!-- CONTENT GOES HERE -->
        <div id="content-box">
            <div>
                <p id="first-p" class="intro-text" style="height: 20px"></p>
                <p class="form-group"">
                <button id="merge_contacts" type="submit" class="btn btn-primary" style="float:right; clear: left; margin-left: 10px;">Merge Contacts</button>
                <button id="create_contact" type="submit" class="btn btn-success" style="float:right; clear: left;">Create Contact</button>
                <button type="button" id="backButton" class="btn" style=" background-color: #D50000; color: white;" onclick="history.go(-1); return true;"><i class="fa fa-arrow-left" aria-hidden="true"></i><b>Back</b></button>

                </p>

                <table id="searchable-table" class="display">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>State</th>
                        <th><input type="checkbox" name="select_all" value="1" id="example-select-all" disabled "></th>
                        <th>Details</th>
                        <th>Tickets</th>
                    </tr>
                    </thead>
                </table>
                <!-- Close content box-->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal123" role="dialog">
                <div class="modal-dialog modal-lg" >

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                        </div>
                        <div class="modal-body">
                            <p>The <strong>show.bs.modal</strong> event occurs when the modal is about to be shown.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            
            <!-- Close body content-->
        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Ticket</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-group" id="create_ticket_form" method="POST" action="">
                            <div class="form-group">
                                <label for="client">Client Name</label>
                                <div>
                                    <input  class="form-control" disabled value="" id="client">
                                    <input   hidden value="" id="clientID" name="clientID">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <div>
                                    <select id="title" class="form-control" name="title" required>
                                        <option selected="selected" value="Select Category" disabled hidden>--Select Category--</option>
                                        <option value="Subscription Payment">Subscription Payment</option>
                                        <option value="Application Update/Upgrade">Application Update/Upgrade</option>
                                        <option value="Installation">Installation</option>
                                        <option value="General">General</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="category">Personnel Category</label>
                                <div>
                                    <select id="category" class="form-control" name="Category" required>
                                        <option selected="selected" value="Select Category" disabled hidden>--Select Receiving Department--</option>
                                        <option value="4">Marketer</option>
                                        <option value="12">Technical Officer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user">Assign To</label>
                                <div>
                                    <select id="user" class="form-control" name="user" required >
                                        <option selected="selected" value="Select User" disabled hidden>--Select Personnel--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="due_date">Due Date</label>
                                <div id="due_date">
                                    <input  class="form-control" placeholder="YYYY-MM-DD" id="due_date" name="due_date" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message">Message</label>
                                <div>
                                    <textarea rows="5" id="message" class="form-control" name="message" required></textarea>
                                </div>
                            </div>

                            <div class="form-group" >
                                <div style="float: right">
                                    <button type="submit" class="btn btn-primary" id="submit">
                                        <i class="fa fa-btn fa-ticket"></i> Open Ticket
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Templates -->
        <!-- Custom JS -->

        <!-- Close content-->
    </div>


    </body>
</html>
<?php
} ?>