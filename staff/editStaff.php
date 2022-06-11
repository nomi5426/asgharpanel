<?php

    /*********************************************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: MODAL USED FOR EDITING STAFF
	* 
	* VARIABLES
	* @PARAM	{STRING}	CONN								//DB CONNECT VARIABLE
	* @PARAM	{STRING}	MESSAGE								//LOG MESSAGE
	* @PARAM	{STRING}	LOGFILE								//LOG FILE PATH
	*
	* FUNCTIONS
	* APP_LOG()													//LOG WRITING
	/*********************************************************************************************************/

    //INCLUDE DIRECTORIES
    include "../base/db.php";

    //GET PARTICULAR STAFF FROM DB FOR TO EDIT AND FIND EXISTING VALUE OF THE STAFF
    if(isset($_REQUEST['id'])){
        $id=intval($_REQUEST['id']);
        $sql="select * from staff WHERE id=$id";
        $run_sql=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_array($run_sql)){
            $id=$row['id'];
            $staff_name=$row['staff_name'];
            $staff_category=$row['staff_department'];
            $staff_type=$row['staff_type'];
        }
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Staff</h5>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>              
            <div class="modal-body">
                <form method="POST" id="formEditStaff" autocomplete="off" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="staff_name">Staff Name</label>
                            <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
                            <input type="text" name="staff_name" id="staff_name"class="form-control" value="<?php echo $staff_name;?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="staff_category">Staff Category</label>
                            <input type="text" name="staff_category" class="form-control" value="<?php echo $staff_category;?>" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="staff_category">Staff Type</label>
                            <input type="text" name="staff_type" class="form-control" value="<?php echo $staff_type;?>" disabled>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="_btnEditCategory" id="_btnEditCategory">Edit</button>
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
        $('#formEditStaff').on('submit', function(e){
            e.preventDefault();
            var id = $('#id').val();
            var e_staffname = $('#staff_name').val();
            $.ajax({
                type: 'POST',
                url: 'edit_staff.php',
                dataType: 'json',
                data: {id:id, e_staffname:e_staffname},
                success: function(response){
                    if(response.status == 1){
                        postStaffUpdate();
                        $('#exampleone').DataTable().ajax.reload();
                    }
                    else if(response.status == 2){
                        staffExists();
                    }
                    else if(response.status == 3){
                        staffAssociated();
                    }
                }
            });
        });
        function postStaffUpdate(){
            swal({
                title: 'Success!',
                text: 'Staff is Updated Succesfully',
                type: 'success',
                confirmButtonColor: '#57a94f'
            });
        }
        function staffExists(){
            swal({
                title:"No Changes",
                text: "Type Something to Rename",
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }
        function staffAssociated(){
            swal({
                title: "Warning",
                text: "Staff Associated with an Order Can't be Renamed",
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }
    });
</script>

        
