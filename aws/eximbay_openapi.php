<?php
// Allowed origins
$allowed_origins = [
    'http://127.0.0.1:5500',
    'https://rtcsa2024.github.io'
];

// Get the origin of the request
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

// Check if the origin is in the list of allowed origins
if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
}

header("Content-Type: application/json"); // Assuming you're serving JSON

$unique_id = random_str(20);

//$url = 'https://api-test.eximbay.com/v1/payments/ready'; // for test
$url = 'https://api.eximbay.com/v1/payments/ready'; // for live
$data = '{
    "payment": {
        "transaction_type": "",
        "order_id": "",
        "currency": "",
        "amount": "",
        "lang": ""
    },
    "merchant": {
        "mid": ""
    },
    "buyer": {
        "name": "",
        "email": ""
    },
    "url": {
        "return_url": "",
        "status_url": ""
    },
    "product" : [{
        "name" : "IEEE RTCSA 2024 registration",
        "quantity" : "",
        "unit_price" : "",
        "link" : ""
    }],
    "other_param" : {
        "param1" : "",
        "param2" : ""
    }
}';

// JSON 문자열을 PHP 배열로 변환
$array = json_decode($data, true);

// 값 변경하기 예제
$array['payment']['transaction_type'] = $_POST['transaction_type'];
$array['payment']['order_id'] = $_POST['order_id'];
$array['payment']['currency'] = $_POST['currency'];
$array['payment']['amount'] = $_POST['amount'];
$array['payment']['lang'] = $_POST['lang'];
$array['merchant']['mid'] = $_POST['mid'];
$array['buyer']['name'] = $_POST['name'];
$array['buyer']['email'] = $_POST['email'];
$array['url']['return_url'] = $_POST['return_url'];
$array['url']['status_url'] = $_POST['status_url'];
$array['product'][0]['name'] = $_POST['product_name'];
$array['other_param']['param1'] = $unique_id;

// PHP 배열을 JSON 문자열로 다시 인코드
$modifiedData = json_encode($array, JSON_PRETTY_PRINT);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic dGVzdF8xODQ5NzA1QzY0MkMyMTdFMEIyRDo=')); // test
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic bGl2ZV9DOUQ4RjExMjlDMUVFRDkzNzlGRDo=')); // live
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $modifiedData);
$response  = curl_exec($ch);

echo $response;
curl_close($ch);

$mysql_err = "";
$result = 1;

$connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");
if (!$connect) {
    $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
} else {
    $name = $_POST['name'];
    $email = $_POST['email'];
    parse_str($_POST['param3'], $output);
    $affiliation = $output['affiliation'];
    $country = $output['country'];
    $ieee_type = $output['ieee_type'];
    $ieee_num = $output['ieee_num'];
    $over_page_length = $_POST['overPageLength'];
    $extra_reception_tickets = $_POST['extraReceptionTickets'];
    $extra_banquet_tickets = $_POST['extraBanquetTickets'];
    $job_title = $_POST['jobTitle'];
    $manuscript_title = $_POST['manuscriptTitle'];
    $author_registration = $_POST['authorRegistration'];
    $amount = $_POST['amount'];
    $dietary = $_POST['dietary'];
     
    $query = "INSERT IGNORE INTO eximbay_try_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration, dietary, unique_id)
        VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration', '$dietary', '$unique_id')";
  
    $result = mysqli_query($connect, $query);
    if ($result != 1) {
      $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
    }
    mysqli_close($connect);
}
?>                      