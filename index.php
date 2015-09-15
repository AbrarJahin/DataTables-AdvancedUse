<!DOCTYPE html>
<html>
	<head>
		<title>Datatable</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

		<!-- This 2 is for jQuery UI -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

		<!--  This is for Bootstrap UI
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css">
		-->

		<!-- Plugin for Column Visiblity - CSS - 1 file -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">

		<link rel="stylesheet" type="text/css" href="css/datable_custom.css">
	</head>
	<body>
		<div class="header"><h1>Hpippm DataTable</h1></div>
		<div class="container">
			<table id="employee-grid"  class="display" cellspacing="0" width="100%">
				<thead>
					<!-- Problamatic Part -->
					<tr>
						<th rowspan="2">Name</th>
						<th colspan="2">HR Information</th>
						<th colspan="3">Contact</th>
					</tr>
					<!-- Problamatic Part - END -->
					<tr>
						<th>Employee name</th>
						<th>Salary</th>
						<th>Position</th>
						<th>City</th>
						<th>Extension</th>
						<th>Joining date</th>
						<th>Age</th>
					</tr>
					<tr>
						<td><input type="text" id="0"  class="employee-search-input"></td>
						<td><input type="text" id="1" class="employee-search-input"></td>
						<td><input type="text" id="2" class="employee-search-input" ></td>
						<td><input type="text" id="3" class="employee-search-input" ></td>
						<td><input type="text" id="4" class="employee-search-input" ></td>
						<td  valign="middle"><input  readonly="readonly" type="text" id="5" class="employee-search-input datepicker" ></td>
						<td><input type="text" id="6" class="employee-search-input" ></td>
					</tr>
				</thead>
			</table>
		</div>

		<!-- Modal - Start -->
		<div class="modal fade" id="addNewData" role="dialog">
			<div class="modal-dialog">

			<!-- Modal content for Pop Up -->
			<div class="modal-content">
				<div class="modal-header panel-primary">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add a New Record</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
					  <label for="usr">Name:</label>
					  <input type="text" class="form-control" id="usr">
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" id="pwd">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success">Add Data</button>
					<input class="btn btn-danger" type="reset" value="Reset">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
			</div>
		</div>
		<!-- Modal - End -->
	</body>

		<!-- External Javascript Sources - Start -->
		<script type="text/javascript" language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" language="javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		<!-- This 2 for jQuery UI -->
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" language="javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<!-- 	This 2 for Bootstrap UI
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
 -->

		<!-- Plugin for Column Visiblity - JS - 2 files -->
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.0.3/js/buttons.colVis.min.js"></script>

		<script type="text/javascript" language="javascript" src="js/datatable_custom.js"></script>
		<!-- External Javascript Sources - End -->
</html>