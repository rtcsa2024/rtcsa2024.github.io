<?php

$currency = $_POST['currency'];
$card_number1 = $_POST['card_number1'];
$transaction_date = $_POST['transaction_date'];
$card_number4 = $_POST['card_number4'];
$mid = $_POST['mid'];
$amount = $_POST['amount'];
$access_country = $_POST['access_country'];
$order_id = $_POST['order_id'];
$payment_method = $_POST['payment_method'];
$email = $_POST['email'];
$ver = $_POST['ver'];
$transaction_id = $_POST['transaction_id'];
$param3 = $_POST['param3'];
$resmsg = $_POST['resmsg'];
$card_holder = $_POST['card_holder'];
$rescode = $_POST['rescode'];
$auth_code = $_POST['auth_code'];
$fgkey = $_POST['fgkey'];
$transaction_type = $_POST['transaction_type'];
$pay_to = $_POST['pay_to'];

$connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");

if ($rescode == "0000") {
    echo "[SUCCESS] rescode:0000<br/>";

    $mysql_err = "";
    $result = 1;

    if (!$connect) {
        $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
    } else {
        $query = "INSERT IGNORE INTO eximbay_succ_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration)
            VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration')";

        $result = mysqli_query($connect, $query);
        if ($result != 1) {
            $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
        }
        mysqli_close($connect);
    }
} else {
    $mysql_err = "";
    $result = 1;

    if (!$connect) {
        $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
    } else {
        $query = "INSERT IGNORE INTO eximbay_failed_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration, rescode, resmsg)
            VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration', '$rescode', '$resmsg')";

        $result = mysqli_query($connect, $query);
        if ($result != 1) {
            $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
        }
        mysqli_close($connect);
    }
    echo "[ERROR] rescode:$rescode<br/>";
}

/*
$url = 'https://api-test.eximbay.com/v1/payments/verify';
//$url = 'https://api.eximbay.com/v1/payments/verify'; // for live
$data = json_encode(array(
	 "data" => "currency=$currency&card_number1=$card_number1&transaction_date=$transaction_date&card_number4=$card_number4&mid=$mid&amount=$amount&access_country=$access_country&order_id=$order_id&payment_method=$payment_method&email=$email&ver=$ver&transaction_id=$transaction_id&param3=$param3&resmsg=$resmsg&card_holder=$card_holder&rescode=$rescode&auth_code=$auth_code&fgkey=$fgkey&transaction_type=$transaction_type&pay_to=$pay_to"
));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic dGVzdF8xODQ5NzA1QzY0MkMyMTdFMEIyRDo='));
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic bGl2ZV9DOUQ4RjExMjlDMUVFRDkzNzlGRDo=')); // live
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$response = curl_exec($ch);
curl_close($ch);

// 응답을 JSON으로 파싱
$responseData = json_decode($response, true);

echo $response;

// 응답 데이터 파싱
if (isset($responseData['rescode']) && isset($responseData['resmsg'])) {
    $rescode = $responseData['rescode']; // 0000 : 정상
    $resmsg = $responseData['resmsg']; // 결제 결과 메세지
} else {
    $rescode = "ERROR";
    $resmsg = "Invalid response from server";
}

if ($rescode == "0000") {
	echo "[SUCCESS] rescode:0000<br/>";

	$mysql_err = "";
	$result = 1;

	if (!$connect) {
		 $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
	} else {
		 $query = "INSERT IGNORE INTO eximbay_succ_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration)
			  VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration')";

		 $result = mysqli_query($connect, $query);
		 if ($result != 1) {
			  $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
		 }
		 mysqli_close($connect);
	}
} else {
	$mysql_err = "";
	$result = 1;

	if (!$connect) {
		 $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
	} else {
		 $query = "INSERT IGNORE INTO eximbay_failed_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration, rescode, resmsg)
			  VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration', '$rescode', '$resmsg')";

		 $result = mysqli_query($connect, $query);
		 if ($result != 1) {
			  $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
		 }
		 mysqli_close($connect);
	}
	echo "[ERROR] rescode:$rescode<br/>";
}
*/
?>
