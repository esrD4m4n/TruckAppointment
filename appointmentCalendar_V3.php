<?php
session_start();
include('login/auth_functions.php');
checkAuthentication();
require_once '../../nwffunctions/i5db2connect.php';

$userid = $_SESSION['userInfo']['profile'];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Truck Appointment</title>
        <link href="css/styles.css" rel="stylesheet" />
          <!-- DataTables CSS -->
  		<link rel='stylesheet' type='text/css' href='/DataTables/datatables.min.css'>
        <!-- flatpickr is a lightweight and powerful datetime picker. -->
      	<link rel="stylesheet" href="/flatpickr/dist/flatpickr.min.css">   
      	<link rel="stylesheet" href="/flatpickr/dist/plugins/confirmDate/confirmDate.css"> 
<!--     	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
<!--     	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css"> -->
<!--      	<link rel="stylesheet" href="/flatpickr/dist/themes/material_red.css">     -->
    	<link rel='stylesheet' href='/fullcalendar/fullcalendar.css'/>
  		<link href='/fullcalendarv5102/lib/main.css' rel='stylesheet' />
  		 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <style type="text/css">
            .ui-autocomplete
                {
                    position:absolute;
                    cursor:default;
                    z-index:9999 !important
                }
                .poRow, .poRowManual{
                	display: none
                }
                .alert{
                	display: none
                }
                .noSlots {
                  background-color: #f0ad4e;
                }
/* .modal-body { */
/*   background-color: #fff; */
/* } */
        </style>
    </head>
    <body class="sb-nav-fixed">
		<?php include_once 'top_bar.php';?>
        <div id="layoutSidenav">
  			<?php include_once 'side_bar.php';?>
            <div id="layoutSidenav_content">
                <main>
 <!--           	    <nav id="formButtons" class="navbar navbar-dark" style="background-color: #E2E5DE;">
                       <form class="form-inline">  
                        <button type="button" onclick="createTicket('<?php //echo $fromUrl.'?tktUser='.$tktUser;;?>')" class="btn btn-primary">Save and Close</button>
<!-- <!--     					<button type="button" id="closeButton"class="btn btn-secondary" data-dismiss="modal">Close</button> --> 
<!--                       </form> -->
<!--                     </nav>  -->
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Truck Appointment</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Truck Appointment</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                            	<div id="calendar"></div>   
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Newly Weds Foods Global Net 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- Logout Modal-->
        <div id="noSlotsModal" class="modal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-warning">
                <h5 class="modal-title" id="noSlotsModalTitle">Warning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>No slots available for the date/time selected</p>
              </div>
              <div class="modal-footer">
                <button type="button"class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Logout Modal-->
        <div id="noSlotsModalManual" class="modal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-warning">
                <h5 class="modal-title" id="noSlotsModalManualTitle">Warning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>No slots available for the date/time selected</p>
              </div>
              <div class="modal-footer">
                <button id="closenoSlotsModalManual" type="button"class="btn btn-secondary">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- truck Manual appointment modal -->
        <div id="truckManualAppoitmentModal" class="modal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="truckManualAppoitmentModalTitle">Create Truck Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">                						
    			<input type="hidden" class="form-control" id="saveMode-manual" value="insert" readonly>	
    			<div class=" mb-3 row">
    				<label for="appt-date-manual" class="col-sm-4 col-form-label">Appointment Date:</label> 
    				<div class="col-sm-8">					  
    					<input  class="form-control dateFlatPickr" id="appt-date-manual" placeholder="Select date and time">
    				</div>
    			</div>
    			<div class=" mb-3 row">
    				<label for="reservation-type-manual" class="col-sm-4 col-form-label">Reservation Type:</label> 
    				<div class="col-sm-8">	
    					<select class="form-select" id="reservation-type-manual">
        					<option value="MANUAL">Called In</option>
                            <option value="RESERVED">Reserved</option>
                      	</select>
    				</div>
    			</div>
			  	<div class="mb-3 row">
                    <label for="pickup-id-manual" class="col-sm-4 col-form-label">Appointment Type</label>
                    <div class="col-sm-8">
                    	<select class="form-select" id="pickup-id-manual">
                    		<option value="" selected>Make a selection..</option>
                            <option value="Pickup">Pick up</option>
        					<option value="Delivery">Delivery</option>
                      	</select> 
                    </div>
                 </div>
                 <div class="mb-3 row">
                    <label for="warehouse-id-manual" class="col-sm-4 col-form-label">Warehouse Id</label>
                    <div class="col-sm-8">
                    	<select class="form-select" id="warehouse-id-manual">
                    		<option value="" selected>Make a Selection...</option>
                            <option value="E1">E 01</option>
        					<option value="E2">E 02</option>
                      </select>
                    </div>
                  </div>
                  <div class="orderRowManual">	
                    <div class="mb-3 row">
                        <label for="order-id-manual" class="col-sm-4 col-form-label">Order#:</label>
                        <div class="col-sm-8">
                        	<input type="number" class="form-control" id="order-id-manual">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="cust-id-manual" class="col-sm-4 col-form-label">Customer#:</label>
                        <div class="col-sm-8">
                        	<input type="number" class="form-control" id="cust-id-manual">
                        </div>
                    </div>			
                    <div class="mb-3 row">
                    	<label for="cust-name-manual" class="col-sm-4 col-form-label">Customer Name:</label>
                        <div class="col-sm-8">                  	
                        	<input type="text" class="form-control" id="cust-name-manual">
                        </div>                       
                    </div>
                </div>
                <div class="poRowManual">
                    <div class="mb-3 row">
                        <label for="po-id-manual" class="col-sm-4 col-form-label">PO#:</label>
                        <div class="col-sm-8">
                        	<input type="text" class="form-control" id="po-id-manual">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="vendor-id-manual" class="col-sm-4 col-form-label">Vendor#:</label>
                        <div class="col-sm-8">
                        	<input type="text" class="form-control" id="vendor-id-manual">
                        </div>
                    </div>	
                    <div class="mb-3 row">
                        <label for="vendor-name-manual" class="col-sm-4 col-form-label">Vendor Name:</label>
                        <div class="col-sm-8">
                        	<input type="text" class="form-control" id="vendor-name-manual">
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button"class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveTruckApptManual" class="btn btn-primary">Create</button>
              </div>
            </div>
          </div>
        </div>
        <!-- truck appointment modal -->
        <div id="truckAppoitmentModal" class="modal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="truckAppoitmentModalTitle">Add Truck Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <span id="dateSelected"></span>
    			<input type="hidden" class="form-control" id="appt-date" readonly>	
    			<input type="hidden" class="form-control" id="appt-dateISO" readonly>				
    			<input type="hidden" class="form-control" id="saveMode"readonly>	
    			<div class=" mb-3 row">
    				<label for="record-id" class="col-sm-4 col-form-label">Record Id:</label> 
    				<div class="col-sm-8">					  
    					<input type="number" class="form-control" id="record-id" readonly>
    				</div>
    			</div>
    			<div class=" mb-3 row">
    				<label for="reservation-type" class="col-sm-4 col-form-label">Reservation Type:</label> 
    				<div class="col-sm-8">	
    					<select class="form-select" id="reservation-type">
        					<option value="MANUAL">Called In</option>
                            <option value="RESERVED">Reserved</option>
                      	</select>
    				</div>
    			</div>
			  	<div class="mb-3 row">
                    <label for="pickup-id" class="col-sm-4 col-form-label">Type</label>
                    <div class="col-sm-8">
                    	<select class="form-select" id="pickup-id">
                            <option value="Pickup">Pick up</option>
        					<option value="Delivery">Delivery</option>
                      	</select> 
                    </div>
                 </div>
                 <div class="mb-3 row">
                    <label for="warehouse-id" class="col-sm-4 col-form-label">Warehouse Id</label>
                    <div class="col-sm-8">
                    	<select class="form-select" id="warehouse-id">
                            <option value="E1">E 01</option>
        					<option value="E2">E 02</option>
                      </select>
                    </div>
                  </div>
                  <div class="orderRow">	
                    <div class="mb-3 row">
                        <label for="order-id" class="col-sm-4 col-form-label">Order#:</label>
                        <div class="col-sm-8">
                        	<input type="number" class="form-control" id="order-id">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="cust-id" class="col-sm-4 col-form-label">Customer#:</label>
                        <div class="col-sm-8">
                        	<input type="number" class="form-control" id="cust-id">
                        </div>
                    </div>			
                    <div class="mb-3 row">
                    	<label for="cust-name" class="col-sm-4 col-form-label">Customer Name:</label>
                        <div class="col-sm-8">                  	
                        	<input type="text" class="form-control" id="cust-name">
                        </div>                       
                    </div>
                </div>
                <div class="poRow">
                    <div class="mb-3 row">
                        <label for="po-id" class="col-sm-4 col-form-label">PO#:</label>
                        <div class="col-sm-8">
                        	<input type="text" class="form-control" id="po-id">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="vendor-id" class="col-sm-4 col-form-label">Vendor#:</label>
                        <div class="col-sm-8">
                        	<input type="text" class="form-control" id="vendor-id">
                        </div>
                    </div>	
                    <div class="mb-3 row">
                        <label for="vendor-name" class="col-sm-4 col-form-label">Vendor Name:</label>
                        <div class="col-sm-8">
                        	<input type="text" class="form-control" id="vendor-name">
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button"class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="deleteTruckAppt" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                <button type="button"  id="saveTruckAppt"  class="btn btn-primary">Create</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Reserved Slot Apointment Modal -->
        <div class="modal fade" id="truckReservedAppoitmentModal" tabindex="-1" role="dialog" aria-labelledby="truckReservedAppoitmentModal" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="truckReservedAppoitmentModalTitle">Add Truck Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                <div class="container">
                	<span id="dateSelected"></span>
        			<input type="date" class="form-control dateFlatPickr" id="appt-dateR">			
        			<div class="row">
        				<div class="col-sm">
                           <label class="col-form-label" for="pickup-idR">Type</label>                   
                          <select class="custom-select" id="pickup-idR">
                            <option value="Pickup">Pick up</option>
        					<option value="Delivery">Delivery</option>
                          </select>            	
                    	</div>
                    	<div class="col-sm">
                           <label class="col-form-label" for="warehouse-idR">Warehouse Id</label>                   
                          <select class="custom-select" id="warehouse-idR">
                            <option value="E1">E 01</option>
        					<option value="E2">E 02</option>
                          </select>            	
                    	</div>    
        			</div>	
        			<div class="row orderRow">
        				<div class="col-sm">
                          	<label for="order-idR" class="col-form-label">Order Number:</label>
                        	<input type="number" class="form-control" id="order-idR">
                        </div> 	
                        <div class="col-sm">
                          	<label for="cust-idR" class="col-form-label">Customer Number:</label>
                        	<input type="number" class="form-control" id="cust-idR">
                        </div>
        			</div>
        			<div class="row orderRow">
                        <div class="col-sm">
                          	<label for="cust-nameR" class="col-form-label">Customer Name:</label>
                        	<input type="text" class="form-control" id="cust-nameR">
                        </div>                       
                    </div>	
        			<div class="row poRow">
        				<div class="col-sm">
                          	<label for="po-idR" class="col-form-label">PO Number:</label>
                        	<input type="text" class="form-control" id="po-idR">
                        </div> 	
                        <div class="col-sm">
                          	<label for="vendor-idR" class="col-form-label">Vendor Number:</label>
                        	<input type="number" class="form-control" id="vendor-idR">
                        </div>
        			</div>	           
                    <div class="row poRow">
                        <div class="col-sm">
                          	<label for="vendor-nameR" class="col-form-label">Vendor Name:</label>
                        	<input type="text" class="form-control" id="vendor-nameR">
                        </div>                       
                    </div>
                </div>
        
                </form> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>                
                <button type="button" id="saveReservedTruckAppt" class="btn btn-primary" data-dismiss="modal">Create</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="categoriesModal" tabindex="-1" role="dialog" aria-labelledby="categoriesModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="categoriesModalTitle">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="category-id" class="col-form-label">Category Id:</label>
                    <input type="number" class="form-control" id="category-id" readonly>
                  </div>
                  <div class="form-group">
                    <label for="category-description" class="col-form-label">Category Descripton:</label>
                     <input type="text" class="form-control" id="category-description">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="saveChanges" class="btn btn-primary">Save changes</button>
                <button type="button" id="saveChangesNew" class="btn btn-primary">Save changes New</button>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    		<!-- jQuery Moment JS --> 
      	<script type='text/javascript' src='/moment/moment.js'></script> 
        <script src="js/scripts.js"></script>
          <!-- jQuery Library - Core Home Page Template -->
          <script type='text/javascript' src='/jquery/jquery.min.js'></script>
          
            <!-- jQuery Library - Core Home Page Template--->
          <script type='text/javascript' src='/jquery-ui/jquery-ui.min.js'></script>
        
          <!-- jQuery Easing JS - Core Home Page Template -->
          <script type='text/javascript' src='/jquery-easing/jquery.easing.min.js'></script>
          
           <!-- Bootstrap JS - Core Home Page Template -->	
          <script type='text/javascript' src='/bootstrap/dist/js/bootstrap.bundle.min.js'></script>
           	<!-- DataTables JS - -->
          <script type='text/javascript' src='/DataTables/datatables.min.js'></script>
          <script type='text/javascript' src='/DataTables/RowGroup/js/dataTables.rowGroup.min.js'></script>
        	<!-- DataTables JSZip (used with buttons) JS -->
          <script type='text/javascript' src='/DataTables/JSZip/jszip.min.js'></script>  
          
          <!-- DataTables PDFMake (used with buttons) JS  -->
          <script type='text/javascript' src='/DataTables/pdfmake/pdfmake.min.js'></script>
              
          <!-- DataTables vfs_fonts (used with buttons) JS  -->
          <script type='text/javascript' src='/DataTables/pdfmake/vfs_fonts.js'></script>
            
          <!-- DataTables Buttons JS -->
         <script type='text/javascript' src='/DataTables/Buttons/js/dataTables.buttons.min.js'></script> 
        
          <!-- DataTables Buttons HTML5 JS custom assets (used with buttons)  -->
          <script type='text/javascript' src='/DataTables/Buttons/js/assets/buttons.html5.js'></script>
          
          <!-- DataTables Buttons Flash JS custom assets (used with buttons)  -->
          <script type='text/javascript' src='/DataTables/Buttons/js/assets/buttons.flash.js'></script>
          
          <!-- DataTables Buttons Print JS custom assets (used with buttons)  -->
          <script type='text/javascript' src='/DataTables/Buttons/js/assets/buttons.print.js'></script>
         
          <!-- DataTables Buttons Print JS -->
          <script type='text/javascript' src='/DataTables/Buttons/js/buttons.print.js'></script>
          <script src="/flatpickr/dist/flatpickr.js"></script>   
          <script src="/flatpickr/dist/plugins/confirmDate/confirmDate.js"></script>  
<!--           <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> -->
          <!-- 	Chart JS --> 
          <script src="/Chart.js/Chart.min.js"></script>
        	<!-- DataTables Editor JS  -->
        	<script type='text/javascript'
        		src='/DataTables_Editor/js/dataTables.editor.min.js'></script>
        
        	<!-- DataTables Editor Bootstrap 4 Integration JS	-->
        	<script type='text/javascript'
        		src='/DataTables_Editor/js/editor.bootstrap4.min.js'></script>
         
        		  <!-- jQuery Full Calendar JS --> 
           <script src='/fullcalendarv5102/lib/main.js'></script>
           <script>
               //initializes date  
          		flatpickr('.dateFlatPickr', {
              		enableTime: true,
              		dateFormat: 'Y-m-d H:i',
              		static: true, //allows to enter time manually
              		plugins: [new confirmDatePlugin({})],
               	   onChange: (selectedDates, dateStr, instance) => {
                	    //  alert('onChange -> ' + dateStr);
                  	   $.getJSON('gets/get_AppointmentRecordsForTheDayManual.php?apptTime='+dateStr, function(result) {
                    		 if(result >= 2){
                        		 //alert('No slots available for the date/time selected');
                        		 $('#truckManualAppoitmentModal').modal('hide');
                    			 $('#noSlotsModalManual').modal('show');
                    		 }
                      	   });
               	   }

              		});
      		
           		let calendarType = '';//'<?php //echo $_POST['parm1']?>';
    
        	  	document.addEventListener('DOMContentLoaded', function() {
        			var calendarEl = document.getElementById('calendar');
    
        		    var calendar = new FullCalendar.Calendar(calendarEl, {
        		    	
        		      initialView: 'timeGrid',
        		      selectable: true,
        		      allDaySlot: false,
        		      editable: true,
        		      selectMirror: true,   //place holder of date and time selected 
        		      customButtons: {
        		    	    myCustomButton: {
        		    	      text: 'Create Appointment',
        		    	      click: function() {
									$('#appt-date-manual').val('');
        				        	$('#cust-name-manual').val('');
        				        	$('#cust-id-manual').val('');
        				        	$('#order-id-manual').val('');
        				        	$('#pickup-id-manual').val(''); 
        				        	$('#warehouse-id-manual').val('');
        				        	$('#vendor-name-manual').val('');
        				        	$('#vendor-id-manual').val('');
        				        	$('#po-id-manual').val('');
        		    	    	  	$('#truckManualAppoitmentModal').modal('show');
        		    	      }
        		    	    }
        		    	  },
        		      headerToolbar: { 
        		        left: 'prev,next today myCustomButton',
        		        center: 'title',
        		        right: 'dayGridMonth,timeGridWeek,timeGridDay' 
        		      },
        		      dateClick: function(info) {
        		          //alert('clicked ' + info.dateStr);
        		          //prompt('Enter order number here'); 
        		    	  //console.log(info);
        		          
        		        },
        			  select: function(info) {
                            $('#dateSelected').text('Slot Selected ' + info.startStr);
                            $('#appt-date').val(info.startStr);
                          //  console.log(info.startStr);
                            //to check if there are more than 2 
                            
                        	$.getJSON('gets/get_AppointmentRecordsForTheDay.php?apptTime='+info.startStr, function(result) { 
                        		 					
         						if(result < 2){
         							$('#cust-name').val('');
                                    $('#cust-id').val('');
                                    $('#order-id').val('');
                                    $('#po-id').val('');
                                    $('#pickup-id').val(''); 
                                    $('#warehouse-id').val('');
                                    $('#vendor-name').val('');
                                    $('#vendor-id').val('');
                                    $('#saveMode').val('insert');
                                    $('.poRow' ).hide();
                					$('.orderRow' ).hide();
                					$('#truckAppoitmentModalTitle').text('Add Truck Appointment');
                					$('#deleteTruckAppt').hide();					
                		          	$('#truckAppoitmentModal').modal('show');
                		          		          					
                					$('#saveTruckAppt').on('click', function(e){					
                						
                                        let pickupType 		= $('#pickup-id').val();
                						let saveMode 		= $('#saveMode').val();
                						let resType 		= $('#reservation-type').val();
                                        let apptDate 		= '';
                                        let apptCustName	= '';
                                        let apptCustNum		= '';
                                        let apptOrderNum	= ''
                                        let apptType		= '';
                                        let warehouseid		= '';
                				    	let jsonData 		= {};
                				    	
                				    	if(pickupType == 'Pickup'){
                				        	apptDate 		= $('#appt-date').val();
                				        	apptCustName	= $('#cust-name').val();
                				        	apptCustNum		= $('#cust-id').val();
                				        	apptOrderNum	= $('#order-id').val();
                				        	apptType		= $('#pickup-id').val(); 
                				        	warehouseid		= $('#warehouse-id').val();
                				        }else{
                				        	apptDate 		= $('#appt-date').val();
                				        	apptCustName	= $('#vendor-name').val();
                				        	apptCustNum		= $('#vendor-id').val();
                				        	apptOrderNum	= $('#po-id').val();
                				        	apptType		= $('#pickup-id').val();
                				        	warehouseid		= $('#warehouse-id').val();
                				        }
                				    	console.log(jsonData);
                						jsonData 	= {
                							'apptDate' 		: encodeURIComponent( apptDate ),
                					   		'apptCustName'	: encodeURIComponent( apptCustName ),
                							'apptCustNum'	: apptCustNum,
                				           	'apptOrderNum' 	: apptOrderNum,
                				           	'apptType' 		: encodeURIComponent( apptType ),
                				           	'warehouseid' 	: encodeURIComponent( warehouseid ),
                				          	'createdBy'		: encodeURIComponent( '<?php echo $userid;?>' ),
                				          	'saveMode' 		: encodeURIComponent( saveMode ),
                				          	'appStdWrk'		: encodeURIComponent( resType )
                				           	    				
                					   } //end of jsonData
            
                                    	$.ajax({
                                    		type : "POST",
                                    		url : "saves/insert_appointment.php",
                                    		data : JSON.stringify(jsonData),
                                    		dataType : 'json',
                                    		success : (function(data, status, xhr) {
                                    			$('#saveTruckAppt').unbind('click');//Added this to prevent adding the event twice
                                    			$('#truckAppoitmentModal').modal('hide');
                                    			calendar.refetchEvents();				 												
                                    		}),
                                    		error : (function(x, e) {
                                    			if (x.status == 0) {
                                    				alert('You are offline!!\n Please Check Your Network.');
                                    			} else if (x.status == 404) {
                                    				alert('Requested URL not found.');
                                    			} else if (x.status == 500) {
                                    				alert('Internel Server Error.');
                                    			} else if (e == 'parsererror') {
                                    				alert('Error.\nParsing JSON1 Request failed.');
                                    			} else if (e == 'timeout') {
                                    				alert('Request Time out.');
                                    			} else {
                                    				alert('Unknow Error.\n' + x.responseText);
                                    			}
                                    		})
                                    	})// end of ajax			        
                                    });//end if click saveTruckAppt		
         						}else{
         							$('#noSlotsModal').modal('show');
         							//alert('No available slots for this date/time slot');
         							calendar.unselect()
         						}
    
                        	});//end of get Json                            	
        		        },
        		      events: 
        			      {
        			      	url: 'gets/get_CalendarData.php',
        	      	   		type: 'POST',
        	       	   		data: {
        	       	   	      calendarType: calendarType
        		            },
        	   				error: function() {
        	       	      		alert('There was events found!');
        	   	    		}
        			      },
        			  eventClick: function(info) {				   
        				   ///To get click event	
        				  // console.log(JSON.stringify(info));			   
        				   let wh_id	    	= info.event.extendedProps.wh_Id; 
        				   let customerNo    	= info.event.extendedProps.custNo; 
        				   let orderNo 			= info.event.extendedProps.orderNo; 
        				   let poNo 			= info.event.extendedProps.poNo; 
        				   let customerName 	= info.event.extendedProps.custName; 	
        				   let appointmentType 	= info.event.extendedProps.apptType;
        				   let reservationType 	= info.event.extendedProps.reservationType;
        				   let whApptId 	    = info.event.id;  //this is the record id
        				   				   
        				   oldapptDateIn 		= info.event.start;
                           oldapptDateIn.setHours(oldapptDateIn.getHours() - 6);//substracts 5 hours from date because toISOString() adds 5 hours 					  
                           oldapptDate	 		= oldapptDateIn.toISOString();//
                           oldapptDate = oldapptDate.replace("T", "-"); //removes the T from 2022-10-10T10:00:00.000Z
                           oldapptDate = oldapptDate.replace("Z", "0"); //removes the Z and replaces it for a 0 in 2022-10-10T10:00:00.000Z
                           oldapptDate = oldapptDate.replace(":", "."); 
                           oldapptDate = oldapptDate.replace(":", ".");  
                           
                           $('#appt-dateISO').val(oldapptDate);              
                           $('#saveMode').val('update');	   
                           $('#record-id').val(whApptId);
                           $('#reservation-type').val(reservationType);
                           
        				    let jsonData 	= {};	
        				    let saveMode	= $('#saveMode').val();        				    
        				    				   
        				    if(appointmentType == 'Delivery'){
        				    	$( ".poRow" ).show();
        						$( ".orderRow" ).hide();
        						$('#po-id').val(poNo);
        						$('#vendor-name').val(customerName);
        						$('#vendor-id').val(customerNo);
        				    } 
        				    
        				    if(appointmentType == 'Pickup'){
        				    	$( ".poRow" ).hide();
        						$( ".orderRow" ).show();
        						$('#order-id').val(orderNo);
        						$('#cust-id').val(customerNo);
        						$('#cust-name').val(customerName);
        				    }
        														
        					$('#appt-date').val(info.event.start);
        					$('#pickup-id').val(appointmentType);
        					$('#warehouse-id').val(wh_id);					
        					$('#truckAppoitmentModalTitle').text('Edit Truck Appointment');
        					$('#deleteTruckAppt').show();					
        					$('#truckAppoitmentModal').modal('show');	
    
        					$('#saveTruckAppt').on('click', function(e){
        				        let pickupType 		= $('#pickup-id').val();
        						let saveMode 		= $('#saveMode').val();
        						let resType 		= $('#reservation-type').val();
                                let apptDate 		= '';
                                let apptCustName	= '';
                                let apptCustNum		= '';
                                let apptOrderNum	= ''
                                let apptType		= '';
                                let warehouseid		= '';
        				    	let jsonData 		= {};
        					    	
        				    	if(pickupType == 'Pickup'){
        				        	apptDate 		= $('#appt-date').val();
        				        	apptCustName	= $('#cust-name').val();
        				        	apptCustNum		= $('#cust-id').val();
        				        	apptOrderNum	= $('#order-id').val();
        				        	apptType		= $('#pickup-id').val(); 
        				        	warehouseid		= $('#warehouse-id').val();
        				        }else{
        				        	apptDate 		= $('#appt-date').val();
        				        	apptCustName	= $('#vendor-name').val();
        				        	apptCustNum		= $('#vendor-id').val();
        				        	apptOrderNum	= $('#po-id').val();
        				        	apptType		= $('#pickup-id').val();
        				        	warehouseid		= $('#warehouse-id').val();
        				        }
        					    	
        						jsonData 	= {
        							'apptDate' 		: encodeURIComponent( apptDate ),
        					   		'apptCustName'	: encodeURIComponent( apptCustName ),
        							'apptCustNum'	: apptCustNum,
        				           	'apptOrderNum' 	: apptOrderNum,
        				           	'apptType' 		: encodeURIComponent( apptType ),
        				           	'warehouseid' 	: encodeURIComponent( warehouseid ),
        				          	'createdBy'		: encodeURIComponent( '<?php echo $userid;?>' ),
        				          	'saveMode' 		: encodeURIComponent( saveMode ),
        				          	'whApptId' 		: encodeURIComponent( whApptId ),
        				          	'appStdWrk'		: encodeURIComponent( resType )					           	    				
        						   } //end of jsonData
    
        	                	$.ajax({
        	                		type : "POST",
        	                		url : "saves/save_appointment.php",
        	                		data : JSON.stringify(jsonData),
        	                		dataType : 'json',
        	                		success : (function(data, status, xhr) {
        	                			$('#saveTruckAppt').unbind('click');//Added this to prevent adding the event twice
        	                			$('#truckAppoitmentModal').modal('hide');
        	                			calendar.refetchEvents();				 												
        	                		}),
        	                		error : (function(x, e) {
        	                			if (x.status == 0) {
        	                				alert('You are offline!!\n Please Check Your Network.');
        	                			} else if (x.status == 404) {
        	                				alert('Requested URL not found.');
        	                			} else if (x.status == 500) {
        	                				alert('Internel Server Error.');
        	                			} else if (e == 'parsererror') {
        	                				alert('Error.\nParsing JSON2 Request failed.');
        	                			} else if (e == 'timeout') {
        	                				alert('Request Time out.');
        	                			} else {
        	                				alert('Unknow Error.\n' + x.responseText);
        	                			}
        	                		})
        	                	})// end of ajax	
        						
        					})
        											
        					$('#deleteTruckAppt').on('click', function(e){
        			        	let text = 'Confirm Deletion';
        			        	if (confirm(text) == true) {
        			                  
        			              	jsonData 	= {			                      	
        			              				'whApptId' 		  : encodeURIComponent( whApptId )
        			                      		}; //end of jsonData
                              		
        			            		$.ajax({
        			            			type : "POST",
        			            			url : "deletes/delete_appointment.php",
        			            			data : JSON.stringify(jsonData),
        			            			dataType : 'json',
        			            			success : (function(data, status, xhr) {
        			            				$('#deleteTruckAppt').unbind('click');         			            				 
        					 					calendar.refetchEvents();   								
        			            			}),
        			        	    			error : (function(x, e) {
        			        	    				if (x.status == 0) {
        			        	    					alert('You are offline!!\n Please Check Your Network.');
        			        	    				} else if (x.status == 404) {
        			        	    					alert('Requested URL not found.');
        			        	    				} else if (x.status == 500) {
        			        	    					alert('Internel Server Error.');
        			        	    				} else if (e == 'parsererror') {
        			        	    					alert('Error.\nParsing JSON3 Request failed.');
        			        	    				} else if (e == 'timeout') {
        			        	    					alert('Request Time out.');
        			        	    				} else {
        			        	    					alert('Unknow Error.\n' + x.responseText);
        			        	    				}
        			        	    			})
        			    	    		})// end of ajax
        			        	  } else {
        			        		  console.log('Cancel');
        			        	  }
         
        			        });		
        				    
        				  },
        			  	eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
        				  
        				   	if (!confirm("Are you sure about this change?")) {
        				   		calendar.refetchEvents(); 
        	                   	revertFunc();
        	                   	
        	                   }	
        	                   
                            let wh_appt_id    	= event.oldEvent.id;   //The record id
                            let wh_id	    	= event.oldEvent.extendedProps.wh_Id;  //warehouse id
                            let customerNo    	= event.oldEvent.extendedProps.custNo; 
                            let orderNo 		= event.oldEvent.extendedProps.orderNo; 
                            let poNo 			= event.oldEvent.extendedProps.poNo; 
                            let customerName 	= event.oldEvent.extendedProps.custName; 	
                            let appointmentType = event.oldEvent.extendedProps.apptType;
                            let reservationType = event.oldEvent.extendedProps.reservationType;
             				
            		  		oldapptDateIn	= '';
            				oldapptDate		= '';
            				oldtitleIn 		= event.oldEvent.title;
                            oldapptDateIn 	= event.oldEvent.start;
                            oldapptDateIn.setHours(oldapptDateIn.getHours() - 6);//substracts 5 hours from date because toISOString() adds 5 hours 					  
                            oldapptDate	 	= oldapptDateIn.toISOString();//converts date to convert to ISO-8601 date  2022-10-10T10:00:00.000Z
                            oldapptDate 	= oldapptDate.replace("T", "-"); //removes the T from 2022-10-10T10:00:00.000Z
                            oldapptDate 	= oldapptDate.replace("Z", "0"); //removes the Z and replaces it for a 0 in 2022-10-10T10:00:00.000Z
                            oldapptDate 	= oldapptDate.replace(":", "."); 
                            oldapptDate 	= oldapptDate.replace(":", ".");                      
        	                   
        	              	var jsonData 	= {			                      	
        	              				'whApptId' : encodeURIComponent( wh_appt_id )
        	              		}
                      		
        		    		$.ajax({
        		    			type : "POST",
        		    			url : "deletes/delete_appointment.php",
        		    			data : JSON.stringify(jsonData),
        		    			dataType : 'json',
        		    			success : (function(data, status, xhr) {
        							//location.reload();
        		    				//window.open(url,"_self");    								
        		    			}),
        			    			error : (function(x, e) {
        			    				if (x.status == 0) {
        			    					alert('You are offline!!\n Please Check Your Network.');
        			    				} else if (x.status == 404) {
        			    					alert('Requested URL not found.');
        			    				} else if (x.status == 500) {
        			    					alert('Internel Server Error.');
        			    				} else if (e == 'parsererror') {
        			    					alert('Error.\nParsing JSON4 Request failed1.');
        			    				} else if (e == 'timeout') {
        			    					alert('Request Time out.');
        			    				} else {
        			    					alert('Unknow Error.\n' + x.responseText);
        			    				}
        			    			})
        			    		})// end of ajax
    
                            // let titleIn		= '';
                            let apptDateIn 	= '';	
                            let apptDate	 	= '';	
                            let jsonDataIn 	= {};  
                                                 
                            apptDateIn 	= event.event.start;                      
                            apptDateIn.setHours(apptDateIn.getHours() - 6);//substracts 5 hours from date because toISOString() adds 5 hours 					  
                            apptDate	= apptDateIn.toISOString();//converts date to convert to ISO-8601 date  2022-10-10T10:00:00.000Z	                
    
        			        jsonDataIn 	= {
                             		'apptDate' 		: encodeURIComponent( apptDate ),
                                 	'apptCustName'	: encodeURIComponent( customerName ),
                              		'apptCustNum'	: customerNo,
                                    'apptOrderNum' 	: orderNo,
                                    'apptType' 		: encodeURIComponent( appointmentType ),
                                    'warehouseid' 	: encodeURIComponent( wh_id ),
                                    'createdBy'		: encodeURIComponent( '<?php echo $userid;?>' ),
                                    'saveMode' 		: encodeURIComponent( 'insert' ),
                                    'appStdWrk'		: encodeURIComponent( reservationType )
                          			} //end of jsonData
    
        					//console.log(JSON.stringify(jsonDataIn))
        		    		//event.preventDefault();
        		    		$.ajax({
        		    			type : "POST",
        		    			url : "saves/insert_appointment.php",
        		    			data : JSON.stringify(jsonDataIn),
        		    			dataType : 'json',
        		    			success : (function(data, status, xhr) { 
    //     					    				calendar.refetchEvents();
        					
        		    			}),
        		    			error : (function(x, e) {
        		    				if (x.status == 0) {
        		    					alert('You are offline!!\n Please Check Your Network.');
        		    				} else if (x.status == 404) {
        		    					alert('Requested URL not found.');
        		    				} else if (x.status == 500) {
        		    					alert('Internel Server Error.');
        		    				} else if (e == 'parsererror') {
        		    					alert('Error.\nParsing JSON5 Request failed.');
        		    				} else if (e == 'timeout') {
        		    					alert('Request Time out.');
        		    				} else {
        		    					alert('Unknow Error.\n' + x.responseText);
        		    				}
        		    			})
        		    		})// end of ajax
    
        			    }//end of evendrop
        			      
        		    });
    
        		    calendar.render();

					$('#saveTruckApptManual').on('click', function(e){					
						
						e.preventDefault();	
                        let apptDate_m 		= '';
                        let apptCustName_m	= '';
                        let apptCustNum_m   = '';
                        let apptOrderNum_m	= '';
                        let apptType_m		= '';
                        let warehouseid_m	= '';
				    	let jsonData_m 		= {};					
                        let pickupType_m 	= $('#pickup-id-manual').val();                        
						let saveMode_m 		= 'insert';						 
						let resType_m 		= $('#reservation-type-manual').val();
						apptDate_m 			= $('#appt-date-manual').val();
						warehouseid_m		= $('#warehouse-id-manual').val();
        						alert(apptDate_m);
						$.getJSON('gets/get_AppointmentRecordsForTheDayManual.php?apptTime='+apptDate_m, function(result) { 
		 					
     						if(result < 2){
        						//Move the order number to apptOrderNum_m if its a pickup
        						if(pickupType_m == 'Pickup'){
        							apptOrderNum_m		= $('#order-id-manual').val();	
        						}else{
        							apptOrderNum_m		= $('#po-id-manual').val();
        						}
        						
        						if(apptDate_m == ''){
        							alert('You must select a date and time');
        							$('#appt-date-manual').focus();
        							return;
        						}
        						if(pickupType_m == ''){
        							alert('You must select a appointment type');
        							$('#pickup-id-manual').focus();
        							return;
        						}
        						if(warehouseid_m == ''){
        							alert('You must select a warehouse id');
        							$('#warehouse-id-manual').focus();
        							return;
        						}
        						if(apptOrderNum_m == '' && pickupType_m == 'Pickup'){
        							alert('You must enter an order number');
        							$('#order-id-manual').focus();
        							return;
        						}
        						if(apptOrderNum_m == '' && pickupType_m == 'Delivery'){
        							alert('You must enter a PO number');
        							$('#po-id-manual').focus();
        							return;
        						}
        						
        				    	if(pickupType_m == 'Pickup'){
        				        	apptDate_m 		= $('#appt-date-manual').val();
        				        	apptCustName_m	= $('#cust-name-manual').val();
        				        	apptCustNum_m	= $('#cust-id-manual').val();
        				        	apptOrderNum_m	= $('#order-id-manual').val();
        				        	apptType_m		= $('#pickup-id-manual').val(); 
        				        	warehouseid_m	= $('#warehouse-id-manual').val();
        				        	
        				        }else{
        				        	apptDate_m 		= $('#appt-date-manual').val();
        				        	apptCustName_m	= $('#vendor-name-manual').val();
        				        	apptCustNum_m	= $('#vendor-id-manual').val();
        				        	apptOrderNum_m	= $('#po-id-manual').val();
        				        	apptType_m		= $('#pickup-id-manual').val();
        				        	warehouseid_m	= $('#warehouse-id-manual').val();
        				        }
         				    	
         						jsonData_m 	= {
        							'apptDate' 		: encodeURIComponent( apptDate_m ),
        					   		'apptCustName'	: encodeURIComponent( apptCustName_m ),
        							'apptCustNum'	: apptCustNum_m,
        				           	'apptOrderNum' 	: apptOrderNum_m,
        				           	'apptType' 		: encodeURIComponent( apptType_m ),
        				           	'warehouseid' 	: encodeURIComponent( warehouseid_m ),
        				          	'createdBy'		: encodeURIComponent( '<? echo $userid;?>' ),
        				          	'saveMode' 		: encodeURIComponent( saveMode_m ),
        				          	'appStdWrk'		: encodeURIComponent( resType_m )
        				           	    				
        					   } //end of jsonData 
        
                            	$.ajax({
                            		type : "POST",
                            		url : "saves/insert_manual_appointment.php",
                            		data : JSON.stringify(jsonData_m),
                            		dataType : 'json',
                            		success : (function(data, status, xhr) {
                            			//$('#saveTruckApptManual').unbind('click');//Added this to prevent adding the event twice
                            			$('#truckManualAppoitmentModal').modal('hide');
                            			calendar.refetchEvents(); 				 												
                            		}),
                            		error : (function(x, e) {
                            			if (x.status == 0) {
                            				alert('You are offline!!\n Please Check Your Network.');
                            			} else if (x.status == 404) {
                            				alert('Requested URL not found.');
                            			} else if (x.status == 500) {
                            				alert('Internel Server Error.');
                            			} else if (e == 'parsererror') {
                            				alert('Error.\nParsing JSON1 Request failed.');
                            			} else if (e == 'timeout') {
                            				alert('Request Time out.');
                            			} else {
                            				alert('Unknow Error.\n' + x.responseText);
                            			}
                            		})
                            	})// end of ajax	
     						}else{
    							 $('#truckManualAppoitmentModal').modal('hide');
                    			 $('#noSlotsModalManual').modal('show');                    			 ;
     						}
						});//end of getJson
     								        
                    });//end of createAppointment
        		    
        		  });

      			//***********************
      		    //*  Auto complete for order in the truck appt modal        *
      		 	//***********************
      		    $( "#order-id" ).autocomplete({ 
      		 	      source: function( request, response ) {
      		 	        $.ajax( {
      		 	          url: "gets/get_OrdersToShip.php",
      		 	          dataType: "json",
      		 	          data: {
      		 	            term: request.term,
      		 	            bus: $('#locationId').val() //busness unit 
      		 	          },
      		 	          success: function( data ) {
      		 	             // alert(JSON.stringify(data));
      		 	            response( data );
      		 	          }
      		 	        } );
      		 	      },
      		 	      minLength: 2,
      		 	      select: function( event, ui ) {
      		 				//loadProductTable(ui.item.ORDER_NUMBER);
      		 				$('#order-id').val(ui.item.ORDER_NUMBER);
      		 				$('#cust-name').val(ui.item.CMSNME);
      		 				$('#cust-id').val(ui.item.CUST_NUM);
      		 	      } //on select
      		 	    } );//End of order id auto complete
          			//***********************
          		    //*  Auto complete for order in the truck appt modal  manual      *
          		 	//***********************
          		    $( "#order-id-manual" ).autocomplete({ 
          		 	      source: function( request, response ) {
          		 	        $.ajax( {
          		 	          url: "gets/get_OrdersToShip.php",
          		 	          dataType: "json",
          		 	          data: {
          		 	            term: request.term,
          		 	            bus: $('#locationId').val() //busness unit 
          		 	          },
          		 	          success: function( data ) {
          		 	             // alert(JSON.stringify(data));
          		 	            response( data );
          		 	          }
          		 	        } );
          		 	      },
          		 	      minLength: 2,
          		 	      select: function( event, ui ) {
          		 				//loadProductTable(ui.item.ORDER_NUMBER);
          		 				$('#order-id-manual').val(ui.item.ORDER_NUMBER);
          		 				$('#cust-name-manual').val(ui.item.CMSNME);
          		 				$('#cust-id-manual').val(ui.item.CUST_NUM);
          		 	      } //on select
          		 	    } );//End of order id auto complete
      		 		//***********************
      		 	    //*  Auto complete for PO number appt modal        *
      		 	 	//***********************
      		 	    $( "#po-id" ).autocomplete({    		  
      		 	 	      source: function( request, response ) {
      		 	 	        $.ajax( {
      		 	 	          url: "gets/get_POs.php",
      		 	 	          dataType: "json",
      		 	 	          data: {
      		 	 	            term: request.term,
      		 	 	            bus: $('#locationId').val() //busness unit 
      		 	 	          },
      		 	 	          success: function( data ) {
      		 	 	             // alert(JSON.stringify(data));
      		 	 	            response( data );
      		 	 	          }
      		 	 	        } );
      		 	 	      },
      		 	 	      minLength: 5,
      		 	 	      select: function( event, ui ) {
      		 	 				//loadProductTable(ui.item.ORDER_NUMBER);
      		 	 				$('#vendor-id').val(ui.item.VENDOR_NUM);
      		 	 				$('#vendor-name').val(ui.item.VENDOR_NAME);
      		 	 				//$('#cust-id').val(ui.item.CUST_NUM);
      		 	 	      } //on select
      		 	 	    } );//End of Manufacturer Name auto complete
          		 	//***********************
      		 	    //*  Auto complete for PO number appt modal  manual      *
      		 	 	//***********************
      		 	    $( "#po-id-manual" ).autocomplete({    		  
      		 	 	      source: function( request, response ) {
      		 	 	        $.ajax( {
      		 	 	          url: "gets/get_POs.php",
      		 	 	          dataType: "json",
      		 	 	          data: {
      		 	 	            term: request.term,
      		 	 	            bus: $('#locationId').val() //busness unit 
      		 	 	          },
      		 	 	          success: function( data ) {
      		 	 	             // alert(JSON.stringify(data));
      		 	 	            response( data );
      		 	 	          }
      		 	 	        } );
      		 	 	      },
      		 	 	      minLength: 5,
      		 	 	      select: function( event, ui ) {
      		 	 				//loadProductTable(ui.item.ORDER_NUMBER);
      		 	 				$('#vendor-id-manual').val(ui.item.VENDOR_NUM);
      		 	 				$('#vendor-name-manual').val(ui.item.VENDOR_NAME);
      		 	 				//$('#cust-id').val(ui.item.CUST_NUM);
      		 	 	      } //on select
      		 	 	    } );//End of Manufacturer Name auto complete

      		 	    $( "#pickup-id" ).change(function(){
      					let x = this.value;
      					if(x == 'Pickup'){
      					//	console.log('Dev')
      						$( ".poRow" ).hide();
      						$( ".orderRow" ).show();
      					}else{		
      						//console.log('PO')			
      						$( ".poRow" ).show();
      						$( ".orderRow" ).hide();
      					}

      		        })

	        	    $( "#pickup-id-manual" ).change(function(){
      					let x = this.value;
      					if(x == 'Pickup'){
      					//	console.log('Dev')
      						$( ".poRowManual" ).hide();
      						$( ".orderRowManual" ).show();
      					}else{		
      						//console.log('PO')			
      						$( ".poRowManual" ).show();
      						$( ".orderRowManual" ).hide();
      					}

      		        })
      		        
      		        $( "#closenoSlotsModalManual" ).click(function() {
      		        	$('#truckManualAppoitmentModal').modal('show');
      		        	$('#appt-date-manual').focus()
      		        	$('#noSlotsModalManual').modal('hide');
                    });
      		        
//$.getJSON('gets/get_AppointmentRecordsForTheDay.php?apptTime='+info.startStr, function(result) { });

           </script>
    </body>
</html>
