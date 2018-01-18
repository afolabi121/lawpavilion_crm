<?php
include_once ("config.php");

/* Database connection end */


// storing  request (ie, get/post) global array to a variable
$requestData= $_POST;


$columns = array(
// datatable column index  => database column name
    0 =>'client_id',
    1 =>'title',
    2 => 'message',
    3 => 'user_id',
    4 => 'date_issued',
    5 => 'date_completed',
    6 => 'complete',
    7 => 'date_due',
    8 => 'complete_acknowledge',
    9 => 'id'

);

// getting total number records without any search
$sql = "SELECT tbl_contact.name as Client, tbl_ticket.title, tbl_ticket.message, tbl_user.name as 'Assigned To', tbl_ticket.date_issued, tbl_ticket.date_due, tbl_ticket.complete, tbl_ticket.date_completed, tbl_ticket.complete_acknowledge, tbl_ticket.id FROM tbl_ticket INNER JOIN tbl_contact ON tbl_ticket.client_id = tbl_contact.id INNER JOIN tbl_user ON tbl_ticket.user_id = tbl_user.id WHERE tbl_ticket.complete_acknowledge = 1 ORDER BY tbl_ticket.date_issued ASC " ;
$query=mysqli_query($connect, $sql) or die("pending_tickets_backend.php: chai");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

//
//        if (!empty($requestData['columns'][4]['search']['value'])) {
//            if($requestData['columns'][4]['search']['value'] == 'active'){
//                $sql.= "WHERE tbl_subscription.expiry_date >= CURDATE()";
//            }
//            else if ($requestData['columns'][4]['search']['value'] == 'expired'){
//                $sql.= "WHERE tbl_subscription.expiry_date < CURDATE()";
//            }
//        }

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND tbl_contact.name LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR tbl_ticket.title LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR tbl_ticket.message LIKE '".$requestData['search']['value']."%'";
    $sql.=" OR tbl_user.name LIKE '".$requestData['search']['value']."%'";
    $sql.=" OR tbl_ticket.date_issued LIKE '".$requestData['search']['value']."%'";
    $sql.=" OR tbl_ticket.date_due LIKE '".$requestData['search']['value']."%'";
    $sql.=" OR tbl_ticket.complete LIKE '".$requestData['search']['value']."%'";
    $sql.=" OR tbl_ticket.date_completed LIKE '".$requestData['search']['value']."%'";
    $sql.=" OR tbl_ticket.complete_acknowledge LIKE '".$requestData['search']['value']."%'";
}

$query=mysqli_query($connect, $sql) or die("pending_tickets_backend.php: i no sabi");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
//$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query=mysqli_query($connect, $sql) or die("pending_tickets_backend.php: go downlow");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
    $nestedData=array();
    $close = '';
    $complete = '';
    $details = '';
    $nestedData[] = $row['Client'];
    $nestedData[] = $row['title'];
    $nestedData[] = $row['message'];
    $nestedData[] = $row['Assigned To'];
    $nestedData[] = $row['date_issued'];
    $nestedData[] = $row['date_completed'];
    $details = '<button id="ticket_details" class="btn btn-info">View Details</button>';
    $nestedData[] = $details;


    $close  = '<button id="" class="btn btn-success" disabled>Ticket Closed</button>';


    $nestedData[] = $close;
    $nestedData[] = $row['id'];
    $data[] = $nestedData;
}



$json_data = array(
    "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal"    => intval( $totalData ),  // total number of records
    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format

?>
