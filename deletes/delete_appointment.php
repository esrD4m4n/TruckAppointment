<?php
header('Content-type: application/json');
require_once '../../../nwffunctions/i5db2connect.php';

$inputData  = json_decode(file_get_contents("php://input"));

// $apptDate           = trim(urldecode($inputData->apptDate));
// $apptCustNo         = trim(urldecode($inputData->apptCustNo));
// $apptVendNo         = trim(urldecode($inputData->apptVendNo));
// $apptWarehouseID    = trim(urldecode($inputData->apptWarehouseID));
// $apptOrder          = trim(urldecode($inputData->apptOrder));
// $apptPO             = trim(urldecode($inputData->apptPO));
// $apptType           = trim(urldecode($inputData->apptType));
$wh_appt_id         = $inputData->whApptId;
//$apptDate   = '2022-10-11-09.00.00.0000';
//               2022-11-10-12.00.00.0000
$query = '';
$result     = true;
// if($apptType == 'Delivery'){
//     $query      = "delete NWFF.WH_APPT_SCHE where APPT_TIME ='$apptDate'
//             AND CUST_NO = $apptVendNo
//             AND WH_ID = '$apptWarehouseID'
//             AND APPT_TYPE = '$apptType'
//             AND PO_NUMBER = '$apptPO'";
// }
// if($apptType == 'Pickup'){
//     $query      = "delete NWFF.WH_APPT_SCHE where APPT_TIME ='$apptDate'
//     AND CUST_NO = $apptCustNo
//     AND WH_ID = '$apptWarehouseID'
//     AND APPT_TYPE = '$apptType'
//     AND ORDER_NO = $apptOrder";
// }
$query      = "delete NWFF.WH_APPT_SCHE where WH_APPT_ID = $wh_appt_id";


$stmt = db2_prepare( $connection, $query )
    or die($result = false);
db2_execute( $stmt )
    or die($result = false);

if ($result){
    echo json_encode(array('success'=>true));
} else {
    echo json_encode(array('msg'=>'Some errors occured.'));
}
db2_close($connection);
?>
