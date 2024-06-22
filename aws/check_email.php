
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
  $connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");
  if (!$connect) {
    die(mysqli_connect_errno());
  }
  
  $ret = $_POST[key($_POST)];

  $query = "SELECT * FROM eximbay_auth_registrant WHERE email='$ret' AND stat='succ'";
  $result = mysqli_query($connect, $query);
  $count = mysqli_num_rows($result);
   
  mysqli_close($connect);
  
  $returnData = '';
  
  if ($count) {

    $returnData = '{
      "status": "DUPLICATED",
      "body": ""
    }';
  }
  else {
    $returnData = '{
      "status": "OK",
      "body": ""
    }';
  }

  echo $returnData;
?>
