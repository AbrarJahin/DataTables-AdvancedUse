$(document).ready(function()
{
	var dataTable =  $('#employee-grid').DataTable(
	{
		processing: true,
		serverSide: true,
		//ajax: "employee-grid-data.php", // json datasource for AJAX Data

		"ajax":
		{
			"url": "employee-grid-data.php",
			//"type": 'POST',
			"data": function ( d )				//Sending Custom Data for manupulating with elements out of the table
					{
						d.myKey = "myValue";
						// d.custom = $('#myInput').val();
						// etc
					}
		},

		"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		"language":{					//Custom Message Setting
						"lengthMenu": "Display _MENU_ records per page",	//Customizing menu Text
						"zeroRecords": "Nothing found - sorry",				//Customizing zero record text - filtered
						"info": "Showing page _PAGE_ of _PAGES_",			//Customizing showing record no
						"infoEmpty": "No records available",				//Customizing zero record message - base
						"infoFiltered": "(filtered from _MAX_ total records)"	//Customizing filtered message
					},
		"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],		//For customizing number of data sets per page

		dom: 'l<"toolbar">Bfrtip',	//"Bfrtip" is for column visiblity - B F and R become visible
		initComplete:	function()	//Adding Custom button in Tools
						{
							$("div.toolbar").html('<button type="button" onclick="addNewEntry()">Add a New Record</button>');
						},
		orderCellsTop: true,			//Collumn Visiblity Buttons - Visual Reorganising - Bug Fixing
		buttons:	[					//Collumn Visiblity Buttons
						{
							extend: 'colvis',
							collectionLayout: 'fixed three-column',
							postfixButtons: [ 'colvisRestore' ]
						}
					],

	});					

	$("#employee-grid_filter").css("display","none");  // hiding global search box

	//Custom Search Boxes-Start////////////////////////////////////////////////////
	$('.employee-search-input').on( 'keyup change', function ()
	{   
		var i =$(this).attr('id');	// getting column index
		var v =$(this).val();		// getting search input value
		dataTable.columns(i).search(v).draw();
	} );
	//Custom Search Boxes-End//////////////////////////////////////////////////////

	//Date Picker Adding and Options-Start///////////////////////////////////////////////
	$( ".datepicker" ).datepicker(
	{
		dateFormat: "yy-mm-dd",
		showOn: "button",
		showAnim: 'slideDown',
		showButtonPanel: true ,
		autoSize: true,
		buttonImage: "//jqueryui.com/resources/demos/datepicker/images/calendar.gif",
		buttonImageOnly: true,
		buttonText: "Select date",
		closeText: "Clear"
	});

	$(document).on("click", ".ui-datepicker-close", function()
	{
		$('.datepicker').val("");
		dataTable.columns(5).search("").draw();
	});
	//Date Picker Adding and Options-End///////////////////////////////////////////////

});

function addNewEntry()
{
	$("#addNewData").modal({}).draggable();
	$(".modal-body")
	$('#addNewData').modal('show');
}