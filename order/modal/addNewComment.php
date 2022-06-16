<?php
include "../../base/db.php";

function loadOrder(){
    global $conn;
    $statusOutput='';   
    $statusSqlQuery = "SELECT * FROM order_status";
    $result = mysqli_query($conn, $statusSqlQuery);
    while($row = mysqli_fetch_array($result)){
        $statusOutput .= '<option value = "'.$row["status_name"].'">'.$row["status_name"].'</option>';
    }
    return $statusOutput;
}
?>
<div class="modal-content modal-content-demo">
    <div class="modal-header">
        <h5 class="modal-title">New Comment</h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    </div>              
    <div class="modal-body">
        <form id="formNewComment" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div>
                        <div class="input-group mb-3">
                            <select name="orderstatus" id="orderstatus" class="SlectBox form-control">
                                <option value="" disabled selected>Select Order Status</option>
                                    <?php
                                        $statusSqlQuery = "SELECT * FROM order_status WHERE NOT (status_name = 'Pending')";
                                        $result = mysqli_query($conn, $statusSqlQuery);
                                        while($row = mysqli_fetch_array($result)){
                                    ?>
                                <option value="<?= $row['status_name'];?>"><?=$row['status_name']?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="input-group mb-3">
                            <select name="invoice" id="invoice"  class="form-control select2-show-search select2-dropdown">
                                <option value="" disabled selected>Select Invoice ID</option>
                                <input hidden id="id" name="id" class="form-control"type="text">
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="input-group mb-3">
                            <textarea id="addedcomment" disabled rows="3" type="text" class="form-control" name="addedcomment" placeholder="Add Comment" value="" required></textarea>
                        </div>
                    </div>
                    <div>
                        <div class="input-group mb-3">
                            <textarea id="newcomment" rows="3" type="text" class="form-control" name="newcomment" placeholder="Add New Comment" value="" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mb-0 mt-3 justify-content-end">
                <div>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary btn-size">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Sweet-alert js  -->
<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/js/sweet-alert.js"></script>
<!-- Internal Form-elements js -->
<script src="../assets/js/advanced-form-elements.js"></script>
<!-- Internal form-elements js -->
<script src="../assets/js/form-elements.js"></script>
<!-- Internal Modal js-->
<script src="../assets/js/modal.js"></script>
<script type="text/javascript">
    $('#addedcomment').hide();
    $('#newcomment').hide();
    $(document).ready(function(){
        $("#orderstatus").change(function(e){
            e.preventDefault();
            var stat = $(this).val();
            $.ajax({
                url:'../order/add_comment.php',
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
                url:'../order/add_comment.php',
                method: 'POST',
                data: {id:id},
                success:function(data){
                    if(data === ""){
                        $('#newcomment').fadeIn("slow");
                        $('#newcomment').show();
                        $('#addedcomment').hide();
                        $('#id').val(id);
                    }
                    else{
                        $('#addedcomment').fadeIn("slow");
                        $('#addedcomment').show();
                        $("#addedcomment").html(data);
                        $('#newcomment').fadeIn("slow");
                        $('#newcomment').show();
                        $('#id').val(id);
                    }
                }
            });
        });
        $('#formNewComment').on('submit', function(e){
            e.preventDefault();
            var id = $('#id').val();
            var newcomment = $('#newcomment').val();
            $.ajax({
                type: "POST",
                url: '../order/add_comment.php',
                data: {oid:id, newcomment:newcomment},
                dataType: 'json',
                success: function(response){
                    if(response.index == 1){
                        _commentAdded();
                        $('#formNewComment')[0].reset();
                        $('#id').val('');
                        $('#newcomment').val('');
                        $('#invoice').val('');
                        $('#orderstatus').val('');
                    }
                }
            });
        });

        //SUCCESS - COMMENT ADDED
        function _commentAdded(){
            swal({
                title: 'Comment is Added!',
                text: 'Order Comment is succesfully saved',
                type: 'success',
                confirmButtonColor: '#57a94f'
            },
            function loadPage(){
                location.reload();
            });
        }
    });
</script>