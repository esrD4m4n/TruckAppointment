<?
    require_once '../../../nwffunctions/i5db2connect.php';
    header('Content-Type: text/plain; charset=utf-8');

    
	$term =  $_GET['term']; 
	$term = strtoupper($term);	
	$businessUnit =  $_REQUEST['bus'];
	
	
	$result = array();

// 	$query =  "SELECT OORD# as ORDER_NUMBER from nwff.oehl01 where OLOC = '{$businessUnit}'
// 	AND OORD# like '%$term%'
// 	order by ORDER_NUMBER"; 
	
	$query =  "SELECT OORD# as ORDER_NUMBER,OSBYDT, NWFFCHI.custmast.cust# as CUST_NUM,NWFFCHI.custmast.CMSNME,NWFFCHI.custmast.CMBNME
    from nwff.oehl01 
    LEFT OUTER  JOIN nwffchi.custmast ON NWFFCHI.custmast.cust# = nwff.oehl01.ocust# 
        where OLOC = 'CHI'
	       AND OORD# like '%$term%'
	           order by ORDER_NUMBER";

// SELECT OORD# as ORDER_NUMBER from nwff.oehl01 where OLOC = 'CHI'
// 	       AND OORD# like '%$term%'
// 	           order by ORDER_NUMBER";
	//APMFTY NOT IN( 'W','P', 'H')  
	//APMFTY NOT IN( 'P', 'H')  
	//$query = "SELECT APMFVN,APMFCD,trim(APMFNM) as APMFNM FROM NWFF.MFGMASFL WHERE APMFTY != 'M' AND APMFBU = '{$businessUnit}' ORDER BY APMFNM";
// 	$query = "SELECT APMFVN,APMFCD,trim(APMFNM) as APMFNM, trim(APMFA1) as APMFA1, trim(APMFCT) as APMFCT, trim(APMFST) as APMFST, APMFPF, APMFTY
// 	                   FROM NWFF.MFGMASFL 
// 	                   WHERE APMFBU = '{$businessUnit}' and APMFNM like '$term%' and APMFVN <> 50000 and APMFPF <> 'H' and APMFTY <> 'W' ORDER BY APMFNM";
	
 	$stmt = db2_prepare( $connection, $query )
		or die("<br>Prepare failed - get_Suppliers! ". db2_stmt_errormsg());
	db2_execute( $stmt )
		or die("<br>Execute failed - get_Suppliers! ". db2_stmt_errormsg());

	//$items = array();

	while ( $row = db2_fetch_assoc( $stmt ) ) {
	    $submittedDateIn = trim($row['OSBYDT']);
	    $submittedDate = date("m/d/Y", strtotime($submittedDateIn));
	    //$row['label']=htmlentities(stripslashes(trim($row['APMFNM'])));
	    $row['label']=trim($row['ORDER_NUMBER']).' [ '.$row['CMSNME'].','.$submittedDate.' -]';
	   	$row['value']=$row['ORDER_NUMBER'];
// 	   	$row['APMFVN'];
// 	   	$row['APMFA1'];
// 	   	$row['APMFST'];
// 	   	$row['APMFTY'];
// 	   	$row['APMFCD'];
// 	   	$row['APMFPF'];
// 	   	$row['APMFBU'];
		$row_set[] = $row;//build an array
	}
	//$result['rows'] = $items;
	//$trim_items = array_map('trim', $items);
	echo json_encode($row_set);
?>
