<?php

include "../../base/db.php";

$upload_dir = '../uploads/';

if(isset($_REQUEST['id'])){
    $id=intval($_REQUEST['id']);
    $sql="select * from product WHERE id=$id";
    $run_sql=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($run_sql)){
        $per_id=$row[0];
        $per_image=$row[7];
    }
    ?>
    <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h5 class="modal-title">Product Image</h5>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>              
        <div class="modal-body">
            <?php
                if($per_image!=='')
                {
                    if(strpos($upload_dir.$per_image,',')!== false){
                        $image = explode(',',$per_image);
                        $imageArr = '';
                        foreach ($image as $im){
                            $imageArr .= '<img src="'.$upload_dir.$im .'"width="1200"/>';
                        }
                    }
                    else{
                        $imageArr = '<img src="'.$upload_dir.$per_image.'"width="1200"/>';
                    }
                }
                else
                {
                    $noImage = 'No Image Modal.jpg';
                    $imageArr = '<img src="'.$upload_dir.$noImage.'"width="1200"/>';
                }?>
                <?php echo $imageArr 
            ?>
        </div>
    </div>
<?php
}
?>
