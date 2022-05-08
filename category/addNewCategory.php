<?php
session_start();
require_once   "../base/db.php";
function loadMasterCat(){
    global $conn;
    $CatOutput='';
    $CatSqlQuery = "SELECT mas_cat_name FROM master_category";
    $result = mysqli_query($conn, $CatSqlQuery);
    $CatOutput .= '<option value = "Select Master Category">Select Master Category</option>';
    while($row = mysqli_fetch_array($result)){
        $CatOutput .= '<option value = "'.$row["mas_cat_name"].'">'.$row["mas_cat_name"].'</option>';
    }
    return $CatOutput;
}

?>
<div class="modal-content modal-content-demo">
    <div class="modal-header">
        <h5 class="modal-title">New Category</h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    </div>
    <div class="modal-body">
        <form id="formNewCat" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input class="form-control" id="category_name" name="category_name" placeholder="Category Name" type="text">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <select value='Master Category' name="master_cat" id="master_cat" class="SlectBox form-control">
                            <?php echo loadMasterCat(); ?>
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
        $("#formNewCat").on('submit', function(e){
            e.preventDefault();
            if(errorHandling()){
                $.ajax({
                    type: 'POST',
                    url: 'add_category.php',
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
                            $('#formNewCat')[0].reset(); //FORM TO RESET AFTER SUBMISSION
                            $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>'); // REPONSE MESSAGE
                            postOrderSave();
                        }else{
                            $('.statusMsg').html(alert(response.message));
                        }
                        $('#formNewCat').css("opacity","");
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
        var _catName = $("#category_name").val();
        var _masterCat = $("#master_cat").val();

        if(_catName == ''){
            _warningMessage = "Category Name is Left Empty";
            emptyFieldAlert(_warningMessage);
            flag = false
        }
        else if(_masterCat == 'Select Master Category'){
            _warningMessage = "Master Category is Empty";
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
            text: 'Category is Succesfully Saved',
            type: 'success',
            confirmButtonColor: '#57a94f'
        });
    }

    //CLEAR FILES AND LABEL AFTER SAVE
    function postOrderSave(){
        //MAKE SELECTORS EMPTY
        $('select.SlectBox')[0].sumo.reload();
    }

</script>

        
