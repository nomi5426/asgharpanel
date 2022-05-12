<?php
include "../base/db.php";
$upload_dir = "../uploads/";

function loadBranch(){
    global $conn;
    $branchOutput='';
    $branchSqlQuery = "SELECT * FROM branch ORDER BY branch_name ASC";
    $result = mysqli_query($conn, $branchSqlQuery);
    $branchOutput .= '<option value = "Choose Branch">Choose Branch</option>';
    while($row = mysqli_fetch_array($result)){
        $branchOutput .= '<option value = "'.$row["branch_name"].'">'.$row["branch_name"].'</option>';
    }
    return $branchOutput;
}

function loadDeliveryLocation(){
    global $conn;
    $cityOutput='';
    $citySqlQuery = "SELECT * FROM delivery_city ORDER BY city_name ASC";
    $result = mysqli_query($conn, $citySqlQuery);
    $cityOutput .= '<option value = "Delivery City">Delivery City</option>';
    while($row = mysqli_fetch_array($result)){
        $cityOutput .= '<option value = "'.$row["city_name"].'">'.$row["city_name"].'</option>';
    }
    return $cityOutput;
}

function loadOrderStatus(){
    global $conn;
    $statusOutput='';
    $statusSqlQuery = "SELECT * FROM order_status ORDER BY order_status_sequence ASC";
    $result = mysqli_query($conn, $statusSqlQuery);
    $statusOutput .= '<option value = "Select Order Status">Select Order Status</option>';
    while($row = mysqli_fetch_array($result)){
        $statusOutput .= '<option value = "'.$row["status_name"].'">'.$row["status_name"].'</option>';
    }
    return $statusOutput;
}

function loadSalesPerson(){
    global $conn;
    $salesPersonOutput='';
    $salesPersonSqlQuery = "SELECT firstname FROM user WHERE userrole = 'sales' ORDER BY firstname ASC";
    $result = mysqli_query($conn, $salesPersonSqlQuery);
    $salesPersonOutput .= '<option value = "Select Sales Consultant">Select Sales Consultant</option>';
    while($row = mysqli_fetch_array($result)){
        $salesPersonOutput .= '<option value = "'.$row["firstname"].'">'.$row["firstname"].'</option>';
    }
    return $salesPersonOutput;
}

function loadMasterCat(){
    global $conn;
    $CatOutput='';
    $CatSqlQuery = "SELECT * FROM category ORDER BY category_name ASC";
    $result = mysqli_query($conn, $CatSqlQuery);
    $CatOutput .= '<option value = "Select Category">Select Category</option>';
    while($row = mysqli_fetch_array($result)){
        $CatOutput .= '<option value = "'.$row["id"].'">'.$row["category_name"].'</option>';
    }
    return $CatOutput;
}
?>        
<div class="modal-content modal-content-demo">
    <div class="modal-header">
        <h5 class="modal-title">Edit Order</h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    </div>              
    <div class="modal-body">
        <form id="formEditOrder" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select name="orderstatusfilter" id="orderstatusfilter" class="SlectBox form-control">
                                    <option value="" disabled selected>Select Order Status</option>
                                        <?php
                                            $statusSqlQuery = "SELECT * FROM order_status ORDER BY order_status_sequence ASC";
                                            $result = mysqli_query($conn, $statusSqlQuery);
                                            while($row = mysqli_fetch_array($result)){
                                        ?>
                                    <option value="<?= $row['status_name'];?>"><?=$row['status_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select name="editinvoice" id="editinvoice"  class="form-control select2-show-search select2-dropdown">
                                    <option value="" disabled selected>Select Invoice ID</option>
                                    <input hidden id="_eid" name="_eid" class="form-control"type="text">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-4">
                                <input aria-label="Invoice ID" id="_editInvoiceId" name="_editInvoiceId" class="form-control" placeholder="Invoice ID" type="text">
                                <!-- <input hidden id="id" name="id" class="form-control"type="text"> -->
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="input-group col-md-6">
                            <div class="input-group-prepend" style="margin-bottom:6.75%">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" name="_editDeliveryDate" id="_editDeliveryDate" placeholder="Delivery Date" type="text">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="input-group mb-3">
                                <input aria-label="Product Name" id="_editItemName" name="_editItemName" class="form-control" placeholder="Product Name" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <input aria-label="Color" id="_editItemColor" name="_editItemColor" class="form-control" placeholder="Color" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <input aria-label="Size" id="_editItemSize" name="_editItemSize" class="form-control" placeholder="Size" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value='Order From' name="_editItemFrom" id="_editItemFrom" class="SlectBox form-control">
                                    <?php echo loadBranch(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value='Deliver To' name="_editDeliveryLocation" id="_editDeliveryLocation" class="SlectBox form-control">
                                    <?php echo loadDeliveryLocation(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value='Order Status' name="_editStatus" id="_editStatus" class="SlectBox form-control">
                                    <?php echo loadOrderStatus(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value="Select Quantity" name="_editQuantity" id="_editQuantity" class="SlectBox form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <textarea value="Order Note Text" id="_editOrderNote" name="_editOrderNote" class="form-control" placeholder="Order Note" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group file-browser">
                                <input id="_editDNLabel" type="text" class="form-control browse-file" placeholder="Select Delivery Note" readonly>
                                <label class="input-group-btn">
                                    <span class="btn btn-default">
                                        Select <input type="file" name="_editDeliveryNoteFile" id="_editDeliveryNoteFile" style="display: none;">
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <div class="input-group mb-3">
                            <select value="Sales Consultant" name="_editSalesConsultant" id="_editSalesConsultant" class="SlectBox form-control">
                                <?php echo loadSalesPerson(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select value="Select Category" name="_editCat_Id" id="_editCat_Id" class="SlectBox form-control">
                            <?php echo loadMasterCat(); ?>
                        </select>
                    </div>
                    <div class="row row-sm">
                        <div class="input-group mb-3">
                            <div class="input-group file-browser">
                                <input id="_editImageLabel" type="text" class="form-control browse-file" placeholder="Select Order Image" readonly>
                                <label class="input-group-btn">
                                    <span class="btn btn-default">
                                        Browse <input type="file" name="_editOrderImage[]" id="_editOrderImage" value="" multiple="true">
                                    </span>
                                </label>
                            </div>
                            <div id="preview" name="preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0 mt-3 justify-content-end">
                <div>
                    <input type="submit" id="_edit" name="_edit" class="btn btn-primary btn-size" value="Edit"/>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    //ORDER STATUS FIRST DROPDOWN CHANGES
    $("#orderstatusfilter").change(function(e){
        e.preventDefault();
        var selectedstat = $(this).val();
        $.ajax({
            url:'../order/fetch_order_detail.php',
            method: 'POST',
            data: {selectedstat:selectedstat},
            success:function(data){
                $("#editinvoice").html(data);
            }
        });
    });
        
    //ORDER INVOICE SECOND DROPDOWN CHANGES
    $("#editinvoice").change(function(e){
        e.preventDefault();
        var id = $(this).find(':selected').attr('data-id');
        $.ajax({
            url:'../order/fetch_order_detail.php',
            method: 'POST',
            dataType: 'json',
            data: {id:id},
            success:function(data){
                $('#_eid').val(data[0].id);
                console.log(data[0].id);
                $('#_editInvoiceId').val(data[0].invoiceId);
                $('#_editDeliveryDate').val(data[0].productlink);
                $('#_editItemName').val(data[0].pname);
                $('#_editItemColor').val(data[0].color);
                $('#_editItemSize').val(data[0].size);
                $('#_editItemFrom')[0].sumo.selectItem(data[0].branchId);
                $('#_editDeliveryLocation')[0].sumo.selectItem(data[0].city);
                $('#_editStatus')[0].sumo.selectItem(data[0].pstatus);
                $('#_editQuantity')[0].sumo.selectItem(data[0].quantity);
                $('#_editSalesConsultant')[0].sumo.selectItem(data[0].salesperson);
                $('#_editCat_Id')[0].sumo.selectItem(data[0].cat_id);
                $('#_editOrderNote').val(data[0].ordernote);

                //IMAGE
                var image_DB = data[0].pimage;
                var img_upload_dir = "../uploads/";
                var _imgInput = document.getElementById ("_editImageLabel");

                //DELIVERY NOTE
                var dn_DB = data[0].deliveryNote;
                var dn_upload_dir = "../pdfUploads/";
                var _dnInput = document.getElementById ("_editDNLabel");

                //IF IMAGE COLUMN HAS A VALUE || IMAGE
                if(image_DB !== '')
                { 
                    //IF THE COLUMN CONTAINTS MULTIPLE IMAGES
                    if(image_DB.includes(',') !== false){ 
                        //SPLITTING IT WITH COMMA -1
                        var image = image_DB.split(',');
                        //ITERATING VALUES TO FIND FILE NAME
                        $.each(image, function(key, value){
                            var img = document.createElement("IMG");
                            img.height = 90;
                            img.weight = 90;
                            //UPDATING IMAGE SOURCE
                            img.src = img_upload_dir+value; 
                            $('#preview').prepend(img);
                        });
                    }
                    //IF THE COLUMN CONTAINTS ONE IMAGE WITHOUT COMMA
                    else{
                        var img = document.createElement("IMG");
                        img.height = 90;
                        img.weight = 90;
                        img.src = img_upload_dir+image_DB;
                        $('#preview').prepend(img);
                    }
                    _imgInput.placeholder = "Image Attached";
                }
                //IF NO IMAGE EXISTS
                else{
                    $('#preview').empty();
                    _imgInput.placeholder = "Select Order Image";
                }
                if(dn_DB !== ''){
                    _dnInput.placeholder = "Delivery Note Attached";
                }
                else{
                    _dnInput.placeholder = "Select Delivery Note";
                }
            }
        });
        $('#preview').empty();
    });

    $(document).ready(function(){
        //ORDER SUBMIT FOR UPDATE
        $("#formEditOrder").on('submit', function(e){
            e.preventDefault();
            if(errorHandling()){
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '../order/edit_order.php',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData:false,
                    // cache: false,
                    // async: false,
                    // autoUpload: false,
                    success: function(response){
                        $('.statusMsg').html('');
                        if(response.status === 1){
                            console.log('HIT');
                        }else{
                            console.log('IN ELSE');
                            $('.statusMsg').html(alert(response.message));
                        }
                        $('#formEditOrder').css("opacity","");
                        $(".submit").removeAttr("disabled");
                    }
                });
            }
        });
    });

    function errorHandling(){
        var flag = true;
        var _warningMessage;
        var _warningText = "Mandatory Fields are Required to be Filled";
        var _invoiceId = $("#_editInvoiceId").val();
        var _deliveryDate = $("#_editDeliveryDate").val();
        var _itemName = $("#_editItemName").val();
        var _itemColor = $("_editItemColor").val();
        var _itemSize = $("#_editItemSize").val();
        var _branchFrom = $("#_editItemFrom").val();
        var _deliveryTo = $("#_editDeliveryLocation").val();
        var _orderStatus = $("#_editStatus").val();
        var _itemQuantity = $("#_editQuantity").val();
        var _orderNote = $("#_editOrderNote").val();
        var _salesConsultant = $("#_editSalesConsultant").val();
        var _categoryId = $("#_editCat_Id").val();

        if(_invoiceId == ''){
            _warningMessage = "Invoice ID is Left Empty";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_deliveryDate == ''){
            _warningMessage = "Select Delivery Date";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_itemName == ''){
            _warningMessage = "Fill Order Name";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_itemColor == ''){
            _warningMessage = "Fill Item Color";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_itemSize == ''){
            _warningMessage = "Fill Item Size";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_branchFrom == 'Choose Branch'){
            _warningMessage = "Select Order Branch";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_deliveryTo == 'Delivery City'){
            _warningMessage = "City Left Empty";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_orderStatus == 'Select Order Status'){
            _warningMessage = "Select Order Status";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_itemQuantity == 'Choose Order Quantity'){
            _warningMessage = "Select Order Quantity";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_orderNote == 'Choose Order Note'){
            _warningMessage = "Order Note Must be Filled";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_salesConsultant == 'Select Sales Consultant'){
            _warningMessage = "Sales Consultant Left Empty";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_categoryId == 'Select Category'){
            _warningMessage = "Category Left Empty";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }      
        else{
            successMessage();
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

    //SUCCESS ALERT
    function successMessage(){
        swal({
            title: 'Order is Edited Successfully!',
            text: 'Check Edited Orders in Tables',
            type: 'success',
            confirmButtonColor: '#57a94f'
        });
    }

    //ORDER IMAGE FUNCTION
    $(function() {
        //MULTIPLE IMAGES PREVIEW IN BROWSER
        var imagesPreview = function(input, placeToInsertImagePreview) {
            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<img class="modalImage">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };
        $('#_editOrderImage').on('change', function() {
            imagesPreview(this, 'div.preview');
            $( 'div.preview' ).empty();
        });
    });

    //ORDER FILE LABEL CHANGE
    $('#_editDeliveryNoteFile').on("change", function(){
        var input = document.getElementById ("_editDNLabel");
        var _dnCount = $(this)[0].files.length;
        var _pdfFileSize = this.files[0].size/1024;
        var _pdfFileSizeLimit = 100;

        if(_pdfFileSize > _pdfFileSizeLimit){
            $('#_editDeliveryNoteFile').val(null);
            var _warningSizeTitle = "Check File Size";
            var _warningSizeText = "Total File Size is Limited to 100 KB";
            emptyFieldAlert(_warningSizeTitle, _warningSizeText);
        }else{
            if(_dnCount > 0){
                input.placeholder = "Delivery Note Attached";
            }else{
                input.placeholder = "Select Delivery Note";
            }
        }
    });

</script>
<!-- Internal Form-elements js -->
<script src="../assets/js/advanced-form-elements.js"></script>

<!-- Internal form-elements js -->
<script src="../assets/js/form-elements.js"></script>

<!--Internal  Sweet-Alert js-->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/plugins/sweet-alert/jquery.sweet-alert.js"></script>

<!-- Sweet-alert js  -->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/js/sweet-alert.js"></script>

<!-- Internal Modal js-->
<script src="../assets/js/modal.js"></script>

