<?php
    include "../base/db.php";
    $upload_dir = "../uploads/";
    $pdf_upload_dir = "../pdfUploads/";
	$agreement_upload_dir = '../salesAgreementUpload/';


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
    //GET PARTICULAR STAFF FROM DB FOR TO EDIT AND FIND EXISTING VALUE OF THE STAFF
    if(isset($_REQUEST['id'])){
        $id=intval($_REQUEST['id']);
        $sql="SELECT * FROM product 
        LEFT JOIN sales_agreement ON 
        product.id = sales_agreement.order_id
        LEFT JOIN customer on
        product.id = customer.order_id
        WHERE product.id = '$id'";
        $run_sql=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_array($run_sql)){
            $id=$row['id'];
            $edAppinvoiceId = $row['invoiceId'];
            $edAppDelDate = $row['productlink'];
            $edAppItemName = $row['pname'];
            $edAppItemColor = $row['color'];
            $edAppItemSize = $row['size'];
            $editAppQuantity = $row['quantity'];
            $edAppOrderNote = $row['ordernote'];
        }
        ?>      
        <div id="mod_open" class="modal-content modal-content-demo">
            <div class="modal-header">
                <h5 class="modal-title">Edit Order</h5>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>              
            <div class="modal-body">
                <form id="formEditAppOrder" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-8">
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="input-group mb-4">
                                        <input aria-label="Invoice ID" id="_editAppInvoiceId" name="_editAppInvoiceId" class="form-control" value="<?php echo $edAppinvoiceId;?>" type="text">
                                        <input hidden id="dat_id" name="dat_id" class="form-control"type="text" value="<?php echo $id;?>"/>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="input-group col-md-6">
                                    <div class="input-group-prepend" style="margin-bottom:6.75%">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker" name="_editAppDeliveryDate" id="_editAppDeliveryDate" value="<?php echo $edAppDelDate;?>" type="text">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="input-group mb-3">
                                        <input aria-label="Product Name" id="_editAppItemName" name="_editAppItemName" value="<?php echo $edAppItemName;?>" class="form-control"  type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <input aria-label="Color" id="_editAppItemColor" name="_editAppItemColor" value="<?php echo $edAppItemColor;?>" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <input aria-label="Size" id="_editAppItemSize" name="_editAppItemSize" value="<?php echo $edAppItemSize;?>" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <select value='Order From' name="_editAppBranch" id="_editAppBranch" class="SlectBox form-control">
                                            <?php echo loadBranch(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <select value='Deliver To' name="_editAppDeliveryLocation" id="_editAppDeliveryLocation" class="SlectBox form-control">
                                            <?php echo loadDeliveryLocation(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <select name="_editAppStatus" id="_editAppStatus" class="SlectBox form-control">
                                            <option value="Pending">Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <input aria-label="Quantity" id="_editAppQuantity" name="_editAppQuantity" value="<?php echo $editAppQuantity;?>" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <textarea value="<?php echo $edAppOrderNote;?>" id="_editAppOrderNote" name="_editAppOrderNote" class="form-control" rows="6"><?php echo $edAppOrderNote;?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group file-browser">
                                        <input id="_editAppDNLabel" type="text" class="form-control browse-file" placeholder="Select Delivery Note" readonly>
                                        <label class="input-group-btn">
                                            <span class="btn btn-default">
                                                Select <input type="file" name="_editAppDeliveryNoteFile" id="_editAppDeliveryNoteFile" style="display: none;">
                                            </span>
                                        </label>
                                    </div>
                                    <div class="input-group file-browser">
                                        <input id="_salesAgreementLabel" type="text" class="form-control browse-file" placeholder="Select Sales Agreement" readonly>
                                        <label class="input-group-btn">
                                            <span class="btn btn-default">
                                                Select <input type="file" name="_salesAgreement" id="_salesAgreement" style="display: none;">
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group mb-3">
                                <select value="Select Category" name="_editAppCat_Id" id="_editAppCat_Id" class="SlectBox form-control">
                                    <?php echo loadMasterCat(); ?>
                                </select>
                            </div>
                            <div class="row row-sm">
                                <div class="input-group mb-3">
                                    <div class="input-group file-browser">
                                        <input id="_editAppImageLabel" type="text" class="form-control browse-file" placeholder="Select Order Image" readonly>
                                        <label class="input-group-btn">
                                            <span class="btn btn-default">
                                                Browse <input type="file" name="_editAppOrderImage[]" id="_editAppOrderImage" value="" multiple="true">
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
        <?php
    }
?>
    <!-- Internal Form-elements js -->
    <script src="../assets/js/advanced-form-elements.js"></script>
    <!-- Internal form-elements js -->
    <script src="../assets/js/form-elements.js"></script>
    <!-- Internal Modal js-->
    <script src="../assets/js/modal.js"></script>
    <script type="text/javascript">
        //ORDERS CAN'T BE ADDED FOR NEXT SEVEN DAYS FROM TODAY EXCLUDING FRIDAY
        var datesAdded = 0;
        var maxDatesToAdd = 7;
        var weekends = [5];
        var date = new Date();
        while (datesAdded < maxDatesToAdd) {
            var newDate = new Date(date.getTime() + (24 * 60 * 60 * 1000));
            date = newDate;
            if (weekends.includes(newDate.getDay())) continue;
            datesAdded++;
        }
        var year = date.getFullYear();
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var day = date.getDate().toString().padStart(2, '0');
        var _minDate = `${year}-${month}-${day}`; 
        $('#_editAppDeliveryDate').datepicker({
            minDate: new Date(_minDate),
        });
        $('#_editAppDeliveryDate').datepicker('setDate', 'today');

        $(document).ready(function(){
            
            //ORDER INVOICE SECOND DROPDOWN CHANGES
            var inp = $('#_editAppInvoiceId');
            if (inp.val().length > 0) {
                var id = $('#dat_id').val();
                $.ajax({
                    url:'../order/fetch_order_detail.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {id:id},
                    success:function(data){
                        $('#dat_id').val(data[0].id);
                        $('#_editAppInvoiceId').val(data[0].invoiceId);
                        $('#_editAppDeliveryDate').val(data[0].productlink);
                        $('#_editAppItemName').val(data[0].pname);
                        $('#_editAppItemColor').val(data[0].color);
                        $('#_editAppItemSize').val(data[0].size);
                        $('#_editAppBranch')[0].sumo.selectItem(data[0].branchId);
                        $('#_editAppDeliveryLocation')[0].sumo.selectItem(data[0].city);
                        $('#_editAppStatus')[0].sumo.selectItem(data[0].pstatus);
                        $('#_editAppCat_Id')[0].sumo.selectItem(data[0].cat_id);
                        $('#_editAppOrderNote').val(data[0].ordernote);

                        //IMAGE
                        var image_DB = data[0].pimage;
                        var img_upload_dir = "../uploads/";
                        var _imgInput = document.getElementById ("_editAppImageLabel");

                        //DELIVERY NOTE
                        var dn_DB = data[0].deliveryNote;
                        var dn_upload_dir = "../pdfUploads/";
                        var _dnInput = document.getElementById ("_editAppDNLabel");

                        //DELIVERY NOTE
                        var salesAgreement_DB = data[0].sales_agreement_path;
                        var sales_agreement_dir = "../salesAgreementUpload/";
                        var _salesAgreementInput = document.getElementById ("_salesAgreementLabel");

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
                        if(salesAgreement_DB !== 'Not Exists'){
                            _salesAgreementInput.placeholder = "Sales Agreement Attached";
                        }
                        else{
                            _salesAgreementInput.placeholder = "Select Sales Agreement";
                        }
                    }
                });
                $('#preview').empty();
            }

            //ORDER SUBMIT FOR UPDATE
            $("#formEditAppOrder").on('submit', function(e){
                e.preventDefault();
                if(errorHandling()){
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: '../order/edit_order_approve.php',
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData:false,
                        success: function(response){
                            $('.statusMsg').html('');
                            if(response.status == 1){
                                _succesEdit();
                            }else{
                                console.log('IN ELSE');
                                $('.statusMsg').html(alert(response.message));
                            }
                            $('#formEditAppOrder').css("opacity","");
                            $(".submit").removeAttr("disabled");
                        }
                    });
                }
            });

            //ERROR HANDLING - EMPTY FIELD CHECK
            function errorHandling(){
                var flag = true;
                var _warningMessage;
                var _warningText = "Mandatory Fields are Required to be Filled";
                var _invoiceId = $("#_editAppInvoiceId").val();
                var _deliveryDate = $("#_editAppDeliveryDate").val();
                var _itemName = $("#_editAppItemName").val();
                var _itemColor = $("_editAppItemColor").val();
                var _itemSize = $("#_editAppItemSize").val();
                var _branchFrom = $("#_editAppBranch").val();
                var _deliveryTo = $("#_editAppDeliveryLocation").val();
                var _orderStatus = $("#_editAppStatus").val();
                var _itemQuantity = $("#_editAppQuantity").val();
                var _orderNote = $("#_editAppOrderNote").val();
                var _categoryId = $("#_editAppCat_Id").val();

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
                else if(_categoryId == 'Select Category'){
                    _warningMessage = "Category Left Empty";
                    emptyFieldAlert(_warningMessage, _warningText);
                    flag = false
                }
                else{
                    _succesEdit();
                }
                return flag;
            }

            //EMPTY FIELD CHECK - WARNING
            function emptyFieldAlert(_alertTitle, _alertText){
                swal({
                    title: _alertTitle,
                    text: _alertText,
                    type: "warning",
                    confirmButtonClass: "btn btn-danger"
                });
            }

            //ORDER EDITED - SUCCESS
            function _succesEdit(){
                swal({
                    title: 'Order is Edited Successfully!',
                    text: 'Check Edited Orders in Tables',
                    type: 'success',
                    confirmButtonColor: '#57a94f'
                },
                function loadPage(){
                    location.reload();
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
                $('#_editAppOrderImage').on('change', function() {
                    imagesPreview(this, 'div.preview');
                    $( 'div.preview' ).empty();
                });
            });

            //ORDER FILE LABEL CHANGE
            $('#_editAppDeliveryNoteFile').on("change", function(){
                var input = document.getElementById ("_editAppDNLabel");
                var _dnCount = $(this)[0].files.length;
                var _pdfFileSize = this.files[0].size/1024;
                var _pdfFileSizeLimit = 100;

                if(_pdfFileSize > _pdfFileSizeLimit){
                    $('#_editAppDeliveryNoteFile').val(null);
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

            //SALES AGREEMENT LABEL CHANGE
            $('#_salesAgreement').on("change", function(){
                var input = document.getElementById ("_salesAgreementLabel");
                var _salesAgreementCount = $(this)[0].files.length;
                if(_salesAgreementCount > 0){
                    input.placeholder = "Sales Agreement Attached";
                }else{
                    input.placeholder = "Select Sales Agreement";
                }
            });
        });
    </script>

