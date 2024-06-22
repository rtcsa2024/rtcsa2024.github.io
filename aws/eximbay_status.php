<?php

// Original data
$data = '{
    "data" : "card_number4=1000&dm_reject=&card_number1=5409&mid=1849705C64&foreign_currency=&card_holder=&dm_review=&base_amount=&currency=USD&pay_to=&email=neo81389%40naver.com&payment_method=P111&transaction_id=1849705C64W0000056371354&transaction_date=20240622160355&base_currency=&amount=600&dcc_rate=&installment_months=00&dm_decision=&transaction_type=PAYMENT&param3=OPENAPI&resmsg=Success.&foreign_rate=&version=230&param1=&rescode=0000&param2=&auth_code=11657007&fgkey=326FECFF23B850CA421CCAE9573DFADF2879D4D3A269A1534E05FEC38BC3A57B&base_rate=&foreign_amount=&order_id=0&access_country=KR"
}';

$testData = http_build_query($_POST, '', '&');
$dataArray = json_decode($data, true);
$dataArray['data'] = $testData;
$newData = json_encode($dataArray, JSON_PRETTY_PRINT);

// Decode the JSON data to an associative array
$dataArray = json_decode($newData, true);

// Parse the 'data' string into an associative array
parse_str($dataArray['data'], $parsedData);

// Extract the email value and decode it
$email = urldecode($parsedData['email']);
$transaction_id = $parsedData['transaction_id'];
$transaction_date = $parsedData['transaction_date'];
$card_number4 = $parsedData['card_number4'];
$card_number1 = $parsedData['card_number1'];

$url = 'https://api-test.eximbay.com/v1/payments/verify';
//$url = 'https://api.eximbay.com/v1/payments/verify'; // for live
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic dGVzdF8xODQ5NzA1QzY0MkMyMTdFMEIyRDo='));
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic bGl2ZV9DOUQ4RjExMjlDMUVFRDkzNzlGRDo=')); // live
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $newData);
$response = curl_exec($ch);
curl_close($ch);

// 응답을 JSON으로 파싱
$responseData = json_decode($response, true);

echo $response;

$connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");

// 응답 데이터 파싱
if (isset($responseData['rescode']) && isset($responseData['resmsg'])) {
    $rescode = $responseData['rescode']; // 0000 : 정상
    $resmsg = $responseData['resmsg']; // 결제 결과 메세지
} else {
    $rescode = "ERROR";
    $resmsg = "Invalid response from server";
}

if ($rescode == "0000") {

	$mysql_err = "";
	$result = 1;

	if (!$connect) {
		 $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
	} else {

          $query = "INSERT IGNORE INTO eximbay_auth_registrant (transaction_id, email, transaction_date, card_number4, card_number1, stat, rescode, resmsg)
          VALUES ('$transaction_id', '$email', '$transaction_date', '$card_number4', '$card_number1', 'succ', '$rescode', '$resmsg')";

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
		
        $query = "INSERT IGNORE INTO eximbay_auth_registrant (transaction_id, email, transaction_date, card_number4, card_number1, stat, rescode, resmsg)
          VALUES ('$transaction_id', '$email', '$transaction_date', '$card_number4', '$card_number1', 'failed', '$rescode', '$resmsg')";


		 $result = mysqli_query($connect, $query);
		 if ($result != 1) {
			  $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
		 }
		 mysqli_close($connect);
	}
	echo "[ERROR] rescode:$rescode<br/>";
}

/*

if ($rescode == "0000") {
    echo "[SUCCESS] rescode:0000<br/>";

    $mysql_err = "";
    $result = 1;

    if (!$connect) {
        $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
    } else {
        $query = "UPDATE eximbay_registrant
        SET status = 'succ', rescode = $rescode
        WHERE email = $email;";

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

        $query = "UPDATE eximbay_registrant
        SET status = 'succ', rescode = $rescode, resmsg = $resmsg
        WHERE email = $email;";

        $result = mysqli_query($connect, $query);
        if ($result != 1) {
            $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
        }
        mysqli_close($connect);
    }
    echo "[ERROR] rescode:$rescode<br/>";
}
*/
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
