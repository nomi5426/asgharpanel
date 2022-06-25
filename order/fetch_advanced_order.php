<?php
	include "../base/db.php";
	include '../base/deliveryNoteDownload.php';

	$upload_dir = '../uploads/';

	$request = $_REQUEST;
	## Read value
	$draw = $_POST['draw'];
	$row = $_POST['start'];
	$rowperpage = $_POST['length']; // Rows display per page
	$columnIndex = $_POST['order'][0]['column']; // Column index
	$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
	$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
	$searchValue = $_POST['search']['value']; // Search value

	$orderStatus = $_POST['orderStatus'];
	$branchId = $_POST['branchId'];
	$salesconsultant = $_POST['salesconsultant'];
	$deliverylocation = $_POST['deliverylocation'];

	## Date search value
	$searchByFromdate = $_POST['searchByFromdate'];
	$searchByTodate = $_POST['searchByTodate'];

	$col =array(
		0   =>  'invoiceId',
		1   =>  'productlink',
		2   =>  'pname',
		3   =>  'size',
		4   =>  'color',
		5   =>  'quantity',
		7   =>  'ordernote',
		8   =>  'salesperson',
		9   =>  'pimage',
		10  =>  'city',
		11 => 'orderFrom'
	);

	//Search
	$filterQuery="";
	if($orderStatus != ''){
		$filterQuery .= " AND (pstatus='".$orderStatus."')";
	}
	if($branchId != ''){
		$filterQuery .= " AND (branchId='".$branchId."')";
	}
	if($salesconsultant != ''){
		$filterQuery .= " AND (salesperson='".$salesconsultant."')";
	}
	if($deliverylocation != ''){
		$filterQuery .= " AND (city='".$deliverylocation."')";
	}
	if($searchByFromdate != '' && $searchByTodate != ''){
		$filterQuery .= " and (productlink between '".$searchByFromdate."' and '".$searchByTodate."' ) ";
	}

	$sql = "SELECT * from product WHERE 1=1 ".$filterQuery;
	$query=mysqli_query($conn,$sql);

	if(!empty($request['search']['value'])){
		$sql.=" AND (invoiceId Like '".$request['search']['value']."%') ";
	}
	//TOTAL NUMBER OF RECORDS ON FILTER
	$query=mysqli_query($conn,$sql);
	$totalData=mysqli_num_rows($query);
	$totalFilter=$totalData;

	//FETCH RECORD
	$sql.=" ORDER BY ".$col[$request['order'][0]['column']]." ".$request['order'][0]['dir']."  LIMIT ".$request['start']."  ,".$request['length']."  ";
	$query=mysqli_query($conn,$sql);
	$data=array();

	while($row=mysqli_fetch_array($query)){
		$subdata=array();
		//Days Given and Days Left
		$productlinkToSec = strtotime($row[15]);
		$insertDateToSec = strtotime(Date('Y-m-d'));
		$timeDiff = ($productlinkToSec - $insertDateToSec);
		$interval = $timeDiff/86400;
		$interval = intval($interval);
		if ($interval < 0) {
			$interval = 0;
		}
		if (($row['dateAvailability']) !==''){
			$dateAvailability=($row['dateAvailability']);
		}
		else{
			$dateAvailability='N/A';
		}

		//IMAGE RETREIVE
		if($row[7]!==''){ 
		if(strpos($upload_dir.$row[7],',') !== false){
			$arr = explode(',', $row[7]);
			$image = $arr[0];
		}
		else{
			$image = $row[7];
		}
		}
		else{
		$noImage = 'No Image.jpg';
		$image = $noImage;
		}
		//COMMENT
		$comment = $row[17];
		if($comment == null){
		$comment = "N/A";
		}

		//GET ITEM AND SIZE
		$oneRow = "$row[6] | <strong>Color: $row[9]</strong><br><strong> Size - $row[8]</strong>";
		$deliveryNotePrint = "<a href=../deliveryNoteDownload.php?file_id=$row[0]>$row[4]";

		//MATERIAL AVAILABILITY
		$material = $row[16];
		$materialAvailable = 'Yes';

		$subdata[]=$deliveryNotePrint;
		$subdata[]=$row[15];
		$subdata[]=$dateAvailability;
		$subdata[]=$row[3];
		$subdata[]=$interval;
		$subdata[]=$oneRow;
		$subdata[]=$row[10];
		$subdata[]=$row[12];
		$subdata[]=$row[13];
		$subdata[]=$row[11];
		$subdata[]='<img src="'.$upload_dir.$image.'" class="modal-effect" data-effect="effect-scale" id="tableImage" height="30" width="20" data-toggle="modal" data-target="#imagemodalone" data-id="'.$row[0].'"/>';
		$subdata[]=$comment;
		$subdata[]= '<a type="button" title="Print" href="../print/customizePrint.php?action=select&id='.$row[0].'" target="_blank" class="btn btn-primary btn-xs"><i class="typcn typcn-document-text"></i></a>';
		$data[]=$subdata;
	}

	$json_data=array(
		"draw"              =>  intval($request['draw']),
		"recordsTotal"      =>  intval($totalData),
		"recordsFiltered"   =>  intval($totalFilter),
		"data"              =>  $data
	);
	echo json_encode($json_data);
?>