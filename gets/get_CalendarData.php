<?php 
session_start();
include('login/auth_functions.php');
checkAuthentication();

//$calendarType = $_POST['calendarType'];

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../../nwffunctions/i5db2connect.php';
   
    $sql = "select WH_APPT_ID,CUST_NAME, ORDER_NO, CREATED_ON, CUST_NO, APPT_TYPE,APPT_STD_WRK,
                WEEK_ENDING_DATE, APPT_DATE, APPT_TIME, WH_ID, APPT_LOG_DATE, PO_NUMBER,CREATED_BY
            from NWFF.WH_APPT_SCHE";
           
    $results = db2_prepare( $connection, $sql )
          or die('<br>Prepare failed - get_CalendarData.php'. db2_stmt_errormsg());
    
    db2_execute($results)
          or die('<br>Execute failed - get_CalendarData.php'. db2_stmt_errormsg());
      
    while ( $row = db2_fetch_assoc( $results ) ) {
        
        $whApptId       = trim($row['WH_APPT_ID']);
        $appType        = trim($row['APPT_TYPE']);
        $custName       = trim($row['CUST_NAME']);        
        $wh_id          = trim($row['WH_ID']);
        $orderNo        = trim($row['ORDER_NO']);
        $poNo           = trim($row['PO_NUMBER']);
        $custNo_vendNo  = trim($row['CUST_NO']);
        $createdBy      = trim($row['CREATED_BY']);
        $reservationType = trim($row['APPT_STD_WRK']);
        
        if($appType == 'Pickup'){
            $appointmentInformation2 = $custName.' <' .$orderNo. '> '.'['.$wh_id.']'.' - ' .$appType.' By: '.$createdBy;
            $backgroundColor = '#0066FF';
        }else{
            $appointmentInformation2 = $custName.' <' .$poNo. '> '.'['.$wh_id.']'.' - ' .$appType.' By: '.$createdBy;
            $backgroundColor = '#9CAF88';
        }
        
        if (strpos($custName, 'MCCAIN') !== false && $orderNo != 0) {
            $backgroundColor = '#808000';
        }
        
        if (strpos($custName, 'KIKKOMAN') !== false && $orderNo != 0) {
            $backgroundColor = '#e69900';
        } 
        
        if (strpos($custName, 'MUFFINS') !== false && $orderNo != 0) {
            $backgroundColor = '#A46200';
        } 
        
        if (strpos($custName, 'MCCAIN') !== false && $orderNo == 0 
                || strpos($custName, 'MUFFINS') !== false && $orderNo == 0 
                    || strpos($custName, 'KIKKOMAN') !== false && $orderNo == 0) {
                        
            $backgroundColor = '#228B22';
            
        }       
      
      //  $appointmentInformation2 = $custName.' <' .$orderNo. '> '.'['.$wh_id.']'.' - ' .$appType.' By: '.$createdBy;
        date_default_timezone_set('UTC');
        $timeLogDate = trim($row['APPT_TIME']);
        $dateIn = substr($timeLogDate, 0, 10);
        $timeIn = substr($timeLogDate, 11, 8);
        $timeHH = substr($timeIn, 0, 2);
        $timeMM = substr($timeIn, 3, 2);
        $timeSS = substr($timeIn, 6, 2);
        $appointmentTime = $dateIn." ".$timeHH.":".$timeMM.":".$timeSS;
        $title2 =  $appointmentInformation2;
           //$dataOUt = str_replace(".",":",$timeLogDate);
           //string dateFrom = ((DateTime)row["date_from"]).ToString("yyyy-MM-dd HH:mm:ss");
           
         //  $timeLogDate = date_format($timeLogDate, 'Y-m-d H:i:s');
               
           //   $timeLogDate = date('Y-m-d h:i:s', trim($row['APPT_TIME']));
           //$timeLogDate = date('Y-m-d', strtotime($row['APPT_TIME']));
           //removes the zeros at the end
           //$timeLogDate = floor($row['APPT_TIME'] / 1000);
           //$timeLogDate = date("Y-m-d H:i:s")$row['APPT_TIME'];
           //$timeLogDate = trim($timeLogDate->format('Y-m-d h:i:s'));
           //$timeLogDate = new DateTime($row['APPT_TIME']);
           
          // $timeLogDate = date('Y-m-d h:i:s', $row['APPT_TIME']);
           //$timeLogDate = date('h:i:s A', strtotime($timeIn));
           //strtotime($human_readable_date) * 1000
           //$timeLogDate = $row['APPT_DATE'];
            
           //$hours   = floor($row['TOTAL_HOURS_SECONDS'] / 3600);
         
         // echo $timeLogDate;
          // if(trim($row['APPT_TYPE']) == 'Delivery'){
           // $title =  $appointmentInformation . ' - ' . trim($row['APPT_TYPE']).' '.$custName;// . ' ' .  $hours . ' hours' ;
           
            
          
            
         //  }else{
           //    $title =  $appointmentInformation . ' - ' . trim($row['OUT_OF_OFFICE']) . ' (' . trim($row['OUT_OF_OFFICE_REASON_DETAIL']) .')' . ' ' .  $hours . ' hours';
         //  }
           
            $data[] = array( 'id'               => $whApptId,//trim($row['CUST_NAME']).trim($row['CUST_NO']),
                            'title'             => $title2,
                            'start'             => $appointmentTime,
                            'end'               => $appointmentTime,
                            'allDay'            => false,
                            'backgroundColor'   => $backgroundColor,
                            'wh_Id'             => $wh_id,
                            'custNo'            => $custNo_vendNo,
                            'orderNo'           => $orderNo,
                            'poNo'              => $poNo,
                            'custName'          => $custName,
                            'apptType'          => $appType,
                            'reservationType'   => $reservationType
                           );
   }
   echo json_encode($data);
   
   db2_close ( $connection );
   
//} // End if POST


?>