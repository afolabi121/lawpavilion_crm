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
        <script src="js/lib/jquery.dataTables.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="dist/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">

        <script>
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

            $(document).ready(function() {
                var dataTable = $('#pending-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "ajax": {
                        url: "pending_tickets_backend.php", // json datasource
                        type: "POST",  // method  , by default get
                        error: function () {  // error handling
                            $(".employee-grid-error").html("");
                            $("#pending-table").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#employee-grid_processing").css("display", "none");
                        }
                    },
                    "columnDefs": [ {"className": "dt-center", "targets": "_all"}]

                });

                $('#pending-table tbody').on('click', '#close_ticket', function () {
                    var data = dataTable.row($(this).parents('tr')).data();
                    var complete = data[6];
                    var id = data[9];
                    var values ={"id" : id};
                    console.log(values);
                    if (complete == '<span class="glyphicon glyphicon-ok"></span>'){
                        swal({title: "Close Ticket?",
                            text: "This cannot be undone!",
                            type: "warning",
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Yes, Proceed",
                                showCancelButton: true,
                                cancelButtonText: "No"},
                            function () {
                            $.ajax({
                            type: "POST",
                            url: "close_pending.php",
                            data: values,
                            cache: false,
                            success: function (success) {
                                if(success = 'true') {
                                    swal({title: "Success", text: "Ticket Closed", type: "success"},
                                        function () {
                                            window.location.href = "customer_service.php";
                                        });
                                }
                                else if (success = 'false'){
                                    swal("Oops...", "Something went wrong!", "error");
                                }
                            }
                        });
                            });
                    }
                    else {
                        swal("Denied!", "Ticket has not been completed by assigned officer", "error");
                    }
                });
            });

            $(document).ready(function(){
                var dataTable = $('#closed-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "ajax": {
                        url: "closed_tickets_backend.php", // json datasource
                        type: "POST",  // method  , by default get
                        error: function () {  // error handling
                            $(".employee-grid-error").html("");
                            $("#closed-table").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#employee-grid_processing").css("display", "none");
                        }
                    },
                    "columnDefs": [ {"className": "dt-center", "targets": "_all"}]

                });

                $('#closed-table tbody').on('click', '#ticket_details', function () {
                    var data = dataTable.row($(this).parents('tr')).data();
                    var id = data[8];
                    var values = {"id" : id};
                    $.ajax({
                        type: "POST",
                        url: "ticket_details.php",
                        data: values,
                        cache: false,
                        success: function (input) {
                            var parse = JSON.parse(input);
                            $('#ticket_details_form')
                                .find('[name="client"]').val(parse.data.Client).end()
                                .find('[name="title"]').val(parse.data.title).end()
                                .find('[name="officer"]').val(parse.data.Assigned).end()
                                .find('[name="message"]').val(parse.data.message).end()
                                .find('[name="date_created"]').val(parse.data.date_issued).end()
                                .find('[name="date_due"]').val(parse.data.date_due).end()
                                .find('[name="date_completed"]').val(parse.data.date_completed).end();
                        }
                    });

                    $('#myModal').modal('show');
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
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Account <span class="caret"></span></a>
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
    <div class=" container">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Customer Service</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-md-6 active">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>Pending Tickets</div>
                                    <div class="huge">124</div>
                                </div>
                            </div>
                        </div>
                        <a data-toggle="pill" href="#pending_tickets" >
                            <div class="panel-footer" style="background-color: white">
                                <span class="pull-left">View Pending Tickets</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel " style="background-color: #5cb85c; border-color: #4cae4c">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-square fa-5x" style="color: white"></i>
                                </div>
                                <div class="col-xs-9 text-right" style="color: white">
                                    <div >Closed Tickets</div>
                                    <div class="huge">124</div>
                                </div>
                            </div>
                        </div>
                        <a data-toggle="pill" href="#closed_tickets" style="color: #5cb85c">
                            <div class="panel-footer" style="background-color: white">
                                <span class="pull-left">View Closed Tickets</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-ok"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-ticket fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>New Ticket</div>
                                </div>
                            </div>
                        </div>
                        <a  href="home.php" style="color: #0c0c0c;">
                            <div class="panel-footer" style="background-color: white">
                                <span class="pull-left">Create Ticket</span>
                                <span class="pull-right"><i class="fa glyphicon glyphicon-pencil"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-content">
            <div id="pending_tickets" class="tab-pane fade in active">
                <h3>Pending</h3>
                <table id="pending-table" class="TABLE" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Client</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Assigned To</th>
                        <th>Date Created</th>
                        <th>Date Due</th>
                        <th>Complete?</th>
                        <th>Date Completed</th>
                        <th>Close</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div id="closed_tickets" class="tab-pane fade">
                <h3>Closed Tickets</h3>
                <table id="closed-table" class="display">
                    <thead>
                    <tr>
                        <th>Client</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Assigned To</th>
                        <th>Date Completed</th>
                        <th>Date Due</th>
                        <th>Details</th>
                        <th>Ticket Closed</th>
                    </tr>
                    </thead>
                </table>

                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Ticket Details</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-group" id="ticket_details_form" method="POST" action="">
                                    <div class="form-group">
                                        <label for="client">Client's Name</label>
                                        <div>
                                            <input  class="form-control" disabled value="" name="client">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Ticket Title</label>
                                        <div>
                                            <input  class="form-control" disabled value="" name="title">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Assigned To</label>
                                        <div>
                                            <input  class="form-control" disabled value="" name="officer">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <div>
                                            <textarea  id="message" class="form-control" name="message" disabled value=""></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="user">Date Created</label>
                                        <div>
                                            <input  class="form-control" disabled value="" name="date_created">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="due_date">Due Date</label>
                                        <div id="due_date">
                                            <input  class="form-control" disabled value="" name="date_due">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="due_completed">Date Completed</label>
                                        <div id="due_completed">
                                            <input  class="form-control" disabled value="" name="date_completed">
                                        </div>
                                    </div>
                                        <div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
} ?>