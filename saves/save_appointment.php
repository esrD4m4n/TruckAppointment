<?php
require_once 'email.php';
header('Content-type: application/json');
require_once '../../../nwffunctions/i5db2connect.php';

$inputData = json_decode(file_get_contents("php://input"));

session_start();

$createdOn      = date("m/d/Y"); // date("m.d.y");
$createdOnFmt   = date("Y-m-d", strtotime($createdOn));
$whApptId       = $inputData->whApptId;
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
$appTime        = str_replace('T',' ',$apptDateIn);
$appTime        = substr($appTime, 0, 19);
$appTime        = $appTime.'.000000';
//$warehouseId    = '01';
$apptLogDate    = $appDate;

$sql ="";
$values = array($apptCustName,$apptCustNum,$apptType,$warehouseId,$apptOrderNum,$appStdWrk);
if($apptType == 'Pickup'){
    $sql = "UPDATE NWFF.WH_APPT_SCHE
    SET CUST_NAME = ?,
    CUST_NO = ?,
    APPT_TYPE = ?,
    WH_ID = ?,
    ORDER_NO = ?,
    APPT_STD_WRK = ?
    WHERE WH_APPT_ID = $whApptId";         
}else{
    $sql = "UPDATE NWFF.WH_APPT_SCHE
    SET CUST_NAME = ?,
    CUST_NO = ?,
    APPT_TYPE = ?,
    WH_ID = ?,
    PO_NUMBER = ?,
    APPT_STD_WRK = ?
    WHERE WH_APPT_ID = $whApptId"; 
}   
// }

//echo $sql;
$result = false;
//echo $sql;
$stmt = db2_prepare($connection, $sql) or
    die("<br>Prepare failed - ".$saveMode." - save_appointment.php " . db2_stmt_errormsg());

$result =  db2_execute($stmt, $values) or
    die("<br>Execute failed - ".$saveMode." - save_appointment.php " . db2_stmt_errormsg());

if ($result) {
    if($apptType == 'Pickup'){
        $orderOrPo = trim($apptOrderNum);
        $backgroundColor = '#0066FF';
    }else{
        $backgroundColor = '#9CAF88';
        $orderOrPo = trim($apptOrderNum);
    }
    
    echo json_encode( $retMsg = array(
        'success'           => true,
        'id'                => trim($apptCustName).trim($apptCustNum),
        'title'             => trim($apptCustName).' <' . trim($apptOrderNum) . '> '.'['.trim($warehouseId).']'.' - ' .trim($apptType),
        'start'             => $appTime,
        'end'               => $appTime,
        'allDay'            => false,
        'backgroundColor'   => $backgroundColor,
    ));
} else {
    echo json_encode(array(
        'error' => 'Some errors occured.'
    ));
}

db2_close($connection);

?>