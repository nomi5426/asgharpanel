<?php

include '../base/db.php';

$upload_dir = '../uploads/';

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

function loadCat(){
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
        <h5 class="modal-title">New Order</h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    </div>
    <div class="modal-body">
        <form id="formNewOrder" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <input class="form-control" id="_newInvoiceId" name="_newInvoiceId" placeholder="Invoice ID" type="text">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="input-group col-md-6">
                            <div class="input-group-prepend" style="margin-bottom:3.75%">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" name="_newDeliveryDate" id="_newDeliveryDate" placeholder="Delivery Date" type="text">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="input-group mb-3">
                                <input aria-label="Product Name" id="_newItemName" name="_newItemName" class="form-control" placeholder="Product Name" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <input aria-label="Color" id="_newItemColor" name="_newItemColor" class="form-control" placeholder="Color" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <input aria-label="Size" id="_newItemSize" name="_newItemSize" class="form-control" placeholder="Size" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value='Order From' name="_newItemFrom" id="_newItemFrom" class="SlectBox form-control">
                                    <?php echo loadBranch(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value='Deliver To' name="_newDeliveryLocation" id="_newDeliveryLocation" class="SlectBox form-control">
                                    <?php echo loadDeliveryLocation(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value='Order Status' name="_newStatus" id="_newStatus" class="SlectBox form-control">
                                    <?php echo loadOrderStatus(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value="Select Quantity" name="_newQuantity" id="_newQuantity" class="SlectBox form-control">
                                    <option>Choose Order Quantity</option>
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
                                <textarea value="Order Note Text" id="_newOrderNote" name="_newOrderNote" class="form-control" placeholder="Order Note" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group file-browser">
                                <input id="_newDNLabel" type="text" class="form-control browse-file" placeholder="Select Delivery Note" readonly>
                                <label class="input-group-btn">
                                    <span class="btn btn-default">
                                        Select <input type="file" name="_newDeliveryNoteFile" id="_newDeliveryNoteFile" style="display: none;">
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <div class="input-group mb-3">
                            <select value="Sales Consultant" name="_newSalesConsultant" id="_newSalesConsultant" class="SlectBox form-control">
                                <?php echo loadSalesPerson(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select value="Select Category" name="_newCat_Id" id="_newCat_Id" class="SlectBox form-control">
                            <?php echo loadCat(); ?>
                        </select>
                    </div>
                    <div>
                        <div class="input-group mb-3">
                            <div class="input-group file-browser">
                                <input id="_newImageLabel" type="text" class="form-control browse-file" placeholder="Select Order Image" readonly>
                                <label class="input-group-btn">
                                    <span class="btn btn-default">
                                        Browse <input class="file-input" type="file" name="_newOrderImage[]" id="_newOrderImage" style="display: none;" multiple>
                                    </span>
                                </label>
                            </div>
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0 mt-3 justify-content-end">
                <div>
                    <input type="submit" id="_add" name="_add" class="btn btn-primary btn-size" value="Add"/>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Internal form-elements js -->
<script src="../assets/js/advanced-form-elements.js"></script>

<!-- Internal form-elements js -->
<!-- <script src="../assets/js/form-elements.js"></script> -->

<!--Internal  Sweet-Alert js-->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/plugins/sweet-alert/jquery.sweet-alert.js"></script>

<!-- Sweet-alert js  -->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/js/sweet-alert.js"></script>

<script type="text/javascript">
    //ORDERS CAN'T BE ADDED FOR NEXT SEVEN DAYS FROM TODAY EXCLUDING FRIDAY
    //For keeping track of the number of times
    var datesAdded = 0;
    //Number of extra days to be added to today
    var maxDatesToAdd = 7;
    //Indices of weekends you get from Date.getDay();
    var weekends = [5];
    var date = new Date();
    while (datesAdded < maxDatesToAdd) {
        var newDate = new Date(date.getTime() + (24 * 60 * 60 * 1000));
        date = newDate;
        //Checking if the day that's added is a weekend
        if (weekends.includes(newDate.getDay())) continue;
        //Incrementing the variable so the while loop will eventually break
        datesAdded++;
    }
    var year = date.getFullYear();
    var month = (date.getMonth() + 1).toString().padStart(2, '0');
    var day = date.getDate().toString().padStart(2, '0');
    //Converting the date to a the YYYY-MM-DD format.
    var _minDate = `${year}-${month}-${day}`; 
    //document.getElementById("_deliveryDate").setAttribute("min", _minDate);
    $('#_newDeliveryDate').datepicker({
        minDate: new Date(_minDate),
    });
    $('#_newDeliveryDate').datepicker('setDate', 'today');

    //FORM SUBMISSION
    $(document).ready(function(){
        $("#formNewOrder").on('submit', function(e){
            e.preventDefault();
            if(errorHandling()){
                $.ajax({
                    type: 'POST',
                    url: '../order/add_order.php',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    async: false,
                    autoUpload: false,
                    success: function(response){
                        $('.statusMsg').html('');
                        if(response.status === 1){
                            //FORM TO RESET AFTER SUBMISSION
                            $('#formNewOrder')[0].reset();
                            //REPONSE MESSAGE
                            $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>'); 
                            //TEST METHOD TO RESET DROPDOWN
                            postOrderSave();
							$('#exampleone').DataTable().ajax.reload();
                        }else{
                            $('.statusMsg').html(alert(response.message));
                        }
                        $('#formNewOrder').css("opacity","");
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
        var _warningText = "Mandatory Fields are Required to be Filled";
        var _invoiceId = $("#_newInvoiceId").val();
        var _deliveryDate = $("#_newDeliveryDate").val();
        var _itemName = $("#_newItemName").val();
        var _itemColor = $("_newItemColor").val();
        var _itemSize = $("#_newItemSize").val();
        var _branchFrom = $("#_newItemFrom").val();
        var _deliveryTo = $("#_newDeliveryLocation").val();
        var _orderStatus = $("#_newStatus").val();
        var _itemQuantity = $("#_newQuantity").val();
        var _orderNote = $("#_newOrderNote").val();
        var _deliveryNote = $("#_newDeliveryNoteFile").val();
        var _salesConsultant = $("#_newSalesConsultant").val();
        var _images = $("#_newOrderImage").val();
        var _categoryId = $("#_newCat_Id").val();

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
        else if(_deliveryNote == ''){
            _warningMessage = "Delivery Note Should be Attached";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_salesConsultant == 'Select Sales Consultant'){
            _warningMessage = "Sales Consultant Left Empty";
            emptyFieldAlert(_warningMessage, _warningText);
            flag = false
        }
        else if(_images == ''){
            _warningMessage = "Item Images are Missing";
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
            title: 'Order is Saved Successfully!',
            text: 'Check Saved Orders in Tables',
            type: 'success',
            confirmButtonColor: '#57a94f'
        });
    }

    //CLEAR FILES AND LABEL AFTER SAVE
    function postOrderSave(){
        //MAKE IMAGE EMPTY
        var orderImageLabel = document.getElementById ("_newImageLabel");
        orderImageLabel.placeholder = "Select Order Image";
        $( 'div.preview' ).empty();
        //MAKE DELIVERY NOTE EMPTY
        var _dnLabel = document.getElementById ("_newDNLabel");
        _dnLabel.placeholder = "Select Delivery Note";
        //MAKE SELECTORS EMPTY
        $('select.SlectBox')[0].sumo.reload();
        $('select.SlectBox')[1].sumo.reload();
        $('select.SlectBox')[2].sumo.reload();
        $('select.SlectBox')[3].sumo.reload();
        $('select.SlectBox')[4].sumo.reload();
        $('select.SlectBox')[5].sumo.reload();
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
        $('#_newOrderImage').on('change', function() {
            imagesPreview(this, 'div.preview');
            $( 'div.preview' ).empty();
        });
    });

    //ORDER IMAGE LABEL CHANGE
    $('#_newOrderImage').on("change", function(){
        var input = document.getElementById ("_newImageLabel");
        var imageCount = $(this)[0].files.length;
        var _imgFileSize = this.files[0].size/1024;
        var _imgFileSizeLimit = 100;
        if(_imgFileSize > _imgFileSizeLimit){
            $("#_newOrderImage").val(null);
            var _warningSizeTitle = "Check File Size";
            var _warningSizeText = "Total File Size is Limited to 100 KB";
            emptyFieldAlert(_warningSizeTitle, _warningSizeText);
        }else{
            if(imageCount > 0){
                input.placeholder = imageCount+" Image Attached";
            }else{
                input.placeholder = "Select Order Image";
            }
        }
    });

    //ORDER FILE LABEL CHANGE
    $('#_newDeliveryNoteFile').on("change", function(){
        var input = document.getElementById ("_newDNLabel");
        var _dnCount = $(this)[0].files.length;
        var _pdfFileSize = this.files[0].size/1024;
        var _pdfFileSizeLimit = 50;

        if(_pdfFileSize > _pdfFileSizeLimit){
            $('#_newDeliveryNoteFile').val(null);
            var _warningSizeTitle = "Check File Size";
            var _warningSizeText = "Total File Size is Limited to 50 KB";
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