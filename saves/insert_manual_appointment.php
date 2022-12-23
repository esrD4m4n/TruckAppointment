<?php
require_once 'email.php';
header('Content-type: application/json');
require_once '../../../nwffunctions/i5db2connect.php';

$inputData = json_decode(file_get_contents("php://input"));

session_start();

$createdOn      = date("m/d/Y"); // date("m.d.y");
$createdOnFmt   = date("Y-m-d", strtotime($createdOn));
//$whApptId       = $inputData->whApptId;
$apptDateIn     = trim(urldecode($inputData->apptDate));
$apptCustName   = trim(urldecode($inputData->apptCustName));
$apptCustNum    = $inputData->apptCustNum;
$apptOrderNum   = $inputData->apptOrderNum;
$apptType       = trim(urldecode($inputData->apptType));
$warehouseId    = trim(urldecode($inputData->warehouseid));
$createdBy      = trim(urldecode($inputData->createdBy));
$saveMode       = trim(urldecode($inputData->saveMode));
$appStdWrk      = trim(urldecode($inputData->appStdWrk));
$appDate        = substr($apptDateIn, 0, 10);
$weekending     = date('Y-m-d',strtotime($appDate.'last sunday'));
$appTime        = $apptDateIn;//str_replace('T',' ',$apptDateIn);
$appTime        = substr($appTime, 0, 19);
$appTime        = $appTime.':00.000000';
//$warehouseId    = '01';
$apptLogDate    = $appDate;

$values         = array();
$sql            = '';
$sqlValues      = "VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
$sql = "INSERT INTO NWFF.WH_APPT_SCHE (CUST_NAME,CREATED_ON,CUST_NO,APPT_TYPE,WEEK_ENDING_DATE,APPT_DATE,APPT_TIME,WH_ID,APPT_LOG_DATE,CREATED_BY,APPT_STD_WRK";

$values = array($apptCustName,$createdOnFmt,$apptCustNum,$apptType,$weekending,$appDate,$appTime,$warehouseId,$apptLogDate,$createdBy,$appStdWrk,$apptOrderNum);

// print_r($values);

if($apptType == 'Pickup'){
    $sql = $sql.",ORDER_NO) ".$sqlValues;
}else{
    $sql = $sql.",PO_NUMBER) ".$sqlValues; 
}

//echo $sql;
$result = false;
//echo $sql;
$stmt = db2_prepare($connection, $sql) or
    die("<br>Prepare failed - ".$saveMode." - save_appointment.php " . db2_stmt_errormsg());

$result =  db2_execute($stmt, $values) or
    die("<br>Execute failed - ".$saveMode." - save_appointment.php " . db2_stmt_errormsg());

if ($result) {
    
    echo json_encode( $retMsg = array(
        'success'           => true
    ));
} else {
    echo json_encode(array(
        'error' => 'Some errors occured.'
    ));
}

db2_close($connection);

?>