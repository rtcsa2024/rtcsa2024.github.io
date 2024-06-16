<?php

	require("eximbay_config.php");
  
  $fgkey = "";
  $baseUrl = 'api-test.eximbay.com';
  $baseUrl = 'api.eximbay.com';

  $url = 'https://'.$baseUrl.'/v1/payments/ready';
  $data = '{
      "payment": {
          "transaction_type": "PAYMENT",
          "order_id": "20220819105102",
          "currency": "USD",
          "amount": "1",
          "lang": "EN"
      },
      "merchant": {
          "mid": "C9D8F1129C"
      },
      "buyer": {
          "name": "eximbay",
          "email": "test@eximbay.com"
      },
      "url": {
          "return_url": "http://54.160.128.164/eximbay_return.php",
          "status_url": "http://54.160.128.164/eximbay_status.php"
      }
  }';
   
  $encodedApiKey = base64_encode($apiKey);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.$encodedApiKey.'='));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $response  = curl_exec($ch);

  // Decode the JSON response
  $responseData = json_decode($response, true);

  // Check if 'fgkey' is set in the response and output it
  if (isset($responseData['fgkey'])) {
      echo "FG Key: " . $responseData['fgkey'];
      $fgkey = $responseData['fgkey'];
  } else {
      echo "FG Key not found in the response";
  }

  curl_close($ch);

  // echo "$fgkey</br></br>";


  $url = 'https://'.$baseUrl.'/v1/payments/verify';
  $data = '{
  "data" : "currency=" . $_POST['cur'] . "&card_number1=4111&transaction_date=20220927152250&card_number4=1111&mid=1849705C64&amount=100&access_country=KR&order_id=20220927152140&payment_method=P101&email=test@eximbay.com&ver=230&transaction_id=1849705C6420220927000016&param3=TEST&resmsg=Success.&card_holder=TESTP&rescode=0000&auth_code=309812&fgkey=2AE38D785E05E6AF57977328908C7CD84A273B3FE6C042D537A800B0CBC783EA&transaction_type=PAYMENT&pay_to=EXIMBAY.COM"
  }';
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic dGVzdF8xODQ5NzA1QzY0MkMyMTdFMEIyRDo='));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POST, 1);
  
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $response  = curl_exec($ch);
  
  echo $response;
  curl_close($ch);
  
    $mysql_err = "";
    $result = 1;

    $connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");
    if (!$connect) {
      $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
    } else {
    $name = $_POST['buyer'];
    $email = $_POST['email'];
    parse_str($_POST['param3'], $output);
    $affiliation = $output['affiliation'];
    $country = $output['country'];
    $acm_type = $output['acm_type'];
    $acm_num = $output['acm_num'];
     
    $query = "INSERT IGNORE INTO eximbay_try_registrant (name, email, affiliation, country, acm_type, acm_num)
        VALUES ('$name', '$email', '$affiliation', '$country', '$acm_type', '$acm_num')";
  
    $result = mysqli_query($connect, $query);
    if ($result != 1) {
      $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
    }
    mysqli_close($connect);
  }
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin="0" topmargin="0" align="center" onload="javascript:document.regForm.submit();">
<form name="regForm" method="post" action="<?php echo $reqURL; ?>">
<input type="hidden" name="fgkey" value="<?php echo $fgkey; ?>" />	<!-- requried -->

<?php
  foreach($_POST as $Key=>$value) {
?>
<input type="hidden" name="<?php echo $Key;?>" value="<?php echo $value;?>">
<?php } ?>
</form>
</body>
</html>
