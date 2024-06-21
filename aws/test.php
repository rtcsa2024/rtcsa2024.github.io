<?php

$mysql_err = "";
$result = 1;

// MySQL 연결 생성
$connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");

if (!$connect) {
   $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
}

// 쿼리 스트링 값 받아오기
$currency = $_GET['currency'];
$card_number1 = $_GET['card_number1'];
$transaction_date = $_GET['transaction_date'];
$card_number4 = $_GET['card_number4'];
$mid = $_GET['mid'];
$amount = $_GET['amount'];
$access_country = $_GET['access_country'];
$order_id = $_GET['order_id'];
$payment_method = $_GET['payment_method'];
$email = $_GET['email'];
$ver = $_GET['ver'];
$transaction_id = $_GET['transaction_id'];
$param3 = $_GET['param3'];
$resmsg = $_GET['resmsg'];
$card_holder = $_GET['card_holder'];
$rescode = $_GET['rescode'];
$auth_code = $_GET['auth_code'];
$fgkey = $_GET['fgkey'];
$transaction_type = $_GET['transaction_type'];
$pay_to = $_GET['pay_to'];

// $data 변수 생성
$data = json_encode(array(
    "data" => "currency=$currency&card_number1=$card_number1&transaction_date=$transaction_date&card_number4=$card_number4&mid=$mid&amount=$amount&access_country=$access_country&order_id=$order_id&payment_method=$payment_method&email=$email&ver=$ver&transaction_id=$transaction_id&param3=$param3&resmsg=$resmsg&card_holder=$card_holder&rescode=$rescode&auth_code=$auth_code&fgkey=$fgkey&transaction_type=$transaction_type&pay_to=$pay_to"
));

// API 요청
$url = 'https://api-test.eximbay.com/v1/payments/verify';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic dGVzdF8xODQ5NzA1QzY0MkMyMTdFMEIyRDo='));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$response = curl_exec($ch);
curl_close($ch);

// 응답 확인 및 디코딩
$response_data = json_decode($response, true);
$response_rescode = $response_data['rescode'];
$response_resmsg = $response_data['resmsg'];

// 응답에 따른 DB 저장 테이블 결정
if ($response_rescode === "0000") {
   $query = "INSERT IGNORE INTO eximbay_succ_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration)
            VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration')";
} else {
   $query = "INSERT IGNORE INTO eximbay_failed_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration, rescode, resmsg)
            VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration', '$rescode', '$resmsg')";
}

$result = mysqli_query($connect, $query);

if ($result != 1) {
   $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
}
mysqli_close($connect);
?>
