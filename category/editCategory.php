<?php
include "../base/db.php";

if(isset($_REQUEST['id'])){
    $id=intval($_REQUEST['id']);
    $sql="select * from category WHERE id=$id";
    $run_sql=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($run_sql)){
        $id=$row['id'];
        $cat_name=$row['category_name'];
        $master_category=$row['master_cat'];
    }
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Comment</h5>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>              
        <div class="modal-body">
            <form method="POST" id="formEditCat" autocomplete="off" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="category_name">Category Name</label>
                        <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
                        <input type="text" name="category_name" id="category_name"class="form-control" value="<?php echo $cat_name;?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="master_cat">Master Category</label>
                        <input type="text" name="master_cat" class="form-control" value="<?php echo $master_category;?>" disabled>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="_btnEditCategory" id="_btnEditCategory">Add</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
            </form>
        </div>
    </div>
<?php
}
?>

<!-- Internal form-elements js -->
<script src="../assets/js/advanced-form-elements.js"></script>


<!--Internal  Sweet-Alert js-->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/plugins/sweet-alert/jquery.sweet-alert.js"></script>

<!-- Sweet-alert js  -->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/js/sweet-alert.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#formEditCat').on('submit', function(e){
            e.preventDefault();
            var id = $('#id').val();
            var cat_name = $('#category_name').val();
            $.ajax({
                type: "POST",
                url: 'edit_category.php',
                data: {cid:id, cat_name:cat_name},
                success: function(response){
                    if(response.status === 1){
                        postCategoryUpdate();
                        $('#exampleone').DataTable().ajax.reload();
                    }
                    else if(response.status === 2){
                        categoryExists();
                    }
                    else if(response.status === 3){
                        categoryAssociated();
                    }
                    else{
                        console.log("Nothing");
                    }
                }
            });
        });
        function postCategoryUpdate(){
            swal({
                title: 'Success!',
                text: 'Category is Updated Succesfully',
                type: 'success',
                confirmButtonColor: '#57a94f'
            });
        }
        function categoryExists(){
            swal({
                title:"No Changes",
                text: "Type Something to Rename",
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }
        function categoryAssociated(){
            swal({
                title: "Warning",
                text: "Category Associated with an Order Can't be Renamed",
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }
    });
</script>

        
