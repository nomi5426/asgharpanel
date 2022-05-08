<?php
	include "../base/db.php";
	$image_upload_dir = '../uploads/';
	$pdf_upload_dir = '../pdfUploads/';

	$response['status'] = 0;
	$response['message'] = 'NOT DONE!';
	$response['success'] = 'false';

//EDIT CATEGORY - RETREIVES CATEGORY ID AND NAME 
if(isset($_POST['cid']) || isset($_POST['cat_name'])){
	$cat_name = $_POST['cat_name'];
	$id = $_POST['cid'];
	$uploadStatus = 1;

	//CHECK IF CATEGORY IS ASSOCIATED WITH ORDERS
	$_categoryAssociate = $conn->query("SELECT * FROM product WHERE cat_id = ".$id);

	//GET CATEGORY NAME
	$catName=mysqli_query($conn,"SELECT * FROM category WHERE id = ".$id);
	$_dbCat_name='';
	while($row = mysqli_fetch_array($catName)){
		$_dbCat_name .=$row['category_name'];
	}

	// //CATEGOTY IS NOT ASSOCIATED WITH ORDERS
	// if(mysqli_num_rows($_categoryAssociate)==0){
	// 	$_update = $conn->query("UPDATE category SET category_name = '{$cat_name}' WHERE id = ".$id);
	// 	if($_update){ 
	// 		$response['status'] = 1;
	// 		$response['message'] = 'Form data submitted successfully!';
	// 		$response['success'] = 'true';
	// 	}
	// }
	// //CATEGORY IS ASSOCIATED WITH ORDERS
	// else{
	// 	$response['status'] = 3;
	// 	$response['message'] = 'CATEGORY ASSOCIATED';
	// 	$response['success'] = 'false';	
	// }

	//CATEGOTY IS NOT ASSOCIATED WITH ORDERS
	if(mysqli_num_rows($_categoryAssociate)!=0){
		$response['status'] = 3;
		$response['message'] = 'CATEGORY EXISTS WITH PRODUCT';
		$response['success'] = 'true';
	}
	else{
		if($cat_name != $_dbCat_name){
			$_update = $conn->query("UPDATE category SET category_name = '{$cat_name}' WHERE id = ".$id);
			if($_update){
				$response['status'] = 1;
				$response['message'] = 'Form data submitted successfully!';
				$response['success'] = 'true';
			}
		}else{
			$response['status'] = 2;
			$response['message'] = 'NO CHANGE';
			$response['success'] = 'true';
		}
	}
}
header('Content-type: application/json');
echo json_encode($response);

