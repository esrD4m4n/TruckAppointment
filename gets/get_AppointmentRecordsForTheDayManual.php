<?php
	require_once '../../../nwffunctions/i5db2connect.php';
	
	$aptTimeIn = trim($_GET['apptTime']);	
// 	$appTime   = str_replace('T',' ',$aptTimeIn);	
// 	$appTime   = substr($appTime, 0, 19);	
	$appTime   = $aptTimeIn.':00.000000';
	
	$sql       = "SELECT count(*) as TOTAL_APPTS FROM NWFF.WH_APPT_SCHE  where APPT_TIME = '$appTime' AND APPT_STD_WRK = 'MANUAL'";
    
    $results   = db2_prepare( $connection, $sql )
        or die("<br>Prepare failed - get_AppointmentRecordsForTheDay.php! ". db2_stmt_errormsg());

    db2_execute( $results )
        or die("<br>Execute failed - get_AppointmentRecordsForTheDay.php! ". db2_stmt_errormsg()); 

    $data = array();
    
    while ( $row = db2_fetch_assoc( $results) ) {

        $totalRecords = trim($row["TOTAL_APPTS"]);      
    
        }

db2_close($connection);

echo $totalRecords;

?>