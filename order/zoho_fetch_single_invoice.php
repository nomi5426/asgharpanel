<?php
/**
 * PROJECT: ZETA 1.0.0
 * AUTHOR: ROSHAN ZAID AKA DAUNTE
 * FILE FOR: TO KEEP REFRESH TOKEN ACTIVE AND GENERATE ACCESS TOKENS
 * 
 * VARIABLES
 * @CLIENT_ID       //ZOHO CLIENT MEMBER ID
 * @CLIENT_SECRET   //ZOHO CLIENT SECRET ID
 * @BASE_ACC_URL    //ZOHO ACCOUNT URL
 * @REFRESH_TOKEN   //HAVE BEEN CREATED WITH | CLIENT ID | CLIENT SECRET | CLIENT CODE
 * @TOKEN_URL       //CREATES THE CALL URL
 * @SERVICE_URL     //WHICH PART THE CALL SHOULD COVER
 */
    
    $client_id ='1000.06AOWAPM5NXKUCPV6YVFJWCYRB1OLM';
    $client_secret = 'f7674c4c2abc64aa9d80e8f36422398bfd0a27d5f8';
    $code = '1000.0fd0aa66119ad802763ec5aef04a06f8.af48efc8c9f92f4e2719f9457ebdee14';
    $base_acc_url = 'https://accounts.zoho.com';
    $refresh_token = '1000.615caad2058055f3f2e5469ee03a519f.dff8a6c6287e5237c2545c5610e0aa25';
    $token_url = $base_acc_url . '/oauth/v2/token?grant_type=authorization_code&client_id='. $client_id . '&client_secret='. $client_secret . '&redirect_uri=http://localhost&code=' . $code;
    $service_url = '';

    function generate_access_token($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result)->access_token;
    }

    $access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';

    $access_token = generate_access_token($access_token_url);
    // var_dump($access_token);

    create_record($access_token);
    function create_record($access_token){
        $service_url = $GLOBALS['service_url'] . 'https://books.zoho.com/api/v3/invoices';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Zoho-oauthtoken '. $access_token,
            'Content-Type: "application/json"'));
        global $result;
        $result = curl_exec($ch);
        curl_close($ch);
        global $decoded_result;
        $decoded_result = array();
        $decoded_result = json_decode($result, true);
    }
?>
