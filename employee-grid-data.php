<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hpippm";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */

///////////////Retriving Custom Value
//var_dump($_REQUEST['myKey']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'employee_name', 
	1 => 'employee_salary',
	2 => 'employee_position',
	3 => 'employee_city',
	4 => 'employee_extension',
	5 => 'employee_joining_date',
	6 => 'employee_age'
);



// getting total number records without any search
$sql = "SELECT employee_id";
$sql.=" FROM employee";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT employee_name, employee_salary, employee_position, employee_city, employee_extension, DATE_FORMAT(employee_joining_date, '%Y-%m-%d') as employee_joining_date, employee_age ";
$sql.=" FROM employee WHERE 1=1";
if( !empty($requestData['columns'][0]['search']['value']) ){
	$sql.=" AND  employee_name LIKE '".$requestData['columns'][0]['search']['value']."%' ";    
}
if( !empty($requestData['columns'][1]['search']['value']) ){
	$sql.=" AND  employee_salary LIKE '".$requestData['columns'][1]['search']['value']."%' ";
}
if( !empty($requestData['columns'][2]['search']['value']) ){
	$sql.=" AND  employee_position LIKE '".$requestData['columns'][2]['search']['value']."%' ";
}
if( !empty($requestData['columns'][3]['search']['value']) ){
	$sql.=" AND  employee_city LIKE '".$requestData['columns'][3]['search']['value']."%' ";
}
if( !empty($requestData['columns'][4]['search']['value']) ){
	$sql.=" AND  employee_extension LIKE '".$requestData['columns'][4]['search']['value']."%' ";
}
if( !empty($requestData['columns'][5]['search']['value']) ){
	$sql.=" AND  employee_joining_date LIKE '".$requestData['columns'][5]['search']['value']."%' ";
}
if( !empty($requestData['columns'][6]['search']['value']) ){
	$sql.=" AND  employee_age LIKE '".$requestData['columns'][6]['search']['value']."%' ";
}

$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains column index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees1");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["employee_name"];
	$nestedData[] = $row["employee_salary"];
	$nestedData[] = $row["employee_position"];
	$nestedData[] = $row["employee_city"];
	$nestedData[] = $row["employee_extension"];
	$nestedData[] = $row["employee_joining_date"];
	$nestedData[] = $row["employee_age"];
	
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
