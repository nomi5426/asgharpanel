<?php
/**
 * PROJECT: ZETA 1.0.0
 * AUTHOR: ROSHAN ZAID AKA DAUNTE
 * FILE FOR: FETCH ZOHO DETAIL TO CREATE NEW ORDER
 * 
 * VARIABLES
 * $DECODED_RESULT: FETCHED FROM ZOHO_TRY_OUT.PHP
 * $RESULT: FETCHED FROM ZOHO_TRY_OUT.PHP
 */
    //GET DB, ZOHO_TRY_OUT FOR FETCHING PURPOSES
    include "../base/db.php";
    include "zoho_try_out.php";

    //FETCH INVOICES FROM ZOHO_TRY_OUT.PHP
    $invoice_number = '';
    function _loadZohoInvoice(){
        global $decoded_result;
        global $result;
        global $invoice_id;
        $_invoiceReturn='';
        $_invoiceReturn .= '<option value = "Select Invoice">Select Invoice</option>';
        foreach($decoded_result['invoices'] as $result) {
            $invoice_number = $result['invoice_number'];
            $invoice_id = $result['invoice_id'];
            $_invoiceReturn .= '<option value = "'.$invoice_id.'">'.$invoice_number.'</option>';
        }
        return $_invoiceReturn;
    }

    //FETCH BRANCHES
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

    //FETCH DELIVERY LOCATION
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

    //FETCH PRODUCT CATEGORY
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

    //FETCH SALESCONSULTANTS
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
?>
<div class="modal-content modal-content-demo">
    <!--MODAL HEADER-->
    <div class="modal-header">
        <h4 class="modal-title">New Order - Zoho</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    </div>
    <!--MODAL BODY-->              
    <div class="modal-body">
        <!--FORM - EDIT ORDER BEINGS-->
        <form id="formEditOrder" method="post" autocomplete="off" enctype="multipart/form-data">
            <h5 class="modal-title">Zoho Input</h5>
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <!--INVOICE FIELD-->
                            <div class="input-group mb-3">
                                <select value="Select Zoho Invoice" name="_zohoInvoice" id="_zohoInvoice" class="SlectBox form-control">
                                    <?php echo _loadZohoInvoice(); ?>
                                    <input hidden id="_zInvoiceId" name="_zInvoiceId" class="form-control"type="text">
                                </select>
                            </div>
                            <!--INVOICE FIELD CLOSED-->
                        </div>
                        <div class="col-lg-6">
                            <!--PRODUCT NAME-->
                            <div class="input-group mb-3">
                                <select value="Select Item" id="_zProductName" class="SlectBox form-control">
								</select>
                            </div>
                            <!--PRODUCT NAME CLOSED-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <!--PRODUCT NAME-->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Name</span> 
                                <input aria-label="Name" id="_zItemName" name="_zItemName" class="form-control" type="text">
                            </div>
                            <!--PRODUCT NAME CLOSED-->
                        </div>
                        <div class="col-lg-6">
                            <!--PRODUCT COLOR-->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Color</span> 
                                <input aria-label="Color" id="_zItemColor" name="_zItemColor" class="form-control" type="text">
                            </div>
                            <!--PRODUCT COLOR CLOSED-->
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <!--ORDER STATUS-->
                            <div class="input-group mb-3">
                                <select value='Order Status' name="_zOrderStatus" id="_zOrderStatus" class="SlectBox form-control">
                                    <option value="Order Status">New Order</option>
                                </select>
                            </div>
                            <!--ORDER STATUS CLOSED-->
                        </div>
                        <div class="col-lg-6">
                            <!--ITEM QUANTITY-->
                            <div class="input-group mb-3">
                                <select value='Deliver To' name="_zQuantity" id="_zQuantity" class="SlectBox form-control">
                                    <option value="Quantity">Quantity</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                            <!--ITEM QUANTITY CLOSED-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <!--PRODUCT SIZE-->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">Size</span> 
                            <input aria-label="Size" id="_zItemSize" name="_zItemSize" class="form-control" type="text">
                        </div>
                        <!--PRODUCT SIZE CLOSED-->
                        <!--SALES CONSULTANT-->
                        <div class="input-group mb-3">
                            <select value="Sales Consultant" name="_zSalesConsultant" id="_zSalesConsultant" class="SlectBox form-control">
                                <?php echo loadSalesPerson(); ?>
                            </select>
                        </div>
                        <!--SALES CONSULTANT CLOSED-->
                    </div>
                </div>
            </div>
            <h5 class="modal-title">User Input</h5>
            <div class="row row-sm">
                <div class="col-lg-8">
                    <div class="row row-sm">
                        <div class="input-group col-md-6">
                            <div class="input-group-prepend" style="margin-bottom:4.75%">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div>
                            <input class="form-control fc-datepicker" name="_zDeliveryDate" id="_zDeliveryDate" placeholder="Delivery Date" type="text">
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value='Deliver To' name="_zItemTo" id="_zItemTo" class="SlectBox form-control">
                                    <?php echo loadDeliveryLocation(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select value='Order From' name="_zItemFrom" id="_zItemFrom" class="SlectBox form-control">
                                <?php echo loadBranch(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group file-browser">
                                <input id="_zDNLabel" type="text" class="form-control browse-file" placeholder="Select Delivery Note" readonly>
                                <label class="input-group-btn">
                                    <span class="btn btn-default">
                                        Select <input type="file" name="_zDeliveryNoteFile" id="_zDeliveryNoteFile" style="display: none;">
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <textarea value="Order Note" id="_zOrderNote" name="_zOrderNote" class="form-control" placeholder="Order Note" rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <div class="input-group mb-3">
                            <select value="Select Category" name="_newCat_Id" id="_newCat_Id" class="SlectBox form-control">
                                <?php echo loadCat(); ?>
                            </select>
                        </div>
                        <div class="row row-sm">
                            <div class="input-group mb-3">
                                <div class="input-group file-browser">
                                    <input id="_zImageLabel" type="text" class="form-control browse-file" placeholder="Select Order Image" readonly>
                                    <label class="input-group-btn">
                                        <span class="btn btn-default">
                                            Browse <input type="file" name="_zOrderImage[]" id="_zOrderImage" value="" multiple="true">
                                        </span>
                                    </label>
                                </div>
                                <div id="preview" name="preview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0 mt-3 justify-content-end">
                <div>
                    <input type="submit" id="_zohoNew" name="_zohoNew" class="btn btn-primary btn-size" value="Edit"/>
                </div>
            </div>
        </form>
        <!--FORM - EDIT ORDER CLOSED-->
    </div>
</div>

<script type="text/javascript">
    //ORDER INVOICE SECOND DROPDOWN CHANGES
    $('#_zohoInvoice').change(function(e){
        $('#_zProductName').html('');
        $('#_zProductName')[0].sumo.reload();
        e.preventDefault();
        var selectedItem;
        var selectedProd;
        var itemName;
        var itemColor;
        var itemSize;
        var itemQuantity;
        var divider;
        var _zid = document.getElementById("_zohoInvoice").value;
        $.ajax({
            url:'../order/zoho_try_out.php',
            method: 'POST',
            dataType: 'json',
            data: {_zid:_zid},
            success:function(data){
                $.each(data.line_items, function(i, item_list) {
                    $('#_zProductName')[0].sumo.add(item_list.description);
                    selectedItem = $('#_zProductName').val();
                    // $.each(item)
                    // itemQuantity = item_list.quantity;
                    // console.log(itemQuantity);
                });
                $('#_zProductName').change(function(e){
                    selectedProd = $('#_zProductName').val();
                    divider = selectedProd.split('\n');
                    itemName = divider[0];
                    itemColor = divider[2];
                    itemSize = divider[1];
                    if(selectedProd.includes('\n')){
                        $('#_zItemName').val(itemName);
                        $('#_zItemColor').val(itemColor);
                        $('#_zItemSize').val(itemSize);
                    }else{
                        $('#_zItemName').val(itemName);
                        $('#_zItemSize').val('');
                        $('#_zItemColor').val('');
                    }
                    $('#_zQuantity')[0].sumo.selectItem(itemQuantity);
                    $('#_zSalesConsultant')[0].sumo.selectItem(data.salesperson_name);
                });
            },
            failure: function (data) {
                console.log('AUL');
            }
        });
    });

    function resetFields(){
        //FIELDS
        $('#_zItemName').val('');
        $('#_zItemColor').val('');
        $('#_zItemSize').val('');
        //SELECT BOXES
        $('select.SlectBox')[3].sumo.reload();
        $('select.SlectBox')[4].sumo.reload();
        $('select.SlectBox')[5].sumo.reload();
        $('select.SlectBox')[6].sumo.reload();
        $('select.SlectBox')[7].sumo.reload();
    }
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

