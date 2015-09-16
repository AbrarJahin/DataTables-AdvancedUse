//Applied on Table with ID = "employee-grid"

$(document).ready(function()
{
	var dataTable =  $('#employee-grid').DataTable(
	{
		"scrollX": true,
		processing: true,
		serverSide: true,			//For Enabling AJAX
		"deferRender": true,		//For Speed up procesing time
		"ajax":
		{
			"url": "employee-grid-data.php",
			"type": 'POST',
			"data": function ( d )				//Sending Custom Data for manupulating with elements out of the table
					{
						d.StartDate	=	"12-13-14";
						d.EndDate	=	"Fuck You";
						d.StateID	=	123;
						// d.custom = $('#myInput').val();
						// etc
					},
			"error": function()									//Custom Error Function
					{									// error handling
						$(".employee-grid-error").html("");
						$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
						$("#employee-grid_processing").css("display","none");
						
					}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": "employee_name"			},
						{	"data": "employee_salary"		},
						{	"data": "employee_position"		},
						{	"data": "employee_city"			},
						{	"data": "employee_extension"	},
						{	"data": "employee_joining_date"	},
						{	"data": "employee_age"			},
						{	"data": null					}		//If it is not null then buttons would not be shown
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
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
							$("div.toolbar").html('<div class="btn-group" style="float:right;"><button onclick="resetAllFilters()" type="button" class="btn btn-info btn-lg">Reset All Filters</button><button onclick="addNewEntry()" class="btn btn-success btn-lg">Add a New Record</button></div>');
						},
		orderCellsTop: true,			//Collumn Visiblity Buttons - Visual Reorganising - Bug Fixing
		buttons:	[					//Collumn Visiblity Buttons
						{
							extend: 'colvis',
							collectionLayout: 'fixed four-column',			//Number of Columns in Column Viiblity POP Up
							postfixButtons: [ 'colvisRestore' ]
						}
					],
		"columnDefs":	[								//For Action Buttons (Edit and Delete button) adding in the Action Column
							{
								"orderable": false,		//Turn off ordering
								"searchable": false,	//Turn off searching
								"targets": [7],			//Going to last column - 7 is the last column index because o is starting index
								"data": null,			//Not receiving any data
								"defaultContent": '<div style="min-width:70px" class="btn-group" role="group"><button type="button" class="edit btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button type="button" class="delete btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div>'
							}
						],

	});

	$('#employee-grid tbody').on( 'click', 'button.edit', function ()	//Handeling Edit Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		itemEdit(data['id']);	//id = index of ID sent from server
	} );

	$('#employee-grid tbody').on( 'click', 'button.delete', function ()	//Handeling Delete Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		itemDelete(data['id']);	//id = index of ID sent from server
	} );

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

function resetAllFilters()
{
	$('#employee-grid').DataTable().state.clear();		//Clear all state
	$(':input').val('');								//Clear all input
	//$('#employee-grid').DataTable().ajax.reload();	//Not working Reloding all AJAX data
	location.reload();
}

function addNewEntry()
{
	$("#addNewData").modal({}).draggable();
	$('#addNewData').modal('show');
}

function itemEdit(item_ID)
{
	alert("Edit Item with ID = "+item_ID);
	dataTable.fnDraw();					//To refresh the table after Editing
}

function itemDelete(item_ID)
{
	if (confirm("Press a button!") == true)
	{	//Do something AJAX for deletation
		alert("Deleted Item with ID = "+item_ID);
	}
	else
	{
		alert("Data is not deleted!!");
	}
	dataTable.fnDraw();					////To refresh the table after Deleting
}