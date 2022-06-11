<?php

	/*********************************************************************************************************
	* PROJECT: ZETA 1.0.0
	* AUTHOR: ROSHAN ZAID AKA DAUNTE
	* FILE FOR: MODAL USED FOR ADDING STAFF
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
    require_once   "../base/db.php";

	//KEEP TRACK ON SESSION VARIABLES
    session_start();

    /**
     * METHOD USED TO GET ALL STAFF CATEGORY AND
     * SET IT ON HTML DROPDOWN
     */
    function loadStaff(){
        global $conn;
        $staffOutput='';
        $staffSqlQuery = "SELECT staff_category_name FROM staff_category";
        $result = mysqli_query($conn, $staffSqlQuery);
        $staffOutput .= '<option value = "Select Staff Category">Select Staff Category</option>';
        while($row = mysqli_fetch_array($result)){
            $staffOutput .= '<option value = "'.$row["staff_category_name"].'">'.$row["staff_category_name"].'</option>';
        }
        return $staffOutput;
    }

?>
<div class="modal-content modal-content-demo">
    <div class="modal-header">
        <h5 class="modal-title">New Staff</h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    </div>
    <div class="modal-body">
        <form id="formNewStaff" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input class="form-control" id="add_staff_name" name="add_staff_name" placeholder="Staff Name" type="text">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <select value='Staff Category' name="staff_department" id="staff_department" class="SlectBox form-control">
                            <?php echo loadStaff(); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <select value='Staff Type' name="staff_type" id="staff_type" class="SlectBox form-control">
                            <option value = "Select Staff Type">Select Staff Type</option>
                            <option value = "Production">Production</option>
                            <option value = "Delivery">Delivery</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0 mt-3 justify-content-end">
                <div>
                    <input type="submit" id="_add" onclick="errorHandling();" name="_add" class="btn btn-primary btn-size" value="Add"/>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Internal Sumoselect js -->
<script src="../assets/plugins/sumoselect/jquery.sumoselect.js"></script>
<!-- Internal Select2 js -->
<!-- <script src="../assets/js/select2.js"></script> -->
<script src="../assets/plugins/select2/js/select2.min.js"></script>
<!-- Internal Form-elements js -->
<script src="../assets/js/advanced-form-elements.js"></script>
<!-- Internal Modal js-->
<script src="../assets/js/modal.js"></script>
<!--Internal  Sweet-Alert js-->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/plugins/sweet-alert/jquery.sweet-alert.js"></script>
<!-- Sweet-alert js  -->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/js/sweet-alert.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#formNewStaff").on('submit', function(e){
            e.preventDefault();
            if(errorHandling()){
                $.ajax({
                    type: 'POST',
                    url: 'add_staff.php',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    async: false,
                    autoUpload: false,
                    success: function(response){
                        $('.statusMsg').html('');
                        if(response.status == 1){
                            $('#exampleone').DataTable().ajax.reload();
                            $('#formNewStaff')[0].reset(); //FORM TO RESET AFTER SUBMISSION
                            $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>'); // REPONSE MESSAGE
                            postOrderSave();
                        }else{
                            $('.statusMsg').html(alert(response.message));
                        }
                        $('#formNewStaff').css("opacity","");
                        $(".submit").removeAttr("disabled");
                    }
                });
            }
        });
    });

    //ERROR HANDLING
    function errorHandling(){
        var flag = true;
        var _warningMessage;
        var _staffName = $("#staff_name").val();
        var _masterCat = $("#master_cat").val();
        var _staffType = $("#staff_type").val();

        if(_staffName == ''){
            _warningMessage = "Staff Name is Left Empty";
            emptyFieldAlert(_warningMessage);
            flag = false
        }
        else if(_masterCat == 'Select Staff Category'){
            _warningMessage = "Staff Category is Empty";
            emptyFieldAlert(_warningMessage);
            flag = false
        }
        else if(_staffType == 'Select Staff Type'){
            _warningMessage = "Staff Type is Empty";
            emptyFieldAlert(_warningMessage);
            flag = false
        }
        else{
            successMessage();
        }
        return flag;
    }

    //WARNING ALERT
    function emptyFieldAlert(_alert){
        swal({
            title: _alert,
            text: "Mandatory Fields are Required to be Filled",
            type: "warning",
            confirmButtonClass: "btn btn-danger"
        });
    }

    //SUCCESS ALERT
    function successMessage(){
        swal({
            title: 'Well done!',
            text: 'Staff is Succesfully Saved',
            type: 'success',
            confirmButtonColor: '#57a94f'
        });
    }

    //CLEAR FILES AND LABEL AFTER SAVE
    function postOrderSave(){
        //MAKE SELECTORS EMPTY
        $('select.SlectBox')[0].sumo.reload();
        $('select.SlectBox')[1].sumo.reload();
    }

</script>

        
