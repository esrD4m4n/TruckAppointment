<?
    require_once '../../../nwffunctions/i5db2connect.php';
    header('Content-Type: text/plain; charset=utf-8');

    
	$term =  $_GET['term']; 
	$term = strtoupper($term);	
	$businessUnit =  $_REQUEST['bus'];
	
	
	$result = array();
	
	$query = "select FPO# as PONUM, nwffchi.vendors.VMVND# as VENDOR_NUM, trim(nwffchi.vendors.VMRMTN) as VENDOR_NAME
                from nwffchi.pofile 
                 inner join nwffchi.vendors on nwffchi.vendors.VMVND# = nwffchi.pofile.fvend#
                 where FPO# like '%$term%'";

 	$stmt = db2_prepare( $connection, $query )
		or die("<br>Prepare failed - get_Vendors! ". db2_stmt_errormsg());
	db2_execute( $stmt )
		or die("<br>Execute failed - get_Vendors! ". db2_stmt_errormsg());

	//$items = array();

	while ( $row = db2_fetch_assoc( $stmt ) ) {
	    //$submittedDateIn = trim($row['OSBYDT']);
	//    $submittedDate = date("m/d/Y", strtotime($submittedDateIn));
	    //$row['label']=htmlentities(stripslashes(trim($row['APMFNM'])));
	    $row['label']=trim($row['PONUM']).' [ '.trim($row['VENDOR_NAME']).' -])';
	   	$row['value']=$row['PONUM'];
		$row_set[] = $row;//build an array
	}
	//$result['rows'] = $items;
	//$trim_items = array_map('trim', $items);
	echo json_encode($row_set);
?>
