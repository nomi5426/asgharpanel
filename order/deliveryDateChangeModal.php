<?php
include "../base/db.php";

if(isset($_REQUEST['id'])){
    $id=intval($_REQUEST['id']);
    $sql="select * from product WHERE id=$id";
    $run_sql=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($run_sql)){
        $id=$row['id'];
        $ddInvoiceId=$row['invoiceId'];
        $dditemName=$row['pname'];
        $ddDelDate=$row['productlink'];

    }
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Delivery Date Change</h5>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>              
        <div class="modal-body">
            <form method="POST" id="fromDateChange" autocomplete="off" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="mat_lpo_id">Invoice ID</label>
                        <input type="text" name="ddInvoiceId" id="ddInvoiceId"class="form-control" value="<?php echo $ddInvoiceId;?>" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="itemName">Item Name</label>
                        <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
                        <input type="text" name="dditemName" id="dditemName"class="form-control" value="<?php echo $dditemName;?>" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="item_color">Delivery Date</label>
                        <input class="form-control fc-datepicker" type="text" name="ddDelDate" id="ddDelDate" class="form-control" value="<?php echo $ddDelDate;?>">
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="_btnChangeDate" id="_btnChangeDate">Save</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
            </form>
        </div>
    </div>
<?php
}
?>

<!-- Internal Form-elements js -->
<script src="../assets/js/advanced-form-elements.js"></script>
<!-- Internal form-elements js -->
<script src="../assets/js/form-elements.js"></script>
<!-- Internal Sumoselect js -->
<script src="../assets/plugins/sumoselect/jquery.sumoselect.js"></script>
<!-- Sweet-alert js  -->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/js/sweet-alert.js"></script>
<!-- Internal Modal js-->
<script src="../assets/js/modal.js"></script>
<script type="text/javascript">
    $('#ddDelDate').datepicker({
        minDate: 0
    });
    $(document).ready(function(){

        $('#fromDateChange').on('submit', function(e){
            e.preventDefault();
            if(errorHandling()){
                var id = $('#id').val();
                var dd_new_date = $('#ddDelDate').val();
                $.ajax({
                    type: "POST",
                    url: '../order/delivery_date_change.php',
                    dataType:'json',
                    data: {
                        id:id, 
                        dd_new_date:dd_new_date
                    },
                    success: function(response){
                        if(response.index == 1){
                            $("#fromDateChange")[0].reset();
                            _postDDSuccess();
                        }
                    }
                });
            }

        });
        function errorHandling(){
            var flag = true;
            var _warningMessage;
            var _warningText = "Mandatory Fields are Required to be Filled";
            var _del_Date = $('#ddDelDate').val();

            if(_del_Date == ''){
                _warningMessage = "New Delivery Date is Left Empty";
                emptyFieldAlert(_warningMessage, _warningText);
                flag = false
            }
            return flag;
        }
        //EMPTY FIELD - WARNING
        function emptyFieldAlert(_alertTitle, _alertText){
            swal({
                title: _alertTitle,
                text: _alertText,
                type: "warning",
                confirmButtonClass: "btn btn-danger"
            });
        }
        //LPO ADDED - SUCCESS
        function _postDDSuccess(){
            swal({
                title: 'Success!',
                text: 'Delivery Date is Changed Succesfully',
                type: 'success',
                confirmButtonColor: '#57a94f'
            },
            function reload(){
                location.reload();
            });
        }
    });
</script>

        
