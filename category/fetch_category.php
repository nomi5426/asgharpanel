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

//$category = $_POST['category'];

$col =array(
    0   =>  'category_name',
    1   =>  'master_cat'
);

//Search
$sql = "SELECT * from category WHERE 1=1";
$query=mysqli_query($conn,$sql);


if(!empty($request['search']['value'])){
    $sql.=" AND (category_name Like '".$request['search']['value']."%') ";
}
$query=mysqli_query($conn,$sql);
$totalData=mysqli_num_rows($query);
$totalFilter=$totalData;

$sql.=" ORDER BY ".$col[$request['order'][0]['column']]." ".$request['order'][0]['dir']."  LIMIT ".$request['start']."  ,".$request['length']."  ";

$query=mysqli_query($conn,$sql);

$data=array();
while($row=mysqli_fetch_array($query)){
    $subdata=array();
    $subdata[] = $row[1];
    $subdata[] = $row[2];
    $subdata[]='<div class="inner" style="text-align:center"><button id="_editCat" type="button" title="Edit Category" class="tbl-btn btn-primary tbl-btn-icon" data-effect="effect-scale" data-toggle="modal" data-target="#editCatModal" data-id="'.$row[0].'"><i class="typcn typcn-tick"></i>Edit</button></div>';
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