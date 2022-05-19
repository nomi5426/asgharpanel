<?php
include "../base/db.php";

if(isset($_REQUEST['id'])){
    $id=intval($_REQUEST['id']);
    $sql="select * from product WHERE id=$id";
    $run_sql=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($run_sql)){
        $id=$row['id'];
        $orderName=$row['pname'];
        $orderColor=$row['color'];
    }
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add LPO</h5>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>              
        <div class="modal-body">
            <form method="POST" id="formAddLpo" autocomplete="off" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="order_name">Item Name</label>
                        <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
                        <input type="text" name="order_name" id="order_name"class="form-control" value="<?php echo $orderName;?>" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="item_color">Item Color</label>
                        <input type="text" name="item_color" id="item_color" class="form-control" value="<?php echo $orderColor;?>" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="mat_lpo_id">LPO ID</label>
                        <input type="text" name="mat_lpo_id" id="mat_lpo_id" class="form-control">
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="_btnAddLpo" id="_btnEditCategory">Save</button>
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
        $('#formAddLpo').on('submit', function(e){
            e.preventDefault();
            if(errorHandling()){
                var id = $('#id').val();
                var mat_lpo_id = $('#mat_lpo_id').val();
                var mat_status = 'Yes';
                $.ajax({
                    type: "POST",
                    url: '../order/materialLpo.php',
                    data: {
                        id:id, 
                        mat_status:mat_status,
                        mat_lpo_id:mat_lpo_id
                    },
                    success: function(response){
                        if(response.status === 1){
                            $("#formAddLpo")[0].reset();
                            $('#exampleone').DataTable().ajax.reload();
                        }
                        else{
                            console.log("Nothing");
                        }
                    }
                });
            }

        });
        function errorHandling(){
            var flag = true;
            var _warningMessage;
            var _warningText = "Mandatory Fields are Required to be Filled";
            var _lpo_id = $('#mat_lpo_id').val();

            if(_lpo_id == ''){
                _warningMessage = "LPO ID is Left Empty";
                emptyFieldAlert(_warningMessage, _warningText);
                flag = false
            }else{
                postLPOUpdate();
            }
            return flag;
        }
        //WARNING ALERT
        function emptyFieldAlert(_alertTitle, _alertText){
            swal({
                title: _alertTitle,
                text: _alertText,
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }
        function postLPOUpdate(){
            swal({
                title: 'Success!',
                text: 'Material and LPO is Updated Succesfully',
                type: 'success',
                confirmButtonColor: '#57a94f'
            });
        }
    });
</script>

        
