<?php

    include "../base/db.php";
    $image_upload_dir = '../uploads/';
    $pdf_upload_dir = '../pdfUploads/';

    //DEFAULT RESPONSES
    $response['status'] = 0;
    $response['message'] = 'NOT DONE!';
    $response['success'] = 'false';

	////RETRIEVES RECORD FROM ADD ORDER MODAL
    if(isset($_POST['dat_id']) || 
    isset($_POST['_editAppInvoiceId']) || 
    isset($_POST['_editAppDeliveryDate']) ||
    isset($_POST['_editAppItemName']) ||
    isset($_POST['_editAppItemColor']) ||
    isset($_POST['_editAppItemSize']) ||
    isset($_POST['_editAppBranch']) ||
    isset($_POST['_editAppDeliveryLocation']) ||
    isset($_POST['_editAppStatus']) ||
    isset($_POST['_editAppQuantity']) ||
    isset($_POST['_editAppCat_Id']) || 
    isset($_POST['_editAppOrderNote'])||
    isset($_POST['_editAppOrderImage']))
    //isset($_FILES['_editDeliveryNoteFile']))
    {
        // if (isset($_POST['_newInvoiceId']) || isset($_FILES['_newDeliveryNoteFile'])){
        $_eid = $_POST['dat_id'];
        $_editAppInvoiceId = $_POST['_editAppInvoiceId'];
        $_eAppdd = $_POST['_editAppDeliveryDate'];
        $_editAppItemName = $_POST['_editAppItemName'];
        $_editAppItemColor = $_POST['_editAppItemColor'];
        $_editAppItemSize = $_POST['_editAppItemSize'];
        $_editAppBranch = $_POST['_editAppBranch'];
        $_editAppDeliveryLocation = $_POST['_editAppDeliveryLocation'];
        $_editAppStatus = $_POST['_editAppStatus'];
        $_editAppQuantity = $_POST['_editAppQuantity'];
        $_editAppOrderNote = $_POST['_editAppOrderNote'];
        // $_editAppSalesConsultant = $_POST['_editAppSalesConsultant'];
        $_editAppCat_Id = $_POST['_editAppCat_Id'];

		//DELIVERY DATE CONVERT
		$_editAppDeliveryDate = date('Y-m-d',strtotime($_eAppdd));

        //IMAGE UPLOAD
        $uploadStatus = 1;
        $image = '';
        foreach($_FILES['_editAppOrderImage']['tmp_name'] as $key => $_editAppOrderImage)
        {
            if(!empty($_FILES['_editAppOrderImage']['tmp_name'][$key]))
            {
                $imageTmpName = $_FILES['_editAppOrderImage']['tmp_name'][$key];
                $name = $_FILES['_editAppOrderImage']['name'][$key];
                //IMAGE NAME PREFEXIED WITH NUMBERS
                $random = rand(000,999);
                $random = str_pad($random, 3, '0', STR_PAD_LEFT);
                $name = $random.$name;
                //IMAGE NAME WILL BE STORED WITH COMMA
                $image=$image.$name.",";
                //DELETE THE LAST COMMA
                $_imageName = substr(trim($image), 0, -1);
                $result = move_uploaded_file($imageTmpName,$image_upload_dir.$name);
            }
            else{
                $_imageName = '';
            }
        }


        //PDF UPLOAD
        //$_editDeliveryNoteFile = '';
        if(!empty($_FILES['_editAppDeliveryNoteFile']['name'])){
            $dnTMP = $_FILES['_editAppDeliveryNoteFile']['tmp_name'];
            $_dnName = $_FILES['_editAppDeliveryNoteFile']['name'];
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
                    invoiceId = '$_editAppInvoiceId',
                    productlink = '$_editAppDeliveryDate',
                    pname = '$_editAppItemName',
                    color = '$_editAppItemColor',
                    size = '$_editAppItemSize',
                    branchId = '$_editAppBranch',
                    city = '$_editAppDeliveryLocation',
                    pstatus = '$_editAppStatus',
                    quantity = '$_editAppQuantity',
                    -- salesperson = '$_editAppSalesConsultant',
                    cat_id = '$_editAppCat_Id',
                    ordernote = '$_editAppOrderNote',
                    pimage = '$_imageName'
                    WHERE id = '$_eid'";

                    $response['status'] = 1;
            }
            else if((empty($_imageName)) && (!empty($_dnName)))
            {
                $statement = "UPDATE product SET 
                    invoiceId = '$_editAppInvoiceId',
                    productlink = '$_editAppDeliveryDate',
                    pname = '$_editAppItemName',
                    color = '$_editAppItemColor',
                    size = '$_editAppItemSize',
                    branchId = '$_editAppBranch',
                    city = '$_editAppDeliveryLocation',
                    pstatus = '$_editAppStatus',
                    quantity = '$_editAppQuantity',
                    -- salesperson = '$_editAppSalesConsultant',
                    cat_id = '$_editAppCat_Id',
                    ordernote = '$_editAppOrderNote',
                    deliveryNote = '$_dnName'
                    WHERE id = '$_eid'";

                    $response['status'] = 1;
            }
            else if((!empty($_imageName)) && (!empty($_dnName)))
            {
                $statement = "UPDATE product SET 
                    invoiceId = '$_editAppInvoiceId',
                    productlink = '$_editAppDeliveryDate',
                    pname = '$_editAppItemName',
                    color = '$_editAppItemColor',
                    size = '$_editAppItemSize',
                    branchId = '$_editAppBranch',
                    city = '$_editAppDeliveryLocation',
                    pstatus = '$_editAppStatus',
                    quantity = '$_editAppQuantity',
                    -- salesperson = '$_editAppSalesConsultant',
                    cat_id = '$_editAppCat_Id',
                    ordernote = '$_editAppOrderNote',
                    pimage = '$_imageName',
                    deliveryNote = '$_dnName'
                    WHERE id = '$_eid'";

                    $response['status'] = 1;
            }
            else
            {
                $statement = "UPDATE product SET 
                    invoiceId = '$_editAppInvoiceId',
                    productlink = '$_editAppDeliveryDate',
                    pname = '$_editAppItemName',
                    color = '$_editAppItemColor',
                    size = '$_editAppItemSize',
                    branchId = '$_editAppBranch',
                    city = '$_editAppDeliveryLocation',
                    pstatus = '$_editAppStatus',
                    quantity = '$_editAppQuantity',
                    -- salesperson = '$_editAppSalesConsultant',
                    cat_id = '$_editAppCat_Id',
                    ordernote = '$_editAppOrderNote'
                    WHERE id = '$_eid'";

                    $response['status'] = 1;
            }
            $result = mysqli_query($conn, $statement);
            if($result){
                $response['status'] = 1;
                $response['message'] = 'UPDATED';
                $response['success'] = 'true';
            }
        }
    }
    echo json_encode($response);
?>