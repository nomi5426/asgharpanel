<?php
include "../../base/db.php";

function loadOrder(){
    global $conn;
    $statusOutput='';   
    $statusSqlQuery = "SELECT * FROM order_status";
    $result = mysqli_query($conn, $statusSqlQuery);
    while($row = mysqli_fetch_array($result)){
        $statusOutput .= '<option value = "'.$row["status"].'">'.$row["status"].'</option>';
    }
    return $statusOutput;
}
?>
    <link rel="stylesheet" href="../assets/plugins/fancyuploder/fancy_fileupload.css" type="text/css" media="all" />

    <link rel="stylesheet" href="../assets/plugins/fancyuploder/fancy_fileupload.css" type="text/css" media="all" />
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
                                        <select name="orderstatus" id="orderstatus" class="SlectBox form-control">
                                            <option value="" disabled selected>Select Order Status</option>
                                                <?php
                                                    $statusSqlQuery = "SELECT * FROM order_status WHERE NOT (status = 'Pending')";
                                                    $result = mysqli_query($conn, $statusSqlQuery);
                                                    while($row = mysqli_fetch_array($result)){
                                                ?>
                                            <option value="<?= $row['status'];?>"><?=$row['status']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <select name="invoice" id="invoice"  class="form-control select2-show-search select2-dropdown">
                                            <option value="" disabled selected>Select Invoice ID</option>
                                            <input hidden id="id" name="id" class="form-control"type="text">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="input-group mb-4">
                                        <input aria-label="Invoice ID" id="inv" name="inv" class="form-control" placeholder="Invoice ID" type="text">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="input-group col-md-6">
                                    <div class="input-group-prepend" style="margin-bottom:6.75%">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker" name="deliveryDate" id="deliveryDate" placeholder="Delivery Date" type="text">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="input-group mb-3">
                                        <input aria-label="Product Name" id="itemname" name="itemname" class="form-control" placeholder="Product Name" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <input aria-label="Color" id="color" name="color" class="form-control" placeholder="Color" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <input aria-label="Size" id="size" name="size" class="form-control" placeholder="Size" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <select value='Order From' name="from" id="from" class="SlectBox form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <select value='Deliver To' name="deliverylocation" id="deliverylocation" class="SlectBox form-control">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <select value='Order Status' name="status" id="status" class="SlectBox form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group mb-3">
                                        <select value="Select Quantity" name="quantity" id="quantity" class="SlectBox form-control">
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
                                        <textarea value="Order Note Text" id="ordernote" name="ordernote" class="form-control" placeholder="Order Note" rows="6"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <input id="asd" name="asd" type="file">
                                        <!-- <label class="custom-file-label" id="dname" name="dname">Choose Delivery Note</label> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row row-sm">
                                <div class="input-group mb-3">
                                    <select value="Sales Consultant" name="salesconsultant" id="salesconsultant" class="SlectBox form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="input-group mb-3">
                                    <input id="demo" type="file" name="pimage[]" accept=".jpg, .png, image/jpeg, image/png" multiple>
                                    <!--<div id="files"></div>-->
                                    <!-- <center>
                                        <div id="dropZone">
                                            <img src="../assets/img/brand/upload.png">
                                            <input class="custom-file-input" name="pimage[]" id="pimage" type="file" multiple>
                                        </div>
                                        <div id="files"></div>
                                        <p id="progress"></p>
                                    </center> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <div>
                            <button type="button" id="_edit" name="_edit" class="btn btn-primary btn-size">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <script type="text/javascript">
    $(document).ready(function(){
        $("#orderstatus").change(function(e){
            e.preventDefault();
            var stat = $(this).val();
            $.ajax({
                url:'../order/edit_order.php',
                method: 'POST',
                data: {selectedstat:stat},
                success:function(data){
                    $("#invoice").html(data);
                }
            });
        });
        $("#invoice").change(function(e){
            e.preventDefault();
            var id = $(this).find(':selected').attr('data-id');
            $.ajax({
                url:'../order/edit_order.php',
                method: 'POST',
                data: {id:id},
                success:function(data){
                    if(data === ""){
                        console.log("data is NULL");
                    }
                    else{
                        console.log("We do have something");
                        $('#id').val(id);
                    }
                }
            });
        });
        $('#formEditOrder').on('submit', function(e){
            e.preventDefault();
            var id = $('#id').val();
            var newcomment = $('#newcomment').val();
            $.ajax({
                type: "POST",
                url: '../order/add_comment.php',
                data: {oid:id, newcomment:newcomment},
                success: function(data){
                    $('#formEditOrder')[0].reset();
                    console.log("BOKKA SUCCESS");
                }
            });
        });
    });
    </script>

    <script src="../assets/plugins/fancyuploder/jquery.ui.widget.js"></script>  
    <script src="../assets/plugins/fancyuploder/jquery.fileupload.js"></script>
    <script src="../assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
    <script src="../assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        var sendData= true;
        $("#demo").FancyFileUpload({
            retries: 0,
            autoUpload : false,
            processData: false,
            contentType: false,
            added : function(e,data){
                $("#_edit").on("click",function(){
                    if(sendData){
                        data.formData = $("#formEditOrder").serializeArray();
                        sendData = false;
                    }
                    data.submit();
                    $('#formEditOrder')[0].reset();
                });
            },
            done: function(e,data){
                sendData = true;
            }
        });
    });
    </script>

<!--Internal  Datepicker js -->
<script src="../assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

<!--Internal  jquery-simple-datetimepicker js -->
<script src="../assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>

<!-- Ionicons js -->
<script src="../assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js"></script>

<!--Internal  pickerjs js -->
<script src="../assets/plugins/pickerjs/picker.min.js"></script>

<!-- Internal Sumoselect js -->
<script src="../assets/plugins/sumoselect/jquery.sumoselect.js"></script>

<!-- Internal Select2 js -->
<script src="../assets/js/select2.js"></script>
<script src="../assets/plugins/select2/js/select2.min.js"></script>
    
<!-- Internal Form-elements js -->
<script src="../assets/js/advanced-form-elements.js"></script>

<!--Internal  jquery.maskedinput js -->
<script src="../assets/plugins/jquery.maskedinput/jquery.maskedinput.js"></script>

<!--Internal  spectrum-colorpicker js -->
<script src="../assets/plugins/spectrum-colorpicker/spectrum.js"></script>

<!-- Internal Select2.min js -->
<script src="../assets/plugins/select2/js/select2.min.js"></script>  

<!-- Internal form-elements js -->
<script src="../assets/js/form-elements.js"></script>

<!--Internal  Notify js -->
<script src="../assets/plugins/notify/js/notifIt.js"></script>
<script src="../assets/plugins/notify/js/notifit-custom.js"></script>

<!-- Internal Modal js-->
<script src="../assets/js/modal.js"></script>
