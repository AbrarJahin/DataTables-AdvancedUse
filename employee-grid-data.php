<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hpippm";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */

$columns = array( 
				// datatable column index  => database column name	->	Should be same as the main HTML table -> Used for Finding Sorting Index Correctly
					0 => 'employee_name', 
					1 => 'employee_salary',
					2 => 'employee_position',
					3 => 'employee_city',
					4 => 'employee_extension',
					5 => 'employee_joining_date',
					6 => 'employee_age'
				);

//////////////////////////////////////////////All POST Variables for using into any condition
// storing  request (ie, get/post) global array to a variable  ->	All data of POST
$requestData= $_REQUEST;
/*
		//	Receiving Custom Requested Data
		var_dump($_REQUEST['StartDate']);
		var_dump($_REQUEST['EndDate']);
		var_dump($_REQUEST['StateID']);
		exit();
*/
$draw_request_code=$requestData['draw'];

//Search Variables
$EmployeeNameSeach	=	$requestData['columns'][0]['search']['value'];
$SalarySeach		=	$requestData['columns'][1]['search']['value'];
$PositionNameSeach	=	$requestData['columns'][2]['search']['value'];
$CitySeach			=	$requestData['columns'][3]['search']['value'];
$ExtensionSeach		=	$requestData['columns'][4]['search']['value'];
$JoiningDataSeach	=	$requestData['columns'][5]['search']['value'];
$AgeSeach			=	$requestData['columns'][6]['search']['value'];

//Ordering
$column_index_for_ordering	=	$requestData['order'][0]['column'];		//$requestData['order'][0]['column'] contains column index
$column_ordering_direction	=	$requestData['order'][0]['dir'];		//$requestData['order'][0]['dir'] contains order such as asc/desc

//Limiting Data for Pagination
$start_data_index			=	$requestData['start'];
$per_page_content_number	=	$requestData['length'];

/////////////////////////////////////////////////////////////////////////////////////////////



// getting total number records without any search
$sql = "SELECT employee_id";
$sql.=" FROM employee";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT employee_name, employee_salary, employee_position, employee_city, employee_extension, DATE_FORMAT(employee_joining_date, '%Y-%m-%d') as employee_joining_date, employee_age ";
$sql.=" FROM employee WHERE 1=1";
if( !empty($EmployeeNameSeach) )
{
	$sql.=" AND  employee_name LIKE '".$EmployeeNameSeach."%' ";    
}
if( !empty($SalarySeach) )
{
	$sql.=" AND  employee_salary LIKE '".$SalarySeach."%' ";
}
if( !empty($PositionNameSeach) )
{
	$sql.=" AND  employee_position LIKE '".$PositionNameSeach."%' ";
}
if( !empty($CitySeach) )
{
	$sql.=" AND  employee_city LIKE '".$CitySeach."%' ";
}
if( !empty($ExtensionSeach) )
{
	$sql.=" AND  employee_extension LIKE '".$ExtensionSeach."%' ";
}
if( !empty($JoiningDataSeach) )
{
	$sql.=" AND  employee_joining_date LIKE '".$JoiningDataSeach."%' ";
}
if( !empty($AgeSeach) )
{
	$sql.=" AND  employee_age LIKE '".$AgeSeach."%' ";
}

$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$column_index_for_ordering]."   ".$column_ordering_direction."  LIMIT ".$start_data_index." ,".$per_page_content_number."   ";

$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees1");

$data = array();
while( $row=mysqli_fetch_array($query) )
{  // Preparing an array For Returning Reponce
	$nestedData=array(); 

	$nestedData = array	(
							"employee_name"			=>	$nestedData[] = $row["employee_name"],
							"employee_salary"		=>	$nestedData[] = $row["employee_salary"],
							"employee_position"		=>	$nestedData[] = $row["employee_position"],
							"employee_city"			=>	$nestedData[] = $row["employee_city"],
							"employee_extension"	=>	$nestedData[] = $row["employee_extension"],
							"employee_joining_date"	=>	$nestedData[] = $row["employee_joining_date"],
							"employee_age"			=>	$nestedData[] = $row["employee_age"],
							"employee_age1"			=>	$nestedData[] = $row["employee_age"],	//Extra data dosen't matter - ordering doesn't matter, tagname matters

							"id"					=>	$nestedData[] = rand()		//Send ID here for edit and delete an item
						);

	$data[] = $nestedData;
}

$json_data	=	array(
						"draw"            => intval( $draw_request_code ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
						"recordsTotal"    => intval( $totalData ),  // total number of records
						"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
						"data"            => $data   // total data array
					);
echo json_encode($json_data);  // send data as json format
?>