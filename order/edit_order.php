<?php

    include "../base/db.php";
    $image_upload_dir = '../uploads/';
    $pdf_upload_dir = '../pdfUploads/';

    //DEFAULT RESPONSES
    $response['status'] = 0;
    $response['message'] = 'NOT DONE!';
    $response['success'] = 'false';

	////RETRIEVES RECORD FROM ADD ORDER MODAL
    if(isset($_POST['_eid']) || 
    isset($_POST['_editInvoiceId']) || 
    isset($_POST['_editDeliveryDate']) ||
    isset($_POST['_editItemName']) ||
    isset($_POST['_editItemColor']) ||
    isset($_POST['_editItemSize']) ||
    isset($_POST['_editItemFrom']) ||
    isset($_POST['_editDeliveryLocation']) ||
    isset($_POST['_editStatus']) ||
    isset($_POST['_editQuantity']) ||
    isset($_POST['_editSalesConsultant']) ||
    isset($_POST['_editCat_Id']) || 
    isset($_POST['_editOrderNote'])|| 
    isset($_POST['_editOrderImage']))
    //isset($_FILES['_editDeliveryNoteFile']))
	// if (isset($_POST['_editInvoiceId']) || isset($_POST['_editDeliveryDate']) || isset($_POST['_editItemName']) || isset($_POST['_editItemColor']) || isset($_POST['_editItemSize']) || isset($_POST['_editItemFrom']) || isset($_POST['_editDeliveryLocation']) || isset($_POST['_editStatus']) || isset($_POST['_editQuantity']) || isset($_POST['_editOrderNote']) || isset($_FILES['_editDeliveryNoteFile']) || isset($_POST['_editSalesConsultant']) || isset($_FILES['_editOrderImage']) || isset($_POST['_editCat_Id']))
    {
        // if (isset($_POST['_newInvoiceId']) || isset($_FILES['_newDeliveryNoteFile'])){
        $_eid = $_POST['_eid'];
        $_editInvoiceId = $_POST['_editInvoiceId'];
        $_editDeliveryDate = $_POST['_editDeliveryDate'];
        $_editItemName = $_POST['_editItemName'];
        $_editItemColor = $_POST['_editItemColor'];
        $_editItemSize = $_POST['_editItemSize'];
        $_editItemFrom = $_POST['_editItemFrom'];
        $_editDeliveryLocation = $_POST['_editDeliveryLocation'];
        $_editStatus = $_POST['_editStatus'];
        $_editQuantity = $_POST['_editQuantity'];
        $_editOrderNote = $_POST['_editOrderNote'];
        $_editSalesConsultant = $_POST['_editSalesConsultant'];
        $_editCat_Id = $_POST['_editCat_Id'];

        // //GET CURRENT DATE AND USER
        // $insertDate=curdate();
        // $userid = $_SESSION['userName'];

        // $deliveryDateToSec = strtotime($deliveryDate);
        // $insertDateToSec = strtotime($insertDate);
        // $timeDiff = abs($deliveryDateToSec - $insertDateToSec);
        // $dateAvailability = $timeDiff/86400;
        // $dateAvailability = intval($dateAvailability);


        //IMAGE UPLOAD
        $uploadStatus = 1;
        //$_imageName = '';
        $image = '';
        foreach($_FILES['_editOrderImage']['tmp_name'] as $key => $_editOrderImage)
        {
            if(!empty($_FILES['_editOrderImage']['tmp_name'][$key]))
            {
                $imageTmpName = $_FILES['_editOrderImage']['tmp_name'][$key];
                $name = $_FILES['_editOrderImage']['name'][$key];

                //Image name prefexified with a random number
                $random = rand(000,999);
                $random = str_pad($random, 3, '0', STR_PAD_LEFT);
                $name = $random.$name;

                //Image name will be saved with comma
                $image=$image.$name.",";
                //Delete Last Comma of the Image
                $_imageName = substr(trim($image), 0, -1);

                $result = move_uploaded_file($imageTmpName,$image_upload_dir.$name);
            }
            else{
                $_imageName = '';
                //echo 'tada';
            }
        }


        //PDF UPLOAD
        //$_editDeliveryNoteFile = '';
        if(!empty($_FILES['_editDeliveryNoteFile']['name'])){
            $dnTMP = $_FILES['_editDeliveryNoteFile']['tmp_name'];
            $_dnName = $_FILES['_editDeliveryNoteFile']['name'];
            $result = move_uploaded_file($dnTMP,$pdf_upload_dir.$_dnName);
        }
        else{
            $_dnName = '';
        }
        
        if(!empty($_eid))
        {
            if((!empty($_imageName)) && (empty($_dnName)))
            {
                $statement = "UPDATE product SET 
                    invoiceId = '$_editInvoiceId',
                    productlink = '$_editDeliveryDate',
                    pname = '$_editItemName',
                    color = '$_editItemColor',
                    size = '$_editItemSize',
                    branchId = '$_editItemFrom',
                    city = '$_editDeliveryLocation',
                    pstatus = '$_editStatus',
                    quantity = '$_editQuantity',
                    salesperson = '$_editSalesConsultant',
                    cat_id = '$_editCat_Id',
                    ordernote = '$_editOrderNote',
                    pimage = '$_imageName'
                    WHERE id = '$_eid'";

                    $response['status'] = 2;
            }
            else if((empty($_imageName)) && (!empty($_dnName)))
            {
                $statement = "UPDATE product SET 
                    invoiceId = '$_editInvoiceId',
                    productlink = '$_editDeliveryDate',
                    pname = '$_editItemName',
                    color = '$_editItemColor',
                    size = '$_editItemSize',
                    branchId = '$_editItemFrom',
                    city = '$_editDeliveryLocation',
                    pstatus = '$_editStatus',
                    quantity = '$_editQuantity',
                    salesperson = '$_editSalesConsultant',
                    cat_id = '$_editCat_Id',
                    ordernote = '$_editOrderNote',
                    deliveryNote = '$_dnName'
                    WHERE id = '$_eid'";

                    $response['status'] = 3;
            }
            else if((!empty($_imageName)) && (!empty($_dnName)))
            {
                $statement = "UPDATE product SET 
                    invoiceId = '$_editInvoiceId',
                    productlink = '$_editDeliveryDate',
                    pname = '$_editItemName',
                    color = '$_editItemColor',
                    size = '$_editItemSize',
                    branchId = '$_editItemFrom',
                    city = '$_editDeliveryLocation',
                    pstatus = '$_editStatus',
                    quantity = '$_editQuantity',
                    salesperson = '$_editSalesConsultant',
                    cat_id = '$_editCat_Id',
                    ordernote = '$_editOrderNote',
                    pimage = '$_imageName',
                    deliveryNote = '$_dnName'
                    WHERE id = '$_eid'";

                    $response['status'] = 4;
            }
            else
            {
                $statement = "UPDATE product SET 
                    invoiceId = '$_editInvoiceId',
                    productlink = '$_editDeliveryDate',
                    pname = '$_editItemName',
                    color = '$_editItemColor',
                    size = '$_editItemSize',
                    branchId = '$_editItemFrom',
                    city = '$_editDeliveryLocation',
                    pstatus = '$_editStatus',
                    quantity = '$_editQuantity',
                    salesperson = '$_editSalesConsultant',
                    cat_id = '$_editCat_Id',
                    ordernote = '$_editOrderNote'
                    WHERE id = '$_eid'";

                    $response['status'] = 5;
            }
            $result = mysqli_query($conn, $statement);
            // //IF NEW IMAGE IS ADDED
            // if(!empty($_imageName))
            // {
            //     $statement = "UPDATE product SET 
            //     invoiceId = '$_editInvoiceId',
            //     productlink = '$_editDeliveryDate',
            //     pname = '$_editItemName',
            //     color = '$_editItemColor',
            //     size = '$_editItemSize',
            //     branchId = '$_editItemFrom',
            //     city = '$_editDeliveryLocation',
            //     pstatus = '$_editStatus',
            //     quantity = '$_editQuantity',
            //     salesperson = '$_editSalesConsultant',
            //     cat_id = '$_editCat_Id',
            //     ordernote = '$_editOrderNote',
            //     pimage = '$_imageName',
            //     deliveryNote = '$_dnName'
            //     WHERE id = '$_eid'";
            // }
            // //IF NO IMAGE IS ADDED
            // else{
            //     $statement = "UPDATE product SET 
            //     invoiceId = '$_editInvoiceId',
            //     productlink = '$_editDeliveryDate',
            //     pname = '$_editItemName',
            //     color = '$_editItemColor',
            //     size = '$_editItemSize',
            //     branchId = '$_editItemFrom',
            //     city = '$_editDeliveryLocation',
            //     pstatus = '$_editStatus',
            //     quantity = '$_editQuantity',
            //     salesperson = '$_editSalesConsultant',
            //     cat_id = '$_editCat_Id',
            //     ordernote = '$_editOrderNote'
            //     WHERE id = '$_eid'";
            // }
            // $result = mysqli_query($conn, $statement);
        }
        if($result){
            $response['status'] = 1;
            $response['message'] = 'UPDATED';
            $response['success'] = 'true';
        }
    }
    echo json_encode($response);
?>