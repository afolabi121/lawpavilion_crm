<?php
include_once ("config.php");

/* Database connection end */


// storing  request (ie, get/post) global array to a variable
$requestData= $_POST;


$columns = array(
// datatable column index  => database column name

    0 =>'name',
    1 => 'email',
    2=> 'phones',
    3 => 'address',
    4 => 'state',
    5 => 'id'

);

// getting total number records without any search
$sql = "SELECT id, name, email, phones, address, state   ";
$sql.=" FROM tbl_contact WHERE name !='' AND is_client = 1" ;
$query=mysqli_query($connect, $sql) or die("DataTB.php: get contacts");
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
        $sql.=" AND name LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR email LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR phones LIKE '".$requestData['search']['value']."%'";
        $sql.=" OR state LIKE '".$requestData['search']['value']."%'";
}

$query=mysqli_query($connect, $sql) or die("DataTB.php: get contacts");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query=mysqli_query($connect, $sql) or die("DataTB.php: get contacts");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
    $nestedData=array();
    $nestedData[] = $row["name"];
    $nestedData[] = $row["email"];
    $nestedData[] = $row["phones"];
    $nestedData[] = $row["address"];
    $nestedData[] = $row["state"];
    $nestedData[] = $row["id"];
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
